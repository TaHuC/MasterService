<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $table = 'clients';
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
