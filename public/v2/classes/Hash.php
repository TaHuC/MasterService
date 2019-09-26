<?php

class Hash {
    public static function make($string, $salt = '') {
        return hash('sha256', $string, $salt);
//        $result = '';
//        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
//        if($salt) {
//            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
//        for ($i = 0; $i < $length; $i++)
//            $result .= $chars[mt_rand(0, strlen($chars)-1)];
//        return $result;
//        }
    }
    
    public static function salt($lenght) {
        return mcrypt_create_iv($lenght);
    }
    
    public static function unique() {
        return self::make(uniqid());
    }
}
