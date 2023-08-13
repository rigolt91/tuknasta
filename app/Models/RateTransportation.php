<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Contracts\Database\Eloquent\Builder;

class RateTransportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'municipality_id',
        'amount',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function scopeWhereProvince(Builder $query, $province): void
    {
        $query->where('province_id', 'like', '%'.$province.'%');
    }

    public function scopeWhereMunicipality(Builder $query, $municipality): void
    {
        $query->where('municipality_id', $municipality);
    }
}
