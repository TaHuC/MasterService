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
    
    $saveTime->findAll('saveHour');
    $x = 0;
    foreach ($saveTime->data() as $timeNow){
        if($timeNow->dateEnd === date('Y-m-d', strtotime('+1 day'))){
            $x++;
        } else if($timeNow->dateEnd === date('Y-m-d')) {
            $x++;
        }
    }
    echo $x;
    
}