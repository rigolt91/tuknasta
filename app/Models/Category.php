<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\UserContact;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'image',
        'name',
        'description',
        'show',
    ];

    public function scopeShow(Builder $query, bool $show): void
    {
        $query->where('show', $show);
    }

    public function subcategory()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function userContact()
    {
        return $this->hasMany(UserContact::class);
    }
}
