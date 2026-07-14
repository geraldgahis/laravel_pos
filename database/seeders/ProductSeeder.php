<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'barcode' => '4806511013444', 
                'name' => 'Lucky Me! Pancit Canton Kalamansi',
                'description' => 'Instant Noodles 80g',
                'selling_price' => 18.00,
                'cost_price' => 15.00,
                'quantity' => 50,
                'unit' => 'pcs',
            ],
            [
                'barcode' => '4800361397022', 
                'name' => 'Nescafe Original 3-in-1',
                'description' => 'Coffee Twin Pack',
                'selling_price' => 15.00,
                'cost_price' => 12.00,
                'quantity' => 100,
                'unit' => 'sachets',
            ],
            [
                'barcode' => '4800888143211', 
                'name' => 'Magic Sarap',
                'description' => 'All-in-one Seasoning 8g',
                'selling_price' => 6.00,
                'cost_price' => 4.50,
                'quantity' => 200,
                'unit' => 'sachets',
            ],
            [
                'barcode' => '4801981116210', 
                'name' => 'Datu Puti Vinegar',
                'description' => 'White Vinegar 385ml (Pouch)',
                'selling_price' => 20.00,
                'cost_price' => 17.00,
                'quantity' => 30,
                'unit' => 'pcs',
            ],
            [
                'barcode' => null, 
                'name' => 'White Sugar (Repacked)',
                'description' => '1/4 kg',
                'selling_price' => 25.00,
                'cost_price' => 20.00,
                'quantity' => 20,
                'unit' => 'bags',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
