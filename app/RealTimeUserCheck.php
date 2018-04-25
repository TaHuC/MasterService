<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealTimeUserCheck extends Model
{
    //
    protected $table = 'real_time_user_checks';

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function realService()
    {
        return $this->belongsTo(RealTimeService::class, 'realTimeServiceId', 'id');
    }
}
