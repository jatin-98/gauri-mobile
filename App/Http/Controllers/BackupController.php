<?php

namespace App\Http\Controllers;

use App\Core\Session;
use App\Services\DatabaseBackup;
use App\Services\MailService;
use Exception;
use FilesystemIterator;

class BackupController
{

    private const __BACKUP_PATH__ = __DIR__ . '/../../../storage/backups/';
    private static function toEmail(): string { return env('BACKUP_TO_EMAIL'); }
    private const __EMAIL_SUBJECT = "Backup for Gauri Mobile";
    private const __INNER_CONTENT = "Please find your backup attached.";

    public function createBackup()
    {
        $backUp = DatabaseBackup::backup();

        if ($backUp['status']) {
            Session::flash('success', $backUp['message']);
            return redirect('/admin/backups');
        }

        Session::flash('error', $backUp['message']);
        return redirect('/admin/backups');
    }

    public function index()
    {
        $backups = [];
        
        if (is_dir(self::__BACKUP_PATH__)) {
            $directory = new FilesystemIterator(self::__BACKUP_PATH__);
            
            foreach ($directory as $file) {
                if ($file->isFile()) {
                    $cleanName = preg_replace('/[[:cntrl:]]/', '', base64_decode($file->getFilename()));
                    $cleanName = rtrim($cleanName, "* \t\n\r\0\x0B");

                    $backups[] = [
                        'name' => $cleanName,
                        'size' => formatSize($file->getSize()),
                        'created_date' => date("Y-m-d H:i:s", $file->getCTime()),
                        'raw_name' => $file->getFilename(),
                        'timestamp' => $file->getCTime(),
                    ];
                }
            }
        }

        usort($backups, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return view('admin.backups.index', compact('backups'));
    }

    public function delete(string $filename)
    {
        try {
            $filePath = self::__BACKUP_PATH__ . $filename;

            if (file_exists($filePath)) {
                unlink($filePath);
                Session::flash('success', "Backup Deleted Successfully!");
                return redirect('/admin/backups');
            }
        } catch (Exception $e) {
            Session::flash('error', base64_encode($e->getMessage()));
            return redirect('/admin/backups');
        }
    }

    public function send(string $filename)
    {
        $filePath = self::__BACKUP_PATH__ . $filename;

        if (!file_exists($filePath)) {
            Session::flash('error', base64_encode('Backup File Not Found'));
            return redirect('admin/backups');
        }

        $mailer = new MailService();

        try {
            $mailer->sendBackup(
                self::toEmail(),
                self::__EMAIL_SUBJECT,
                self::__INNER_CONTENT,
                file_get_contents($filePath),
                pathinfo($filename, PATHINFO_FILENAME)
            );

            Session::flash('success', "Backup sent Successfully!");
            return redirect('/admin/backups');
        } catch (Exception $e) {
            Session::flash('error', base64_encode($e->getMessage()));
            return redirect('/admin/backups');
        }
    }
}
