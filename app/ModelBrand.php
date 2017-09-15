<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelBrand extends Model
{
    //
    protected $table = 'models';
    protected $fillable = [
        'id',
        'brandId',
        'title'
    ];

    public function modelBrand()
    {
        $this->hasMany(Brand::class);
    }
}
