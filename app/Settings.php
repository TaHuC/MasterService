<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    //
    protected $table = 'settings';
    protected $fillable = ['no_reg'];

    public static function no_reg()
    {
        $no_reg = Settings::find(1);
        return $no_reg->no_reg;
    }
}
