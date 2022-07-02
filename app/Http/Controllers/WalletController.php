<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function index()
    {
        $transactions = Transaction::whereIn('category',[Transaction::CATEGORY_WITHDRAW])
            ->whereIn('status',[Transaction::STATUS_WAITING_APPROVAL,Transaction::STATUS_SUCCESS])
            ->with('wallet.user')
            ->get();
        return view('admin.withdrawal.index', compact('transactions'));
    }

    public function confirm(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_proof' => "required|file|mimes:jpeg,png,jpg,gif,svg|max:1000"
        ]);

        $image_path = $transaction['payment_proof'];
        if ($request->file('payment_proof') != '') {
            $main_image = uniqid() . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $request->file('payment_proof')->move(storage_path('app/public/payment_proof'), $main_image);
            $image_path = '/storage/payment_proof/' . $main_image;
        }
        $transaction['payment_proof'] = $image_path;
        $transaction['status'] = Transaction::STATUS_SUCCESS;
        $transaction->save();

        return redirect()->route('withdrawal.index')->withMessage('Payment proof uploaded');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        $request->validate([
            'description' => 'required|string'
        ]);

        if($transaction['description'] !== null) {
            $description = json_decode($transaction['description'], true);
        }
        $description['alasan penolakan'] = $request['description'];

        $transaction['description'] = json_encode($description);
        $transaction['status'] = Transaction::STATUS_FAILED;
        $transaction->save();

        return redirect()->route('withdrawal.index')->withMessage('Withdraw rejected');
    }
}

