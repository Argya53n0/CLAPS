<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Products
        $products = [
            [
                'name' => 'Claps Signature Iced Coffee',
                'description' => 'Our best-selling signature iced coffee with creamy milk and palm sugar.',
                'price' => 25000,
                'category' => 'coffee',
                'image' => 'https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?w=800&q=80',
            ],
            [
                'name' => 'Caramel Macchiato',
                'description' => 'Espresso with vanilla-flavored syrup, milk and caramel drizzle.',
                'price' => 35000,
                'category' => 'coffee',
                'image' => 'https://images.unsplash.com/photo-1485808191679-5f86510681a2?w=800&q=80',
            ],
            [
                'name' => 'Matcha Latte',
                'description' => 'Premium matcha green tea blended with steamed milk.',
                'price' => 30000,
                'category' => 'non_coffee',
                'image' => 'https://images.unsplash.com/photo-1515823064-28b981bc88bb?w=800&q=80',
            ],
            [
                'name' => 'Butter Croissant',
                'description' => 'Classic buttery and flaky French pastry.',
                'price' => 20000,
                'category' => 'snack',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&q=80',
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }

        // 2. Create Dummy Orders for the Customer
        $customer = User::where('email', 'customer@clapscoffee.com')->first();
        $allProducts = Product::all();

        if ($customer && $allProducts->count() > 0) {
            // Create 3 orders with different statuses
            $statuses = ['completed', 'delivery', 'preparing'];
            
            foreach ($statuses as $status) {
                $order = Order::create([
                    'order_code' => Order::generateCode(),
                    'user_id' => $customer->id,
                    'status' => $status,
                    'total_price' => 0, // Will calculate below
                ]);

                $total = 0;
                // Add 1-2 random items
                $itemsToTake = rand(1, 2);
                $selectedProducts = $allProducts->random($itemsToTake);

                foreach ($selectedProducts as $prod) {
                    $qty = rand(1, 2);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $prod->id,
                        'quantity' => $qty,
                        'price' => $prod->price,
                    ]);
                    $total += ($prod->price * $qty);
                }

                $order->update(['total_price' => $total]);
            }
        }
    }
}
