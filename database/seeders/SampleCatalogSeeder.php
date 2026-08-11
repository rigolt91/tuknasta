<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::firstOrCreate(
            ['email' => 'demo@tuknasta.com'],
            [
                'name' => 'Sucursal Demo',
                'phone' => '+15622201521',
                'contract_number' => 'DEMO-0001',
                'person_contact' => 'Admin Demo',
            ]
        );

        $categories = [
            'Frutas y Vegetales' => ['Frutas Frescas', 'Vegetales Frescos'],
            'Carnes y Embutidos' => ['Carnes Rojas', 'Embutidos'],
            'Lácteos' => ['Quesos', 'Leches y Yogures'],
            'Bebidas' => ['Refrescos', 'Jugos'],
        ];

        $categoryImage = 'categories/902ba3cda1.jpg';
        $productImage = 'products/001/cd3f0c85b1.jpg';

        $productNumber = 1;

        foreach ($categories as $categoryName => $subcategoryNames) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['image' => $categoryImage, 'show' => true]
            );

            foreach ($subcategoryNames as $subcategoryName) {
                $subcategory = Subcategory::firstOrCreate(
                    ['name' => $subcategoryName],
                    ['category_id' => $category->id, 'show' => true]
                );

                for ($i = 1; $i <= 2; $i++) {
                    $name = "{$subcategoryName} {$i}";
                    $sku = 'DEMO-' . str_pad($productNumber, 4, '0', STR_PAD_LEFT);

                    Product::firstOrCreate(
                        ['name' => $name],
                        [
                            'image' => $productImage,
                            'sku' => $sku,
                            'slug' => Str::slug($name) . '-' . $sku,
                            'short_description' => "Producto de muestra: {$name}",
                            'description' => "Descripción de muestra para {$name}. Producto generado para poblar el catálogo de demostración.",
                            'price' => rand(100, 5000) / 100,
                            'stock' => rand(10, 100),
                            'show' => true,
                            'recommend' => $productNumber % 3 === 0,
                            'category_id' => $category->id,
                            'subcategory_id' => $subcategory->id,
                            'branch_id' => $branch->id,
                        ]
                    );

                    $productNumber++;
                }
            }
        }
    }
}
