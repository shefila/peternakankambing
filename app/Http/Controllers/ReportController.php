<?php

namespace App\Http\Controllers;

use App\Models\HistoryStock;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request, Product $product)
    {
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $orders = Order::where('status', 'done')
                ->whereDate('created_at', '>=', $request['start_date'])
                ->whereDate('created_at', '<=', $request['end_date'])
                ->whereHas('orderDetails', function($orderDetails) use ($product) {
                    $orderDetails->whereHas('productDetail', function($productDetail) use ($product) {
                        $productDetail->where('product_id', $product['id']);
                    });
                })->get();
        } else {
            $orders = Order::where('status', 'done')
            ->whereHas('orderDetails', function($orderDetails) use ($product) {
                $orderDetails->whereHas('productDetail', function($productDetail) use ($product) {
                    $productDetail->where('product_id', $product['id']);
                });
            })->get();
        }

        $pendingOrders = Order::whereNotIn('status', ['draft', 'done'])->get();
        $totalPending = 0;
        $totalComplete = 0;
        foreach ($pendingOrders as $pendingOrder) {
            $totalPending += ($pendingOrder->amount());
        }
        foreach ($orders as $completeOrder) {
            $totalComplete += ($completeOrder->amount());
        }

        return view('admin.report.index', compact('orders', 'totalComplete', 'totalPending','product'));
    }

    public function reports(Request $request){
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $orders = Order::where('status', 'done')
                ->whereDate('created_at', '>=', $request['start_date'])
                ->whereDate('created_at', '<=', $request['end_date'])
                ->get();
        } else {
            $orders = Order::where('status', 'done')->get();
        }

        $modal = 0;
        $omset = 0;
        $untungRugi = 0;
        foreach($orders as $order){
            $modal += $order->modal();
            $omset += $order->amount();
        }
        $untungRugi = ($omset-$modal);
        return view('admin.report.reports',compact('modal','omset','untungRugi','orders'));
    }

    public function stockHistory(){
        $historyStocks = HistoryStock::with('productDetail.product')->get();

        return view('admin.report.stock', compact('historyStocks'));
    }

}
