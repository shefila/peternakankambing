<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()['is_admin']) {
            return redirect('/order');
        }

        $products = Product::with('productDetails')->get();
        return redirect('/');
    }

    public function order(Request $request)
    {
        $currentUser = $request->user();
        $orders = $currentUser->orders()->where('status', '<>', 'draft')->get();
        return view('order.index', compact('orders'));
    }

    public function orderBuy(ProductDetail $productDetail)
    {
        if($productDetail['stock']==0){
            return redirect()->back()->withErrors('Stock Habis');
        }

        $product = $productDetail->product;
        $productDetails = $product->productDetails()->where('id',$productDetail['id'])->get()->toArray();
        $cart = new cart();
        $cart->destroy();
        $cart->create([
            'product' => $product->toArray(),
            'productDetails' => $productDetails,
            'product_detail_id' => $productDetail['id'],
            'amount' => 1
        ]);

        return redirect('/my/order/new');
    }

    public function createOrder(Request $request)
    {
        $currentUser = $request->user();
        $draftOrder = $currentUser->orders()->where('status', 'draft')->firstOrCreate([
            'user_id' => $currentUser['id'],
            'status' => 'draft'
        ]);

        $products = Product::with('productDetails')->get();
        $cart = Cart::all();
        $wallet = $currentUser->wallet;

        return view('order.create', compact('products', 'draftOrder', 'cart', 'wallet'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request['product_id']);
        $productDetails = $product->productDetails()->get()->toArray();
        $cart = new Cart();
        if ($cart->whereExist($product['id'])) {
            return redirect()->back()->withErrors('Kamu Hanya Bisa Membeli 1 Jenis Produk');
        } else {
            $cart->create([
                'product' => $product->toArray(),
                'productDetails' => $productDetails,
                'product_detail_id' => null,
                'amount' => 1
            ]);
        }

        return redirect()->back();
    }

    public function removeFromCart($id)
    {
        $cart = new Cart();
        $cart->delete($id);

        return redirect()->back();
    }

    public function submitOrder(Request $request)
    {
        $request->validate([
            'product_detail_id' => 'required',
            'amount' => 'required',
            'number' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping' => ['required', 'string',
                Rule::in(['DI AMBIL', 'DI ANTAR']),
            ],
            'use_wallet' => 'nullable|string'
        ]);
        if (isset($request['use_wallet'])) {
            $request['use_wallet'] = true;
        } else {
            $request['use_wallet'] = false;
        }

        for ($i = 0; $i < count($request['product_detail_id']); $i++) {
            $productDetail = ProductDetail::find($request['product_detail_id'][$i]);
            if ($productDetail['stock'] < $request['amount'][$i]) {
                return redirect()->back()->withErrors('Stock produk ' . $productDetail->product['name'] . ' - ' . $productDetail['detail'] . ' hanya ' . $productDetail['stock'] . ' tersisa');
            }
        }
        $currentUser = $request->user();
        $order = $currentUser->orders()->where('status', 'draft')->first();
        DB::transaction(function () use ($request, $order, $currentUser) {
            $wallet = $currentUser->wallet;
            $order['shipping'] = $request['shipping'];
            $order['number'] = $request['number'];
            $order['shipping_address'] = $request['shipping_address'];
            $order['status'] = $order->nextStatus();
            $order->save();

            $total = 0;
            for ($i = 0; $i < count($request['product_detail_id']); $i++) {
                $productDetail = ProductDetail::find($request['product_detail_id'][$i]);
                $order->orderDetails()->create([
                    'product_detail_id' => $request['product_detail_id'][$i],
                    'amount' => $request['amount'][$i],
                    'price' => $productDetail['price'],
                    'buy_price' => $productDetail['buy_price'],
                ]);
                $productDetail['stock'] -= $request['amount'][$i];
                $productDetail->save();
                $subTotal = $request['amount'][$i] * $productDetail['price'];
                $total += $subTotal;
            }

            if ($request['use_wallet']) {
                if ($total <= $wallet['cash']) {
                    $amount = $total;
                    $order['status'] = 'success_payment';
                    $order->save();
                } else {
                    $amount = $wallet['cash'];
                }

                $wallet->transactions()->create([
                    'order_id' => $order['id'],
                    'amount' => $amount,
                    'category' => Transaction::CATEGORY_BUY,
                    'status'=>Transaction::STATUS_SUCCESS,
                ]);
            }
        });

        $cart = new Cart();
        $cart->destroy();

        if($order['status'] === 'success_payment'){
            return redirect()->route('my.withdrawal')->withMessage('Pembayaran anda sudah berhasil');
        } else {
            return redirect()->route('my.order.detail.upload', $order['id'])->withMessage('Oke, Silahkan lakukan transfer sesuai instruksi');
        }
    }

    public function orderDetail(Order $order)
    {
        return view('order.show', compact('order'));
    }

    public function uploadForm(Order $order)
    {
        if ($order['status'] !== 'pending_payment') {
            abort(404);
        }
        return view('order.upload', compact('order'));
    }

    public function updatePayment(Request $request, Order $order)
    {
        if ($order['status'] !== 'pending_payment') {
            abort(404);
        }

        $request->validate([
            'payment_proof' => "required|file|mimes:jpeg,png,jpg,gif,svg|max:1000"
        ]);

        $image_path = $order['payment_proof'];
        if ($request->file('payment_proof') != '') {
            if($image_path !== null) {
                $productImage = str_replace('/storage', '', $image_path);
                Storage::delete('/public' . $productImage);
            }
            $main_image = uniqid() . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $request->file('payment_proof')->move(storage_path('app/public/payment_proof'), $main_image);
            $image_path = '/storage/payment_proof/' . $main_image;
        }
        $order['payment_proof'] = $image_path;
        $order->save();

        return redirect()->route('my.order.detail', $order['id'])->withMessage('Bukti Transfer Berhasil Diunggah');
    }

    public function withdrawalUser(Request $request)
    {
        $wallet = $request->user()->wallet;
        $wallet->load('transactions');
        $transactions = $wallet->transactions()->whereIn('category', [Transaction::CATEGORY_WITHDRAW])->get();
        return view('saving.withdrawal', compact('wallet', 'transactions'));
    }

    public function withdrawalUserSubmit(Request $request)
    {
        $wallet = $request->user()->wallet;
        $request->validate([
            'amount' => 'required|integer:min:10000|max:' . $wallet['cash'],
            'description' => 'required|string'
        ]);
        $description = [
            'alasan penarikan' => $request['description']
        ];
        $wallet->transactions()->create([
            'amount' => $request['amount'],
            'category' => Transaction::CATEGORY_WITHDRAW,
            'status' => Transaction::STATUS_WAITING_APPROVAL,
            'description' => json_encode($description)
        ]);

        return redirect()->back()->withMessage('Penarikan diproses, menunggu konfirmasi admin');
    }

    public function withdrawalUserCancel(Request $request, Transaction $transaction)
    {
        if ($transaction['status'] === Transaction::STATUS_WAITING_APPROVAL) {
            $transaction['status'] = Transaction::STATUS_CANCELLED;
            $transaction->save();
        }

        return redirect()->back()->withMessage('Penarikan dibatalkan');
    }
}
