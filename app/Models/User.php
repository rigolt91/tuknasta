<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Cart;
use App\Models\UserContact;
use App\Models\UserOrder;
use App\Models\UserJob;
use App\Models\ModelHasRole;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'block',
        'trash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartAmount()
    {
        return $this->cart()->selectRaw('units * price as total_amount')->get()->sum('total_amount');
    }

    public function userContact()
    {
        return $this->hasMany(UserContact::class);
    }

    public function userOrder()
    {
        return $this->hasMany(UserOrder::class);
    }

    public function userJob()
    {
        return $this->hasMany(UserJob::class);
    }

    public function modelHasRole()
    {
        return $this->belongsTo(ModelHasRole::class, 'id', 'model_id');
    }
}
