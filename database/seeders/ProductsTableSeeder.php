<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::inRandomOrder()->first(); // random user

        // Create three products
        for ($i = 1; $i <= 3; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'quantity' => rand(1, 10), // Random
                'image' => 'product' . $i . '.jpg',
                'user_id' => $user->id,
            ]);
        }
    }
}
