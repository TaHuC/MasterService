<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'id',
        'productId',
        'statusId',
        'userId',
        'price',
        'deposit',
        'now',
        'problem',
        'password',
        'description',
        'active'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'statusId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'orderId', 'id');
    }
}
