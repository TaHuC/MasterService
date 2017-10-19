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
        'comment'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'typeId', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandId', 'id');
    }

    public function model()
    {
        return $this->belongsTo(ModelBrand::class, 'modelId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'productId', 'id');
    }

    public function repairs()
    {
        return $this->hasManyThrough(Repair::class, Order::class, 'productId', 'orderId',  'id', 'productId');
    }
}
