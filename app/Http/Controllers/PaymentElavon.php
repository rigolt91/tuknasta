<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentElavon extends Controller
{
    protected $merchantId = '002516';
    protected $username = '';
    protected $password = 'webpage';
    protected $testMode = true;
    protected $params = [];

    public function __construct($amount, $card)
    {
        $this->params = [
            'amount'                => $amount,
            'card'                  => $card,
            'ssl_invoice_number'    => 1,
            'ssl_show_form'         => 'false',
            'ssl_result_format'     => 'ASCII',
        ];

        return $this->payment();
    }

    public function payment()
    {
        $gateway = Omnipay::create('Elavon_Converge')->initialize([
            'merchantId' => $this->merchantId,
            'username'   => $this->username,
            'password'   => $this->password,
            'testMode'   => $this->testMode,
        ]);

        $response = $gateway->purchase($this->params)->send();

        if ($response->isSuccessful())
        {
            $reference = $response->getTransactionReference();

            return $reference;

        } else {
            throw new ApplicationException($response->getMessage());
        }
    }
}

