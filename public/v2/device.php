<?php
require_once 'core/init.php';

my_head('Устройства');

my_menu();

$user = new User();
$status = new ADD();
$token = new Token();

if ($user->isLoggedIn()) {
    if (Input::exists()) {

        // izvajda info za zaqvkata
        if (Input::get('order')) {
            $userId = new User(); // vzimame informacia za lognatia potrebitel
            $client = new Clients();
            $client->findOne(Input::get('order'), 'id', 'orders');
            $order = $client->data();
            $client->findOne($order->modelId, 'id', 'model');
            $model = $client->data();
            $client->findOne($order->brandId, 'id', 'brand');
            $brand = $client->data();
            $client->findOne($order->serialId, 'id', 'device');
            $device = $client->data();

            // vzimame informacia za porychkata dali e prieta ot nqkoi ili ne e
            $client->findOne($order->id, 'orderId', 'orderTime');
            $userOrder = $client->data();
            // $user = userOrder
            $client->findOne($order->id, 'orderId', 'userOrder');
            $user = $client->data();


            //add parts
            if (Input::get('addPart') === 'ok') {
                $add = new ADD();
                try {
                    $add->create(array(
                        'orderId' => Input::get('order'),
                        'storeId' => Input::get('partOrder'),
                        'dateTime' => date('Y-m-d H:i:s')
                            ), 'orderParts');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setTimeout(function () {
                            $(location).attr('href', 'device.php?order=<?php echo $order->id; ?>')
                        }, 1000);

                    });
                </script>
                <?php
            }

            //edit serial
            if (Input::get('ed') === 'ed') {
                $add = new ADD();
                if ($device->vrSerial === '1' && $device->serial !== Input::get('serial')) {
                    try {

                        if (Input::get('modelEd') !== NULL) {

                            $add->update(array(
                                'modelId' => Input::get('modelEd'),
                                'serial' => Input::get('serial'),
                                'vrSerial' => '0'
                                    ), $order->serialId, 'device');
                        } else {
                            $add->update(array(
                                'serial' => Input::get('serial'),
                                'vrSerial' => '0'
                                    ), $order->serialId, 'device');
                        }
                    } catch (Exception $ex) {
                        die($ex->getMessage());
                    }
                } else {
                    $add->update(array(
                        'serial' => Input::get('serial')
                            ), $order->serialId, 'device');
                }

                try {

                    if (Input::get('modelEd') !== '') {
                        $add->update(array('modelId' => Input::get('modelEd')), $order->serialId, 'device');
                        $modelCh = new Clients();
                        $modelCh->findAll('orders');

                        foreach ($modelCh->data() as $modelChange) {
                            if ($modelChange->serialId === $order->serialId) {
                                $add->update(array('modelId' => Input::get('modelEd')), $modelChange->id, 'orders');
                            }
                        }
                    }
                    $add->update(array(
                        'password' => Input::get('password'),
                        'account' => Input::get('account'),
                        'info' => Input::get('info')
                            ), Input::get('order'), 'orders');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setTimeout(function () {
                            $(location).attr('href', 'device.php?order=<?php echo $order->id; ?>')
                        }, 1000);

                    });
                </script>
                <?php
            }

            //zapisva note
            if (Input::get('idDevNote') === $order->id && Input::get('compNote') === 'compNote') {
                $add = new ADD();
                try {
                    $add->create(array(
                        'note' => Input::get('note'),
                        'idOrder' => $order->id,
                        'idUser' => $userId->data()->id,
                        'dateTime' => date('Y-m-d H:i:s')
                            ), 'notes');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setInterval($(location).attr('href', 'device.php?order=<?php echo $order->id; ?>'), 3000);

                    });
                </script>
                <?php
            }
            // zapisva ordera
            if (Input::get('repair') !== NULL && $token->check(Input::get('tokenEdit'))) {
                $add = new ADD();
                $inoutservice = new Clients();
                $inoutservice->findOne($order->id, 'idOrder', 'inoutservice');


                if ($order->status === '2') {
                    $ordStatus = '3';
                } elseif ($order->status === '3') {
                    $ordStatus = '4';
                } elseif ($order->status === '5') {
                    echo '<div class="alert alert-denger">Това е взето, ехо!!!</div>';
                    exit();
                } elseif ($order->status === '4') {
                    $ordStatus = '4';
                }

                if ($_FILES['repairImg']['name']) {
                    $tmpType = explode(".", $_FILES['repairImg']['name']);
                    $img = $userId->data()->id . '_' . date('His') . '.' . $tmpType[1];
                    move_uploaded_file($_FILES['repairImg']['tmp_name'], "images/works/" . $img);
                    $add->create(array(
                        'url' => 'images/works/' . $img,
                        'orderId' => $order->id
                            ), 'photos');
                }

                try {
                    $add->update(array(
                        'status' => $ordStatus,
                        'repair' => Input::get('repair'),
                        'repairInfo' => Input::get('repairInfo')
                            ), $order->id, 'orders');
                    if (Input::get('impossibleRepair')) {
                        $add->update(array(
                            'impossibleRepair' => 1
                                ), $order->id, 'orders');
                    }
                    if ($order->status === '3') {
                        $add->create(array(
                            'endOrder' => date('Y-m-d H:i:s'),
                            'userId' => $userId->data()->id,
                            'orderId' => $order->id
                                ), 'orderTime');
                    } elseif ($order->status === '4') {
                        $add->create(array(
                            'updateOrder' => date('Y-m-d H:i:s'),
                            'userId' => $userId->data()->id,
                            'orderId' => $order->id
                                ), 'orderTime');
                    } else {
                        $add->create(array(
                            'updateOrder' => date('Y-m-d H:i:s'),
                            'userId' => $userId->data()->id,
                            'orderId' => $order->id
                                ), 'orderTime');
                    }

                    if ($inoutservice->data()->id !== NULL) {
                        $add->update(array(
                            'inOrder' => Input::get('price'),
                            'idUser' => $userId->data()->id,
                            'dateOrder' => date('Y-m-d H:i:s')
                                ), $inoutservice->data()->id, 'inoutservice');
                    } else {
                        $add->create(array(
                            'inOrder' => Input::get('price'),
                            'idOrder' => $order->id,
                            'idUser' => $userId->data()->id,
                            'dateOrder' => date('Y-m-d H:i:s')
                                ), 'inoutservice');
                    }
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setInterval($(location).attr('href', 'device.php?order=<?php echo $order->id; ?>'), 3000);

                    });
                </script>
                <?php
            } elseif ($token->check(Input::get('tokenEdit')) && $order->status === '4') {
                $update = new ADD();
                try {
                    $update->update(array(
                        'repair' => Input::get('repair'),
                        'repairInfo' => Input::get('repairInfo'),
                            ), $order->id, 'orders');
                    if (Input::get('impossibleRepair')) {
                        $update->update(array(
                            'impossibleRepair' => 1
                                ), $order->id, 'orders');
                    }

                    $client->findOne($order->id, 'idOrder', 'inoutservice');
                    $update->update(array('inOrder' => Input::get('price')), $client->data()->id, 'inoutservice');
                    $client->findOne($order->id, 'orderId', 'orderTime');
                    $update->create(array('updateOrder' => date('Y-m-d H:i:s'),
                        'userId' => $userId->data()->id,
                        'orderId' => $order->id
                            ), 'orderTime');
                    ?>
                    <div class="alert alert-success">Всички промени бяха приети :)</div>
                    <?php
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                ?>
                <input type="hidden" id="redirect" value="<?php echo 'device.php?order=' . $order->id; ?>">
                <?php ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setInterval($(location).attr('href', 'device.php?order=<?php echo $order->id; ?>'), 3000);

                    });
                </script>
                <?php
            }

            if ($token->check(Input::get('takeOrder'), 'takeOrder')) { // start na priemaneto na porychkata
                $add = new ADD();

                try {
                    $add->update(array(
                        'status' => '2'
                            ), $order->id, 'orders');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }

                // syzdava orderTime 
                try {
                    $add->create(array(
                        'startOrder' => date('Y-m-d H:i:s'),
                        'userId' => $userId->data()->id,
                        'orderId' => $order->id
                            ), 'orderTime');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }

                // vzima id-to na vremeto na porychkata
                $orderTimeId = new Clients();
                $orderTimeId->find($order->id, 'orderId', 'orderTime');

                try {
                    $add->create(array(
                        'orderId' => $order->id,
                        'userId' => $userId->data()->id,
                        'orderTimeId' => $orderTimeId->data()->id
                            ), 'userOrder');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setTimeout($(location).attr('href', 'device.php?order=<?php echo $order->id; ?>'), 3000);

                    });
                </script>
                <?php
            }

            //Markira kato vzeta
            if (Input::get('end') === 'end' && Input::get('order') === $order->id) {
                $update = new ADD();
                $client->find($order->id, 'idOrder', 'inoutservice');
                try {
                    $update->update(array(
                        'status' => '5',
                        'active' => '0'
                            ), $order->id, 'orders');
                    $update->update(array(
                        'inOrder' => Input::get('price'),
                        'active' => '0'
                            ), $client->data()->id, 'inoutservice');
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {
                        setTimeout($(location).attr('href', 'index.php'), 3000);
                    });
                </script>
                <?php
            }
            ?>
            <!--Clients Settigns-->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <?php
                        $clientInfo = new Clients();
                        $clientInfo->find($order->clientId, 'id', 'clients');
                        ?>
                        <div class="x_title"><h4><a class="text-uppercase" style="color: #eea236;" href="clients.php?cl=<?php echo $clientInfo->data()->id; ?>"><?php echo $clientInfo->data()->name . ' ' . $clientInfo->data()->last_name . ' :  ' . $clientInfo->data()->phone . ' / ' . $clientInfo->data()->email; ?></a></h4></div>
                    </div>
                </div>
                <div class = "col-md-12 col-sm-12 col-xs-12">
                    <div class = "x_panel">
                        <div class = "x_title">
                            <h4 class="pull-right"><?php echo $brand->brand . ' ' . $model->model; ?> S/N: <?php
                                echo $device->serial;
                                if ($device->vrSerial) {
                                    ?>
                                    <i style="color: #EF6C00;" class="fa fa-exclamation-triangle pull-right" data-toggle="tooltip" data-placement="top" title="Този сериен номер е временен и трябва да се смени при първа възможност"></i>
                                    <?php
                                }
                                ?>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" title="Редактирай" data-target=".EditDevice"> <i class="fa fa-edit"></i></button>
                            </h4>
                            <!-- Formata za redaktirane -->

                            <h4 class="pull-left" style="font-size: 20px;">#<?php echo $order->id; ?></h4>
                            <div class="modal fade EditDevice" tabindex="-1" role="dialog" aria-labelledby="EditDevice">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <form class="form-horizontal" action="" method="post">
                                                <?php
                                                $userPer = new User();
                                                if ($userPer->hasPermission('admin') || $userPer->hasPermission('modelEd')) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label>Модел</label>
                                                        <select name="modelEd" class="form-control">
                                                            <?php
                                                            $client->findAll('model');
                                                            foreach ($client->data() as $modelEdit) {
                                                                if ($modelEdit->brand === $brand->id) {
                                                                    ?>
                                                                    <option <?php
                                                                    if ($modelEdit->id === $model->id) {
                                                                        echo 'selected';
                                                                    }
                                                                    ?> value="<?php echo $modelEdit->id; ?>"><?php echo $modelEdit->model; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <label>Сериен номер</label>
                                                    <input class="form-control" type="text" name="serial" value="<?php echo $device->serial; ?>">
                                                </div>
                                                <div class=form-group>
                                                    <label>Парола</label>
                                                    <input type="text" class="form-control" name="password" value="<?php echo $order->password; ?>">
                                                </div>
                                                <div class=form-group>
                                                    <label>Акаунт</label>
                                                    <input type="text" class="form-control" placeholder="да се изписва по следния начин bla@bla.com/password" name="account" value="<?php echo $order->account; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Информация</label>
                                                    <input type="text" name="info" class="form-control" value="<?php echo $order->info ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="hidden" name="ed" value="ed">
                                                    <input type="hidden" value="<?php echo $order->id ?>" name="order" >
                                                    <input type="submit" value="Запиши" class="btn btn-primary pull-right">
                                                </div>
                                            </form>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!--                        Krai na formata za redaktirane -->
                            <div class = "clearfix"></div>
                        </div>
                        <div class = "x_content">
                            <div class = "col-md-3 col-sm-3 col-xs-12 profile_left img-thumbnail">
                                <div class = "profile_img img-rounded">
                                    <h3 style="color: #1A82C3;"><i class="fa fa-check-square"></i> 
                                        <?php
                                        $client->find($order->status, 'orderStatus', 'status');

                                        echo $client->data()->name;
                                        ?>
                                    </h3>
                                </div>
                                <!--End Clients img -->
                                <h4 style="border-bottom: 1px solid; color: red;"><i class="fa fa-warning"></i> <?php echo $order->problem; ?></h4>
                                <lu class="list-unstyled user_data">
                                    <li style="font-size: 16px;"><i class="fa fa-clock-o"></i> <?php echo $order->timeOrder; ?></li>
                                    <li style="font-size: 16px;"><i class="fa fa-info"></i> <?php echo $order->info; ?></li>
                                    <li style="font-size: 16px;"><i class="fa fa-gear"></i> <?php echo $order->snapshop; ?></li>
                                    <li style="font-size: 16px;"><i class="fa fa-key"></i> <?php echo $order->password; ?></li>
                                    <li style="font-size: 16px;"><i class="fa fa-user"></i> <?php echo $order->account; ?></li>
                                    <br>
                                    <li style="border-bottom: 1px solid;"></li>
                                    <li class="border-aero bg-orange text-center"> Приета от: 
                                        <?php
                                        $client->findOne($order->userId, 'id', 'users');
                                        echo $client->data()->name . ' ' . $client->data()->last_name;
                                        ?>
                                    </li>
                                    <li style="border-bottom: 1px solid #1A82C3;"></li>
                                    <br>
                                    <li>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                История на сервизните
                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                if (!empty($userOrder->orderId)) {
                                                    if (!empty($userOrder->startOrder)) {
                                                        $client->find($userOrder->userId, 'id', 'users');
                                                        echo '<div class="alert alert-info alert-dismissible" role="alert">Приета от: ' . $client->data()->name . ' на ';

                                                        echo $userOrder->startOrder . ' </div>';
                                                    }
                                                    $client->findLoop($order->id, 'orderId', 'orderTime');
                                                    foreach ($client->data() as $updateTime) {
                                                        if ($updateTime->updateOrder !== '' && !empty($updateTime->updateOrder)) {
                                                            $client->find($updateTime->userId, 'id', 'users');
                                                            echo '<div class="alert alert-warning alert-dismissible" role="alert">Редактиран от: ' . $client->data()->name . ' на ';

                                                            echo $updateTime->updateOrder . ' </div>';
                                                        }
                                                    }
                                                    $end = new Clients();
                                                    $end->find($order->id, 'orderId', 'orderTime');
                                                    if ($end->numres() !== NULL) {
                                                        foreach ($end->search() as $endOrder) {
                                                            if (!empty($endOrder->endOrder)) {
                                                                $client->find($endOrder->userId, 'id', 'users');
                                                                echo '<div class="alert alert-success alert-dismissible" role="alert">Приключен от: ' . $client->data()->name . ' на ';

                                                                echo $endOrder->endOrder . ' </div>';
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                </lu>
                            </div> <!-- end left col -->
                            <div class="col-md-9 col-sm-9 col-xs-12">

                                <div class="col-xs-9">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <?php
                                        if ($userPer->hasPermission('admin') || $userPer->hasPermission('servicePer')) {
                                            ?>
                                            <div class="tab-pane <?php
                                            if ($userPer->hasPermission('admin') || $userPer->hasPermission('servicePer')) {
                                                echo 'active';
                                            }
                                            ?>" id="service">
                                                 <?php
                                                 // proverka

                                                 if ($order->status === '5') {
                                                     ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">Error:</span>
                                                        Тази поръчка е взета!!!
                                                    </div>
                                                    <?php
                                                } elseif (isset($user->userId) && !empty($userOrder->startOrder) && $user->active === '1') {

                                                    if ($order->status === '4') {
                                                        echo '<div class="alert alert-danger" role="alert"> Поръчката е приключена !!!</div>';
                                                    }
                                                    $price = new Clients();
                                                    $price->find($order->id, 'idOrder', 'inoutservice');
                                                    ?>
                                                    <form class="form-horizontal overflow_hidden" action="" enctype="multipart/form-data" method="post" style="max-width: 400px;">
                                                        <div class="form-group">
                                                            <label>Ремонт</label>
                                                            <input class="form-control" autofocus="on" name="repair" autocomplete="off" value="<?php echo $order->repair; ?>" placeholder="Внимание това се вижда и от клиента" type="text">
                                                        </div>
                                                        <div class="form-groupm">
                                                            <label>Цена</label>
                                                            <input class="form-control" type="text" autocomplete="off" placeholder="Цена за ремонта" value="<?php
                                                            if ($price->data() !== NULL) {
                                                                echo $price->data()->inOrder;
                                                            }
                                                            ?>" name="price" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Приложи снимка</label>
                                                            <input type="file" name="repairImg">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Забележка към ремонта</label>
                                                            <textarea class="form-control" name="repairInfo" autofocus="off" placeholder="Достъпно само за персонала"><?php echo $order->repairInfo; ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <input class="checkbox-inline" type="checkbox" value="1" <?php
                                                            if ($order->impossibleRepair) {
                                                                echo 'checked';
                                                            }
                                                            ?> name="impossibleRepair">
                                                            <label style="color: red;">Невъзможен ремонт</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="tokenEdit" value="<?php echo $token->generate(); ?>" >
                                                            <input type="hidden" name="order" value="<?php echo $order->id ?>">
                                                            <input type="submit" class="btn btn-primary pull-right" value="<?php
                                                            if ($order->status === '4') {
                                                                echo 'Редактирай';
                                                            } else {
                                                                if ($order->status === '3') {
                                                                    echo 'Приключи';
                                                                } else {
                                                                    echo 'За тест';
                                                                }
                                                            }
                                                            ?>">
                                                        </div>
                                                    </form> 

                                                    <?php
                                                } elseif (isset($userOrder->userId) === TRUE && $user->active === '2') {
                                                    if ($user->userId === $userId->data()->id) {
                                                        ?>
                                                        <form class="form-horizontal" action="" method="post">
                                                            <div class="form-group-lg text-center">
                                                                <label>Тази поръчка е прехвърлена от <?php
                                                                    $client->findAll('userOrder');
                                                                    foreach ($client->data() as $shareUser) {
                                                                        if ($shareUser->active === '0' && $shareUser->orderId === $order->id) {
                                                                            $client->findOne($shareUser->userId, 'id', 'users');
                                                                            echo $client->data()->name . ' ' . $client->data()->last_name;
                                                                        }
                                                                    }
                                                                    ?></label>
                                                            </div>
                                                            <div class="form-group-lg text-center">
                                                                <input type="hidden" class="form-control" name="order" value="<?php echo $order->id; ?>">
                                                                <button class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </form>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>

                                                    <div class="col-md-12 text-center" style="font-size: 32px; margin-top: 20%;">
                                                        <form class="form-horizontal overflow_hidden" action="" method="post">
                                                            <div class="form-group">
                                                                <label></label>
                                                                <input type="hidden" name="order" value="<?php echo $order->id; ?>">
                                                                <input type="hidden" name="takeOrder" value="<?php echo $token->generate(); ?>">
                                                                <button class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <!-- chasti -->
                                            <div class="tab-pane" id="parts">
                                                <?php
                                                if ($order->status == 1) {
                                                    ?>
                                                    <div class="alert alert-info" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">Error:</span>
                                                        Тази поръчка не е приета!!!
                                                    </div>
                                                    <?php
                                                } elseif ($order->status == 5) {
                                                    ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">Error:</span>
                                                        Тази поръчка е взета!!!
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <form class="form-horizontal overflow_hidden pull-right" action="" method="post">
                                                        <div class="form-group">
                                                            <label>Избери</label>
                                                            <select class="form-control" name="partOrder">
                                                                <?php
                                                                $client->findAll('store');
                                                                if ($client->data() !== NULL) {
                                                                    foreach ($client->data() as $store) {
                                                                        echo '<option value="' . $store->id . '">' . $store->name . '</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option>Няма добавени части</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i></button>
                                                        <input type="hidden" name="order" value="<?php echo $order->id; ?>">
                                                        <input type="hidden" name="addPart" value="ok">
                                                    </form>
                                                    <form class="form-horizontal overflow_hidden pull-left" action="" method="post">
                                                        <div class="form-group">
                                                            <label>Поръчка</label>
                                                            <input type="text" class="form-control" name="number" placeholder="брой">
                                                            <label></label>
                                                            <input type="text" class="form-control" name="part" placeholder="">
                                                        </div>
                                                        <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i></button>
                                                    </form>
                                                    <div class="clearfix"></div>
                                                    <br>

                                                    <div class="table-responsive">
                                                        <table class="table table-striped jambo_table" id="example">
                                                            <thead><td style="min-width: 200px; ">Част</td><td>Цена</td><td>Опций</td></thead>
                                                            <tbody>
                                                                <?php
                                                                $client->findAll('orderParts');
                                                                if ($client->data() !== NULL) {
                                                                    foreach ($client->data() as $parts) {
                                                                        if ($parts->orderId === $order->id) {
                                                                            $client->findOne($parts->storeId, 'id', 'store');
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $client->data()->name; ?></td>
                                                                                <td><?php echo $client->data()->price; ?></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <div class="tab-pane" id="notes">

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4>Забележки
                                                        <?php
                                                        if ($order->status !== '5') {
                                                            ?>
                                                            <small class="">
                                                                <a class="right-arrow" data-toggle="modal" data-target="#noteComp"><i class="fa fa-plus"></i></a>
                                                            </small>
                                                        </h4>
                                                        <div class="modal fade text-left" id="noteComp" tabindex="-1" role="dialog" aria-labelleby="">
                                                            <div class="modal-dialog" role="documnet">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <form action="" method="post">

                                                                            <div class="form-group">
                                                                                <label>Забележка</label> 
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input autocomplete="off" type="text" name="note" class="form-control" >
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="form-group">
                                                                            <label></label>
                                                                            <input type="hidden" name="compNote" value="compNote">
                                                                            <input type="hidden" name="idDevNote" value="<?php echo $order->id; ?>">
                                                                            <input type="submit" class="btn btn-primary" value="Запиши">
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="list-group">
                                                        <?php
                                                        $nodess = new Clients();
                                                        $nodess->findLoop($order->id, 'idOrder', 'notes');
                                                        $nNote = $nodess->numersLoop();
                                                        if ($nNote) {
                                                            foreach (array_reverse($nodess->data()) as $notes) {
                                                                $client->findOne($notes->idUser, 'id', 'users');
                                                                ?>
                                                                <div class="list-group-item list-group-item-success">
                                                                    <h4 class="list-group-item-heading"><?php echo $notes->dateTime . ' - ' . $client->data()->name . ' ' . $client->data()->last_name; ?></h4>
                                                                    <p class="list-group-item-text"><?php echo $notes->note; ?></p>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="oldService">
                                            <!-- start accordion -->
                                            <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                                                <?php
                                                $client->findLoop($order->serialId, 'serialId', 'orders');
                                                $x = 0;
                                                foreach (array_reverse($client->data()) as $oldService) {
                                                    if ($oldService->active == 0) {
                                                        $x++;
                                                        
                                                        
                                                        
                                                        ?>
                                                        <div class="panel">
                                                            <div class="panel-heading display">
                                                                <a class="btn btn-primary pull-right" href="device.php?order=<?php echo $oldService->id; ?>"><i class="fa fa-folder-open"></i></a>
                                                                <a class="panel-title" role="tab" id="heading<?php echo $x; ?>" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $x; ?>"  aria-controls="collapse<?php echo $x; ?>">
                                                                    <h4 class=""><?php
                                                                        $client->find($oldService->id, 'orderId', 'orderTime');
                                                                        foreach ($client->search() as $showTime) {
                                                                            if (!empty($showTime->endOrder)) {
                                                                                echo $showTime->endOrder;
                                                                                echo ' - ';
                                                                                $client->find($showTime->userId, 'id', 'users');
                                                                                echo $client->data()->name . ' (' . $client->data()->username . ')';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </h4>
                                                                </a>
                                                            </div>
                                                            <div id="collapse<?php echo $x; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $x; ?>">
                                                                <div class="panel-body">
                                                                    <p><strong><?php echo $oldService->repair; ?></strong></p>
                                                                    <p><?php echo $oldService->repairInfo; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <!-- end of accordion -->
                                        </div>
                                        <?php
                                        if ($userPer->hasPermission('admin') || $userPer->hasPermission('finalPer')) {
                                            ?>
                                            <div class="tab-pane <?php
                                            if (!$userPer->hasPermission('servicePer') && !$userPer->hasPermission('admin')) {
                                                echo 'active';
                                            }
                                            ?>" id="infoOrder">
                                                 <?php
                                                 $client->find($order->id, 'orderId', 'userOrder', 'id ASC');
                                                 if (isset($client->data()->userId)) {
                                                     $client->find($client->data()->userId, 'id', 'users');
                                                 }
                                                 ?>
                                                <table class="table-bordered">
                                                    <tr>
                                                        <td class="col-md-3"><h4 class="title">Сервизен</h4></td>
                                                        <td class="col-md-9"><?php
                                                            if (isset($client->data()->name)) {
                                                                echo $client->data()->name . ' ' . $client->data()->last_name;
                                                            }
                                                            ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3"><h4 class="title">Ремонт</h4></td>
                                                        <td class="col-md-9">
                                                            <div class="media-body">
                                                                <h4 class="media-heading media-left">
                                                                    <?php
                                                                    echo $order->repair;
                                                                    ?>
                                                                </h4>
                                                            </div>
                                                            <?php
                                                            $img = new Clients();
                                                            $img->find($order->id, 'orderId', 'photos');
                                                            if ($img->data() !== NULL) {
                                                                ?>
                                                                <div class="media media-right">
                                                                    <img class="media-object" data-toggle="modal" data-target="#img" style="width: 34px; height: 34px;" src="<?php echo $img->data()->url; ?>">
                                                                </div>
                                                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="img" role="dialog" >
                                                                    <div class="modal-dialog modal-lg" rule="documnt">

                                                                        <div class="modal-content text-center">
                                                                            <div class="modal-header"></div>
                                                                            <div class="modal-body">
                                                                                <img style="width: 800px; height: 600px;" src="<?php echo $img->data()->url; ?>">
                                                                            </div>
                                                                            <div class="modal-footer">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3"><h4 class="title">Части<h4</td>
                                                                    <td class="col-md-9"> <div class="table-responsive">
                                                                            <table class="table table-hover">
                                                                                <tbody>
                                                                                    <?php
                                                                                    $total = 0;
                                                                                    $partsOrder = new ADD();
                                                                                    $partsOrder->findAll('orderParts');
                                                                                    if ($partsOrder->data() !== NULL) {
                                                                                        foreach ($partsOrder->data() as $parts) {
                                                                                            if ($parts->orderId === $order->id) {
                                                                                                $client->findOne($parts->storeId, 'id', 'store');
                                                                                                $total += $client->data()->price;
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td><?php echo $client->data()->name; ?></td><td id="totalFinal"><?php echo $client->data()->price; ?></td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <tr><td>Общо</td><td>
                                                                                            <?php echo $total; ?>
                                                                                        </td></tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="col-md-3"><h4>Забележка</h4></td>
                                                                        <td class="col-md-9"><?php
                                                                            echo $order->repairInfo . '<br><br><br>';
                                                                            if ($order->impossibleRepair === '1') {
                                                                                ?>
                                                                                <div class="alert alert-danger" role="alert">
                                                                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                                                    <span class="sr-only">Error:</span>
                                                                                    Невъзможен ремонт !!!
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="col-md-3 bg-info"></td>
                                                                        <td class="col-md-9 bg-info">
                                                                            <?php
                                                                            if ($order->status === '5') {
                                                                                echo 'Устройството е взето<br>';
                                                                                echo 'Цена: ';
                                                                                $client->find($order->id, 'idOrder', 'inoutservice');
                                                                                if (isset($client->data()->inOrder)) {
                                                                                    echo $client->data()->inOrder + $total;
                                                                                } else {
                                                                                    echo 0 + $total;
                                                                                }
                                                                                echo 'лв.';
                                                                            } else {
                                                                                ?>
                                                                                <form class="form-inline pull-right" method="post" action="">
                                                                                    <div class="form-group">
                                                                                        <label>Цена:</label>
                                                                                        <input type="text" class="form-control focus text-right" name="price" value="<?php
                                                                                        $client->find($order->id, 'idOrder', 'inoutservice');
                                                                                        if (isset($client->data()->inOrder)) {
                                                                                            echo $client->data()->inOrder + $total;
                                                                                        } else {
                                                                                            echo 0 + $total;
                                                                                        }
                                                                                        ?>">
                                                                                        <span class="add-on">лв.</span>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label></label>
                                                                                        <input type="hidden" name="order" value="<?php echo $order->id; ?>">
                                                                                        <input type="hidden" name="end" value="end">
                                                                                        <button class="btn btn-danger btn-sm"><i class="fa fa-close">Взета</i></button>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    </table>
                                                                    </div>

                                                                <?php } ?>
                                                                </div>
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <!-- required for floating -->
                                                                    <!-- Nav tabs -->
                                                                    <ul class="nav nav-tabs tabs-right">
                                                                        <?php
                                                                        if ($userPer->hasPermission('admin') || $userPer->hasPermission('finalPer')) {
                                                                            ?>
                                                                            <li class="<?php
                                                                            if (!$userPer->hasPermission('servicePer') && !$userPer->hasPermission('admin')) {
                                                                                echo 'active';
                                                                            }
                                                                            ?>"><a href="#infoOrder" data-toggle="tab"><i class="fa fa-info"> Информация</i></a>
                                                                            </li>
                                                                            <?php
                                                                        }
                                                                        if ($userPer->hasPermission('admin') || $userPer->hasPermission('servicePer')) {
                                                                            ?>
                                                                            <li <?php
                                                                            if ($userPer->hasPermission('admin') || $userPer->hasPermission('servicePer')) {
                                                                                echo 'class="active"';
                                                                            }
                                                                            ?>><a href="#service" data-toggle="tab"><i class="fa fa-cogs"></i> Сервиз</a>
                                                                            </li>

                                                                            <li><a href="#parts" data-toggle="tab"><i class="fa fa-chain-broken"></i> Части</a>
                                                                            </li>
                                                                        <?php } ?>
                                                                        <li><a href="#notes" data-toggle="tab"><i class="fa fa-list"></i> Забележки <span class="badge right"> <?php
                                                                                    if (!$nNote) {
                                                                                        echo 0;
                                                                                    } else {
                                                                                        echo $nNote;
                                                                                    }
                                                                                    ?></span></a>
                                                                        </li>
                                                                        <li><a href="#oldService" data-toggle="tab"><i class="fa fa-calendar"></i> Пред. рем. <span class="badge right"> <?php
                                                                                    echo $x;
                                                                                    ?></span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                </div> <!-- end left col -->
                                                                </div>
                                                                </div>
                                                                </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    my_footer();
                                                    