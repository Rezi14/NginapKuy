<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // Panggil RoleSeeder
            TipeKamarSeeder::class, // Tambahkan baris ini
            KamarSeeder::class,
            AdminUserSeeder::class,
            // UserSeeder::class, // Jika Anda memiliki UserSeeder
        ]);
    }
    
}