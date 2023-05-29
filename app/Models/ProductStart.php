<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductStart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'one',
        'two',
        'three',
        'four',
        'five',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
