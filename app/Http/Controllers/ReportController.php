<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $orders = Order::where('status', 'done')
                ->whereDate('created_at', '>=', $request['start_date'])
                ->whereDate('created_at', '<=', $request['end_date'])
                ->get();
        } else {
            $orders = Order::where('status', 'done')->get();
        }

        $completeOrders = Order::where('status', 'done')->get();
        $pendingOrders = Order::where('status', '<>', 'done')->get();
        $totalPending = 0;
        $totalComplete = 0;
        foreach ($pendingOrders as $pendingOrder) {
            $totalPending += ($pendingOrder->amount());
        }
        foreach ($completeOrders as $completeOrder) {
            $totalComplete += ($completeOrder->amount());
        }

        return view('admin.report.index', compact('orders', 'totalComplete', 'totalPending'));
    }
}
