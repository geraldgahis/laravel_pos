<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin & Merchant
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $merchant = User::create([
            'name' => 'Gerald Gahis',
            'email' => 'merchant@merchant.com',
            'password' => Hash::make('password'),
            'role' => 'merchant',
        ]);

        // 2. Create Store for Merchant
        Store::create([
            'owner_id' => $merchant->id,
            'name' => 'Gerald Sari-Sari Store',
            'address' => 'Nueva Ecija, Philippines',
            'is_active' => true,
        ]);

        // 3. Create Categories (Admin created)
        $categories = [
            ['name' => 'Canned Goods', 'slug' => 'canned-goods', 'icon' => 'soup', 'created_by' => $admin->id],
            ['name' => 'Noodles & Instant', 'slug' => 'noodles-instant', 'icon' => 'ramen', 'created_by' => $admin->id],
            ['name' => 'Beverages', 'slug' => 'beverages', 'icon' => 'cup-soda', 'created_by' => $admin->id],
            ['name' => 'Loose Items / Tingi', 'slug' => 'loose-items', 'icon' => 'package-open', 'created_by' => $admin->id],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 4. Create Global Products
        $noodlesCategory = Category::query()->where('slug', 'noodles-instant')->first();
        $beveragesCategory = Category::query()->where('slug', 'beverages')->first();

        // Product 1: Pancit Canton
        $pancitCanton = Product::create([
            'category_id' => $noodlesCategory->id,
            'name' => 'Lucky Me Pancit Canton Kalamansi 80g',
            'slug' => Str::slug('Lucky Me Pancit Canton Kalamansi 80g'),
            'base_unit' => 'piece',
            'scope' => 'global',
            'created_by' => $admin->id,
        ]);

        // Barcodes for Pancit Canton (Piece and Box of 72)
        $pancitCanton->units()->create([
            'label' => 'Piece',
            'barcode' => '480001664112',
            'conversion_qty' => 1,
            'is_default' => true,
        ]);
        $pancitCanton->units()->create([
            'label' => 'Box of 72',
            'barcode' => '480001664112BOX', // Example box barcode
            'conversion_qty' => 72,
            'is_default' => false,
        ]);

        // Product 2: Nescafe Sticks
        $nescafe = Product::create([
            'category_id' => $beveragesCategory->id,
            'name' => 'Nescafe Original Twin Pack',
            'slug' => Str::slug('Nescafe Original Twin Pack'),
            'base_unit' => 'piece',
            'scope' => 'global',
            'created_by' => $admin->id,
        ]);

        $nescafe->units()->create([
            'label' => 'Twin Pack',
            'barcode' => '480112345678',
            'conversion_qty' => 1,
            'is_default' => true,
        ]);
    }
}