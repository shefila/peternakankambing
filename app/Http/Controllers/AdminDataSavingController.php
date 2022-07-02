<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDataSavingController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin',0)->with('wallet')->get();
        return view('admin.datasaving.index', compact('users'));
    }

}
