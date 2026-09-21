@extends('layout.app')

@section('title', 'Settings - SkillUp')

@section('content')
	@php
		$settings = $user?->settings ?? [];
		$accountData = $settings['account'] ?? [];
		$learningData = $settings['learning_preferences'] ?? [];
		$appearanceData = $settings['appearance'] ?? [];
		$notificationsData = $settings['notifications'] ?? [];
		$privacyData = $settings['privacy'] ?? [];
		$securityData = $settings['security'] ?? [];
	@endphp

	<div class="skillup-settings-page min-h-screen bg-slate-100 py-10 text-slate-800">
		<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
			<div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
				<div>
					<p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-cyan-600">Profile & Preferences</p>
					<h1 class="text-3xl font-black tracking-tight text-slate-900">Settings</h1>
				</div>

				<div class="inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-3 py-2 text-sm font-medium text-cyan-700">
					<span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
					Account is active
				</div>
			</div>

			@if (session('success'))
				<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
					{{ session('success') }}
				</div>
			@endif

			<form method="POST" action="{{ route('user.settings.update') }}" class="space-y-6" data-appearance-settings>
				@csrf

				<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex items-center justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Account</p>
							<h2 class="mt-2 text-2xl font-bold text-slate-900">Account</h2>
						</div>
						<div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">Personal info</div>
					</div>

					<div class="grid gap-5 md:grid-cols-2">
						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="name">Full name</label>
							<input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100" required>
						</div>

						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="email">Email address</label>
							<input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100" required>
						</div>

						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="account_phone">Phone number</label>
							<input id="account_phone" name="account[phone]" type="tel" value="{{ old('account.phone', $accountData['phone'] ?? '') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100" placeholder="+1 (555) 123-4567">
						</div>

						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="account_language">Preferred language</label>
							<select id="account_language" name="account[language]" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								<option value="English" {{ old('account.language', $accountData['language'] ?? 'English') === 'English' ? 'selected' : '' }}>English</option>
								<option value="Filipino" {{ old('account.language', $accountData['language'] ?? 'English') === 'Filipino' ? 'selected' : '' }}>Filipino</option>
								<option value="Spanish" {{ old('account.language', $accountData['language'] ?? 'English') === 'Spanish' ? 'selected' : '' }}>Spanish</option>
							</select>
						</div>
					</div>
				</section>

				<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex items-center justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Learning</p>
							<h2 class="mt-2 text-2xl font-bold text-slate-900">Learning Preferences</h2>
						</div>
						<div class="rounded-full bg-violet-50 px-3 py-1 text-xs font-medium text-violet-700">Study style</div>
					</div>

					<div class="grid gap-5 md:grid-cols-2">
						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="learning_style">Preferred learning style</label>
							<select id="learning_style" name="learning_preferences[learning_style]" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								<option value="visual" {{ old('learning_preferences.learning_style', $learningData['learning_style'] ?? 'balanced') === 'visual' ? 'selected' : '' }}>Visual</option>
								<option value="auditory" {{ old('learning_preferences.learning_style', $learningData['learning_style'] ?? 'balanced') === 'auditory' ? 'selected' : '' }}>Auditory</option>
								<option value="kinesthetic" {{ old('learning_preferences.learning_style', $learningData['learning_style'] ?? 'balanced') === 'kinesthetic' ? 'selected' : '' }}>Hands-on</option>
								<option value="balanced" {{ old('learning_preferences.learning_style', $learningData['learning_style'] ?? 'balanced') === 'balanced' ? 'selected' : '' }}>Balanced</option>
							</select>
						</div>

						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="learning_pace">Learning pace</label>
							<select id="learning_pace" name="learning_preferences[pace]" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								<option value="steady" {{ old('learning_preferences.pace', $learningData['pace'] ?? 'steady') === 'steady' ? 'selected' : '' }}>Steady</option>
								<option value="fast" {{ old('learning_preferences.pace', $learningData['pace'] ?? 'steady') === 'fast' ? 'selected' : '' }}>Fast</option>
								<option value="deep" {{ old('learning_preferences.pace', $learningData['pace'] ?? 'steady') === 'deep' ? 'selected' : '' }}>Deep dive</option>
							</select>
						</div>

						<div class="md:col-span-2 space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="learning_tracks">Favorite tracks</label>
							<select id="learning_tracks" name="learning_preferences[tracks][]" multiple class="min-h-[120px] w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								@php $selectedTracks = old('learning_preferences.tracks', $learningData['tracks'] ?? []); @endphp
								<option value="Web Development" {{ is_array($selectedTracks) && in_array('Web Development', $selectedTracks, true) ? 'selected' : '' }}>Web Development</option>
								<option value="Data Science" {{ is_array($selectedTracks) && in_array('Data Science', $selectedTracks, true) ? 'selected' : '' }}>Data Science</option>
								<option value="Design" {{ is_array($selectedTracks) && in_array('Design', $selectedTracks, true) ? 'selected' : '' }}>Design</option>
								<option value="Business" {{ is_array($selectedTracks) && in_array('Business', $selectedTracks, true) ? 'selected' : '' }}>Business</option>
							</select>
						</div>
					</div>
				</section>

				<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex items-center justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Appearance</p>
							<h2 class="mt-2 text-2xl font-bold text-slate-900">Appearance</h2>
						</div>
						<div class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">Theme</div>
					</div>

					<div class="grid gap-5 md:grid-cols-3">
						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="appearance_theme">Theme</label>
							<select id="appearance_theme" name="appearance[theme]" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								<option value="light" {{ old('appearance.theme', $appearanceData['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>Light</option>
								<option value="dark" {{ old('appearance.theme', $appearanceData['theme'] ?? 'light') === 'dark' ? 'selected' : '' }}>Dark</option>
								<option value="system" {{ old('appearance.theme', $appearanceData['theme'] ?? 'light') === 'system' ? 'selected' : '' }}>System</option>
							</select>
						</div>

						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="appearance_font_size">Font size</label>
							<select id="appearance_font_size" name="appearance[font_size]" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								<option value="small" {{ old('appearance.font_size', $appearanceData['font_size'] ?? 'medium') === 'small' ? 'selected' : '' }}>Small</option>
								<option value="medium" {{ old('appearance.font_size', $appearanceData['font_size'] ?? 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
								<option value="large" {{ old('appearance.font_size', $appearanceData['font_size'] ?? 'medium') === 'large' ? 'selected' : '' }}>Large</option>
							</select>
						</div>

						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span>
								<span class="block text-sm font-semibold text-slate-800">Reduced motion</span>
								<span class="block text-xs text-slate-500">Minimize animations</span>
							</span>
							<input type="checkbox" name="appearance[reduced_motion]" value="1" {{ old('appearance.reduced_motion', $appearanceData['reduced_motion'] ?? false) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>
					</div>
				</section>

				<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex items-center justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Notifications</p>
							<h2 class="mt-2 text-2xl font-bold text-slate-900">Notifications</h2>
						</div>
						<div class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">Delivery</div>
					</div>

					<div class="grid gap-4 md:grid-cols-3">
						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span class="text-sm font-medium text-slate-800">Email updates</span>
							<input type="checkbox" name="notifications[email]" value="1" {{ old('notifications.email', $notificationsData['email'] ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>

						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span class="text-sm font-medium text-slate-800">Push alerts</span>
							<input type="checkbox" name="notifications[push]" value="1" {{ old('notifications.push', $notificationsData['push'] ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>

						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span class="text-sm font-medium text-slate-800">Weekly digest</span>
							<input type="checkbox" name="notifications[weekly_digest]" value="1" {{ old('notifications.weekly_digest', $notificationsData['weekly_digest'] ?? false) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>
					</div>
				</section>

				<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex items-center justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Privacy</p>
							<h2 class="mt-2 text-2xl font-bold text-slate-900">Privacy</h2>
						</div>
						<div class="rounded-full bg-pink-50 px-3 py-1 text-xs font-medium text-pink-700">Visibility</div>
					</div>

					<div class="grid gap-5 md:grid-cols-2">
						<div class="space-y-2">
							<label class="block text-sm font-semibold text-slate-700" for="privacy_visibility">Profile visibility</label>
							<select id="privacy_visibility" name="privacy[profile_visibility]" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-900 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
								<option value="public" {{ old('privacy.profile_visibility', $privacyData['profile_visibility'] ?? 'public') === 'public' ? 'selected' : '' }}>Public</option>
								<option value="students_only" {{ old('privacy.profile_visibility', $privacyData['profile_visibility'] ?? 'public') === 'students_only' ? 'selected' : '' }}>Students only</option>
								<option value="private" {{ old('privacy.profile_visibility', $privacyData['profile_visibility'] ?? 'public') === 'private' ? 'selected' : '' }}>Private</option>
							</select>
						</div>

						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span>
								<span class="block text-sm font-medium text-slate-800">Show contact details</span>
								<span class="block text-xs text-slate-500">Allow others to see your contact info</span>
							</span>
							<input type="checkbox" name="privacy[show_contact]" value="1" {{ old('privacy.show_contact', $privacyData['show_contact'] ?? false) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>
					</div>
				</section>

				<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex items-center justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Security</p>
							<h2 class="mt-2 text-2xl font-bold text-slate-900">Security</h2>
						</div>
						<div class="rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">Protection</div>
					</div>

					<div class="grid gap-4 md:grid-cols-2">
						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span>
								<span class="block text-sm font-medium text-slate-800">Two-factor authentication</span>
								<span class="block text-xs text-slate-500">Extra layer during sign-in</span>
							</span>
							<input type="checkbox" name="security[two_factor]" value="1" {{ old('security.two_factor', $securityData['two_factor'] ?? false) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>

						<label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 p-4">
							<span>
								<span class="block text-sm font-medium text-slate-800">Login alerts</span>
								<span class="block text-xs text-slate-500">Notify me about new sign-ins</span>
							</span>
							<input type="checkbox" name="security[login_alerts]" value="1" {{ old('security.login_alerts', $securityData['login_alerts'] ?? true) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
						</label>
					</div>
				</section>

				<div class="flex justify-end gap-3 pt-2">
					<a href="{{ route('userpage.dashboard') }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:bg-slate-50">Cancel</a>
					<button type="submit" class="inline-flex items-center rounded-xl bg-cyan-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-cyan-200 transition hover:bg-cyan-500">Save settings</button>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
<script>
	(() => {
		const form = document.querySelector('[data-appearance-settings]');
		if (!form) return;

		const root = document.documentElement;
		const theme = form.querySelector('#appearance_theme');
		const fontSize = form.querySelector('#appearance_font_size');
		const reducedMotion = form.querySelector('input[name="appearance[reduced_motion]"]');
		const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

		function applyAppearance() {
			const choice = theme.value;
			const activeTheme = choice === 'system' ? (systemTheme.matches ? 'dark' : 'light') : choice;
			root.dataset.skillupTheme = activeTheme;
			root.dataset.skillupThemeChoice = choice;
			root.dataset.skillupFontSize = fontSize.value;
			root.dataset.skillupReducedMotion = reducedMotion.checked ? 'true' : 'false';
			root.classList.toggle('dark-mode', activeTheme === 'dark');

			localStorage.setItem('skillup-appearance', JSON.stringify({
				theme: choice,
				font_size: fontSize.value,
				reduced_motion: reducedMotion.checked,
			}));
		}

		theme.addEventListener('change', applyAppearance);
		fontSize.addEventListener('change', applyAppearance);
		reducedMotion.addEventListener('change', applyAppearance);
		systemTheme.addEventListener('change', () => {
			if (theme.value === 'system') applyAppearance();
		});

		form.addEventListener('submit', () => {
			applyAppearance();
			localStorage.removeItem('skillup-appearance');
		});
	})();
</script>
@endpush
