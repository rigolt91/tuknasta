<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            ['name' => 'Café, Té', 'category_id' => 1],
            ['name' => 'Licuadoras', 'category_id' => 1],
            ['name' => 'Freidoras', 'category_id' => 1],
            ['name' => 'Equipo de cocina', 'category_id' => 1],
            ['name' => 'Turbinas y motores eléctricos', 'category_id' => 1],
            ['name' => 'Lavadoras', 'category_id' => 1],
            ['name' => 'Equipos de climatización y ventilación', 'category_id' => 1],
            ['name' => 'Refrigeradores', 'category_id' => 1],
            ['name' => 'Equipo eléctrico de respaldo', 'category_id' => 2],
            ['name' => 'Teléfonos móviles y accesorios', 'category_id' => 3],
            ['name' => 'Ordenadores y accesorios', 'category_id' => 4],
            ['name' => 'Herramientas manuales', 'category_id' => 5],
            ['name' => 'Pinturas', 'category_id' => 5],
            ['name' => 'Materiales de construcción', 'category_id' => 5],
            ['name' => 'Recambios y piezas de moto', 'category_id' => 6],
            ['name' => 'Accesorios de coche', 'category_id' => 6],
            ['name' => 'Insumos para la agricultura', 'category_id' => 7],
            ['name' => 'Carnes', 'category_id' => 8],
            ['name' => 'Embutidos y ahumados', 'category_id' => 8],
            ['name' => 'Aceites y grasas', 'category_id' => 8],
            ['name' => 'Condimentos', 'category_id' => 8],
            ['name' => 'Conservas', 'category_id' => 8],
            ['name' => 'Lácteos', 'category_id' => 8],
            ['name' => 'Pasta, granos y cereales', 'category_id' => 8],
            ['name' => 'Raíces vegetales, frutas y verduras', 'category_id' => 8],
            ['name' => 'Higiene personal', 'category_id' => 9],
            ['name' => 'Muebles para el hogar', 'category_id' => 10],
            ['name' => 'Flores y regalo', 'category_id' => 11],
        ];

        foreach($subcategories as $subcategory)
        {
            Subcategory::create($subcategory);
        }
    }
}
