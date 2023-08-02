<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'dni',
        'phone',
        'street',
        'prefer',
        'trash',
        'between_streets',
        'number',
        'province_id',
        'municipality_id',
    ];

    public function scopeWherePrefer(Builder $query, $prefer)
    {
        return $query->where('prefer', $prefer);
    }

    public function scopeWhereContact(Builder $query, $contact)
    {
        return $query->where('id', $contact);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function userOrder()
    {
        return $this->hasMany(UserOrder::class);
    }
}
