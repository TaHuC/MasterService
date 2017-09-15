<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $table = 'brands';
    protected $fillable = [
        'id',
        'typeId',
        'title'
    ];

    public function brandType()
    {
        $this->hasMany(Type::class);
    }
}
