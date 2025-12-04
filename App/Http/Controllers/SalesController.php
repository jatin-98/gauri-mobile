<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Model\QueryBuilder;
use DB;
use Exception;

class SalesController
{
    private string $tableName = "sales";
    private string $productTable = "products";

    public function insert(Request $request)
    {
        try {
            QueryBuilder::beginTransaction();
            $data = $request->only(['product_name', 'cost_price', 'sell_price', 'handling_charges']);
            $productId = $request->only(['product_id']);

            $insertData = QueryBuilder::insertRecords($this->tableName, $data);

            if ($insertData) {
                DB::table($this->productTable)
                    ->where('id', $productId['product_id'])
                    ->decrement('stock', 1);
            }

            QueryBuilder::commit();

            Session::flash('success', 'Sale created successfully!');
            return redirect('/admin/sales');
        } catch (Exception $e) {
            Session::flash('error', base64_encode($e->getMessage()));
            return redirect('/admin/sales/add');
        }
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

    public function fetchProducts(Request $request)
    {
        $productName = $request->input('product_name');
        $query = DB::table($this->productTable)
            ->select('id', 'product_name');

        if (empty($productName)) {
            return $query->limit(5)->get();
        }

        $result = $query->where('product_name', 'LIKE', '%' . $productName . '%')->get();
        return json_encode($result);
    }
}
