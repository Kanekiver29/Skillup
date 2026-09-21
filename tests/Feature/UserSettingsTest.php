<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_and_update_settings(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $this->actingAs($user)
            ->get(route('user.settings'))
            ->assertOk()
            ->assertSee('Account')
            ->assertSee('Learning Preferences');

        $response = $this->actingAs($user)->from(route('user.settings'))->post(route('user.settings.update'), [
            'account' => [
                'phone' => '+1234567890',
                'language' => 'English',
            ],
            'learning_preferences' => [
                'learning_style' => 'visual',
                'pace' => 'steady',
                'tracks' => ['Web Development', 'Design'],
            ],
            'appearance' => [
                'theme' => 'dark',
                'font_size' => 'large',
                'reduced_motion' => '1',
            ],
            'notifications' => [
                'email' => '1',
                'push' => '1',
                'weekly_digest' => '1',
            ],
            'privacy' => [
                'profile_visibility' => 'private',
                'show_contact' => '0',
            ],
            'security' => [
                'two_factor' => '1',
                'login_alerts' => '1',
            ],
        ]);

        $response->assertRedirect(route('user.settings'));

        $user->refresh();

        $this->assertSame('Jane Doe', $user->name);
        $this->assertSame('+1234567890', $user->settings['account']['phone']);
        $this->assertSame('dark', $user->settings['appearance']['theme']);
        $this->assertSame('visual', $user->settings['learning_preferences']['learning_style']);
        $this->assertTrue((bool) $user->settings['security']['two_factor']);
    }
}
