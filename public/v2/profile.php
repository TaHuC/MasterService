<?php
require_once 'core/init.php';

$user = new User();
$img = new ADD();
$order = new Clients();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
my_head('Профил');
my_menu();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => TRUE,
                'min' => 6
            ),
            'password_new' => array(
                'required' => TRUE,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => TRUE,
                'matches' => 'password_new',
                'min' => 6
            )
        ));

        if ($validate->passed()) {
            if (utf8_decode(Hash::make(Input::get('password_current'), $user->data()->salt)) !== $user->data()->password) {
                echo 'Not OK';
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => utf8_decode(Hash::make(Input::get('password_new'), $salt)),
                    'salt' => utf8_decode($salt)
                ));

                Session::flash('home', 'Паролата беше променена успешно!');
                Redirect::to('index.php');
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }

    if (isset($_FILES['image']) !== NULL) {
        if (!empty($_FILES['image']['name'])) {

            $tmpType = explode(".", $_FILES['image']['name']);
            $newName = $user->data()->id . '_' . date('His') . '.' . $tmpType[1];


            try {
                $img->create(array(
                    'url' => 'images/works/' . $newName,
                    'userId' => $user->data()->id
                        ), 'photos');
                move_uploaded_file($_FILES['image']['tmp_name'], "images/works/" . $newName);
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
    }

    if (isset($_POST['choiseIMG'])) {
        $img->find($user->data()->id, 'userId', 'photos');

        if ($img->numres() !== NULL) {

            foreach ($img->search() as $imgSet) {
                if ($imgSet->active == "1") {
                    try {
                        $img->update(array(
                            'active' => '0'
                                ), $imgSet->id, 'photos');
                    } catch (Exception $ex) {
                        die($ex->getMessage());
                    }
                }
            }
        }

        try {
            $img->update(array(
                'active' => '1'
                    ), $_POST['idIMG'], 'photos');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        echo '<h4>Снимтака е активирана</h4>';
    }
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="modal-header">
            <h3>Нова парола</h3>
        </div>
        <form action="" class="form-horizontal" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label  for="password_current">Текуща парола</label>
                    <input type="password" class="form-control" name="password_current" id="password_current">
                </div>
                <div class="form-group">
                    <label for="password_new">Нова парола</label>
                    <input type="password" class="form-control" name="password_new" id="password_new">
                </div>
                <div class="form-group">
                    <label for="password_new_again">Повтори новата парола</label>
                    <input type="password" class="form-control" name="password_new_again" id="password_new_again">
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
                    <input type="submit" class="btn btn-primary" value="Промени">
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <form class="form-horizontal" action="" accept-charset="post">
            <div class="modal-header">
                <h3>Сменя на лични данни</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Име</label>
                    <input class="form-control" type="text" name="fName">
                </div>
                <div class="form-group">
                    <label>Фамилия</label>
                    <input class="form-control" type="text" name="lName">
                </div>
                <div class="form-group">
                    <label>Телефон</label>
                    <input class="form-control" type="text" name="phone">
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="update" value="Промени">
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-4">
        <div class="modal-header">
            <h3>Снимки</h3>
        </div>
        <form class="" action="" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label>Избери снимка</label>
                    <input type="file" class="form-group" name="image">
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button name="imgUpload" class="btn btn-primary">Качи</button>
                </div>
            </div>
        </form>
        <div class="">
            <?php
            $img->find($user->data()->id, 'userId', 'photos');
            if ($img->numres() !== NULL) {

                echo '<h4>Избери</h4>';
                foreach ($img->search() as $imgs) {
                    echo '<div class="col-md-2">';
                    echo '<form action="" class="form-horizontal" method="post">';
                    echo '<div class="form-group">';
                    echo '<input type="hidden" name="idIMG" value="' . $imgs->id . '">';
                    echo '<input type="hidden" name="choiseIMG" value="1">';
                    echo '<button class="form-group"><img id="imgUser" class="img-rounded" src="' . $imgs->url . '"></button>';
                    echo '</div></form></div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title left">История на поръчките</h4>
                <a href="#" class="filter"><i class="fa fa-filter"></i></a>
            </div>

            <div class="panel-body">
                <?php
                //istoria na porychkite 
                $order->find($user->data()->id, 'userId', 'orderTime');
                foreach ($order->search() as $timeInfo) {
                    if ($timeInfo->startOrder !== '') {
                        $order->findOne($timeInfo->orderId, 'id', 'orders');
                        $orderInfo = $order->data();
                        ?>
                        <div class="col-md-4" data-toggle="tooltip" data-placement="top">
                            <div class="alert <?php
                            if ($orderInfo->status === '2' || $orderInfo->status === '3') {
                                echo 'alert-info';
                            } else if ($orderInfo->status === '4') {
                                echo 'alert-warning';
                            } else if ($orderInfo->status === '5') {
                                echo 'alert-success';
                            }
                            ?>">
                                <h6 class="title" id="orderId"><a class="text-log" href="device.php?order=<?php echo $orderInfo->id; ?>">#<?php echo $orderInfo->id; ?></a>
                                    <small class="text-right"><?php
                                        $order->find($orderInfo->status, 'id', 'status');
                                        echo $order->data()->name;
                                        ?></small></h6>
                                <?php 
                                $order->findAll('notes');
                                $i = 0;
                                foreach ($order->data() as $numNotes){
                                    if($numNotes->idOrder === $orderInfo->id){
                                        $i++;
                                    }
                                }
                                ?>
                                <a class="btn btn-sm btn-primary <?php if($i === 0) echo 'disabled'; ?>" data-toggle="modal" data-target=".bs-example-modal-sm_<?php echo $orderInfo->id; ?>">Забележки: <?php echo $i; ?> </a>
                                <div class="modal fade bs-example-modal-sm_<?php echo $orderInfo->id; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-green">
                                                <h4 class="modal-title">Забележки</h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                foreach (array_reverse($order->data()) as $notes) {
                                                    if ($notes->idOrder === $orderInfo->id) {
                                                        ?>
                                                        <div class="alert alert-info">
                                                            <h5 class="title_left">
                                                            <?php 
                                                                $order->findOne($notes->idUser, 'id', 'users');
                                                                echo $order->data()->name.' '.$order->data()->last_name;
                                                                $noteDate = date_create($notes->dateTime);
                                                            ?>
                                                                <small><?php echo date_format($noteDate, 'd/m/Y'); ?></small>
                                                            </h5>
                                                            <?php echo $notes->note; ?>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>
<?php
my_footer();
