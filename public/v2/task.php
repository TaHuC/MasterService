<?php

require_once 'core/init.php';
checkUser();

$task = new ADD();


if (Input::get('fromUser') !== NULL) {
    $fromUser = Input::get('fromUser');
    $userId = Input::get('userId');
    $getTask = trim(Input::get('task'));
    if (Input::get('task') !== NULL) {
        try {
            $task->create(array(
                'task' => $getTask,
                'userId' => $userId,
                'fromUser' => $fromUser
                    ), 'taskMenager');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
} else {
    if (Input::get('task') !== NULL) {
        $userId = Input::get('userId');
        $getTask = trim(Input::get('task'));
        try {
            $task->create(array(
                'task' => $getTask,
                'userId' => $userId
                    ), 'taskMenager');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
}

if ($getTask !== NULL) {
    $task->find($getTask, 'task', 'taskMenager');
    echo $task->data()->id;
}

if (Input::get('taskId') !== NULL) {
    try {
        $task->update(array(
            'active' => 0
        ), Input::get('taskId'), 'taskMenager');
    } catch (Exception $ex) {
        die($ex->getMessage());
    }
}