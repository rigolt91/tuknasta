<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\UserOrder;

class UserPurchasedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'units',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function userOrder()
    {
        return $this->belongsTo(UserOrder::class);
    }
}
