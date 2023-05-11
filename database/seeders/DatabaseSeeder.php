<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateTables([
            'roles',
            'users',
            'categories',
            'subcategories',
            'provinces',
            'municipalities',
            'delivery_methods',
            'order_statuses',
        ]);

        $this->call([
            RoleTableSeeder::class,
            UserTableSeeder::class,
            CategoryTableSeeder::class,
            SubcategoryTableSeeder::class,
            ProvinceTableSeeder::class,
            MunicipalityTableSeeder::class,
            DeliveryMethodTableSeeder::class,
            OrderStatusTableSeeder::class,
        ]);
    }

    public function truncateTables(array $tablas){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach($tablas as $tabla){
            DB::table($tabla)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
