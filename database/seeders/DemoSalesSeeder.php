<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\OrderStatus;
use App\Models\DeliveryMethod;
use App\Models\Product;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserOrder;
use App\Models\UserPurchasedProduct;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = $this->seedCustomers();

        $products = Product::all();
        $orderStatusIds = OrderStatus::pluck('id')->all();
        $deliveryMethodIds = DeliveryMethod::pluck('id')->all();

        if ($products->isEmpty() || empty($orderStatusIds) || empty($deliveryMethodIds)) {
            return;
        }

        $orderNumber = 1;

        foreach ($customers as $customer) {
            $ordersForCustomer = rand(3, 8);

            for ($i = 0; $i < $ordersForCustomer; $i++) {
                $date = $this->randomRecentDate();

                $order = new UserOrder([
                    'number' => 'ORD-' . str_pad($orderNumber, 5, '0', STR_PAD_LEFT),
                    'order_status_id' => $orderStatusIds[array_rand($orderStatusIds)],
                    'delivery_method_id' => $deliveryMethodIds[array_rand($deliveryMethodIds)],
                    'user_id' => $customer['user']->id,
                    'user_contact_id' => $customer['contact']->id,
                    'payment' => true,
                ]);
                $order->created_at = $date;
                $order->updated_at = $date;
                $order->save();

                $lineItems = rand(1, 3);
                $chosenProducts = $products->random(min($lineItems, $products->count()));
                foreach ($chosenProducts as $product) {
                    $units = rand(1, 5);

                    $purchase = new UserPurchasedProduct([
                        'user_order_id' => $order->id,
                        'product_id' => $product->id,
                        'units' => $units,
                        'price' => $product->price,
                        'amount' => round($product->price * $units, 2),
                    ]);
                    $purchase->created_at = $date;
                    $purchase->updated_at = $date;
                    $purchase->save();
                }

                $orderNumber++;
            }
        }
    }

    private function seedCustomers(): array
    {
        $names = [
            ['Yaneisy', 'Rodríguez Pérez'],
            ['Carlos', 'Fernández López'],
            ['María', 'González Díaz'],
            ['Luis', 'Martínez Ortiz'],
            ['Ana', 'Suárez Castro'],
            ['Jorge', 'Ramírez Alonso'],
            ['Yordanka', 'Herrera Vega'],
            ['Ernesto', 'Torres Morales'],
        ];

        $municipalities = Municipality::inRandomOrder()->limit(count($names))->get();

        $customers = [];

        foreach ($names as $index => [$firstName, $lastName]) {
            $email = 'cliente' . ($index + 1) . '@marketplace.example.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $firstName,
                    'last_name' => $lastName,
                    'password' => bcrypt('Demo12345!'),
                    'email_verified_at' => now(),
                ]
            );

            if (! $user->hasRole('customer')) {
                $user->assignRole('customer');
            }

            $municipality = $municipalities[$index % max($municipalities->count(), 1)] ?? null;

            $contact = UserContact::firstOrCreate(
                ['user_id' => $user->id, 'email' => $email],
                [
                    'name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => '+1 555 02' . str_pad($index, 2, '0', STR_PAD_LEFT),
                    'street' => 'Calle ' . rand(1, 50),
                    'between_streets' => 'entre ' . rand(1, 30) . ' y ' . rand(31, 60),
                    'number' => (string) rand(100, 999),
                    'province_id' => $municipality?->province_id,
                    'municipality_id' => $municipality?->id,
                    'prefer' => true,
                ]
            );

            $customers[] = ['user' => $user, 'contact' => $contact];
        }

        return $customers;
    }

    private function randomRecentDate(): Carbon
    {
        // Bias towards recent days so this week/month/year reports all have data.
        $bucket = rand(1, 100);

        $daysAgo = match (true) {
            $bucket <= 40 => rand(0, 6),
            $bucket <= 75 => rand(7, 30),
            default => rand(31, 75),
        };

        return Carbon::now()->subDays($daysAgo)->setTime(rand(8, 20), rand(0, 59));
    }
}
