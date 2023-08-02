<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserContact;
use App\Models\DeliveryMethod;
use App\Models\UserPurchasedProduct;
use App\Models\OrderStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;

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

    public function scopeWhereStatus(Builder $query, $status)
    {
        $query->when($status, function($query, $status) {
            $query->where('order_status_id', $status);
        });
    }

    public function scopeWhereMethod(Builder $query, $method)
    {
        $query->when($method, function($query, $method) {
            $query->where('delivery_method_id', $method);
        });
    }

    public function scopeWhereDate(Builder $query, $date)
    {
        $query->when($date, function($query, $date) {
            $query->where('created_at', 'like', '%'.$date.'%');
        });
    }

    public function scopeWhereDateBetween(Builder $query, $start, $end)
    {
        $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeWhereNumber(Builder $query, $number)
    {
        $query->when($number, function ($query, $number) {
            $query->where('user_orders.number', 'like', '%'.$number.'%');
        });
    }

    public function scopeJoinUserContact(Builder $query)
    {
        $query->join('user_contacts', 'user_contact_id', '=', 'user_contacts.id')
            ->select('user_orders.*', 'user_contacts.dni', $this->raw("CONCAT(user_contacts.name,' ',user_contacts.last_name) AS contact"));
    }

    public function scopeWhereContact(Builder $query, $contact)
    {
        $query->when($contact, function ($query, $contact) {
            $query->orWhere('user_contacts.name', 'like', '%'.$contact.'%');
            $query->orWhere('user_contacts.last_name', 'like', '%'.$contact.'%');
            $query->orWhere('user_contacts.dni', 'like', '%'.$contact.'%');
        });
    }

    public function scopeWhereUser(Builder $query, $user)
    {
        $query->where('user_orders.user_id', $user);
    }

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
