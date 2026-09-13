<?php

namespace Tests\Feature;

use App\Http\Livewire\Cart\CartComponent;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // App\Providers\RemoveProductAfterFewMinutes is a queued listener that
        // restores stock and clears the cart line after a delay (abandoned-cart
        // cleanup). Fake the queue so it doesn't run synchronously mid-test.
        Queue::fake();
    }

    public function test_adding_a_product_reduces_its_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);

        Livewire::actingAs($user)
            ->test(CartComponent::class)
            ->call('addProductCart', $product, 3);

        $this->assertSame(7, $product->fresh()->stock);
        $this->assertSame(1, $user->cart()->count());
        $this->assertSame(3, $user->cart()->first()->units);
    }

    public function test_total_products_counts_units_not_lines(): void
    {
        $user = User::factory()->create();
        $productA = Product::factory()->create(['stock' => 10]);
        $productB = Product::factory()->create(['stock' => 10]);

        $user->cart()->create(['product_id' => $productA->id, 'units' => 2, 'price' => $productA->price]);
        $user->cart()->create(['product_id' => $productB->id, 'units' => 5, 'price' => $productB->price]);

        // Two distinct cart lines, but 7 total units: the badge must reflect
        // units (matching CartTrait::totalProducts()), not the line count.
        $this->assertSame(2, $user->cart()->count());

        $component = Livewire::actingAs($user)->test(CartComponent::class);
        $this->assertSame(7, $component->get('total_products'));
    }

    public function test_clearing_a_cart_line_restores_product_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);

        $component = Livewire::actingAs($user)->test(CartComponent::class);
        $component->call('addProductCart', $product, 4);

        $this->assertSame(6, $product->fresh()->stock);

        $cart = $user->cart()->first();
        $component->call('clearCart', $cart);

        $this->assertSame(10, $product->fresh()->stock);
        $this->assertSame(0, $user->cart()->count());
    }

    public function test_cannot_add_more_units_than_available_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 2]);

        Livewire::actingAs($user)
            ->test(CartComponent::class)
            ->call('addProductCart', $product, 5)
            ->assertEmitted('openModal');

        $this->assertSame(2, $product->fresh()->stock);
        $this->assertSame(0, $user->cart()->count());
    }
}
