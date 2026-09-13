<?php

namespace Tests\Feature\Payment;

use App\Http\Controllers\UPagosDirectService;
use App\Http\Livewire\Payment\ConfirmComponent;
use App\Models\DeliveryMethod;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ConfirmComponentTest extends TestCase
{
    use RefreshDatabase;

    private function makeCheckoutUser(): User
    {
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id, 'prefer' => true]);

        $product = Product::factory()->create(['stock' => 10, 'price' => 25]);
        $user->cart()->create(['product_id' => $product->id, 'units' => 2, 'price' => 25]);

        return $user;
    }

    public function test_order_is_created_when_upagos_verifies_the_payment(): void
    {
        Mail::fake();

        OrderStatus::factory()->create();
        $deliveryMethod = DeliveryMethod::factory()->create();
        $user = $this->makeCheckoutUser();

        $this->mock(UPagosDirectService::class, function ($mock) {
            $mock->shouldReceive('postData')
                ->once()
                ->with('creditcard/verify', \Mockery::type('array'))
                ->andReturn((object) ['result' => '0']);
        });

        Livewire::actingAs($user)
            ->test(ConfirmComponent::class, ['method' => $deliveryMethod->id])
            ->call('paymentConfirm');

        $this->assertSame(1, UserOrder::where('user_id', $user->id)->where('payment', true)->count());
        $this->assertSame(0, $user->cart()->count());
        // OrderShipped implements ShouldQueue, so Mailer::send() queues it
        // rather than dispatching it synchronously.
        Mail::assertQueued(\App\Mail\OrderShipped::class);
    }

    public function test_order_is_not_created_when_upagos_does_not_verify_the_payment(): void
    {
        Mail::fake();

        $deliveryMethod = DeliveryMethod::factory()->create();
        $user = $this->makeCheckoutUser();

        // Simulates a forged client-side call to paymentConfirm() without a
        // real, successful transaction at UPagos.
        $this->mock(UPagosDirectService::class, function ($mock) {
            $mock->shouldReceive('postData')
                ->once()
                ->with('creditcard/verify', \Mockery::type('array'))
                ->andReturn((object) ['result' => '1']);
        });

        Livewire::actingAs($user)
            ->test(ConfirmComponent::class, ['method' => $deliveryMethod->id])
            ->call('paymentConfirm');

        $this->assertSame(0, UserOrder::where('user_id', $user->id)->count());
        $this->assertSame(2, (int) $user->cart()->sum('units'));
        Mail::assertNothingSent();
    }
}
