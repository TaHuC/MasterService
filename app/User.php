<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function product()
    {
        $this->hasMany(Product::class);
    }

    public function client()
    {
        $this->hasMany(Client::class);
    }

    public function order()
    {
        $this->hasMany(Order::class);
    }

    public function repair()
    {
        $this->hasMany(Repair::class);
    }
}
