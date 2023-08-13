<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\RateTransportation;
class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'province_id',
    ];

    public function scopeWhereProvince(Builder $query, $province): void
    {
        $query->where('province_id', $province);
    }

    public function rateTransportation()
    {
        return $this->hasOne(RateTransportation::class);
    }
}
