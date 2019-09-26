<?php
require_once 'core/init.php';
my_head('Клиенти');
my_menu();
$user = new User();
$token = new Token();

if (Input::exists()) {
    if ($token->check(Input::get('tokenAdd'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => TRUE,
                'min' => 3,
                'max' => 30
            ),
            'last_name' => array(
                'required' => TRUE,
                'min' => 3,
                'max' => 30
            ),
            'phone' => array(
                'required' => true,
                'min' => 7,
                'max' => 30,
                'unique' => 'clients'
            ),
            'email' => array(
                'min' => 7,
                'max' => 50,
                'unique' => 'clients'
            )
        ));


        if ($validation->passed()) {

            if (!empty(Input::get('egn'))) {
                $client = new Clients();
                $client->create(array(
                    'name' => Input::get('name'),
                    'last_name' => Input::get('last_name'),
                    'email' => Input::get('email'),
                    'phone' => Input::get('phone'),
                    'joined' => date('Y-m-d H:m:s'),
                    'egn' => Input::get('egn')
                ));
            } else {
                $client = new Clients();
                $client->create(array(
                    'name' => Input::get('name'),
                    'last_name' => Input::get('last_name'),
                    'email' => Input::get('email'),
                    'phone' => Input::get('phone'),
                    'joined' => date('Y-m-d H:m:s')
                ));
            }
            $clientId = new Clients();
            $clientId->findOne(Input::get('phone'), 'phone', 'clients');
            ?>
            <div id="redirectTest"  class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
            <script type="text/javascript">
                $(function () {
                    setTimeout($('#redirectTest').fadeIn(function () {
                        $('#redirectTest').fadeOut();
                    }), 8000);
                });
            </script>
            <?php
        } else {
            foreach ($validate->errors() as $error) {
                echo '<div class="jumbotron">';
                echo '<h3>' . $error . '</h3>';
                echo '</div>';
            }
        }
    }
}


