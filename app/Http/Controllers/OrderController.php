<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('status','<>','draft')->with('orderDetails', 'user')->get();
        return view('admin.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if(!in_array($request['status'], Order::STATUS_OPTION)){
            abort(404);
        }

        $order['status'] = $request['status'];
        $order->save();

        return redirect()->back()->withMessage('Order status updated');
    }
}
