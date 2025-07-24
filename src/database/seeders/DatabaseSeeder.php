<?php

namespace Database\Seeders;

use Database\Seeders\ProductSeeder as SeedersProductSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            CategorySeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
