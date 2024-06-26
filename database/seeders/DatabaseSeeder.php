<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // DB::table('users')->insert([
        //     'username' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('password')
        // ]);

        $this->call([
            ProductSeeder::class,
            StatisticSeeder::class,
            VisitorSeeder::class
        ]);
    }
}
