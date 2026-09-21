<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_area_while_public_site_is_in_maintenance_mode(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        $this->actingAs($admin)
            ->from(route('admin.settings'))
            ->post(route('admin.settings.maintenance'), [
                'maintenance_reason' => 'System update and database maintenance from 10:00 AM to 12:00 PM.',
            ])
            ->assertRedirect(route('admin.settings'));

        $this->assertTrue(app()->isDownForMaintenance());

        $this->actingAs($admin)
            ->get('/admin/settings')
            ->assertOk();

        $this->actingAs(null)
            ->get('/login')
            ->assertStatus(200);
    }
}
