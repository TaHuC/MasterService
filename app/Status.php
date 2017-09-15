<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $table = 'statuses';
    protected $fillable = [
        'id',
        'status'
    ];

    public function order()
    {
        $this->hasMany(Order::class);
    }
}
