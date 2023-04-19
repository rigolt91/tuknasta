<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserContact;
use App\Models\DeliveryMethod;
use App\Models\UserPurchasedProduct;
use App\Models\OrderStatus;

class UserOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'order_status_id',
        'delivery_method_id',
        'user_id',
        'user_contact_id',
        'payment',
    ];

    public function totalProducts()
    {
        return $this->userPurchasedProduct()->count();
    }

    public function totalCost()
    {
        return $this->userPurchasedProduct()->selectRaw('units * price as total_cost')->get()->sum('total_cost');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPurchasedProduct()
    {
        return $this->hasMany(UserPurchasedProduct::class);
    }

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function userContact()
    {
        return $this->belongsTo(UserContact::class);
    }
}
