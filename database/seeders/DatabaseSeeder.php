<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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
        $user = User::create([
            "name"=>"Test",
            "email"=>"test@gmail.com",
            "password"=>Hash::make("test123")
        ]);
        $tenant =Tenant::create([
            "name" => "Tenant 1",
            "email"=>"tenant1@gmail.com",
            "contact"=>"1234567890"
        ]);
        $tenant->users()->attach($user);
    }
}
