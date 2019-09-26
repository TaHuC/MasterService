<?php
require_once 'core/init.php';
checkUser();

$user = new User();

$task = new Clients();
$task->findAll('taskMenager WHERE userId = ' . $user->data()->id . ' AND active = 1');

if($task->numres() !== NULL){
    echo $task->numres();
} else {
    echo '0';
}
