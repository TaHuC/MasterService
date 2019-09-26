<?php
require_once 'core/init.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/bootstrap.min.css" >
        <link rel="stylesheet" href="css/style.css" >

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/reg.js" type="text/javascript"></script>
    </head>
    <body>

        <div class="wrapper">

            <?php
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {

                    $validate = new Validation();
                    $validation = $validate->check($_POST, array(
                        'username' => array(
                            'required' => TRUE,
                            'min' => 2,
                            'max' => 20,
                            'unique' => 'users'
                        ),
                        'password' => array(
                            'required' => TRUE,
                            'min' => 6,
                        ),
                        'password_again' => array(
                            'required' => TRUE,
                            'matches' => 'password'
                        ),
                        'name' => array(
                            'required' => TRUE,
                            'min' => 2,
                            'max' => 30,
                        ),
                        'last_name' => array(
                            'required' => TRUE,
                            'min' => 2,
                            'max' => 30
                        ),
                        'phone' => array(
                            'required' => TRUE,
                            'min' => 7,
                            'max' => 20,
                            'unique' => 'users'
                        ),
                        'email' => array(
                            'required' => TRUE,
                            'min' => 9,
                            'max' => 50,
                            'unique' => 'users'
                        )
                    ));

                    if ($validation->passed()) { // zapisvane v bazata danni
                        $user = new User();
                        $salt = Hash::salt(32);
                        
                        try {
                            $user->create(array(
                                'username' => Input::get('username'),
                                'password' => utf8_decode(Hash::make(Input::get('password'), $salt)),
                                'salt' => utf8_decode($salt),
                                'name' => Input::get('name'),
                                'last_name' => Input::get('last_name'),
                                'email' => Input::get('email'),
                                'phone' => Input::get('phone'),
                                'joined' => date('Y-m-d H:m:s'),
                                'groups' => 1
                            ));
                            
                            $userId = new ADD();
                            
                            $userId->find($_POST['username'], 'username', 'users');
                            
                            if ($_FILES['photo']['name'] !== NULL) {
                                $tmpType = explode(".", $_FILES['photo']['name']);
                                $img = $userId->data()->id . '_' . date('His') . '.' . $tmpType[1];
                                move_uploaded_file($_FILES['photo']['tmp_name'], "images/works/" . $img);
                            } else {
                                $img = 'images/works/user.png';
                            }

                            $userId->create(array(
                                'url' => 'images/works/'.$img,
                                'userId' => $userId->data()->id,
                                'active' => '1'
                                    ), 'photos');

                            Session::flash('home', 'Регистрацията мина успешно! Можете да влезнете в системата от тук!');
                            Redirect::to('index.php');
                            
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        echo '<h3 type="button" >';
                        foreach ($validation->errors() as $error) {

                            echo '<p class="bg-danger">' . $error . '</p>';
                        }
                        echo '</h3>';
                    }
                }
            }
            ?>
            <div class="panel panel-primary panel-reg center-block">
                <div class="panel-heading" >
                    <h3 class="text-center">SisCom 2011 Ltd</h3><h4 class="text-center">Service system</h4>
                </div>
                <div class="panel-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Потребителско име</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php
                           
                            echo escape(Input::get('username'))
                            ?>" autocomplete="off" autofocus="on">
                        </div>
                        <div class="form-group">
                            <label for="password">Парола</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password_again">Повтори паролата</label>
                            <input type="password" class="form-control" name="password_again" id="password_again">
                        </div>
                        <div class="form-group">
                            <label for="name">Име</label>
                            <input type="text" class="form-control" name="name" class="" id="name" value="<?php
                            echo escape(Input::get('name'));
                            ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" class="form-control" name="last_name" class="" id="last_name" value="<?php echo escape(Input::get('last_name')) ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="phone" >Телефон</label>
                            <input type="text" class="form-control" placeholder="Ако телефона е домашен, кода е задължителен" name="phone" id="phone" value="<?php echo Input::get('phone'); ?>" autocomplete="off" >
                        </div>
                        <div class="form-group" >
                            <label for="phone">Е-поща</label>
                            <input type="email" class="form-control" name="email" id="email" id="email" value="<?php echo Input::get('email'); ?>" autocomplete="off" >
                        </div>
                        <div class="form-group">
                            <input type="file" id="photoSel" accept="image/*" placeholder="Избери снимка" name="photo" >
                            <label for="photoSel" class="btn btn-primary" id="photoText">Избери снимка</label>
                        </div>
                </div>
                <div class="panel-footer">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <input type="submit" class="btn form-control btn-primary" value="Запиши" >
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>