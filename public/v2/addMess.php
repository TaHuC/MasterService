<?php


require_once 'core/init.php';

$user = new User();

$message = new ADD();

if (Input::exists()) {
    if (Input::get('smMess') === 'ok') {
        try {
            $message->create(array(
                'textMess' => Input::get('textMess'),
                'userId' => Input::get('userMess'),
                'dateMess' => date('Y-m-d H:i:s'),
                'sendUser' => $user->data()->id
                    ), 'inboxUser');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
}