<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Cart;
use App\Models\UserPurchasedProduct;
use App\Models\Branch;
use App\Models\ProductStart;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'starts',
        'recommend',
        'category_id',
        'subcategory_id',
        'branch_id',
    ];

    public function scopeShow(Builder $query, $show): void
    {
        $query->where('show', $show);
    }

    public function scopeRecommend(Builder $query, $recommend): void
    {
        $query->select('id', 'image', 'name', 'slug', 'short_description', 'price')
            ->where('recommend', $recommend)
            ->show(true);
    }

    public function scopeWhereRecommend(Builder $query, $recommend): void
    {
        $query->where('recommend', $recommend)->show(true);
    }

    public function scopeWhereName(Builder $query, $name): void
    {
        $query->when($name, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
    }

    public function scopeWhereBranch(Builder $query, $branch): void
    {
        $query->when($branch, function ($query, $branch) {
            $query->where('branch_id', $branch);
        });
    }

    public function scopeWhereSubcategory(Builder $query, $subcategory): void
    {
        $query->when($subcategory, function ($query, $subcategory) {
            $query->where('subcategory_id', $subcategory);
        });
    }

    public function scopeWhereCategory(Builder $query, $category): void
    {
        $query->when($category, function ($query, $category) {
            $query->where('category_id', $category);
        });
    }

    public function scopeWherePrice(Builder $query, $min, $max): void
    {
        $query->when($min, function ($query, $min) {
            $query->where('price', '>=', $min);
        });
        $query->when($max, function($query, $max) {
            $query->where('price', '<=', $max);
        });
    }

    public function scopeWhereInCategory(Builder $query, $categories): void
    {
        $query->whereIn('category_id', $categories);
    }

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

    public function productStart()
    {
        return $this->hasOne(ProductStart::class);
    }
}
