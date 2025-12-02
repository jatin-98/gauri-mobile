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

            $backUpFileName = base64_encode(date('Y-m-d_H:i:s'));
            $backupFile = self::__FILE_PATH__ . $backUpFileName . ".sql";

            // Use mysqldump native file option (avoid > redirection)
            $command = "\"$mysqldumpPath\" --user=\"$user\" --password=\"$pass\" --host=\"$host\" \"$dbName\" --single-transaction --quick --routines --result-file=\"$backupFile\"";

            exec($command . " 2>&1", $output, $status);

            return $status === 0
                ? ['status' => true, 'message' => "Backup created successfully: " . base64_decode($backUpFileName)]
                : ['status' => false, 'message' => "Backup failed:\n" . implode("\n", $output)];
        } catch (Exception $e) {
            return ['status' => false, 'message' => base64_encode($e->getMessage())];
        }
    }
}
