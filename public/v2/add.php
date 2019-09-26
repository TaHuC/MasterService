<?php
require_once 'core/init.php';

my_head('Добавяне');

my_menu();
$user = new User();

if (Input::get('cl')) {
    $client = new Clients();
    $client->findOne(Input::get('cl'), 'id', 'clients');
    $result = new Add();
    $result->findAll('type');

    if (Input::get('addGr')) {
        $add = new ADD();

        $existGr = $result->findOne(Input::get('nameGR'), 'type', 'type');
        if (!$existGr) {
            try {
                $add->create(array(
                    'type' => Input::get('nameGR'),
                        ), 'type');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        } else {
            echo '<h1>Това вече го има избери си друго</h1>';
        }
    }

    if (Input::get('add')) {
        $add = new ADD();

        $existBrand = $result->findOne(Input::get('brand'), 'brand', 'brand');
        if (!$existBrand) {
            try {
                $add->create(array(
                    'brand' => Input::get('brand'),
                    'type' => Input::get('typeId')
                        ), 'brand');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }

        $result->findOne(Input::get('brand'), 'brand', 'brand');
        $brandId = $result->data()->id;

        $result->findOne(Input::get('model'), 'model', 'model');
        foreach ($result->search() as $modelExist) {
            if ($modelExist->brand === $brandId) {
                $existModel = '1';
            }
        }

        if (!$existModel) {
            try {
                $add->create(array(
                    'model' => Input::get('model'),
                    'brand' => $brandId
                        ), 'model');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
        $result->findOne(Input::get('model'), 'model', 'model', 'id DESC');
        $modelId = $result->data()->id;

        $existSerial = $result->findOne(Input::get('serial'), 'serial', 'device');
        if (!$existSerial) {
            $outSpace = str_replace(" ", "", Input::get('serial'));
            if (!$outSpace) {
                $random = substr(md5(rand()), 0, 7);
                $serial = strtoupper(date('YmdHis') . "" . $random);
                $vrSerial = 1;
            } else {
                $serial = strtoupper($outSpace);
                $vrSerial = 0;
            }
            try {
                $add->create(array(
                    'serial' => $serial,
                    'modelId' => $modelId,
                    'clientId' => $client->data()->id,
                    'vrSerial' => $vrSerial
                        ), 'device');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
        $result->findOne($serial, 'serial', 'device');
        $serialId = $result->data()->id;
        $userId = new User();
        $timeOrder = date('Y-m-d H-i-s');
        try {
            $add->create(array(
                'clientId' => $client->data()->id,
                'userId' => $userId->data()->id,
                'account' => Input::get('account'),
                'serialId' => $serialId,
                'modelId' => $modelId,
                'brandId' => $brandId,
                'timeOrder' => $timeOrder,
                'snapshop' => Input::get('snapshop'),
                'problem' => Input::get('problem'),
                'info' => Input::get('info'),
                'password' => Input::get('password')
                    ), 'orders');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        if (Input::get('price') !== NULL) {
            $result->findOne($timeOrder, 'timeOrder', 'orders');
            try {
                $add->create(array(
                    'idOrder' => $result->data()->id,
                    'inOrder' => Input::get('price'),
                    'idUser' => $userId->data()->id,
                    'dateOrder' => $timeOrder
                        ), 'inoutservice');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
        ?>
        <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
        <script type="text/javascript">
            $(function () {

                setInterval($(location).attr('href', 'index.php'), 3000);

            });
        </script>
        <?php
    }


    $result->findAll('type');
    ?>
    <div class="row">
        <?php
        if ($result->data() !== NULL) {
            foreach ($result->data() as $res) {
                ?>

                <button type="button" class="btn btn-primary btn-lg animated fadeInDownBig" data-toggle="modal" data-target=".<?php echo $res->id; ?>"><?php echo $res->type; ?></button>

                <div class="modal fade bs-example-modal <?php echo $res->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog animated fadeInRightBig">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"><?php echo $res->type; ?> - Към клиент <?php echo $client->data()->name . ' ' . $client->data()->last_name; ?></h4>
                            </div>
                            <form method="post" action="" id="addForm" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Марка</label>
                                        <input class="form-control" id="addBrand<?php echo $res->id; ?>" type="text" name="brand" autocomplete="off">
                                        <div id="brands<?php echo $res->id; ?>"></div>
                                        <script>
                                            $('input#addBrand<?php echo $res->id; ?>').on('input', function () {
                                                var addBrand = $('input#addBrand<?php echo $res->id; ?>').val();
                                                var getId = <?php echo $res->id; ?>;

                                                if ($.trim(addBrand) != '') {
                                                    $.post('addValue.php', {addBrand: addBrand, getId: getId}, function (brands) {
                                                        $('div#brands<?php echo $res->id; ?>').html(brands);
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label>Модел</label>
                                        <input class="form-control" id="addModel<?php echo $res->id; ?>" type="text" name="model" autocomplete="off">
                                        <input type="hidden" id="addIdBrand<?php echo $res->id; ?>">
                                        <div id="model<?php echo $res->id; ?>"></div>
                                        <script>
                                            $('input#addModel<?php echo $res->id; ?>').on('input', function () {
                                                var getIdBrand = $('input#addIdBrand<?php echo $res->id; ?>').val();
                                                var getModel = $('input#addModel<?php echo $res->id; ?>').val();
                                                var idBrand = <?php echo $res->id; ?>;

                                                if ($.trim(getModel) != '') {
                                                    $.post('addValue.php', {getIdBrand: getIdBrand, getModel: getModel, idBrand: idBrand}, function (model) {
                                                        $('div#model<?php echo $res->id; ?>').html(model);
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label>Сериен номер</label>
                                        <input class="form-control" type="text" onfocus="checkSerial()" name="serial" id="serial" placeholder="ВНИМАНИЕ ако няма добавен, системата ще генерира автоматично!!!" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Акаунт</label>
                                        <input class="form-control" type="text" name="account" placeholder="Задължителен въпрос (да се изписва по сл. начин ime@poshta.com/parola)" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Парола</label>
                                        <input class="form-control" type="text" name="password" placeholder="Задължителен въпрос (паролана устройството)" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Моментно състояние</label>
                                        <input class="form-control" type="text" name="snapshop"autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Проблем</label>
                                        <input class="form-control" type="text" name="problem" placeholder="Според клиентa" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Цена</label>
                                        <input type="text" name="price" autocomplete="off" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Допълнителна информация</label>
                                        <textarea class="form-control" name="info" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input class="" type="hidden" name="cl" value="<?php echo $client->data()->id; ?>">
                                    <input class="" type="hidden" name="typeId" value="<?php echo $res->id; ?>">
                                    <input class="" type="hidden" name="add" value="357">
                                    <input class="btn btn-primary" type="submit" value="Приеми">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <?php
            }
        }
        if ($user->hasPermission('admin') || $user->hasPermission('addGr')) {
            ?>
            <button type="button" class="btn btn-primary btn-lg animated fadeInDownBig" data-toggle="modal" data-target=".add"><i class="fa fa-plus"></i></button>
            <div class="modal fade bs-example-modal add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog animated fadeInDownBig">
                    <div class="modal-content">
                        <form class="form-horizontal">
                            <div class="modal-header">
                                <h4 class="">Добавяне на група</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Име на групата</label>
                                    <input type="text" class="form-control" name="nameGR">
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="cl" value="<?php echo $client->data()->id; ?>">
                                    <input type="hidden" name="addGr" value="358">
                                    <input type="submit" class="btn btn-primary" value="Добави">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div><!-- end row add new order-->
    <?php
} elseif (isset($_POST['clAgain'])) { // add again device
    if (!empty($_POST['addAgain'])) {
        $client = new Clients();
        $client->find($_POST['serial'], 'id', 'device');
        $device = $client->data();
        $client->find($device->modelId, 'id', 'model');
        $model = $client->data();
        $client->find($model->brand, 'id', 'brand');
        $brand = $client->data();
        $client->find($device->clientId, 'id', 'clients');
        $userId = new User();
        $timeOrder = date('Y-m-d H-m-s');

        if (isset($_POST['cmpAgain'])) {
            if (!empty($_POST['problem'])) {
                $add = new ADD();
                try {
                    $add->create(array(
                        'snapshop' => $_POST['snapshop'],
                        'problem' => $_POST['problem'],
                        'info' => $_POST['info'],
                        'clientId' => $client->data()->id,
                        'userId' => $userId->data()->id,
                        'modelId' => $model->id,
                        'brandId' => $brand->id,
                        'timeOrder' => $timeOrder,
                        'serialId' => $device->id
                            ), 'orders');
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }

                if (Input::get('price') !== NULL) {
                    $inoutservice = new Clients();
                    $inoutservice->find($device->id, 'serialId', 'orders', 'id DESC');

                    try {
                        $add->create(array(
                            'idOrder' => $inoutservice->data()->id,
                            'inOrder' => Input::get('price'),
                            'idUser' => $userId->data()->id,
                            'dateOrder' => $timeOrder
                                ), 'inoutservice');
                    } catch (Exception $ex) {
                        die($ex->getMessage());
                    }
                }
                ?>
                <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
                <script type="text/javascript">
                    $(function () {

                        setInterval($(location).attr('href', 'index.php'), 3000);

                    });
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    <h3>Има проблем! Моля проверете да ли сте попълнили полето: ПРОБЛЕМ</h3>
                </div>
                <?php
            }
        }
        ?>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-xs-8">
                <form class="form-horizontal" method="post" action="">
                    <div class="form-group">
                        <label>Акаунт</label>
                        <input type="text" name="account" placeholder="Задължителен въпрос (да се изписва по сл. начин ime@poshta.com/parola)" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Парола</label>
                        <input class="form-control" autocomplete="off" placeholder="Задължителен въпрос (парола на устройството)" type="text" name="password">
                    </div>
                    <div class="form-group">
                        <label>Моментно състояние</label>
                        <input type="text" class="form-control" name="snapshop" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Проблем</label>
                        <input type="text" name="problem" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Цена</label>
                        <input type="text" name="price" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Допълнителна информация</label>
                        <textarea class="form-control" name="info" autocomplete="off"></textarea>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <button class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
                        <input type="hidden" name="clAgain" value="<?php echo $client->data()->id; ?>">
                        <input type="hidden" name="serial" value="<?php echo $device->id; ?>">
                        <input type="hidden" name="cmpAgain" value="add">
                        <input type="hidden" name="addAgain" value="443">
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-xs-12 widget_tally_box">
                <div class="x_panel fixed_height_150">
                    <div class="x_content">
                        <h3 class="name"><?php echo $client->data()->name . ' ' . $client->data()->last_name; ?></h3>
                        <div class="flex">
                            <ul class="list-inline count2">
                                <h4><?php echo $brand->brand . ' ' . $model->model; ?></h4>
                                <span></span>
                            </ul>
                        </div>
                        <p>
                            Сериен №: <?php echo $device->serial; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} elseif (Input::get('clHour') !== NULL && is_numeric(Input::get('clHour'))) { //dobavqne na chas
    $hour = new ADD();
    $client = new Clients();
    $token = new Token();

    $client->findOne(Input::get('clHour'), 'id', 'clients');
    
    if($token->check(Input::get('clToken'))){
        try {
            $hour->create(array(
                'info' => Input::get('infoGet'),
                'clientId' => Input::get('clHourAdd'),
                'userId' => $user->data()->id,
                'price' => Input::get('priceGet'),
                'timeNow' => date('Y-m-d H:i:s'),
                'dateEnd' => Input::get('dateGet'),
                'timeEnd' => Input::get('timeEnd')
            ), 'saveHour');
        } catch (Exception $ex) {
        die ($ex->getMessage());    
        }
    }
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-6">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <h4 class="title" id="warningHour">Записване на час </h4>
                </div>
                <div class="panel-body">
                        <div class="form-group">
                            <label>Описание</label>
                            <input name="info" id="infoHour" autocomplete="off" type="text" class="form-control" id="infoHour" >
                        </div>
                        <div class="form-group form-inline">
                            <label>За дата</label>
                            <input type="date" id="dateHour" name="date" value="<?php echo date('m/d/Y'); ?>" class="form-control" >
                            <label> от</label>
                            <select name="clock" id="timeEnd" class="form-control">
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                            </select>
                            <label>часа</label><label id="dateHourWar"></label>
                        </div>
                        <div class="form-group">
                            <label>Капаро</label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" id="priceHour" class="form-control" name="price">
                            <div class="input-group-addon" >лв.</div>
                            </div>
                        </div>
                    <br>
                        <div class="form-group text-right">
                            <input type="hidden" name="clToken" id="clToken" value="<?php echo $token->generate(); ?>">
                            <input type="hidden" name="clHour" id="clHour" value="<?php echo Input::get('clHour'); ?>">
                            <input type="hidden" name="clHourAdd" id="clHourAdd" value="<?php echo Input::get('clHour'); ?>">
                            <button id="btnHour" class="btn btn-primary"><i class="fa fa-plus fa-2x"></i></button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>            
    <script type="text/javascript">
        $(function () {
            setInterval($(location).attr('href', 'index.php'), 1);

        });
    </script>
    <?php
}
my_footer();
