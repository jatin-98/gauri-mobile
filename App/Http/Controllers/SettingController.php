<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Model\QueryBuilder;
use DB;

class SettingController
{

    private string $tableName = "settings";

    public function settings()
    {
        $settings = DB::table($this->tableName)->get();
        $config = [];

        foreach ($settings as $item) {
            $config[$item->key] = $item->value ?? null;
        }

        return view('admin.settings.index', compact('config'));
    }

    public function insert(Request $request)
    {
        try {
            $data = $request->only(['key', 'value']);
            $insertData = QueryBuilder::insertRecords($this->tableName, $data);

            if ($insertData) {
                Session::flash('success', 'Configuration Added Successfully!');
                return redirect('/admin/settings');
            }
        } catch (\Exception $e) {
            Session::flash('success', base64_encode($e->getMessage()));
            return redirect('/admin/settings');
        }
    }
}
