<?php
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Product 1',
            'quantity' => 10,
            'image' => 'product1.jpg',
        ]);

        Product::create([
            'name' => 'Product 2',
            'quantity' => 20,
            'image' => 'product2.jpg',
        ]);



    }
}
