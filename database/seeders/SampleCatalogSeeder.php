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
        $branches = [
            'Sucursal Demo' => Branch::firstOrCreate(
                ['email' => 'demo@marketplace.example.com'],
                [
                    'name' => 'Sucursal Demo',
                    'phone' => '+1 555 0100',
                    'contract_number' => 'DEMO-0001',
                    'person_contact' => 'Admin Demo',
                ]
            ),
            'Distribuidora Central' => Branch::firstOrCreate(
                ['email' => 'central@marketplace.example.com'],
                [
                    'name' => 'Distribuidora Central',
                    'phone' => '+1 555 0101',
                    'contract_number' => 'DEMO-0002',
                    'person_contact' => 'Gerente Central',
                ]
            ),
            'Mayorista del Norte' => Branch::firstOrCreate(
                ['email' => 'norte@marketplace.example.com'],
                [
                    'name' => 'Mayorista del Norte',
                    'phone' => '+1 555 0102',
                    'contract_number' => 'DEMO-0003',
                    'person_contact' => 'Gerente Norte',
                ]
            ),
        ];

        $categories = [
            'Frutas y Vegetales' => [
                'image' => 'categories/frutas-vegetales.jpg',
                'branch' => 'Sucursal Demo',
                'subcategories' => [
                    'Frutas Frescas' => ['products/demo/frutas-frescas-1.jpg', 'products/demo/frutas-frescas-2.jpg'],
                    'Vegetales Frescos' => ['products/demo/vegetales-frescos-1.jpg', 'products/demo/vegetales-frescos-2.jpg'],
                ],
            ],
            'Carnes y Embutidos' => [
                'image' => 'categories/carnes-embutidos.jpg',
                'branch' => 'Distribuidora Central',
                'subcategories' => [
                    'Carnes Rojas' => ['products/demo/carnes-rojas-1.jpg', 'products/demo/carnes-rojas-2.jpg'],
                    'Embutidos' => ['products/demo/embutidos-1.jpg', 'products/demo/embutidos-2.jpg'],
                ],
            ],
            'Lácteos' => [
                'image' => 'categories/lacteos.jpg',
                'branch' => 'Distribuidora Central',
                'subcategories' => [
                    'Quesos' => ['products/demo/quesos-1.jpg', 'products/demo/quesos-2.jpg'],
                    'Leches y Yogures' => ['products/demo/leches-yogures-1.jpg', 'products/demo/leches-yogures-2.jpg'],
                ],
            ],
            'Bebidas' => [
                'image' => 'categories/bebidas.jpg',
                'branch' => 'Mayorista del Norte',
                'subcategories' => [
                    'Refrescos' => ['products/demo/refrescos-1.jpg', 'products/demo/refrescos-2.jpg'],
                    'Jugos' => ['products/demo/jugos-1.jpg', 'products/demo/jugos-2.jpg'],
                ],
            ],
        ];

        $productsPerSubcategory = 5;
        $productNumber = 1;

        foreach ($categories as $categoryName => $categoryData) {
            $category = Category::updateOrCreate(
                ['name' => $categoryName],
                ['image' => $categoryData['image'], 'show' => true]
            );

            $branch = $branches[$categoryData['branch']];

            foreach ($categoryData['subcategories'] as $subcategoryName => $productImages) {
                $subcategory = Subcategory::updateOrCreate(
                    ['name' => $subcategoryName],
                    ['category_id' => $category->id, 'show' => true]
                );

                for ($i = 0; $i < $productsPerSubcategory; $i++) {
                    $name = "{$subcategoryName} " . ($i + 1);
                    $sku = 'DEMO-' . str_pad($productNumber, 4, '0', STR_PAD_LEFT);
                    $productImage = $productImages[$i % count($productImages)];

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
