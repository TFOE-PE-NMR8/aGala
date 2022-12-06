<?php

namespace App\Http\Controllers;

use App\Models\PaymentLog;

class PaymentLogController extends Controller
{
    public function index(){

        return view('backend.payment_logs.index');
    }

    public function log_data(){
        $data = PaymentLog::with(['registration', 'agent'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($data, 200);
    }
}
