<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            ['loc' => route('dashboard'), 'priority' => '1.0'],
            ['loc' => route('products'), 'priority' => '0.9'],
            ['loc' => route('wholesaler'), 'priority' => '0.5'],
            ['loc' => route('about-us'), 'priority' => '0.3'],
            ['loc' => route('delivery-policy'), 'priority' => '0.3'],
            ['loc' => route('return-policy'), 'priority' => '0.3'],
            ['loc' => route('terms'), 'priority' => '0.3'],
            ['loc' => route('policy'), 'priority' => '0.3'],
        ]);

        Category::whereShow(true)->get()->each(function ($category) use ($urls) {
            $urls->push([
                'loc' => route('products', ['category_id' => $category->id]),
                'priority' => '0.6',
            ]);
        });

        Product::show(true)->get()->each(function ($product) use ($urls) {
            $urls->push([
                'loc' => route('product.details', $product->slug),
                'priority' => '0.7',
                'lastmod' => optional($product->updated_at)->toAtomString(),
            ]);
        });

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'text/xml');
    }
}
