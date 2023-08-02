<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserOrder;
use Illuminate\Contracts\Database\Eloquent\Builder;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeWhereName(Builder $query, $name): void
    {
        $query->where('name', $name);
    }

    public function userOrder()
    {
        return $this->hasMany(UserOrder::class);
    }
}
