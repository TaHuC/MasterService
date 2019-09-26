<?php

class Input {

    public static function exists($type = 'post') {
//        switch ($type) {
//            case 'post':
//                return (!empty($_POST)) ? TRUE : FALSE;
//                break;
//            case 'get':
//                return (!empty($_GET)) ? TRUE : FALSE;
//                break;
//            default:
//                return FALSE;
//                break;
//        }
        
        if($_POST){
            return (!empty($_POST)) ? TRUE : FALSE;
            exit();
        } elseif($_GET){
            return (!empty($_GET)) ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }

    public static function get($item) {
        if (isset($_POST[$item])) {
            return $_POST[utf8_decode($item)];
        } elseif (isset($_GET[$item])) {
            return $_GET[utf8_decode($item)];
        }
        return '';
    }

}
