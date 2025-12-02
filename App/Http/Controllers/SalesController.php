<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Model\QueryBuilder;

class SalesController
{
    private string $tableName = "sales";

    public function insert(Request $request)
    {
        $data = $request->only(['product_name', 'cost_price', 'sell_price', 'handling_charges']);

        $insertData = QueryBuilder::insertRecords($this->tableName, $data);

        if ($insertData) {
            Session::flash('success', 'Sale created successfully!');
            return redirect('/admin/sales');
        }

        Session::flash('error', base64_encode('Something went wrong!'));
        return redirect('/admin/sales/add');
    }

    public function edit(int $id)
    {
        $sale = QueryBuilder::fetchOneRecord($this->tableName, ['id' => $id]);
        return view('admin.sales.edit', compact('sale'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['product_name', 'cost_price', 'sell_price', 'handling_charges']);
        $id = $request->only(['id']);

        $updateRecord = QueryBuilder::updateRecord($this->tableName, $data, $id);

        if ($updateRecord) {
            Session::flash('success', 'Sale Updated successfully!');
            return redirect('/admin/sales/edit/' . $id['id']);
        }

        Session::flash('error', 'Something went wrong!');
        return redirect('/admin/sales/edit/' . $id['id']);
    }
}
