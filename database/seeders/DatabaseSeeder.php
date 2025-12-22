<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'username' => 'ali',
            'type'=>'admin',
            'password'=>Hash::make('password')
        ]);
        User::factory()->create([
    'username' => 'manager',
    'type' => 'manager',
    'password' => Hash::make('manager123'),
    'salary' => 800
]);
User::factory()->create([
            'username' => 'cashier1',
            'type' => 'cashier',
            'password' => Hash::make('cashier123'),
            'salary' => 500
        ]);
    }
}
