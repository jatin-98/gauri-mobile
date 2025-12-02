<?php

namespace App\Http\Controllers;

use App\Core\Session;
use App\Services\DatabaseBackup;
use Exception;
use FilesystemIterator;

class BackupController
{

    private const __BACKUP_PATH__ = __DIR__ . '/../../../storage/backups/';

    public function createBackup()
    {
        $backUp = DatabaseBackup::backup();

        if ($backUp['status']) {
            Session::flash('success', $backUp['message']);
            return redirect('/admin/backups');
        }

        return Session::flash('error', $backUp['message']);
        return redirect('/admin/backups');
    }

    public function index()
    {
        $directory = new FilesystemIterator(self::__BACKUP_PATH__);
        $backups = [];

        foreach ($directory as $file) {
            if ($file->isFile()) {
                $cleanName = preg_replace('/[[:cntrl:]]/', '', base64_decode($file->getFilename()));
                $cleanName = rtrim($cleanName, "* \t\n\r\0\x0B");

                $backups[] = [
                    'name' => $cleanName,
                    'size' => formatSize($file->getSize()),
                    'created_date' => date("Y-m-d H:i:s", $file->getCTime()),
                    'raw_name' => $file->getFilename(),
                ];
            }
        }

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
            return Session::flash('error', base64_encode($e->getMessage()));
            return redirect('/admin/backups');
        }
    }
}
