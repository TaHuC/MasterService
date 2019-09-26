<?php

require_once 'core/init.php';
checkUser();

$task = new ADD();
$userId = Input::get('userId');
$getTask = trim(Input::get('task'));
if (Input::get('task') !== NULL) {
    try {
        $task->create(array(
            'task' => $getTask,
            'userId' => $userId
                ), 'taskMenager');
    } catch (Exception $ex) {
        die($ex->getMessage());
    }
}