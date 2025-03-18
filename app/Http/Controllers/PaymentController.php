<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $snapToken = session('snap_token');
        return view('payment.index', compact('snapToken'));
    }
}
