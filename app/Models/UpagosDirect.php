<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpagosDirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode',
        'token',
        'email',
        'phone',
        'address',
        'facebook',
        'instagram',
        'twitter',
        'google',
        'linkedin',
    ];
}
