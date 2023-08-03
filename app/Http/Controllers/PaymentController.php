<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UPagosDirectService;

class PaymentController extends Controller
{
    private $uPagosDirect;

    public function __construct(UPagosDirectService $uPagosDirect)
    {
        $this->uPagosDirect = $uPagosDirect;
    }

    public function validateForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|numeric|digits_between:0,10',
            'order_number' => 'required|string',
            'card_number' => 'required|numeric|digits_between:8,16',
            'exp_date' => 'required|date_format:m/y',
            'cvv2cvv2' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        return response()->json(['status' => true]);
    }

    public function getToken()
    {
        return $this->uPagosDirect->getEfsToken();
    }

    public function verify(Request $request)
    {
        return $this->uPagosDirect->postData('creditcard/verify', $request->all());
    }

    public function sale(Request $request)
    {
        return $this->uPagosDirect->postData('creditcard/sale', $request->all());
    }
}
