<?php
require_once 'core/init.php';
checkUser();
$user = new User();

$task = new Clients();
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