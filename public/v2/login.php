<?php
require_once 'core/init.php';



if (Input::exists()) {

    if (Token::check(Input::get('token'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => TRUE),
            'password' => array('required' => TRUE)
        ));

        if ($validation->passed()) {
            $user = new User();
            
            $remember = (Input::get('remember') === 'on') ? TRUE : FALSE;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                Redirect::to('index.php');
            } else {
                
                Redirect::to('index.php');
                echo '<p> Няма да влезнеш брат, регистрираи се!';
            }
        } else {
            foreach ($validation->errors() as $error) {
                
                $_POST['error'] = $error . '<br>';
                Redirect::to('index.php');
            }
        }
    }
}