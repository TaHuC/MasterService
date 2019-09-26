<?php
require_once 'core/init.php';
$user = new User();
$token = new Token();
$add = new ADD();
my_head('Админ Панел');

my_menu();

if (isset($_POST['addGr']) !== NULL) {
    if ($token->check(Input::get('token'))) { // add gr
        if(Input::get('all_orders') === '1'){
            $allOrders = '"all_orders":1 ,';
        } else {
            $allOrders = '';
        }
        if(Input::get('addDv') === '1'){
            $addDv = '"addDv":1 ,';
        } else {
            $addDv = '';
        }
        if(Input::get('addCl') === '1'){
            $addCl = '"addCl":1 ,';
        } else {
            $addCl = '';
        }
        if(Input::get('servicePer') === '1'){
            $servicePer = '"servicePer":1 ,';
        } else {
            $servicePer = '';
        }
        if(Input::get('finalPer') === '1'){
            $finalPer = '"finalPer":1';
        } else {
            $finalPer = '';
        }
        
        if(Input::get('addGr') === '1'){
            $addGr = '"addGr":1';
        } else {
            $addGr = '';
        }
        
        try {
            $add->create(array(
                'name' => Input::get('nameGr'),
                'permissions' => '{'.$allOrders.' '.$addDv.' '.$addCl.' '.$servicePer.' '.$finalPer.'}'
                    ), 'groups');
            Redirect::to('admin.php');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
}

if (Input::get('dUser') === 'yes') {
    $add->find(Input::get('uId'), 'id', 'users');
    if ($add->data()->active === '1') {
        try {
            $add->update(array(
                'active' => '0'
                    ), Input::get('uId'), 'users');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    } else {
        echo '<h3>Този потребител не е активен!!!</h3>';
    }
}

if ($user->exists()) {
    if ($user->hasPermission('admin')) {
        ?>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel fixed_height_320">
                    <div class="x_title">
                        <h2>Групи</h2>
                        <ul class="nav navbar-right">
                            <li><button  data-toggle="modal" data-target="#addGr"><i class="fa fa-2x fa-plus"></i></button></li>
                            <div class="modal fade" id="addGr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Добавяне на група</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="" method="post">
                                                <div class="form-group">
                                                    <label>Име на групата</label>
                                                    <input type="text" name="nameGr" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Избери права</label>
                                                    <div class="checkbox">
                                                        <label><input class="checkbox-inline" type="checkbox" name="all_orders" value="1">  Всички поръчки (Начална страница) </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input class="checkbox-inline" type="checkbox" name="addDv" value="1">Добави устройство</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input class="checkbox-inline" type="checkbox" name="addGr" value="1">Добавяне на групи(GSM, GPS....)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input class="checkbox-inline" type="checkbox" name="addCl" value="1"> Добави клиент </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input class="checkbox-inline" type="checkbox" name="servicePer" value="1">Сервиз </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input class="checkbox-inline" type="checkbox" name="finalPer" value="1">Информация за ремонт (при сервизната страница)</label>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="form-group">
                                                <input type="hidden" name="addGr" value="add">
                                                <input type="hidden" name="token" value="<?php echo $token->generate(); ?>">
                                                <input type="submit" value="Добави">
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
                        $add->findAll('groups');
                        foreach ($add->data() as $groups) {
                            if ($groups->id !== '100') {
                                echo $groups->name . '<br>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>



            <div class="col-md-8 col-sm-10 col-xs-14">
                <div class="x_panel fixed_height_320">
                    <div class="x_title">
                        <h2>Потребители</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="userTable">
                        <table class="table table-striped responsive-utilities jambo_table ">
                            <thead class="table-hover">
                            <td>Име</td>
                            <td>П. име</td>
                            <td>Поща</td>
                            <td>Група</td>
                            <td>Опций</td>
                            </thead>
                            <tbody>
                                <?php
                                $add->findAll('users');
                                foreach ($add->data() as $shwo_user) {
                                    if ($shwo_user->groups !== '100') {
                                        echo '<tr>';
                                        echo '<td>';
                                        if ($shwo_user->active === '0') {
                                            echo '<i style="color: red;" data-toggle="tooltip" data-placement="top" title="Този потребител е неактивен" class="fa fa-exclamation-triangle"></i> ';
                                        }

                                        echo $shwo_user->name . ' ' . $shwo_user->last_name;
                                        echo '</td>';
                                        echo '<td>';
                                        echo $shwo_user->username;
                                        echo '</td>';
                                        echo '<td>';
                                        echo $shwo_user->email;
                                        echo '</td>';
                                        echo '<td>';
                                        $add->find($shwo_user->groups, 'id', 'groups');
                                        echo $add->data()->name;
                                        echo '</td>';
                                        echo '<td>';
                                        ?>
                                    <div class="col-sm-4">
                                        <a class="ed_user" data-toggle="modal" data-target="#edUser<?php echo $shwo_user->id; ?>"><i class="fa fa-edit"></i></a>
                                    </div>
                                    <div class="modal fade" id="edUser<?php echo $shwo_user->id; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Bla</h4>
                                                </div>
                                                <div class="modal-body">

                                                </div>
                                                <div class="modal-footer">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                            <?php
                                            if ($shwo_user->active === '1') {
                                                ?>
                                                <i data-uId="<?php echo $shwo_user->id; ?>" data-aCheck="<?php echo $shwo_user->active; ?>" class="fa fa-remove" id="dis_user"></i>
                                                <?php
                                            } else {
                                                ?>
                                                <i data-uId="<?php echo $shwo_user->id; ?>" data-aCheck="<?php echo $shwo_user->active; ?>" class="fa fa-plus" id="dis_user"></i>
                                                <?php
                                            }
                                            ?>
                                    </div>
                            <div class="show_result_admin"></div>
                                    <?php
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo 'Нямате права за тази страница';
    }
}

my_footer();
