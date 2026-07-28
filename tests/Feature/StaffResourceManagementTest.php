<?php

use App\Models\User;

it('renders the staff video, image, and powerpoint resource pages for staff users', function () {
    $staff = User::factory()->create([
        'role' => 'staff',
        'email' => 'staff-resource@example.com',
    ]);

    $this->actingAs($staff);

    $this->get(route('staff.videos.index'))->assertOk();
    $this->get(route('staff.images.index'))->assertOk();
    $this->get(route('staff.powerpoints.index'))->assertOk();
});
