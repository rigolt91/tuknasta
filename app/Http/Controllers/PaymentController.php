<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return $request->all();
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
