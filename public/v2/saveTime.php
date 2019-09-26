<?php
require_once 'core/init.php';

if (Input::exists()) {
    // proverka za potrebitel
    if (!$user->isLoggedIn() && $user->hasPermission('standart')) {
        ?>
        <script type="text/javascript">
            $(function () {
                $(location).attr('href', 'index.php');
            });
        </script>
        <?php
    }

    $saveTime = new ADD();
} else {
    $user = new User();
    // proverka za potrebitel
    if (!$user->isLoggedIn() && $user->hasPermission('standart')) {
        ?>
        <script type="text/javascript">
            $(function () {
                $(location).attr('href', 'index.php');
            });
        </script>
        <?php
    }


    $saveTime = new ADD();
    $x = 0;
    $saveTime->findAll('saveHour');
    if ($saveTime->data() !== NULL) {


        foreach ($saveTime->data() as $timeNow) {
            if ($timeNow->dateEnd === date('Y-m-d')) {
                ?>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <?php
                            $saveTime->findOne($timeNow->clientId, 'id', 'clients');
                            echo $saveTime->data()->name . ' ' . $saveTime->data()->last_name;
                            ?>
                            <small class="pull-right"><?php echo $timeNow->timeEnd; ?>ч / Днес</small></h5>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo '<span>Тел: ' . $saveTime->data()->phone . '</span>';
                        echo '<p>' . $timeNow->info . '</p>';
                        ?>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="clients.php?cl=<?php echo $timeNow->clientId; ?>"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
                <?php
                $x++;
            } else if ($timeNow->dateEnd === date('Y-m-d', strtotime('+1 day'))) {
                ?>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <?php
                            $saveTime->findOne($timeNow->clientId, 'id', 'clients');
                            echo $saveTime->data()->name . ' ' . $saveTime->data()->last_name;
                            ?>
                            <small class="pull-right"><?php echo $timeNow->timeEnd; ?>ч / <?php echo $timeNow->dateEnd; ?></small></h5>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo '<span>Тел: ' . $saveTime->data()->phone . '</span>';
                        echo '<p>' . $timeNow->info . '</p>';
                        ?>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="clients.php?cl=<?php echo $timeNow->clientId; ?>"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
                <?php
                $x++;
            } else if ($timeNow->dateEnd < date('Y-m-d') && $timeNow->active !== '0') {
                $saveTime->update(array(
                    'active' => '0'
                        ), $timeNow->id, 'saveHour');
            }
        }
    }

    if ($x === 0) {
        echo '<li>';
        echo '<span class="title">Няма записани часове</span>';
        echo '</li>';
    }
    ?>

    <li>
        <a href="saveTimeLs.php" class="btn">
            Виж всички
        </a>
    </li>

    <?php
}