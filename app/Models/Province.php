<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Municipality;
use App\Models\RateTransportation;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function municipality()
    {
        return $this->hasMany(Municipality::class);
    }

    public function rateTransportation()
    {
        return $this->hasMany(RateTransportation::class);
    }
}
