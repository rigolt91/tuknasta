<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
