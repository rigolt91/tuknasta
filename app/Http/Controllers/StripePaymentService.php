<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripePaymentService extends Controller
{
    protected ?StripeClient $client = null;

    public function __construct()
    {
        $secret = config('services.stripe.secret');

        if (!empty($secret)) {
            $this->client = new StripeClient($secret);
        }
    }

    public function createPaymentIntent(float $amount, string $orderNumber, string $currency = 'usd'): object
    {
        if (!$this->client) {
            return $this->gatewayError();
        }

        try {
            return $this->client->paymentIntents->create([
                'amount' => (int) round($amount * 100),
                'currency' => $currency,
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => ['order_number' => $orderNumber],
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Error creating Stripe PaymentIntent: ' . $e->getMessage());

            return $this->gatewayError();
        }
    }

    public function retrievePaymentIntent(string $paymentIntentId): object
    {
        if (!$this->client) {
            return $this->gatewayError();
        }

        try {
            return $this->client->paymentIntents->retrieve($paymentIntentId);
        } catch (ApiErrorException $e) {
            Log::error('Error retrieving Stripe PaymentIntent: ' . $e->getMessage());

            return $this->gatewayError();
        }
    }

    protected function gatewayError(): object
    {
        return (object) [
            'errorCode' => 'gateway_unreachable',
            'errorMessage' => __('Payment gateway is temporarily unavailable. Please try again later.'),
        ];
    }
}
