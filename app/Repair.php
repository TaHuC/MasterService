<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    //
    protected $table = 'repairs';
    protected $fillable = [
        'id',
        'orderId',
        'userId',
        'repair',
        'description',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
