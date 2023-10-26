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
            'provinces',
            'municipalities',
            'delivery_methods',
            'order_statuses',
            'upagos_directs'
        ]);

        $this->call([
            RoleTableSeeder::class,
            UserTableSeeder::class,
            ProvinceTableSeeder::class,
            MunicipalityTableSeeder::class,
            DeliveryMethodTableSeeder::class,
            OrderStatusTableSeeder::class,
            UpagosDirectTableSeeder::class,
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
