<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Cart;
use App\Models\UserPurchasedProduct;
use App\Models\Branch;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'sku',
        'slug',
        'short_description',
        'description',
        'price',
        'previous_price',
        'stock',
        'show',
        'recommend',
        'category_id',
        'subcategory_id',
        'branch_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function userPurchasedProduct()
    {
        return $this->hasMany(UserPurchasedProduct::class);
    }

    public function purchasedUnits($date = '')
    {
        return $this->userPurchasedProduct()->where('created_at', 'like', '%'.$date.'%')->sum('units');
    }

    public function purchasedPrice($date = '')
    {
        return $this->userPurchasedProduct()->where('created_at', 'like', '%'.$date.'%')->groupBy('price');
    }

    public function purchasedAmount($date = '')
    {
        return $this->userPurchasedProduct()->where('created_at', 'like', '%'.$date.'%')->selectRaw('units * price as total_cost')->get()->sum('total_cost');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
