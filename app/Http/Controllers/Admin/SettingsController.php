<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Show the admin settings page.
     */
    public function index(Request $request)
    {
        // Only admins may access settings
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        // Collect current env-based or config-based settings to pass to the view.
        // These are read-only display values; actual mutations go through update().
        $settings = [
            'app_name'            => config('app.name'),
            'app_env'             => config('app.env'),
            'app_debug'           => config('app.debug'),
            'app_url'             => config('app.url'),
            'mail_mailer'         => config('mail.default'),
            'mail_from_address'   => config('mail.from.address'),
            'mail_from_name'      => config('mail.from.name'),
            'cache_driver'        => config('cache.default'),
            'session_driver'      => config('session.driver'),
            'session_lifetime'    => config('session.lifetime'),
            'queue_connection'    => config('queue.default'),
            'filesystems_default' => config('filesystems.default'),
        ];

        return view('Admin.settings', compact('settings'));
    }

    /**
     * Handle settings form submission.
     * Values are persisted to the .env file via a safe key-value update.
     */
    public function update(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $section = $request->input('section', 'general');

        // Validate per-section so tabbed saves work independently.
        if ($section === 'email') {
            $validated = $request->validate([
                'mail_from_address' => ['required', 'email', 'max:255'],
                'mail_from_name'    => ['required', 'string', 'max:100'],
            ]);

            $envUpdates = [
                'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
                'MAIL_FROM_NAME'    => $validated['mail_from_name'],
            ];
        } else { // general (default)
            $validated = $request->validate([
                'app_name'          => ['required', 'string', 'max:100'],
                'app_url'           => ['required', 'url', 'max:255'],
                'session_lifetime'  => ['required', 'integer', 'min:1', 'max:10080'],
            ]);

            // Only update known, safe keys to prevent injection.
            $envUpdates = [
                'APP_NAME'         => $validated['app_name'],
                'APP_URL'          => $validated['app_url'],
                'SESSION_LIFETIME' => (string) $validated['session_lifetime'],
            ];
        }

        $this->updateEnvFile($envUpdates);

        // Clear config cache so changes take effect immediately.
        Artisan::call('config:clear');

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Settings updated successfully.']);
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }

    /**
     * Show one of the SIAS admin settings sections.
     */
    public function section(Request $request, string $section)
    {
        $this->authorizeSettings($request);

        $definitions = $this->sectionDefinitions();
        abort_unless(isset($definitions[$section]), 404);

        $userSettings = $request->user()->settings ?? [];
        $values = $userSettings['admin'][$section] ?? [];

        if ($section === 'language') {
            $values = array_merge([
                'locale' => app()->getLocale(),
                'timezone' => config('app.timezone', 'UTC'),
            ], $values);
        }

        if ($section === 'school-information') {
            $values = array_merge([
                'app_name' => config('app.name'),
                'app_url' => config('app.url'),
            ], $values);
        }

        $views = [
            'school-information' => 'sias.admin.settings.school-information.index',
            'academic-settings' => 'sias.admin.settings.academic-settings.index',
            'grading-settings' => 'sias.admin.settings.grading-settings.index',
            'language' => 'sias.admin.settings.language.index',
            'maintenance' => 'sias.admin.settings.system-maintenance.index',
        ];

        return view($views[$section], [
            'section' => $section,
            'definition' => $definitions[$section],
            'values' => $values,
        ]);
    }

    /**
     * Persist one of the SIAS admin settings sections.
     */
    public function updateSection(Request $request, string $section)
    {
        $this->authorizeSettings($request);

        $definitions = $this->sectionDefinitions();
        abort_unless(isset($definitions[$section]), 404);

        $validated = $request->validate($definitions[$section]['rules']);
        $user = $request->user();
        $settings = $user->settings ?? [];
        $settings['admin'] ??= [];
        $settings['admin'][$section] = $validated;

        if ($section === 'school-information') {
            $this->updateEnvFile([
                'APP_NAME' => $validated['app_name'],
                'APP_URL' => $validated['app_url'],
            ]);
            Artisan::call('config:clear');
        }

        if ($section === 'language') {
            $request->session()->put('locale', $validated['locale']);
        }

        $user->forceFill(['settings' => $settings])->save();

        return redirect()
            ->route('sias.admin.settings.section', $section)
            ->with('success', $definitions[$section]['title'] . ' updated successfully.');
    }

    /**
     * Define the editable SIAS settings and their validation rules in one place.
     */
    private function sectionDefinitions(): array
    {
        return [
            'school-information' => [
                'title' => __('sias.settings_school_information'),
                'purpose' => __('sias.settings_school_information_purpose'),
                'fields' => [
                    ['name' => 'app_name', 'label' => 'School name', 'type' => 'text'],
                    ['name' => 'app_url', 'label' => 'School website URL', 'type' => 'url'],
                    ['name' => 'school_email', 'label' => 'School email', 'type' => 'email'],
                    ['name' => 'school_phone', 'label' => 'School phone', 'type' => 'text'],
                    ['name' => 'school_address', 'label' => 'School address', 'type' => 'textarea'],
                ],
                'rules' => [
                    'app_name' => ['required', 'string', 'max:100'],
                    'app_url' => ['required', 'url', 'max:255'],
                    'school_email' => ['nullable', 'email', 'max:255'],
                    'school_phone' => ['nullable', 'string', 'max:50'],
                    'school_address' => ['nullable', 'string', 'max:500'],
                ],
            ],
            'academic-settings' => [
                'title' => __('sias.settings_academic'),
                'purpose' => __('sias.settings_academic_purpose'),
                'fields' => [
                    ['name' => 'school_year', 'label' => 'School year', 'type' => 'text'],
                    ['name' => 'semester', 'label' => 'Semester / term', 'type' => 'select', 'options' => ['First Semester', 'Second Semester', 'Summer Term']],
                    ['name' => 'grading_period', 'label' => 'Grading period', 'type' => 'select', 'options' => ['Quarter', 'Semester', 'Trimester']],
                    ['name' => 'section_capacity', 'label' => 'Default section capacity', 'type' => 'number'],
                ],
                'rules' => [
                    'school_year' => ['required', 'string', 'max:20'],
                    'semester' => ['required', 'in:First Semester,Second Semester,Summer Term'],
                    'grading_period' => ['required', 'in:Quarter,Semester,Trimester'],
                    'section_capacity' => ['required', 'integer', 'min:1', 'max:500'],
                ],
            ],
            'grading-settings' => [
                'title' => __('sias.settings_grading'),
                'purpose' => __('sias.settings_grading_purpose'),
                'fields' => [
                    ['name' => 'passing_grade', 'label' => 'Passing grade (%)', 'type' => 'number', 'step' => '0.01'],
                    ['name' => 'maximum_grade', 'label' => 'Maximum grade (%)', 'type' => 'number', 'step' => '0.01'],
                    ['name' => 'decimal_places', 'label' => 'Displayed decimal places', 'type' => 'number'],
                ],
                'rules' => [
                    'passing_grade' => ['required', 'numeric', 'min:0', 'max:100'],
                    'maximum_grade' => ['required', 'numeric', 'gt:passing_grade', 'max:100'],
                    'decimal_places' => ['required', 'integer', 'min:0', 'max:4'],
                ],
            ],
            'language' => [
                'title' => __('sias.settings_language'),
                'purpose' => __('sias.settings_language_purpose'),
                'fields' => [
                    ['name' => 'locale', 'label' => 'Language', 'type' => 'select', 'options' => ['en', 'tl']],
                    ['name' => 'timezone', 'label' => 'Timezone', 'type' => 'timezone'],
                ],
                'rules' => [
                    'locale' => ['required', 'in:en,tl'],
                    'timezone' => ['required', 'timezone'],
                ],
            ],
            'maintenance' => [
                'title' => __('sias.settings_maintenance'),
                'purpose' => __('sias.settings_maintenance_purpose'),
                'fields' => [],
                'rules' => [],
            ],
        ];
    }

    private function authorizeSettings(Request $request): void
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }
    }

    /**
     * Clear one or all Laravel caches.
     * Accepted types: config | route | view | all
     */
    public function clearCache(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $type = $request->input('type', 'config');

        $map = [
            'config' => ['config:clear'],
            'route'  => ['route:clear'],
            'view'   => ['view:clear'],
            'all'    => ['config:clear', 'route:clear', 'view:clear'],
        ];

        if (! array_key_exists($type, $map)) {
            abort(422, 'Invalid cache type.');
        }

        foreach ($map[$type] as $command) {
            Artisan::call($command);
        }

        $label = $type === 'all' ? 'All caches' : ucfirst($type) . ' cache';

        if ($request->expectsJson()) {
            return response()->json(['message' => $label . ' cleared successfully.']);
        }

        return redirect()->route('admin.settings')->with('success', $label . ' cleared successfully.');
    }

    /**
     * Toggle maintenance mode on/off.
     */
    public function toggleMaintenance(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            $message = 'Application is now live.';
        } else {
            $maintenanceReason = trim((string) $request->input('maintenance_reason', 'Scheduled system maintenance in progress.'));

            if ($maintenanceReason === '') {
                $maintenanceReason = 'Scheduled system maintenance in progress.';
            }

            $this->updateEnvFile([
                'APP_MAINTENANCE_REASON' => $maintenanceReason,
            ]);

            Artisan::call('config:clear');

            Artisan::call('down', [
                '--secret' => bin2hex(random_bytes(16)),
                '--render' => 'errors.maintenance',
                '--retry' => '60',
            ]);

            $message = 'Maintenance mode enabled: ' . $maintenanceReason;
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.settings')->with('success', $message);
    }

    /**
     * Safely update key=value pairs in the .env file.
     * Only pre-approved keys are written; values are quoted when they contain spaces.
     */
    private function updateEnvFile(array $updates): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        foreach ($updates as $key => $value) {
            // Sanitize key: only uppercase letters, digits, underscores.
            if (! preg_match('/^[A-Z0-9_]+$/', $key)) {
                continue;
            }

            // Quote value if it contains spaces or special shell characters.
            $safeValue = preg_match('/\s/', $value) ? '"' . addslashes($value) . '"' : $value;

            // Replace existing key or append if not found.
            $pattern     = '/^' . preg_quote($key, '/') . '=.*/m';
            $replacement = $key . '=' . $safeValue;

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $replacement, $content);
            } else {
                $content .= PHP_EOL . $replacement;
            }
        }

        file_put_contents($envPath, $content);
    }
}
