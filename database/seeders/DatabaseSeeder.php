<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories (7 entries)
        $categories = ['Dairy', 'Bakery', 'Beverages', 'Snacks', 'Canned Goods', 'Produce', 'Frozen Foods'];
        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'name' => $cat,
                'created_at' => now(),
            ]);
        }

        // 2. Seed Subcategories (7 entries)
        $subcategories = [
            ['name' => 'Milk', 'category_id' => 1],
            ['name' => 'Bread', 'category_id' => 2],
            ['name' => 'Soft Drinks', 'category_id' => 3],
            ['name' => 'Chips', 'category_id' => 4],
            ['name' => 'Vegetables', 'category_id' => 6],
            ['name' => 'Fruits', 'category_id' => 6],
            ['name' => 'Ice Cream', 'category_id' => 7],
        ];
        DB::table('subcategories')->insert($subcategories);

        // 3. Seed Manufacturers (7 entries)
        $manufacturers = ['Nestle', 'Unilever', 'PepsiCo', 'Coca-Cola', 'General Mills', 'Kelloggs', 'Danone'];
        foreach ($manufacturers as $man) {
            DB::table('manufacturers')->insert(['name' => $man, 'created_at' => now()]);
        }

        // 4. Seed Import Companies (7 entries)
        for ($i = 1; $i <= 7; $i++) {
            DB::table('import_companies')->insert([
                'name' => "Import Corp $i",
                'email' => "contact$i@importcorp.com",
                'phone' => "555-000$i",
                'address' => "$i Main St, Logistics City",
                'created_at' => now(),
            ]);
        }

        // 5. Seed Users (7 entries)
        $roles = ['admin', 'manager', 'cashier'];
        foreach ($roles as $index => $role) {
            DB::table('users')->insert([
                'username' => "$role",
                'password' => Hash::make('password'),
                'salary' => 2000 + ($index * 100),
                'type' => $role,
                'created_at' => now(),
            ]);
        }

        // 6. Seed Products (20 entries)
        $products = [
            ['Full Cream Milk', 1, 7, 1], ['Sourdough Bread', 2, 5, 2], ['Cola 500ml', 3, 4, 3],
            ['Potato Chips', 4, 3, 4], ['Canned Peas', 5, 1, 5], ['Fresh Apple', 6, 2, 6],
            ['Vanilla Ice Cream', 7, 7, 7], ['Greek Yogurt', 1, 7, 1], ['Whole Wheat Bread', 2, 5, 2],
            ['Orange Juice', 3, 4, 3], ['Chocolate Bar', 4, 1, 4], ['Canned Corn', 5, 2, 5],
            ['Banana Pack', 6, 6, 6], ['Frozen Pizza', 7, 5, 7], ['Butter', 1, 7, 1],
            ['Energy Drink', 3, 3, 2], ['Tortilla Chips', 4, 3, 3], ['Tomato Soup', 5, 1, 4],
            ['Frozen Berries', 7, 2, 5], ['Cheddar Cheese', 1, 7, 6]
        ];

        foreach ($products as $key => $p) {
            DB::table('products')->insert([
                'code' => 'PROD-' . (1000 + $key),
                'name' => $p[0],
                'subcategory_id' => $p[1],
                'price' => rand(5, 50) + 0.99,
                'manufacture_id' => $p[2],
                'import_company_id' => $p[3],
                'isStockLow' => false,
                'minimum' => 10,
                'created_at' => now(),
            ]);
        }

        // 7. Seed Stocks (20 entries linked to products)
        for ($i = 1; $i <= 20; $i++) {
            DB::table('stocks')->insert([
                'product_id' => $i,
                'quantity' => rand(20, 100),
                'cost_price' => rand(1, 4) + 0.50,
                'created_at' => now(),
            ]);
        }

        // 8. Seed Receipts (7 entries)
        for ($i = 1; $i <= 7; $i++) {
            DB::table('receipts')->insert([
                'cashier_id' => rand(3, 7), // Picking from the cashiers
                'total' => 0, // Will be updated by items or logic
                'created_at' => now(),
            ]);
        }

        // 9. Seed Receipt Items (At least 7 entries)
        // Note: I used 'recipt_id' as written in your migration typo
        // for ($i = 1; $i <= 10; $i++) {
        //     DB::table('receipt_items')->insert([
        //         'recipt_id' => rand(1, 7),
        //         'product_id' => rand(1, 20),
        //         'quantity' => rand(1, 5),
        //         'item_total' => rand(10, 100),
        //         'created_at' => now(),
        //     ]);
        // }

         $items = [
            // --- BEST SELLERS ---
            // Product 1 (Milk) - Sold many times in large amounts
            ['recipt_id' => 1, 'product_id' => 1, 'quantity' => 10, 'item_total' => 35.00],
            ['recipt_id' => 2, 'product_id' => 1, 'quantity' => 15, 'item_total' => 52.50],
            ['recipt_id' => 3, 'product_id' => 1, 'quantity' => 20, 'item_total' => 70.00],

            // Product 2 (Bread) - Sold many times
            ['recipt_id' => 1, 'product_id' => 2, 'quantity' => 5, 'item_total' => 12.50],
            ['recipt_id' => 4, 'product_id' => 2, 'quantity' => 8, 'item_total' => 20.00],
            ['recipt_id' => 5, 'product_id' => 2, 'quantity' => 12, 'item_total' => 30.00],

            // Product 3 (Cola) - Sold many times
            ['recipt_id' => 2, 'product_id' => 3, 'quantity' => 25, 'item_total' => 50.00],
            ['recipt_id' => 6, 'product_id' => 3, 'quantity' => 10, 'item_total' => 20.00],

            // --- AVERAGE SELLERS ---
            ['recipt_id' => 3, 'product_id' => 5, 'quantity' => 4, 'item_total' => 16.00],
            ['recipt_id' => 7, 'product_id' => 6, 'quantity' => 3, 'item_total' => 9.00],
            ['recipt_id' => 4, 'product_id' => 8, 'quantity' => 5, 'item_total' => 25.00],

            // --- WORST SELLERS ---
            // Product 19 (Frozen Berries) - Only 1 sold total
            ['recipt_id' => 1, 'product_id' => 19, 'quantity' => 1, 'item_total' => 15.00],

            // Product 20 (Cheddar Cheese) - Only 2 sold total
            ['recipt_id' => 5, 'product_id' => 20, 'quantity' => 2, 'item_total' => 12.00],

            // Product 15 (Butter) - Only 2 sold total
            ['recipt_id' => 7, 'product_id' => 15, 'quantity' => 2, 'item_total' => 10.00],
        ];

        foreach ($items as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('receipt_items')->insert($item);
        }
    }
}
