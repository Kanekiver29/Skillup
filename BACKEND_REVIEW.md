# SkillUp — Backend Code Review

> **For Students:** This document walks through every issue found during a senior
> backend review of this project. Each section tells you **what the problem is**,
> **why it matters**, and **how to fix it**. Read it carefully, try to understand
> the reasoning, and then apply the fixes to the original code yourself.

---

## Table of Contents

1. [🔴 Security Issues](#-security-issues)
   - [S1 — Admin routes are not protected by dedicated middleware](#s1--admin-routes-are-not-protected-by-dedicated-middleware)
   - [S2 — Weak password policy on registration](#s2--weak-password-policy-on-registration)
   - [S3 — File upload trusts the client-provided extension](#s3--file-upload-trusts-the-client-provided-extension)
2. [🟠 Bugs](#-bugs)
   - [B1 — Accessing a non-existent model attribute (`full_name`)](#b1--accessing-a-non-existent-model-attribute-full_name)
   - [B2 — `$this->middleware()` called inside a method body](#b2--thismiddleware-called-inside-a-method-body)
   - [B3 — Validating a database column that does not exist](#b3--validating-a-database-column-that-does-not-exist)
   - [B4 — Null `attempt_limit` silently blocks all quiz retries](#b4--null-attempt_limit-silently-blocks-all-quiz-retries)
   - [B5 — Migration `down()` does not reverse all changes from `up()`](#b5--migration-down-does-not-reverse-all-changes-from-up)
   - [B6 — Model `$fillable` lists columns that have no migration](#b6--model-fillable-lists-columns-that-have-no-migration)
3. [🟡 Code Quality & Maintainability](#-code-quality--maintainability)
   - [Q1 — Redundant database query in `ModuleController`](#q1--redundant-database-query-in-modulecontroller)
   - [Q2 — Closing PHP tag `?>` in a class file](#q2--closing-php-tag--in-a-class-file)
   - [Q3 — Feature tests fail because Vite is not configured for testing](#q3--feature-tests-fail-because-vite-is-not-configured-for-testing)

---

## 🔴 Security Issues

Security issues are the highest priority. They can allow attackers to gain
unauthorized access, steal data, or damage the application.

---

### S1 — Admin routes are not protected by dedicated middleware

**Files affected:**
- `routes/web.php`
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/CourseController.php`
- `app/Http/Controllers/Admin/EnrollmentController.php`
- `app/Http/Controllers/Admin/UserManagementController.php`
- `app/Http/Controllers/Admin/MainAdminController.php`

#### The Problem

All admin routes are placed inside the same `auth` middleware group as regular
user routes. There is no middleware that enforces the **admin role** at the
routing layer. Instead, every single admin controller defines its own private
helper method called `authorizeAdmin()`:

```php
// ❌ WRONG — repeated in 4 different admin controllers
private function authorizeAdmin()
{
    if (!auth()->check() || !auth()->user()->is_admin) {
        abort(403, 'Unauthorized');
    }
}
```

And then every controller action calls it manually at the top:

```php
// ❌ WRONG — every admin action has to remember to call this
public function index()
{
    $this->authorizeAdmin(); // ← must not forget this!
    // ...
}
```

Even `DashboardController` has its own separate inline check:

```php
// ❌ WRONG — inline check, yet another pattern for the same thing
public function index(Request $request)
{
    $user = $request->user();
    if (! $user || ! $user->is_admin) {
        abort(403, 'Forbidden');
    }
    // ...
}
```

#### Why Is This Dangerous?

1. **Human error** — If a developer adds a new admin route and forgets to call
   `$this->authorizeAdmin()`, that route is completely open to any logged-in
   user, including regular students.
2. **Code duplication** — The same security check is copy-pasted 5+ times. If
   the logic ever needs to change (e.g., you add a "super-admin" role), you must
   update every single copy.
3. **Inconsistency** — Some controllers use `authorizeAdmin()`, others use
   inline checks with slightly different logic. This makes the codebase hard to
   trust and audit.

#### How to Fix It

The correct Laravel approach is to create a **single dedicated middleware** that
is applied to all admin routes at once.

**Step 1 — Create the middleware:**

```php
// app/Http/Middleware/IsAdmin.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
```

**Step 2 — Register an alias in `bootstrap/app.php`:**

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'is_admin' => \App\Http\Middleware\IsAdmin::class,
    ]);
})
```

**Step 3 — Use `['auth', 'is_admin']` for the admin route group in `web.php`:**

```php
// ✅ CORRECT — admin routes get their own dedicated group
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    // ... all other admin routes
});
```

**Step 4 — Remove all `authorizeAdmin()` helper methods and their calls** from
every admin controller. The middleware handles it automatically for every route
in the group — no manual calls needed.

---

### S2 — Weak password policy on registration

**File:** `app/Http/Controllers/AuthController.php`

#### The Problem

Laravel's `Password` rule class is imported at the top of the file, but it is
never actually used in the `register()` validation:

```php
// The import is there...
use Illuminate\Validation\Rules\Password;

// ...but the password rule is just 'required' and 'confirmed'
$validated = $request->validate([
    'password' => [
        'required',    // ← only requires "required" and "confirmed"
        'confirmed',   // ← no minimum length, no complexity requirement
    ],
]);
```

This means a user can register with a password like `a` or `1` — a single
character is accepted.

#### Why Is This a Problem?

Weak passwords are trivially cracked by brute-force or dictionary attacks.
A learning platform stores personal information (names, emails, progress).
Users deserve a baseline level of account security. The rule class was already
imported — it just was never put to use.

#### How to Fix It

Apply the `Password` rule with minimum requirements:

```php
// ✅ CORRECT — enforces minimum security requirements
$validated = $request->validate([
    'password' => [
        'required',
        'confirmed',
        Password::min(8)->mixedCase()->numbers(),
    ],
]);
```

This enforces:
- At least **8 characters**
- At least one **uppercase** and one **lowercase** letter
- At least one **number**

You can make it stricter (add `.symbols()` or `.uncompromised()`) depending on
your security requirements.

---

### S3 — File upload trusts the client-provided extension

**File:** `app/Http/Controllers/ProfileController.php`

#### The Problem

When a user uploads a profile image, the code uses `getClientOriginalExtension()`
to build the filename:

```php
// ❌ WRONG — the extension comes from the user's browser
$filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
```

#### Why Is This Dangerous?

`getClientOriginalExtension()` returns whatever extension the user's browser
sends in the HTTP request. A malicious user can rename a PHP script
`shell.php` to `shell.jpg` and upload it. The browser sends `jpg` as the
extension, but the file itself still contains PHP code.

If that file ends up in a web-accessible directory and a `.php` extension is
served, the web server could execute it — which is called a **Remote Code
Execution (RCE)** attack.

> **Note:** The `mimes:jpeg,png,jpg,gif,webp` validation rule adds a layer of
> protection by checking the file's MIME type, but using the MIME-derived
> extension *in the filename too* is the correct defence-in-depth approach.

#### How to Fix It

Use `guessExtension()` instead. This method determines the extension from the
file's actual MIME type, not from what the user claims it is:

```php
// ✅ CORRECT — extension is derived from the real MIME type
$filename = time() . '_' . $user->id . '.' . $file->guessExtension();
```

---

## 🟠 Bugs

Bugs are logic errors that cause the application to behave incorrectly or crash.

---

### B1 — Accessing a non-existent model attribute (`full_name`)

**File:** `app/Http/Controllers/Api/StatsController.php`

#### The Problem

The `userDashboardStats()` and `adminCourseStats()` methods try to read a
`full_name` attribute from the `User` model and the user relationship:

```php
// ❌ WRONG — 'full_name' is not a column or accessor on the User model
'user_name' => $user->full_name,           // in userDashboardStats()

'user_name' => $enrollment->user->full_name, // in adminCourseStats()
```

#### Why Is This a Bug?

Looking at `app/Models/User.php`, the user table has a `name` column, not
`full_name`. There is no `getFullNameAttribute()` accessor either.

In PHP, accessing a non-existent property on an Eloquent model returns `null`
silently — so this won't throw an exception, but the JSON response will always
contain `"user_name": null` instead of the actual name. This is a data bug that
is hard to spot during development.

#### How to Fix It

```php
// ✅ CORRECT — use the actual column name
'user_name' => $user->name,
'user_name' => $enrollment->user->name,
```

---

### B2 — `$this->middleware()` called inside a method body

**File:** `app/Http/Controllers/CourseController.php`

#### The Problem

The `enroll()` and `myLearning()` methods call `$this->middleware('auth')`
inside the method body:

```php
// ❌ WRONG — this does nothing in Laravel 11+
public function enroll($slug)
{
    $this->middleware('auth'); // ← has no effect here

    $course = Course::where('slug', $slug)->firstOrFail();
    // ...
}

public function myLearning()
{
    $this->middleware('auth'); // ← has no effect here

    $enrollments = Enrollment::where('user_id', auth()->id())->with('course')->get();
    // ...
}
```

#### Why Is This a Bug?

In **Laravel 10 and earlier**, `$this->middleware()` could be called from a
controller's constructor to apply middleware to specific actions. This was
never valid inside an action method itself.

In **Laravel 11** (which this project uses), inline controller middleware was
removed entirely. Calling `$this->middleware()` inside a method body has
**absolutely no effect** — the middleware is never applied and the method runs
without authentication. The code only appears to work because both routes
already have `->middleware('auth')` applied at the route definition level in
`web.php`.

The dead code is confusing and misleading.

#### How to Fix It

Remove the dead calls. Authentication is already enforced in `routes/web.php`:

```php
// ✅ CORRECT — remove the dead calls, the routes in web.php already protect these
public function enroll($slug)
{
    $course = Course::where('slug', $slug)->firstOrFail();
    // ...
}

public function myLearning()
{
    $enrollments = Enrollment::where('user_id', auth()->id())->with('course')->get();
    // ...
}
```

---

### B3 — Validating a database column that does not exist

**File:** `app/Http/Controllers/Admin/UserManagementController.php`

#### The Problem

The `updateUser()` method includes `username` in its validation rules:

```php
// ❌ WRONG — 'username' does not exist in the DB or in User::$fillable
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email,' . $user->id,
    'username' => 'required|string|max:255|unique:users,username,' . $user->id, // ← problem
]);

$user->update($validated);
```

#### Why Is This a Bug?

1. There is no `username` column in the `users` database migration.
2. `username` is not listed in `User::$fillable`.
3. The `unique:users,username` rule queries a column that doesn't exist, which
   will throw a **database exception** at runtime.
4. Even if it didn't throw, `$user->update($validated)` would try to write
   `username` to the database — also causing a failure.

#### How to Fix It

Remove the `username` rule from the validation. If `username` is a feature you
want to add later, you must first create a migration to add the column to the
`users` table and add it to `User::$fillable`.

```php
// ✅ CORRECT — only validate fields that actually exist
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email,' . $user->id,
]);
```

---

### B4 — Null `attempt_limit` silently blocks all quiz retries

**File:** `app/Models/Quiz.php`

#### The Problem

The `canUserRetry()` method compares the attempt count against `attempt_limit`:

```php
// ❌ WRONG — broken when attempt_limit is null
public function canUserRetry($userId)
{
    $attemptCount = $this->getUserAttemptCount($userId);
    return $attemptCount < $this->attempt_limit;
}
```

#### Why Is This a Bug?

Looking at the `quizzes` migration, `attempt_limit` is allowed to be `null`:

```php
$table->integer('attempt_limit')->default(3); // nullable is not set, but
                                               // it can be set to null manually
```

The intent of a `null` value is to mean "**unlimited attempts**". However, in
PHP, `3 < null` evaluates to `false`, and `0 < null` also evaluates to `false`.
This means a quiz with `attempt_limit = null` will **never** allow a user to
start — `canUserRetry()` will always return `false`.

#### How to Fix It

Check for `null` first and treat it as unlimited:

```php
// ✅ CORRECT — null means unlimited retries
public function canUserRetry($userId)
{
    if ($this->attempt_limit === null) {
        return true;
    }

    $attemptCount = $this->getUserAttemptCount($userId);
    return $attemptCount < $this->attempt_limit;
}
```

---

### B5 — Migration `down()` does not reverse all changes from `up()`

**File:** `database/migrations/2025_02_07_000001_add_profile_fields_to_users.php`

#### The Problem

The `up()` method adds six columns to the `users` table, including
`portfolio_url`. But the `down()` method (which reverses the migration) only
drops five of them — `portfolio_url` is missing:

```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->text('bio')->nullable()->after('is_admin');
        $table->string('location')->nullable()->after('bio');
        $table->string('portfolio_url')->nullable()->after('location'); // ← added here
        $table->json('skills')->nullable()->after('portfolio_url');
        $table->boolean('profile_public')->default(true)->after('skills');
        $table->integer('hours_spent')->default(0)->after('profile_public');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'bio',
            'location',
            // ← portfolio_url is MISSING from this list!
            'skills',
            'profile_public',
            'hours_spent',
        ]);
    });
}
```

#### Why Is This a Bug?

Running `php artisan migrate:rollback` will fail with a database error when
it tries to reconstruct the previous schema, because `portfolio_url` will
still be in the table. This breaks the rollback workflow and makes the
migration unreliable.

#### How to Fix It

Add `portfolio_url` to the `dropColumn` array in `down()`:

```php
// ✅ CORRECT — down() mirrors up() exactly
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'bio',
            'location',
            'portfolio_url', // ← added
            'skills',
            'profile_public',
            'hours_spent',
        ]);
    });
}
```

**Key principle:** Every column added in `up()` must be removed in `down()`.
Always check that your migrations are perfectly reversible.

---

### B6 — Model `$fillable` lists columns that have no migration

**File:** `app/Models/User.php`

#### The Problem

The `User` model declares `github_url`, `linkedin_url`, and `twitter_url`
as mass-assignable attributes:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'is_admin',
    'profile_image',
    'bio',
    'location',
    'github_url',      // ← no migration!
    'linkedin_url',    // ← no migration!
    'twitter_url',     // ← no migration!
    'portfolio_url',
    'skills',
    'profile_public',
];
```

Looking at all the migrations, there is no migration that creates these three
columns in the `users` table.

#### Why Is This a Bug?

Any code that tries to save `github_url`, `linkedin_url`, or `twitter_url` to
the database (e.g., from the profile update form) will throw a database
exception at runtime because the columns don't exist.

This is a mismatch between the model layer and the database layer.

#### How to Fix It

Create a new migration to add the missing columns:

```php
// database/migrations/2025_02_09_000000_add_social_urls_to_users_table.php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('github_url')->nullable();
        $table->string('linkedin_url')->nullable();
        $table->string('twitter_url')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['github_url', 'linkedin_url', 'twitter_url']);
    });
}
```

Then run `php artisan migrate`.

**Key principle:** Every column in `$fillable` must have a corresponding
migration. If you need a new attribute, write the migration first.

---

## 🟡 Code Quality & Maintainability

These issues do not cause immediate security problems or crashes, but they make
the code harder to read, maintain, and extend.

---

### Q1 — Redundant database query in `ModuleController`

**File:** `app/Http/Controllers/ModuleController.php`

#### The Problem

The `show()` method first loads a module from the database using
`$course->modules()->where('slug', $moduleSlug)->firstOrFail()`, then
*immediately* queries the database a second time to fetch the exact same record:

```php
// ❌ WRONG — $module is already in memory; no need to hit the DB again
public function show($courseSlug, $moduleSlug)
{
    $course = Course::where('slug', $courseSlug)->firstOrFail();
    $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail(); // ← loaded here

    $this->authorize('view', $course);

    $userProgress = Module::find($module->id)->getProgress(auth()->id()); // ← pointless re-fetch
    //              ^^^^^^^^^^^^^^^^^^^^^^^^^^
    //              This runs SELECT * FROM modules WHERE id = ? 
    //              for a record we already have in $module!
    // ...
}
```

#### Why Does This Matter?

Every unnecessary database query adds latency to the page load, increases the
load on the database server, and makes the code harder to understand. In this
case, `Module::find($module->id)` is 100% redundant — the variable `$module`
already holds the exact same Eloquent model instance.

#### How to Fix It

Call `getProgress()` directly on the `$module` variable that was already loaded:

```php
// ✅ CORRECT — use the model that is already in memory
$userProgress = $module->getProgress(auth()->id());
```

---

### Q2 — Closing PHP tag `?>` in a class file

**File:** `app/Http/Controllers/Admin/MainAdminController.php`

#### The Problem

The file ends with a closing PHP tag `?>`:

```php
class MainAdminController extends Controller
{
    public function index(Request $request)
    {
        // ...
        return view('Admin.main');
    }
}

?> // ← this should not be here
```

#### Why Does This Matter?

The [PHP documentation](https://www.php.net/manual/en/language.basic-syntax.phptags.php)
and the [PSR-2 / PSR-12 coding standards](https://www.php-fig.org/psr/psr-12/)
explicitly state: **files that contain only PHP should omit the closing `?>`
tag.**

Any whitespace or newline characters after the closing `?>` are sent as output
to the browser *before* the HTTP headers, which causes the dreaded
**"Headers already sent"** error. This will break redirects, session handling,
and cookie operations.

#### How to Fix It

Simply delete the closing `?>` tag. The file should end with the closing
brace of the class and nothing else:

```php
// ✅ CORRECT — no closing ?>
class MainAdminController extends Controller
{
    public function index(Request $request)
    {
        return view('Admin.main');
    }
}
```

---

### Q3 — Feature tests fail because Vite is not configured for testing

**File:** `tests/TestCase.php`

#### The Problem

Running `php artisan test` fails for every feature test with this error:

```
Illuminate\Foundation\ViteManifestNotFoundException: Vite manifest not found
at: /public/build/manifest.json
```

This is because the views call `@vite(...)` to load CSS/JS assets, and Laravel
looks for the compiled Vite manifest file. During automated testing, Vite is
never running, so the manifest does not exist.

The base `TestCase` class is essentially empty:

```php
// ❌ WRONG — missing Vite configuration for the test environment
abstract class TestCase extends BaseTestCase
{
    //
}
```

#### Why Does This Matter?

If your feature tests can never run, you lose one of the most important safety
nets in software development. Broken tests are often worse than no tests —
they create a false sense of security and a habit of ignoring CI failures.

#### How to Fix It

Override `setUp()` in the base `TestCase` and call `$this->withoutVite()`.
This tells Laravel's test runner not to try to load Vite assets:

```php
// ✅ CORRECT — tests now run without needing a built Vite bundle
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }
}
```

---

## Summary Table

| # | Severity | File(s) | Problem |
|---|----------|---------|---------|
| S1 | 🔴 Security | `routes/web.php`, 5 admin controllers | Admin authorization scattered across controllers instead of using middleware |
| S2 | 🔴 Security | `AuthController.php` | `Password` rule imported but not applied — any password length accepted |
| S3 | 🔴 Security | `ProfileController.php` | `getClientOriginalExtension()` trusts user-controlled input for filename |
| B1 | 🟠 Bug | `StatsController.php` | `$user->full_name` does not exist; always returns `null` |
| B2 | 🟠 Bug | `CourseController.php` | `$this->middleware('auth')` in method body has no effect in Laravel 11 |
| B3 | 🟠 Bug | `UserManagementController.php` | `username` field validated and saved but the DB column does not exist |
| B4 | 🟠 Bug | `Quiz.php` | `null < null` is `false` — quizzes with no attempt limit can never be retried |
| B5 | 🟠 Bug | Migration `2025_02_07_000001` | `portfolio_url` added in `up()` but not removed in `down()` |
| B6 | 🟠 Bug | `User.php` + migrations | `github_url`, `linkedin_url`, `twitter_url` in `$fillable` but no DB columns |
| Q1 | 🟡 Quality | `ModuleController.php` | `Module::find($module->id)` re-fetches a record already in memory |
| Q2 | 🟡 Quality | `MainAdminController.php` | Closing `?>` PHP tag can cause "headers already sent" errors |
| Q3 | 🟡 Quality | `tests/TestCase.php` | All feature tests crash with `ViteManifestNotFoundException` |

---

## Good Practices to Carry Forward

1. **Centralize cross-cutting concerns in middleware.** Authorization, logging,
   rate-limiting — these belong in middleware, not copy-pasted into each
   controller.

2. **Never trust user input for security decisions.** This applies to file
   extensions, file names, and any data that arrives over HTTP.

3. **Always enforce password complexity.** Laravel has a built-in `Password`
   rule class specifically for this — use it.

4. **Keep your migrations reversible.** Every `up()` must have a complete and
   matching `down()`. Test your rollbacks.

5. **Keep your model `$fillable` and your migrations in sync.** If a column is
   in `$fillable`, it must exist in the database.

6. **Avoid redundant queries.** If you already have a model in a variable,
   don't query the database again to fetch the same record.

7. **Omit the closing PHP tag** (`?>`) from files that contain only PHP.

8. **Make your test suite runnable.** If `php artisan test` doesn't work, fix
   it immediately. A broken test suite provides no value.
