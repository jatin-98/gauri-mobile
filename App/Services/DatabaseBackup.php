<?php

namespace App\Services;

use DB;
use Exception;

class DatabaseBackup
{

    private const __FILE_PATH__ = __DIR__ . './../../storage/backups/';
    private const __DUMP_PATH__ = 'C:\xampp\mysql\bin\mysqldump.exe';

    public static function backup(): array
    {
        try {
            $config = DB::connection()->getConfig();

            $host = $config['host'] ?? 'localhost';
            $user = $config['username'];
            $pass = $config['password'];
            $dbName = $config['database'];

            // Full path for Windows
            $mysqldumpPath = self::__DUMP_PATH__;

            $backupFile = self::__FILE_PATH__ . "backup_{$dbName}_" . date('Y-m-d_H-i-s') . ".sql";

            // Use mysqldump native file option (avoid > redirection)
            $command = "\"$mysqldumpPath\" --user=\"$user\" --password=\"$pass\" --host=\"$host\" \"$dbName\" --single-transaction --quick --routines --result-file=\"$backupFile\"";

            exec($command . " 2>&1", $output, $status);

            return $status === 0
                ? ['status' => true, 'message' => "Backup created successfully: " . basename($backupFile)]
                : ['status' => false, 'message' => "Backup failed:\n" . implode("\n", $output)];
        } catch (Exception $e) {
            return ['status' => false, 'message' => base64_encode($e->getMessage())];
        }
    }
}
