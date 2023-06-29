<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cel',
        'cpf',
        'email',
        'password',
        'zipcode',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city_id',
        'state_id',
    ];


    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
        );
    }

    public function cel(): Attribute
    {
        return new Attribute(
            get: fn ($value) => trim(limpa_cel($value)),
            set: fn ($value) => trim(limpa_cel($value)),
        );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function scopeOfSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%');
    }

    public function city()
    {
        return $this->belongsTo(City::class);

    }

    public function state()
    {
        return $this->belongsTo(State::class);

    }

    public function orders()
    {
        return $this->hasMany(Order::class);

    }
}
