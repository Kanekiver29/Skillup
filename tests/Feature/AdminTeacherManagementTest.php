<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the teacher management page for staff users', function () {
    $user = User::factory()->create([
        'role' => 'staff',
        'staff_type' => 'content_manager',
        'is_admin' => false,
    ]);

    $response = $this->actingAs($user)->get(route('admin.teachers.index'));

    $response->assertOk();
    $response->assertSee('Teacher Management');
});
