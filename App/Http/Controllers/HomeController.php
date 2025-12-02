<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Model\QueryBuilder;
use DB;
use Exception;

class HomeController
{

    private string $salesTable = 'sales';
    private string $productsTable = 'products';

    public function index()
    {
        return 'Welcome to Laravel-style routing in Core PHP! Hurray';
    }

    public function admin()
    {
        $sales = QueryBuilder::fetchLimitedrecords($this->salesTable, 3, ['sale_date', 'desc']);
        $bestSellingProductsByProfit = $this->getBestSellingProductsByProfit();
        $bestSellingProductsByQuantity = $this->getBestSellingProductsByQuantity();
        $chartData = $this->getDataForChart();
        $productCount = $this->getProductCount();
        $stockCount = $this->getStockCount();
        $earnings = $this->getEarnings();

        return view('admin.dashboard.dashboard', compact('sales', 'bestSellingProductsByProfit', 'bestSellingProductsByQuantity', 'chartData', 'productCount', 'stockCount', 'earnings'));
    }

    public function getProductCount()
    {
        return QueryBuilder::getCount($this->productsTable);
    }

    public function getStockCount()
    {
        return DB::table($this->productsTable)->sum('stock');
    }

    public function getEarnings()
    {
        return DB::table($this->salesTable)->sum('profit');
    }

    public function getBestSellingProductsByProfit()
    {
        return DB::table($this->salesTable)
            ->select('product_name', DB::raw('SUM(profit) AS total_profit'), DB::raw('COUNT(*) AS total_sales'))
            ->groupBy('product_name')
            ->orderByDesc('total_profit')
            ->limit(3)
            ->get();
    }

    public function getBestSellingProductsByQuantity()
    {
        return DB::table($this->salesTable)
            ->select('product_name', DB::raw('COUNT(*) AS total_sales'), DB::raw('SUM(profit) AS total_profit'))
            ->groupBy('product_name')
            ->orderByDesc('total_sales')
            ->limit(3)
            ->get();
    }

    public function getDataForChart()
    {
        $data = DB::table($this->salesTable)
            ->select(
                DB::raw('DATE(sale_date) AS date'),
                DB::raw('COUNT(*) AS total_sales'),
                DB::raw('SUM(profit) AS total_profit')
            )
            ->groupBy(DB::raw('DATE(sale_date)'))
            ->orderBy(DB::raw('DATE(sale_date)'), 'ASC')
            ->get();

        return json_encode($data);
    }

    public function deleteRecord(Request $request)
    {
        try {
            $data = $request->only(['id', 'tableName']);
            $delete = QueryBuilder::deleteRecord($data['tableName'], $data['id']);

            if ($delete) {
                return json_encode(['success' => true]);
            }

            return json_encode(['error' => false]);
        } catch (Exception $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
