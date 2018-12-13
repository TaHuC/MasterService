<?php

namespace App;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_settings() 
    {
        return $this->belongsTo(UserSettings::class, 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function client()
    {
        return $this->hasMany(Client::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function repair()
    {
        return $this->hasMany(Repair::class);
    }
}