if ($user->isLoggedIn()) {
    if ($user->hasPermission('admin') || $user->hasPermission('addCl')) {
        if (Input::get('add')) {
            ?>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Добави клиент</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" action="" method="post">

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input autocomplete="off" type="text" name="name" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Име" value="<?php echo Input::get('name'); ?>">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input autocomplete="off" type="text" name="last_name" class="form-control" id="inputSuccess3" placeholder="Фамиля" value="<?php echo Input::get('last_name'); ?>">
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input autocomplete="off" type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Е-поща" value="<?php echo Input::get('email'); ?>">
                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input autocomplete="off" type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Телефон" value="<?php echo Input::get('phone'); ?>">
                            <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="has-feedback-left" id="egn" > ЕГН/N на лична карта
                                    <script type="text/javascript">
                                        $('#egn').on('click', function () {
                                            // check box za egn
                                            var isCheck = $('#egn').is(':checked');

                                            if (isCheck) {
                                                $('#egnId').show();
                                            } else {
                                                $('#egnId').hide();
                                            }
                                        });
                                    </script>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" id="egnId" hidden="">
                            <input type="text" name="egn" class="form-control has-feedback-right" placeholder="ЕГН или Номер на Л.К.">
                            <span class="fa fa-ils form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="form-group-lg">
                            <div class="col-lg-12">
                                <input type="hidden" name="tokenAdd" value="<?php echo $token->generate(); ?>">
                                <button type="submit" class="btn btn-primary btn-lg form-control"><i class="fa fa-user-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    }

//ot tuk e profila na klienta
    if (!Input::get('add')) {
        if (Input::exists()) {
            if (!empty(Input::get('cl'))) {
                $cl = Input::get('cl');
            } else {
                $cl = $clientId->data()->id;
            }
            $client = new Clients();
            $client->findOne($cl, 'id', 'clients');
            ?>
            <!--Clients Settigns-->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Профил на клиента</h2>
                        <?php
                        if ($user->hasPermission('admin') || $user->hasPermission('addDv')) {
                            ?>
                            <div class="pull-right">
                                <div class="col-md-4">
                                    <form action="add.php" method="post">
                                        <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Запиши устройство">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <input type="hidden" name="cl" value="<?php echo $client->data()->id; ?>">
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form action="add.php" method="post">
                                        <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Запиши час">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                        <input type="hidden" name="clHour" value="<?php echo $client->data()->id; ?>">
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div class="crop-avatar">
                                    <div class="avatar-view" title="">
                                        <img src="images/user.png" alt="Avatar">
                                    </div>

                                </div>
                            </div>
                            <!-- End Clients img -->

                            <h3><?php echo $client->data()->name . ' ' . $client->data()->last_name; ?></h3>
                            <lu class="list-unstyled user_data">
                                <li><i class="fa fa-phone"></i> <?php echo $client->data()->phone; ?></li>
                                <li><i class="fa fa-envelope-o"></i> <?php echo $client->data()->email; ?></li>
                            </lu>
                        </div> <!-- end left col -->
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Устройства</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Записани часове</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Таб 3</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content"> <!-- ot tuk zapochvat taovete -->
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profile-tab">

                                        <!-- start user projects -->
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Устройства</th>
                                                    <th>Сериен #</th>
                                                    <th class="hidden-phone">Статус</th>
                                                    <th>Опций</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $client->findLoop(Input::get('cl'), 'clientId', 'device');
                                                if ($client->numersLoop()) {
                                                    $i = 1;
                                                    foreach ($client->data() as $device) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i++; //$device->id;                ?></td>
                                                            <td>
                                                                <?php
                                                                $client->findOne($device->modelId, 'id', 'model');
                                                                $brandId = $client->data()->brand;
                                                                $modelName = $client->data()->model;
                                                                $client->findOne($brandId, 'id', 'brand');
                                                                echo $client->data()->brand . ' ' . $modelName;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $device->serial;
                                                                if ($device->vrSerial) {
                                                                    ?>
                                                                    <i style="color: #EF6C00;" class="fa fa-exclamation-triangle fa-2x pull-right" data-toggle="tooltip" data-placement="top" title="Този сериен номер е временен и трябва да се смени при първа възможност"></i>
                                                                    <?php
                                                                }
                                                                ?></td>
                                                            <td class="hidden-phone"><?php
                                                                $serialId = $client->data()->id;
                                                                $orderStatus = new ADD();
                                                                $orderStatus->findOne($device->id, 'serialId', 'orders', 'id DESC');
                                                                $devStatus = $orderStatus->data();
                                                                $client->findOne($devStatus->status, 'orderStatus', 'status');
                                                                echo $client->data()->name;
                                                                ?></td>
                                                            <td class="vertical-align-mid">
                                                                <?php
                                                                if ($devStatus->status === '5') {
                                                                    if ($user->hasPermission('admin') || $user->hasPermission('addDv')) {
                                                                        ?>
                                                                        <form action="add.php" method="post">
                                                                            <input type="hidden" name="addAgain" value="231">
                                                                            <input type="hidden" name="clAgain" value="<?php echo $cl; ?>">
                                                                            <input type="hidden" name="serial" value="<?php echo $device->id; ?>" >
                                                                            <input type="hidden" name="token" value="<?php echo $token->generate(); ?>">
                                                                            <button class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                                        </form>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <form action="device.php" method="post">
                                                                    <input type="hidden" name="order" value="<?php echo $devStatus->id; ?>">
                                                                    <button class="btn btn-danger"><i class="fa fa-edit"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo '<td>Няма устройства</td><td></td><td></td><td></td><td></td>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- end user projects -->

                                    </div>


                                    <div class="tab-pane fade" id="tab_content2" role="tabpanel" aria-labelledbe="profile-tab">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Информация</th><th>Час</th><th>За дата</th><th>Цена</th><th>Опций</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $hour = new ADD();
                                                    $hour->findAll('saveHour');
                                                    foreach (array_reverse($hour->data()) as $myHour) {
                                                        if ($myHour->clientId === $cl) {
                                                            echo '<tr id="saveTimeTable">';
                                                            echo '<td>' . $myHour->info . '</td><td>' . $myHour->timeEnd . '</td><td>' . $myHour->dateEnd . '</td><td>' . $myHour->price . '</td>';
                                                            if ($myHour->active !== '0') {
                                                                echo '<input type="hidden" id="disId_' . $myHour->id . '" value="' . $myHour->id . '">';
                                                                echo '<td><button id="bt_' . $myHour->id . '" ><i class="fa fa-check"></i></button><button><i class="fa fa-coffee"></i></button></td>';
                                                                ?>
                                                            <script>
                                                                $(document).ready(function () {
                                                                    $('#bt_<?php echo $myHour->id; ?>').click(function () {
                                                                        var disId = $('#disId_<?php echo $myHour->id; ?>').val();
                                                                        var finalTime = 'final';
                                                                        alert(disId);
                                                                        $.post('saveTime.php', {disId: disId, finalTime: finalTime}, function () {
                                                                            $('#tab_content2').html('bla');
                                                                            setTimeout(function () {
                                                                                $(location).attr('href', 'clients.php?cl=<?php echo $clientId->id; ?>');
                                                                            }, 1000);
                                                                        });
                                                                    });
                                                                });

                                                            </script>
                                                            <?php
                                                        } else {
                                                            echo '<td>Приключен</td>';
                                                        }

                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_content3" role="tabpanel" aria-labelledbe="profile-tab">
                                        <h2>и тук така</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

my_footer();
