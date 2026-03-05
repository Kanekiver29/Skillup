# SkillUp Database Structure

## Overview
The SkillUp database is organized to support two main user types: **Regular Users** (learners) and **Admins** (managers).

---

## Users Table

### Regular User Fields
| Field | Type | Purpose |
|-------|------|---------|
| `id` | Integer | Primary key |
| `name` | String | User's full name |
| `email` | String (unique) | User's email address |
| `password` | String | Hashed password |
| `email_verified_at` | Timestamp | Email verification status |

### Admin Identification
| Field | Type | Purpose |
|-------|------|---------|
| `is_admin` | Boolean | **true** = Admin user, **false** = Regular user |

### Profile Information (All Users)
| Field | Type | Purpose |
|-------|------|---------|
| `bio` | Text | User biography/about section |
| `location` | String | User's location |
| `github_url` | String | GitHub profile link |
| `linkedin_url` | String | LinkedIn profile link |
| `twitter_url` | String | Twitter profile link |
| `portfolio_url` | String | Portfolio/personal website link |
| `skills` | JSON Array | List of user's skills |
| `profile_public` | Boolean | **true** = Profile visible publicly, **false** = Private |

### Learning Metrics (All Users)
| Field | Type | Purpose |
|-------|------|---------|
| `hours_spent` | Integer | Total hours spent learning on platform |

### System Fields
| Field | Type | Purpose |
|-------|------|---------|
| `created_at` | Timestamp | Account creation date |
| `updated_at` | Timestamp | Last profile update |
| `remember_token` | String | For "Remember Me" login functionality |

---

## Courses Table
**Purpose**: Store course information created/managed by admins

| Field | Type | Purpose |
|-------|------|---------|
| `id` | Integer | Primary key |
| `title` | String | Course name |
| `slug` | String (unique) | URL-friendly identifier (e.g., `web-development-101`) |
| `short_description` | Text | Brief summary for course listings |
| `description` | Long Text | Full detailed course description |
| `category` | String | Course category (e.g., Web Development, Design) |
| `level` | Enum | **Beginner**, **Intermediate**, or **Advanced** |
| `instructor_name` | String | Name of course instructor |
| `instructor_title` | String | Instructor's job title/expertise |
| `image_url` | String | Course cover image URL |
| `duration_hours` | Integer | Total course length in hours |
| `rating` | Float | Average user rating (0-5) |
| `students_count` | Integer | Number of enrolled students |
| `is_published` | Boolean | **true** = Published, **false** = Draft |
| `created_at` | Timestamp | Course creation date |
| `updated_at` | Timestamp | Last course update |

---

## Lessons Table
**Purpose**: Store individual lesson content within courses

| Field | Type | Purpose |
|-------|------|---------|
| `id` | Integer | Primary key |
| `course_id` | Foreign Key | Links to parent course |
| `title` | String | Lesson name |
| `description` | Text | Brief lesson overview |
| `content` | Long Text | Full lesson content/instructions |
| `video_url` | String | URL to lesson video (if applicable) |
| `duration_minutes` | Integer | Time to complete lesson |
| `order` | Integer | Position in course sequence (1, 2, 3...) |
| `is_published` | Boolean | **true** = Published, **false** = Draft |
| `created_at` | Timestamp | Lesson creation date |
| `updated_at` | Timestamp | Last lesson update |

---

## Enrollments Table
**Purpose**: Track which users are enrolled in which courses and their progress

| Field | Type | Purpose |
|-------|------|---------|
| `id` | Integer | Primary key |
| `user_id` | Foreign Key | Which user enrolled |
| `course_id` | Foreign Key | Which course they enrolled in |
| `progress` | Integer | Completion percentage (0-100) |
| `completed` | Boolean | **true** = Course finished, **false** = In progress |
| `completed_at` | Timestamp | When course was completed |
| `hours_spent` | Integer | Hours spent on this specific course |
| `created_at` | Timestamp | Enrollment date |
| `updated_at` | Timestamp | Last progress update |

**Constraint**: Each user can only enroll in a course once (unique user_id + course_id combination)

---

## Lesson_Enrollments Table
**Purpose**: Track individual lesson completion within a course enrollment

| Field | Type | Purpose |
|-------|------|---------|
| `id` | Integer | Primary key |
| `enrollment_id` | Foreign Key | Links to the course enrollment |
| `lesson_id` | Foreign Key | Links to the specific lesson |
| `completed` | Boolean | **true** = Lesson finished, **false** = Not done |
| `completed_at` | Timestamp | When lesson was completed |
| `created_at` | Timestamp | First access date |
| `updated_at` | Timestamp | Last progress update |

**Constraint**: Each lesson can only be marked complete once per enrollment (unique enrollment_id + lesson_id combination)

---

## User Roles Summary

### Regular User Capabilities
- ✅ Browse and enroll in courses
- ✅ View lessons and complete lessons
- ✅ Track course progress
- ✅ Manage profile and social links
- ✅ Build portfolio through completed courses
- ❌ Cannot create or edit courses
- ❌ Cannot access admin dashboard
- ❌ Cannot manage other users

### Admin Capabilities
- ✅ Everything a regular user can do
- ✅ Create and publish courses
- ✅ Create and organize lessons
- ✅ View platform analytics
- ✅ Manage user accounts
- ✅ Access admin dashboard
- ✅ Monitor student progress

---

## Data Relationships

```
users (1) ──→ (Many) enrollments
users (1) ──→ (Many) lesson_enrollments (via enrollments)

courses (1) ──→ (Many) lessons
courses (1) ──→ (Many) enrollments

lessons (1) ──→ (Many) lesson_enrollments

enrollments (1) ──→ (Many) lesson_enrollments
```

## Key Design Principles

1. **Simplicity**: Minimal fields, clear purpose for each column
2. **Clarity**: Comments explain field usage for both users and admins
3. **Data Integrity**: Constraints prevent duplicate records
4. **Scalability**: Structure supports adding more courses, users, and lessons
5. **Flexibility**: JSON skills field allows storing variable skill data
6. **Tracking**: Timestamps and progress fields enable analytics
