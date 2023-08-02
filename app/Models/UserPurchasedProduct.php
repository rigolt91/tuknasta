<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\UserOrder;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserPurchasedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'units',
        'price',
    ];

    public function scopeWhereDate(Builder $query, $date)
    {
        $query->when($date, function ($query, $date) {
            $query->where('created_at', 'like', '%'.$date.'%');
        });
    }

    public function scopeWhereDateBetween(Builder $query, $start, $end)
    {
        $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeGroupByYear(Builder $query)
    {
        $query->select($this->raw('date_format(created_at, "%Y") as year'))->groupBy('year');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function userOrder()
    {
        return $this->belongsTo(UserOrder::class);
    }
}
