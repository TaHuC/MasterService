<?php

require_once 'core/init.php';


checkUser();

$notes = new ADD();

$getNote = $_POST['getNote'];
$userNote = $_POST['userId'];

if (isset($getNote) && isset($userNote)) {
    try {
        $notes->create(array(
            'note' => $getNote,
            'dateTime' => date('Y-m-d H:i:s'),
            'userNote' => $userNote
                ), 'notes');
    } catch (Exception $ex) {
        die($ex->getMessage());
    }
}

echo 'ok';
