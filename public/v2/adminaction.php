<?php
require_once 'core/init.php';
$user = new User();
$token = new Token();
$add = new ADD();

my_head('Настройки');
my_menu();


if (Input::get('eUser') === 'yes') {
    $add->find(Input::get('uId'), 'id', 'users');
        try {
            $add->update(array(
                'active' => Input::get('aCheck')
                    ), Input::get('uId'), 'users');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
}