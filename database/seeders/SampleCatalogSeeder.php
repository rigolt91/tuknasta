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
            ['email' => 'demo@marketplace.example.com'],
            [
                'name' => 'Sucursal Demo',
                'phone' => '+1 555 0100',
                'contract_number' => 'DEMO-0001',
                'person_contact' => 'Admin Demo',
            ]
        );

        $categories = [
            'Frutas y Vegetales' => [
                'image' => 'categories/frutas-vegetales.jpg',
                'subcategories' => [
                    'Frutas Frescas' => ['products/demo/frutas-frescas-1.jpg', 'products/demo/frutas-frescas-2.jpg'],
                    'Vegetales Frescos' => ['products/demo/vegetales-frescos-1.jpg', 'products/demo/vegetales-frescos-2.jpg'],
                ],
            ],
            'Carnes y Embutidos' => [
                'image' => 'categories/carnes-embutidos.jpg',
                'subcategories' => [
                    'Carnes Rojas' => ['products/demo/carnes-rojas-1.jpg', 'products/demo/carnes-rojas-2.jpg'],
                    'Embutidos' => ['products/demo/embutidos-1.jpg', 'products/demo/embutidos-2.jpg'],
                ],
            ],
            'Lácteos' => [
                'image' => 'categories/lacteos.jpg',
                'subcategories' => [
                    'Quesos' => ['products/demo/quesos-1.jpg', 'products/demo/quesos-2.jpg'],
                    'Leches y Yogures' => ['products/demo/leches-yogures-1.jpg', 'products/demo/leches-yogures-2.jpg'],
                ],
            ],
            'Bebidas' => [
                'image' => 'categories/bebidas.jpg',
                'subcategories' => [
                    'Refrescos' => ['products/demo/refrescos-1.jpg', 'products/demo/refrescos-2.jpg'],
                    'Jugos' => ['products/demo/jugos-1.jpg', 'products/demo/jugos-2.jpg'],
                ],
            ],
        ];

        $productNumber = 1;

        foreach ($categories as $categoryName => $categoryData) {
            $category = Category::updateOrCreate(
                ['name' => $categoryName],
                ['image' => $categoryData['image'], 'show' => true]
            );

            foreach ($categoryData['subcategories'] as $subcategoryName => $productImages) {
                $subcategory = Subcategory::updateOrCreate(
                    ['name' => $subcategoryName],
                    ['category_id' => $category->id, 'show' => true]
                );

                foreach ($productImages as $i => $productImage) {
                    $name = "{$subcategoryName} " . ($i + 1);
                    $sku = 'DEMO-' . str_pad($productNumber, 4, '0', STR_PAD_LEFT);

                    Product::updateOrCreate(
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
