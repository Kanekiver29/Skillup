<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Show the admin settings page.
     */
    public function index(Request $request)
    {
        // Only admins may access settings
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        // Collect current env-based or config-based settings to pass to the view.
        // These are read-only display values; actual mutations go through update().
        $settings = [
            'app_name'            => config('app.name'),
            'app_env'             => config('app.env'),
            'app_debug'           => config('app.debug'),
            'app_url'             => config('app.url'),
            'mail_mailer'         => config('mail.default'),
            'mail_from_address'   => config('mail.from.address'),
            'mail_from_name'      => config('mail.from.name'),
            'cache_driver'        => config('cache.default'),
            'session_driver'      => config('session.driver'),
            'session_lifetime'    => config('session.lifetime'),
            'queue_connection'    => config('queue.default'),
            'filesystems_default' => config('filesystems.default'),
        ];

        return view('Admin.settings', compact('settings'));
    }

    /**
     * Handle settings form submission.
     * Values are persisted to the .env file via a safe key-value update.
     */
    public function update(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $section = $request->input('section', 'general');

        // Validate per-section so tabbed saves work independently.
        if ($section === 'email') {
            $validated = $request->validate([
                'mail_from_address' => ['required', 'email', 'max:255'],
                'mail_from_name'    => ['required', 'string', 'max:100'],
            ]);

            $envUpdates = [
                'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
                'MAIL_FROM_NAME'    => $validated['mail_from_name'],
            ];
        } else { // general (default)
            $validated = $request->validate([
                'app_name'          => ['required', 'string', 'max:100'],
                'app_url'           => ['required', 'url', 'max:255'],
                'session_lifetime'  => ['required', 'integer', 'min:1', 'max:10080'],
            ]);

            // Only update known, safe keys to prevent injection.
            $envUpdates = [
                'APP_NAME'         => $validated['app_name'],
                'APP_URL'          => $validated['app_url'],
                'SESSION_LIFETIME' => (string) $validated['session_lifetime'],
            ];
        }

        $this->updateEnvFile($envUpdates);

        // Clear config cache so changes take effect immediately.
        Artisan::call('config:clear');

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Settings updated successfully.']);
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear one or all Laravel caches.
     * Accepted types: config | route | view | all
     */
    public function clearCache(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $type = $request->input('type', 'config');

        $map = [
            'config' => ['config:clear'],
            'route'  => ['route:clear'],
            'view'   => ['view:clear'],
            'all'    => ['config:clear', 'route:clear', 'view:clear'],
        ];

        if (! array_key_exists($type, $map)) {
            abort(422, 'Invalid cache type.');
        }

        foreach ($map[$type] as $command) {
            Artisan::call($command);
        }

        $label = $type === 'all' ? 'All caches' : ucfirst($type) . ' cache';

        if ($request->expectsJson()) {
            return response()->json(['message' => $label . ' cleared successfully.']);
        }

        return redirect()->route('admin.settings')->with('success', $label . ' cleared successfully.');
    }

    /**
     * Toggle maintenance mode on/off.
     */
    public function toggleMaintenance(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            $message = 'Application is now live.';
        } else {
            Artisan::call('down', [
                '--secret' => bin2hex(random_bytes(16)),
                '--render' => 'errors::503',
            ]);
            $message = 'Maintenance mode enabled.';
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.settings')->with('success', $message);
    }

    /**
     * Safely update key=value pairs in the .env file.
     * Only pre-approved keys are written; values are quoted when they contain spaces.
     */
    private function updateEnvFile(array $updates): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        foreach ($updates as $key => $value) {
            // Sanitize key: only uppercase letters, digits, underscores.
            if (! preg_match('/^[A-Z0-9_]+$/', $key)) {
                continue;
            }

            // Quote value if it contains spaces or special shell characters.
            $safeValue = preg_match('/\s/', $value) ? '"' . addslashes($value) . '"' : $value;

            // Replace existing key or append if not found.
            $pattern     = '/^' . preg_quote($key, '/') . '=.*/m';
            $replacement = $key . '=' . $safeValue;

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $replacement, $content);
            } else {
                $content .= PHP_EOL . $replacement;
            }
        }

        file_put_contents($envPath, $content);
    }
}
