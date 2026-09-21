# Course Redesign & Major-Based Redirection System

## Overview
This document describes the new major-based course assignment and automatic redirection system implemented in SkillUp. Students now choose a major during registration and are automatically assigned to their major's designated course.

## Database Changes

### New Tables
- **majors** - Stores information about academic majors/programs

### Modified Tables
- **users** - Added `major_id` field to track student's major
- **courses** - Added `major_id` and `is_primary` fields to link courses to majors

### New Relationships
- **Major ↔ Courses** - One major can have many courses
- **Major ↔ Users** - One major can have many students
- **Courses ↔ Majors** - A course belongs to one major

## User Registration Flow

### Before
1. Student fills out registration form
2. Selects a **course** from dropdown
3. Automatically enrolled in that course
4. User's `assigned_course_id` is set to selected course

### After
1. Student fills out registration form
2. Selects a **major** from dropdown
3. System finds the major's primary/designated course
4. Student is automatically enrolled in that course
5. User's `major_id` is set to selected major
6. User's `assigned_course_id` is set to major's designated course

## Course Redirection Logic

When a logged-in student visits `/courses`, the system follows this priority:

1. **Major-Based Redirection** (Primary)
   - Check if user has `major_id`
   - Load user's major and find primary course
   - If no primary is set, use first published course in major
   - Redirect to that course

2. **Assigned Course Redirection** (Fallback)
   - Check if user has `assigned_course_id`
   - Redirect to assigned course

3. **Show All Courses** (Default)
   - If neither above applies, show course listing

## Admin Management

### Create a Major
1. Go to: **Admin → Majors & Programs**
2. Click "Add Major"
3. Fill in:
   - **Major Name** (e.g., "Information Technology")
   - **Code** (e.g., "IT")
   - **Description** (optional)
   - **Department** (optional)
   - **Brand Color** (for UI consistency)
   - **Active** (toggle to deactivate)
4. Save

### Assign Courses to Major
1. Open a major from the majors list
2. Scroll to "Assign a Course" section
3. Select a course from dropdown
4. Optionally check "Make Primary" to designate it as the main course
5. Click "Assign"

### Set Primary Course
1. In major details, find the course in the table
2. Click "Set Primary" (if not already primary)
3. This course will be used when students enroll in this major

### View Enrollments by Major
1. Go to a major's detail page
2. See list of students enrolled in this major
3. Check which course each student is currently taking

## Models

### Major Model
```php
$major = Major::find(1);

// Relationships
$major->courses()      // All courses in this major
$major->primaryCourse()  // The designated course for this major
$major->students()     // All students enrolled in this major
```

### Course Model (Updated)
```php
$course = Course::find(1);

// New relationship
$course->major()       // The major this course belongs to
```

### User Model (Updated)
```php
$user = User::find(1);

// New relationships
$user->major()         // Student's major
$user->assignedCourse()  // Student's assigned course (via FK)
```

## API Endpoints

### For Admins
- `GET /admin/majors` - List all majors
- `GET /admin/majors/create` - Show create form
- `POST /admin/majors` - Store new major
- `GET /admin/majors/{major}` - Show major details
- `GET /admin/majors/{major}/edit` - Show edit form
- `PUT /admin/majors/{major}` - Update major
- `DELETE /admin/majors/{major}` - Delete major
- `POST /admin/majors/{major}/assign-course` - Assign course to major
- `DELETE /admin/majors/{major}/courses/{course}` - Remove course from major
- `POST /admin/majors/{major}/courses/{course}/set-primary` - Set primary course

### For Students (Implicit)
- `GET /courses` - Redirects to major's designated course (if major assigned)

## Migration Instructions

Run migrations to create the new tables and columns:
```bash
php artisan migrate
```

This will:
1. Create `majors` table
2. Add `major_id` to `users` table
3. Add `major_id` and `is_primary` to `courses` table

## Example Setup

### Step 1: Create Majors
- IT (Information Technology)
- BM (Business Management)
- EC (E-Commerce)

### Step 2: Create Courses (or update existing)
For each major, create or designate courses:
- **IT Major**
  - Python Programming (primary)
  - Web Development
  - Database Design
  
- **BM Major**
  - Business Administration (primary)
  - Financial Management
  - Marketing Strategies

### Step 3: Test Registration
- Create new student account
- Select "Information Technology" major
- Student is automatically enrolled in "Python Programming" course

### Step 4: Verify Redirection
- Student logs in
- Visits `/courses`
- Automatically redirected to Python Programming course

## Features

✅ Automatic course assignment based on major
✅ Primary course designation per major
✅ Student major tracking
✅ Course-to-major relationships
✅ Admin UI for major management
✅ Updated registration form
✅ Smart redirection logic
✅ Fallback to assigned course

## Future Enhancements

- Multiple pathway support (students can switch majors)
- Course prerequisites by major
- Major-specific content variations
- Analytics by major
- Graduation requirements per major
- Major-based certificates

## Troubleshooting

### Student not redirected to designated course
- Check if student has `major_id` set
- Verify major has courses assigned
- Check if primary course is marked as `is_published = true`

### Cannot delete a major
- Major has students enrolled in it
- Transfer or delete students first

### Course not showing in major assignment dropdown
- Course must exist in database
- Check course is not already assigned to another major

## Database Queries

### Get all students in a major
```php
$major = Major::find(1);
$students = $major->students()->get();
```

### Get major's primary course
```php
$major = Major::find(1);
$course = $major->primaryCourse; // or ->primaryCourse()
```

### Find which major a course belongs to
```php
$course = Course::find(1);
$major = $course->major;
```

### Get all courses for a major
```php
$major = Major::find(1);
$courses = $major->courses()->where('is_published', true)->get();
```

## Files Modified/Created

### New Files
- `app/Models/Major.php`
- `app/Http/Controllers/MajorController.php`
- `database/migrations/2026_09_01_000000_create_majors_table.php`
- `database/migrations/2026_09_01_000001_add_major_relationships.php`
- `resources/views/admin/majors/index.blade.php`
- `resources/views/admin/majors/create.blade.php`
- `resources/views/admin/majors/edit.blade.php`
- `resources/views/admin/majors/show.blade.php`

### Modified Files
- `app/Models/User.php` - Added major relationship
- `app/Models/Course.php` - Added major relationship
- `app/Http/Controllers/AuthController.php` - Updated registration logic
- `app/Http/Controllers/CourseController.php` - Added major-based redirection
- `resources/views/auth/register.blade.php` - Changed course to major selection
- `routes/web.php` - Added major routes

## Support

For issues or questions, contact the admin panel at `/admin/majors`
