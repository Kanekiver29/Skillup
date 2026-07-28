<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('allows a user to upload a profile image and displays it on profile', function () {
    // make sure upload directory exists in test environment
    $uploadDir = public_path('uploads/profiles');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('avatar.jpg');

    $response = $this->put(route('userpage.profile-update'), [
        'name' => $user->name,
        'email' => $user->email,
        'profile_image' => $file,
    ]);

    $response->assertRedirect(route('userpage.profile'));
    $response->assertSessionHas('success');

    $user->refresh();
    expect($user->profile_image)->toBeTruthy();
    // ensure the file physically exists
    $this->assertFileExists(public_path('uploads/profiles/' . $user->profile_image));

    // request profile page and verify image tag present
    $resp = $this->get(route('userpage.profile'));
    $resp->assertSee('uploads/profiles/' . $user->profile_image);
});

it('returns enrollment stats JSON for the logged in user', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'progress' => 42,
        'completed' => false,
    ]);

    $this->actingAs($user);

    $resp = $this->getJson(route('userpage.enrollments.stats'));
    $resp->assertStatus(200)
         ->assertJsonStructure([['id','course_id','progress','completed','course']]);
    $data = $resp->json();
    expect($data[0]['progress'])->toBe(42);
});
