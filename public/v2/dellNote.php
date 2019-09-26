<?php
require_once 'core/init.php';
checkUser();

$notes = new ADD();

$dellNote = $_POST['dellNote'];

echo $dellNote;

if(is_numeric($dellNote) !== NULL){
    try {
        $notes->dell('notes', 'id='.$dellNote);
    } catch (Exception $ex) {
        $ex->getMessage();
    }
}
