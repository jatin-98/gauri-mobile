<?php

namespace App\Http\Controllers;

use App\Core\Request;
use DB;

class DatatableController
{
    public function index(Request $request)
    {
        $data = $request->only([
            'draw',
            'start',
            'length',
            'order',
            'columns',
            'search',
            'tableName',
            'searchableColumns',
            'orderbyColumns',
            'includeViewButton',
            'editUrl'
        ]);

        $draw = $data['draw'];
        $start = $data['start'];
        $length = $data['length'];
        $searchValue = $data['search']['value'] ?? '';
        $tableName = $data['tableName'];
        $searchableColumns = $data['searchableColumns'];
        $orderbyColumns = $data['orderbyColumns'];
        $includeViewButton = $data['includeViewButton'] ?? null;
        $editUrl = $data['editUrl'] ?? null;

        $query = DB::table($tableName);

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue, $searchableColumns) {
                foreach ($searchableColumns as $columns) {
                    $q->orWhere($columns, 'LIKE', "%{$searchValue}%");
                }
            });
        }

        if (!empty($data['order'])) {
            $orderColumnIndex = $data['order'][0]['column'];
            $orderDir = $data['order'][0]['dir'];

            $orderColumn = $data['columns'][$orderColumnIndex]['data'];

            if ($orderColumnIndex == 0 || !in_array($orderColumn, $orderbyColumns)) {
                $query->orderBy('created_at', 'desc');
            } else {
                $query->orderBy($orderColumn, $orderDir);
            }
        }

        $totalFiltered = $query->count();
        $records = $query->offset($start)->limit($length)->get();
        $dataArr = [];
        $index = $start + 1;

        foreach ($records as $row) {
            $rowArr = ['DT_RowIndex' => $index++];

            foreach ($data['columns'] as $col) {
                $colName = $col['data'];
                if (isset($row->$colName)) {
                    $rowArr[$colName] = $row->$colName ?? null;
                }
            }

            $viewButton = '';
            $deleteButton = '<button class="btn btn-sm btn-danger" onclick="deleteRecord(' . $row->id . ',`' . $tableName . '`,`' . url('/admin/delete-record') . '`)">Delete</button>';
            $editButtonUrl = "$editUrl/$row->id";
            $editButton = '<button class="btn btn-sm btn-primary" onclick="navigateViaJs(`' . $editButtonUrl . '`)">Edit</button>';

            if ($includeViewButton != null) {
                $link = url('/admin/invoices/view/' . $row->id);
                $viewButton = '<button class="btn btn-sm btn-success" onclick="navigateViaJs(`' . $link . '`)">View</button>';
            }

            $rowArr['action'] = $editButton .
                ' ' . $deleteButton .
                ' ' . $viewButton;

            $dataArr[] = $rowArr;
        }

        return json_encode([
            'draw' => intval($draw),
            'recordsTotal' => DB::table($tableName)->count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $dataArr
        ]);
    }
}
