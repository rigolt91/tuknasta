<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\StripePaymentService;

class PaymentController extends Controller
{
    private $stripe;

    public function __construct(StripePaymentService $stripe)
    {
        $this->stripe = $stripe;
    }

    public function validateForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|string',
            'amount' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        return response()->json(['status' => true]);
    }

    public function createIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'order_number' => 'required|string',
        ]);

        $paymentIntent = $this->stripe->createPaymentIntent($request->amount, $request->order_number);

        if (isset($paymentIntent->errorCode)) {
            return response()->json($paymentIntent, 502);
        }

        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
            'id' => $paymentIntent->id,
        ]);
    }
}
