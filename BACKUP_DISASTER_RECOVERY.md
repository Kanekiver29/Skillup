# Backup and Disaster Recovery

## Configuration

Set these values in the server `.env` file. Never commit `.env` or place the backup password in Blade, JavaScript, SQL, or a command argument.

```env
APP_BACKUP_PASSWORD=replace-with-a-long-random-secret
BACKUP_RETENTION_DAYS=30
SEVEN_ZIP_PATH="C:\Program Files\7-Zip\7z.exe"
MYSQLDUMP_PATH="C:\xampp\mysql\bin\mysqldump.exe"
MYSQL_PATH="C:\xampp\mysql\bin\mysql.exe"
```

The application stores backups under the private local disk at `storage/app/private/backups`. The archive contains the MySQL dump and important application/upload files, but excludes `.env`, caches, logs, Git metadata, `node_modules`, and previous backups. PHP's `ZipArchive` creates the payload and 7-Zip creates an AES-256 encrypted `.7z` archive with encrypted headers.

## Install Windows dependencies

1. Install 7-Zip from the official 7-Zip website.
2. Either add its installation directory to the Windows `PATH`, or set `SEVEN_ZIP_PATH` as shown above.
3. Confirm XAMPP MySQL exists at `C:\xampp\mysql\bin` or set `MYSQLDUMP_PATH` and `MYSQL_PATH` to the actual executable paths.
4. Enable PHP `zip` and `pdo_mysql` extensions in the PHP used by Apache and CLI.
5. Run `php artisan config:clear` after changing `.env`.

## Database and scheduler setup

```powershell
php artisan migrate --force
php artisan config:clear
php artisan route:list --name=backup
php artisan schedule:list
```

The application schedule runs a recorded, locked automatic backup every day at 02:00, a weekly automatic backup on Sunday at 02:30, and retention pruning at 02:45. Cache/config/route/view cleanup runs after that.

Laravel's scheduler must be invoked on Windows. In Task Scheduler, create a task that runs every minute:

- Program: `C:\path\to\php.exe`
- Arguments: `artisan schedule:run`
- Start in: `C:\xampp\htdocs\skillupv2`

Use the PHP executable that reports the same extensions as `php -m` in the project terminal.

## Admin workflow

Open `Admin -> System Maintenance -> Backup & Recovery`.

- `Backup Now` creates a manual encrypted backup.
- Upload accepts archive files into the private disk and records the checksum.
- Restore requires the archive password and an explicit confirmation.
- The archive is decrypted/extracted into a temporary directory and verified before the live system is changed.
- A pre-restore encrypted snapshot is created automatically.
- Restore, upload, delete, success, and failure events are written to `recovery_logs`.
- Concurrent backup and restore operations are blocked with Laravel cache locks.

The application never overwrites `.env` during a restore. Database passwords are supplied to `mysqldump` and `mysql` through a temporary client option file that is deleted after the process exits.

## 3-2-1 disaster recovery

Keep at least:

1. Three copies: production data, the local encrypted backup, and an additional copy.
2. Two media/locations: the server disk plus an external disk or NAS.
3. One off-site copy: a restricted cloud bucket, encrypted external drive stored elsewhere, or a remote backup server.

For cloud storage, configure Laravel's S3-compatible disk using deployment-secret storage or the machine's secret manager. Do not put cloud credentials in the archive, database, Blade pages, JavaScript, or source control. Copy completed encrypted files from `storage/app/private/backups` to the off-site location using a separate scheduled job and verify SHA-256 checksums.

## Verification checklist

```powershell
php artisan backup:full --exclude-heavy --type=manual
php artisan backup:prune --days=30
php artisan schedule:list
```

Test each release with a non-production restore: manual backup, automatic schedule, MySQL dump, uploaded-file recovery, encrypted archive extraction, incorrect password rejection, corrupted archive rejection, successful restore, failed restore rollback/safety snapshot, deletion, retention pruning, and unauthorized access. At least once per term, restore onto a clean XAMPP installation and record the result.
