<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class UserSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (request()->routeIs('sias.teacher.settings', 'sias.student.settings')) {
            $view = request()->routeIs('sias.student.settings')
                ? 'sias.students.setting'
                : 'sias.teacher.setting';

            return view($view, [
                'user' => $user,
                'settings' => $user?->settings ?? [],
            ]);
        }

        return view('Userpage.setting.setting', [
            'user' => $user,
            'settings' => $user?->settings ?? [],
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $isPortalSettings = $request->routeIs('sias.teacher.settings.update', 'sias.student.settings.update');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'account.phone' => ['nullable', 'string', 'max:40'],
            'account.language' => ['required', 'in:English,Filipino'],
            'appearance.theme' => ['required', 'in:light,dark,system'],
            'appearance.font_size' => ['required', 'in:small,medium,large'],
            'appearance.reduced_motion' => ['nullable', 'boolean'],
            'notifications.email' => ['nullable', 'boolean'],
            'notifications.push' => ['nullable', 'boolean'],
            'notifications.weekly_digest' => ['nullable', 'boolean'],
            'privacy.profile_visibility' => ['required', 'in:public,students_only,private'],
            'privacy.show_contact' => ['nullable', 'boolean'],
        ];

        if (! $isPortalSettings) {
            $rules += [
                'learning_preferences.learning_style' => ['required', 'in:visual,auditory,kinesthetic,balanced'],
                'learning_preferences.pace' => ['required', 'in:steady,fast,deep'],
                'learning_preferences.tracks' => ['nullable', 'array'],
                'learning_preferences.tracks.*' => ['string', 'in:Web Development,Data Science,Design,Business'],
            ];
        }

        $request->validate($rules);
        $existingSettings = $user->settings ?? [];

        $settings = [
            ...$existingSettings,
            'account' => [
                ...($existingSettings['account'] ?? []),
                'phone' => $request->input('account.phone', $user?->settings['account']['phone'] ?? ''),
                'language' => $request->input('account.language', $user?->settings['account']['language'] ?? 'English'),
            ],
            'learning_preferences' => $isPortalSettings ? ($existingSettings['learning_preferences'] ?? []) : [
                'learning_style' => $request->input('learning_preferences.learning_style', $user?->settings['learning_preferences']['learning_style'] ?? 'balanced'),
                'pace' => $request->input('learning_preferences.pace', $user?->settings['learning_preferences']['pace'] ?? 'steady'),
                'tracks' => $request->input('learning_preferences.tracks', $user?->settings['learning_preferences']['tracks'] ?? []),
            ],
            'appearance' => [
                ...($existingSettings['appearance'] ?? []),
                'theme' => $request->input('appearance.theme', $user?->settings['appearance']['theme'] ?? 'light'),
                'font_size' => $request->input('appearance.font_size', $user?->settings['appearance']['font_size'] ?? 'medium'),
                'reduced_motion' => (bool) $request->boolean('appearance.reduced_motion'),
            ],
            'notifications' => [
                ...($existingSettings['notifications'] ?? []),
                'email' => (bool) $request->boolean('notifications.email'),
                'push' => (bool) $request->boolean('notifications.push'),
                'weekly_digest' => (bool) $request->boolean('notifications.weekly_digest'),
            ],
            'privacy' => [
                ...($existingSettings['privacy'] ?? []),
                'profile_visibility' => $request->input('privacy.profile_visibility', $user?->settings['privacy']['profile_visibility'] ?? 'public'),
                'show_contact' => (bool) $request->boolean('privacy.show_contact'),
            ],
            'security' => $isPortalSettings ? ($existingSettings['security'] ?? []) : [
                'two_factor' => (bool) $request->boolean('security.two_factor'),
                'login_alerts' => (bool) $request->boolean('security.login_alerts'),
            ],
        ];

        unset($settings['mentor_support']);

        $user->update([
            'name' => $request->input('name', $user->name),
            'email' => $request->input('email', $user->email),
            'profile_public' => $request->input('privacy.profile_visibility') === 'public',
            'settings' => $settings,
        ]);

        if ($isPortalSettings) {
            $locale = $request->input('account.language') === 'Filipino' ? 'tl' : 'en';
            $request->session()->put('locale', $locale);
            App::setLocale($locale);
        }

        $route = match (true) {
            $request->routeIs('sias.teacher.settings.update') => 'sias.teacher.settings',
            $request->routeIs('sias.student.settings.update') => 'sias.student.settings',
            default => 'user.settings',
        };

        return redirect()->route($route)->with('success', 'Your settings were saved successfully.');
    }
}