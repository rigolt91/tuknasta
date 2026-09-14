<?php

namespace App\Http\Controllers;

use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (UnexpectedValueException|SignatureVerificationException $e) {
            Log::error('Invalid Stripe webhook payload: ' . $e->getMessage());

            return response()->json(['error' => 'Invalid payload'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;

            $order = UserOrder::where('stripe_payment_intent_id', $paymentIntent->id)->first();

            if ($order && !$order->payment) {
                $order->update(['payment' => true]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
