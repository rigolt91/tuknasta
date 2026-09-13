<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipality;
use App\Models\RateTransportation;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function municipality()
    {
        return $this->hasMany(Municipality::class);
    }

    public function rateTransportation()
    {
        return $this->hasMany(RateTransportation::class);
    }
}
