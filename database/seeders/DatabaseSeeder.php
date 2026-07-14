<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create the master admin account
        User::create([
            'name' => 'Store Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Change this in production
            'role' => 'admin',
        ]);

        // Call the Product Seeder
        $this->call([
            ProductSeeder::class,
        ]);
    }
}
