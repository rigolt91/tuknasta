<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'image' => 'slider/banner-frescos.jpg',
                'title' => 'Frutas y vegetales frescos',
                'text' => 'Recibe en tu casa los productos más frescos de nuestros proveedores, seleccionados a diario.',
                'link' => '/products',
            ],
            [
                'image' => 'slider/banner-despensa.jpg',
                'title' => 'Todo para tu despensa',
                'text' => 'Encuentra vegetales, carnes, lácteos y bebidas en un solo lugar, con entrega rápida y segura.',
                'link' => '/products',
            ],
            [
                'image' => 'slider/banner-mayorista.jpg',
                'title' => 'Compras al por mayor',
                'text' => 'Opciones mayoristas para tu negocio, con los mejores precios de nuestros proveedores.',
                'link' => '/wholesaler',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(
                ['title' => $slider['title']],
                $slider
            );
        }
    }
}
