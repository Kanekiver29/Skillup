<?php

return [
    'password' => env('APP_BACKUP_PASSWORD'),
    'retention_days' => (int) env('BACKUP_RETENTION_DAYS', 30),
    'seven_zip_path' => env('SEVEN_ZIP_PATH'),
    'mysqldump_path' => env('MYSQLDUMP_PATH'),
    'mysql_path' => env('MYSQL_PATH'),
];
