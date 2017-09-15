<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    //protected $table = 'products';
    protected $fillable = [
        'id',
        'clientId',
        'typeId',
        'brandId',
        'modelId',
        'userId',
        'serial',
        'comment',
        'client.name'
    ];

    public function client()
    {
        $this->belongsTo(Client::class, 'clientId', 'id');
    }

    public function type()
    {
        $this->belongsTo(Type::class, 'typeId', 'id');
    }

    public function brand()
    {
        $this->belongsTo(Brand::class, 'brandId', 'id');
    }

    public function model()
    {
        $this->belongsTo(ModelBrand::class, 'modelId', 'id');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'userId', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
