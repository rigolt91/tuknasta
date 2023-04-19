<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserOrder;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function userOrder()
    {
        return $this->hasMany(UserOrder::class);
    }
}
