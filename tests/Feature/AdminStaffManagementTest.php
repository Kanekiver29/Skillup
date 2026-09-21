<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the staff management page for staff users', function () {
    $user = User::factory()->create([
        'role' => 'staff',
        'staff_type' => 'content_manager',
        'is_admin' => false,
    ]);

    $response = $this->actingAs($user)->get(route('admin.staff.index'));

    $response->assertOk();
    $response->assertSee('Staff Management');
});

it('shows the staff management page for admin users', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'staff_type' => null,
        'is_admin' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.staff.index'));

    $response->assertOk();
    $response->assertSee('Staff Management');
});
