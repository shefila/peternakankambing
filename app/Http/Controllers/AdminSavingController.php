<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminSavingController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('saving_id', '<>', null)
            ->where('status', Transaction::STATUS_WAITING_APPROVAL)
            ->where('category', Transaction::CATEGORY_DEPOSIT)
            ->get();
        $transactions->load('wallet.user', 'savingRelation');
        return view('admin.saving.index', compact('transactions'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status'=>'required|string|in:success,failed'
        ]);
        $transaction['status'] = $request['status'];
        $transaction->save();

        return redirect()->back()->withMessage('Status Updated');
    }
}
