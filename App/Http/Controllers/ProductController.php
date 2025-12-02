<?php

namespace App\Http\Controllers;

use App\Model\QueryBuilder;
use App\Core\Request;
use App\Core\Session;
use Exception;

class ProductController
{

    private string $tableName = 'products';

    public function edit(int $id)
    {
        $product = QueryBuilder::fetchOneRecord($this->tableName, ['id' => $id]);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['product_name', 'stock', 'product_description']);
        $id = $request->only(['id']);

        $updateRecord = QueryBuilder::updateRecord($this->tableName, $data, $id);

        if ($updateRecord) {
            Session::flash('success', 'Product Updated successfully!');
            return redirect('/admin/products');
        }

        Session::flash('error', 'Something went wrong!');
        return redirect('/admin/products');
    }

    public function insert(Request $request)
    {
        $data = $request->only(['product_name', 'stock', 'product_description']);

        if (!is_array($data['product_name'])) {

            $product = QueryBuilder::insertRecords($this->tableName, $data);

            if ($product) {
                Session::flash('success', 'Product created successfully!');
                return redirect('/admin/products');
            }

            Session::flash('error', 'Something went wrong!');
            return redirect('/admin/products/add');
        }

        return $this->insertInBatches($data);
    }

    public function insertInBatches(array $data)
    {
        try {
            $productNames = $data['product_name'];
            $stocks = $data['stock'];
            $productDescription = $data['product_description'];
            $data = [];

            foreach ($productNames as $key => $product) {
                $data[] = [
                    'product_name' => $product,
                    'stock' => $stocks[$key],
                    'product_description' => $productDescription[$key]
                ];
            }

            $insertedRecord = QueryBuilder::insertMultipleRecords($this->tableName, $data);

            if ($insertedRecord) {
                Session::flash('success', 'Product created successfully!');
                return redirect('/admin/products');
            }

            Session::flash('error', 'Something went wrong!');
            return redirect('/admin/products/add');
        } catch (Exception $e) {

            Session::flash('error', $e->getMessage());
            return redirect('/admin/products/add');
        }
    }
}
