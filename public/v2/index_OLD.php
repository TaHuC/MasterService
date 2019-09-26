<?php
require_once 'core/init.php';

my_head('Начало');

my_menu();
$user = new User();
if ($user->isLoggedIn()) {
    $client = new Clients();
    $client->findLoop('4', 'status', 'orders');
    ?>
    <!-- top tiles -->
    <div class="row tile_count">
        <div class="clearfix"></div>
        <?php
        if ($user->hasPermission('admin') || $user->hasPermission('all_orders')) {
//        Zadachi
            $task = new Clients();
            ?>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <div class="x_panel" id="tasking">
                        <div class="col-md-10 col-lg-10 col-sm-10 pull-left">
                            <?php $task = new Clients(); ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#acttask" aria-controls="acttask" role="tab" data-toggle="tab"><i class="fa fa-tasks"></i> Акт. Задачи</a></li>
                                <li role="presentation"><a href="#oldTask" aria-controls="oldTask" role="tab" data-toggle="tab"><i class="fa fa-archive"></i> Приключени Зад.</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-2 pull-right">
                            <button class="btn btn-primary pull-right" data-toggle="modal" data-target=".task-sm-add"><i class="fa fa-plus"></i></button>
                        </div>
                        
                        <div class="modal fade task-sm-add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Задача</label>
                                            <textarea class="form-control" id="taskAdd" name="taskAdd"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>До</label>
                                            <select class="form-control" id="userIdTask" name="userId">
                                                <?php
                                                $taskUser = new ADD();
                                                $taskUser->findAll('users');
                                                foreach ($taskUser->data() as $userIdTask) {
                                                    if ($userIdTask->id === $user->data()->id) {
                                                        ?>
                                                        <option value="<?php echo $userIdTask->id; ?>" selected>Мен</option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $userIdTask->id; ?>" ><?php echo $userIdTask->name . ' ' . $userIdTask->last_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label></label>
                                            <button id="btnTask" class="btn btn-success pull-right"><i class="fa fa-plus"></i></button>
                                            <input type="hidden" id="fromUser" value="<?php echo $user->data()->id; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <br>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="acttask">
                                <div id="taskList">
                                    <?php
                                    $task->findAll('taskMenager WHERE userId = ' . $user->data()->id . ' AND active = 1');

                                    if ($task->data() !== NULL) {
                                        foreach ($task->data() as $userTask) {
                                            ?>
                                            <div id="task_<?php echo $userTask->id; ?>" class="list-group-item border-purple text-danger"><button onclick="taskClick(<?php echo $userTask->id; ?>)" class="close"><i class="fa fa-close"></i></button>
                                                <?php
                                                if ($userTask->fromUser !== '0') {
                                                    $task->find($userTask->fromUser, 'id', 'users');
                                                    echo '<strong>' . $task->data()->username . ':</strong> ';
                                                }
                                                echo $userTask->task;
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div role="tabpanel" class="tab-pane" id="oldTask">
                                <?php
                                    $task->findAll('taskMenager WHERE userId = ' . $user->data()->id . ' AND active = 0');

                                    if ($task->data() !== NULL) {
                                        foreach ($task->data() as $userTask) {
                                            ?>
                                            <div class="list-group-item border-dark text-muted">
                                                <?php
                                                if ($userTask->fromUser !== '0') {
                                                    $task->find($userTask->fromUser, 'id', 'users');
                                                    echo '<strong>' . $task->data()->username . ':</strong> ';
                                                }
                                                echo $userTask->task;
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="x_panel" id="tasking">
                        <div class="x_content" id="statusTab">
                            <div class="col-xs-9">
                                <!-- Tab panes -->
                                <div class="tab-content" >
                                    <?php
                                    $oldTime = date('Y-m-d', strtotime('-13 days'));
                                    $client->findAll('orders WHERE active = 1 AND timeOrder < "' . $oldTime . '" AND status <= 3');
                                    $delayedNum = $client->numres();
                                    ?>
                                    <div class="tab-pane active" id="delayed">

                                        <?php
                                        foreach ($client->data() as $value) {
                                            ?>
                                            <a href="device.php?order=<?php echo $value->id; ?>" class="btn btn-warning"><?php echo $value->id; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $client->findAll('orders WHERE status = 4');
                                    $successNum = $client->numres();
                                    ?>
                                    <div class="tab-pane" id="completed">
                                        <?php
                                        foreach ($client->data() as $success) {
                                            ?>
                                            <a href="device.php?order=<?php echo $success->id; ?>" class="btn btn-success"><?php echo $success->id; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="tab-pane" id="orders">
                                        Поръчки.
                                    </div>
                                    <?php
                                    if ($user->hasPermission('servicePer') || $user->hasPermission('admin')) {
                                        $client->findAll('orderTime WHERE userId =' . $user->data()->id);
                                        $testNum = 0;
                                        ?>
                                        <div class="tab-pane active" id="userOrder">
                                            <?php
                                            foreach ($client->data() as $value) {
                                                if ($value->startOrder !== '') {
                                                    $client->findOne($value->orderId, 'id', 'orders');
                                                    if ($client->data()->timeOrder <= $oldTime) {
                                                        if ($client->data()->status <= 3) {
                                                            $testNum++;
                                                            ?>
                                                            <a href="device.php?order=<?php echo $client->data()->id; ?>" class="btn btn-danger"><?php echo $client->data()->id; ?></a>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="col-xs-3 pull-right">
                                <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-right">
                                    <li class="active"><a href="#delayed" class="bg-orange" data-toggle="tab"><i class="fa fa-warning"></i><span class="badge right"><?php echo $delayedNum; ?></span></a>
                                    </li>
                                    <li><a href="#completed" class="bg-green" data-toggle="tab"><i class="fa fa-check-square-o"></i> <span class="badge right"><?php echo $successNum; ?></span></a>
                                    </li>
                                    <li><a href="#orders" class="bg-blue" data-toggle="tab"><i class="fa fa-shopping-bag"></i><span class="badge right">2</span></a>
                                    </li>
                                    <?php
                                    if ($user->hasPermission('servicePer') || $user->hasPermission('admin')) {
                                        ?>
                                        <li><a href="#userOrder" class="bg-red" data-toggle="tab"><i class="fa fa-user-md"></i><span class="badge right"><?php echo $testNum; ?></span></a>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>

                            <div class="clearfix"></div>

                        </div>
                    </div>
                </div>
            </div>

            <!--  porychki -->
            <div class="row ">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Поръчки <small>SisCom 2011 Ltd</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" id="thisTable" style="overflow-y: auto;">
                            <table id="example indexTable" class="table table-striped responsive-utilities jambo_table">
                                <thead>
                                    <tr class="headings">

                                        <th>№: </th>
                                        <th>Клиент </th>
                                        <th>Устройство </th>
                                        <th>Приет </th>
                                        <th>Дата </th>
                                        <th>Статус </th>
                                        <th class=" no-link last"><span class="nobr">Опций </span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $client->findAll('orders');
                                    if ($client->data() !== NULL) {
                                        $x = 0;
                                        foreach (array_reverse($client->data()) as $all) {
                                            $x++;
                                            ?>
                                            <tr id="<?php echo $x; ?>" class="even pointer">
                                                <td class=""><?php echo $all->id; ?></td>
                                                <td class=" ">
                                                    <?php
                                                    $client->find($all->clientId, 'id', 'clients');
                                                    echo '<a href="clients.php?cl=' . $client->data()->id . '">' . $client->data()->name . ' ' . $client->data()->last_name . '</a>';
                                                    ?> 
                                                </td>
                                                <td class=" ">
                                                    <?php
                                                    $client->find($all->brandId, 'id', 'brand');
                                                    $brand = $client->data()->brand;
                                                    $client->find($all->modelId, 'id', 'model');
                                                    echo $brand . ' ' . $client->data()->model;
                                                    ?> 
                                                </td>

                                                <td class=" ">
                                                    <?php
                                                    $client->find($all->userId, 'id', 'users');
                                                    echo $client->data()->name;
                                                    ?> 
                                                </td>

                                                <td class=" "><?php echo $all->timeOrder; ?></td>
                                                <td class=" " id="statusIndex">
                                                    <?php
                                                    $client->find($all->status, 'orderStatus', 'status');
                                                    echo $client->data()->name;
                                                    ?>
                                                </td>
                                                <td class="last"><a href="device.php?order=<?php echo $all->id; ?>">Отвори</a></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br />

            </div>

        </div>

        <?php
    }
}
my_footer();
?>
<!--                <video id=”video1” controls muted loop autoplay  preload=”auto” poster=”images/bg.jpg”>
                <source src="images/test.mp4" type="video/mp4">
            </video>-->


