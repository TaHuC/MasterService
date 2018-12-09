<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instantly extends Model
{
    //
    protected $table = 'instantly';

    public function user() 
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function answerUser() 
    {
        return $this->hasOne(User::class, 'id', 'answer_user_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
