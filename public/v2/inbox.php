<?php
require_once 'core/init.php';

my_head('Съобщевия');

my_menu();

$user = new User();
$message = new Clients();
?>
<div class="row tile_count">
    <div class="col-lg-12 col-xs-12 col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#inMess" aria-controls="inMess" role="tab" data-toggle="tab" class="btn btn-app"><i class="fa fa-inbox"></i> Получени</a>
            </li>
            <li role="presentation"><a href="#outMess" aria-controls="outMess" role="tab" data-toggle="tab" class="btn btn-app"><i class="fa fa-send"></i> Изпратени</a>
            </li>
        </ul>

        <div class="clearfix"></div>
        <br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="inMess">
                <?php
                $message->find($user->data()->id, 'userId', 'inboxUser', 'id DESC');
                foreach ($message->search() as $showMes) {
                    $message->find($showMes->sendUser, 'id', 'users');
                    $userMes = $message->data();
                    ?>
                    <div class="panel panel-info" role="">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $userMes->name . ' ' . $userMes->last_name; ?><small class="pull-right"><?php echo $showMes->dateMess; ?></small></h4>
                        </div>
                        <div class="panel-body">
                            <p class="text-justify">
                                <?php echo $showMes->textMess; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="outMess">
                <?php
                $message->findAll('inboxUser WHERE userId =' . $user->data()->id . ' AND active = 0');
                foreach ($message->data() as $showMes) {
                    $message->findOne($showMes->sendUser, 'id', 'users');
                    $userMes = $message->data();
                    ?>
                    <div class="panel panel-default" role="">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $userMes->name . ' ' . $userMes->last_name; ?><small class="pull-right"><?php echo $showMes->dateMess; ?></small></h4>
                        </div>
                        <div class="panel-body">
                            <p class="text-justify">
                                <?php echo $showMes->textMess; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</div>
<?php
my_footer();
