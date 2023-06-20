<?php

namespace App\Http\Controllers;
use App\Models\TransactionType;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['transaction_type'] = TransactionType::all();
        return view('home', $data);
    }

    public function pay(Request $request)
    {   
        return view('pay');
    }
}
