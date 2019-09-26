<?php

require_once 'core/init.php';

$user = new User();

$message = new ADD();

$message->find($user->data()->id, 'userId', 'inboxUser', 'id DESC');
if($message->numres() !== NULL){
  $x = 0;

foreach ($message->search() as $numMes) {
    if ($numMes->active !== '0') {
       $x++;
    }
}

echo $x;  
} else {
    echo '0';
}



