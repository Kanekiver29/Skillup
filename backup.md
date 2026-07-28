**Backup Guide**

This document explains how to create full backups of the project (files + database), the available CLI command, the web UI behavior, scheduler example, and basic troubleshooting steps.

**Backup Location**: - Backups are stored on the local disk at `storage/app/backups`.

**Files changed / added**
- `app/Services/BackupService.php`: core backup logic (ZIP + Phar fallback).
- `app/Console/Commands/FullBackup.php`: `php artisan backup:full` CLI command.
- `app/Http/Controllers/Admin/BackupController.php`: web UI endpoint wired to the same backup behavior.

**Quick CLI usage**

- Create a full backup (includes `vendor` and `node_modules` by default):

```
php artisan backup:full
```

- Exclude heavy directories (omit `vendor` and `node_modules`):

```
php artisan backup:full --exclude-heavy
```

- Provide a target filename (placed in `storage/app/backups` if no path supplied):

```
php artisan backup:full --path=full_backup_20260706.zip
```

**Web UI**

- The admin Backup page (UI) exposes a "Full Backup" action and a checkbox named `include_all`. Checking that box includes `vendor`, `node_modules`, `.github`, `vite.config.js`, and top-level `*.php` files in the archive.

**Scheduler**

- A sample scheduler entry is provided in `app/Console/Kernel.php` (commented). To enable a daily backup at 02:00, uncomment or add:

```
$schedule->command('backup:full')->dailyAt('2:00');
```

Ensure the scheduler runs on the server (cron or Windows Task Scheduler invoking `php artisan schedule:run`).

**Restore**

- Use the web UI Restore action to restore a DB-only backup or a full backup archive.
- Full backup restore overwrites application files and database contents, and requires explicit confirmation on the restore form.
- By default `.env` is preserved during full restore; check the "Overwrite .env" option to replace it.

**Troubleshooting**

- ZIP fails with "Invalid or uninitialized Zip object" or similar:
  - Verify `ext-zip` is enabled: `php -r "echo extension_loaded('zip') ? 'zip ok' : 'zip missing';"`.
  - On XAMPP edit `php.ini` to enable `extension=zip` and restart Apache.
- Phar fallback fails due to `phar.readonly`:
  - Check `php -r "echo ini_get('phar.readonly');"` and set `phar.readonly = 0` in `php.ini` if necessary.
- Permission or write errors to `storage/app/backups` on Windows:
  - Ensure the PHP/Apache process has write access. Example using `icacls`:

```
icacls storage\app\backups /grant "IIS_IUSRS":(OI)(CI)F
```

  - Or grant the user account running Apache/PHP full control over the directory.
- Disk space: including `vendor` and `node_modules` can produce very large archives — check free disk space before running.

**Logs & Diagnostics**

- Recent errors and diagnostic information are written to `storage/logs/laravel.log`.
- The admin Backup page also shows a Diagnostics panel reporting `zip` availability, `PharData` availability, `phar.readonly`, `sys_get_temp_dir()`, `open_basedir`, and a tail of the Laravel log.

**Notes & Recommendations**

- Prefer running `php artisan backup:full` from CLI for large archives to avoid web request timeouts.
- For production, use scheduled CLI backups and offsite copies (S3, remote server) — this repo currently writes locally to `storage/app/backups`.
- Consider using a queued job or streaming backup approach if backups routinely exceed available memory/time.

**Files referenced**
- `app/Services/BackupService.php`
- `app/Console/Commands/FullBackup.php`
- `app/Http/Controllers/Admin/BackupController.php`
- `storage/app/backups`
- `storage/logs/laravel.log`
