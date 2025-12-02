<?php

namespace App\Http\Controllers;

use App\Core\Session;
use App\Services\DatabaseBackup;

class BackupController
{
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
        return view('admin.backups.index');
    }
}
