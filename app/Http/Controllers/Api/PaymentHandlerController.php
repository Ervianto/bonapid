<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMidtrains;

class PaymentHandlerController extends Controller
{
    
    public function handler(Request $request)
    {
        $json = json_decode($request->getContent());

        $signature_key = hash('sha512', $json->order_id.$json->status_code.$json->gross_amount.env('MIDTRAINS_SERVER_KEY'));
        
        if($signature_key != $json->signature_key){
            return abort(404);
        }

        $order = PaymentMidtrains::where('order_id', $json->order_id)
            ->update([
                'status' => $json->transaction_status
            ]);

        return $order;
    }

}
