<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');

include_once '../configs/ConfigVisitor.php';
include_once '../models/GET.php';

$database = new VisitorDatabase();
$db = $database->tryConnect();
$get=new GET($db);

$object=$_GET['Object'];

if (filter_var($object, FILTER_VALIDATE_INT)){
    $answer=$get->getObjectGuest($object);
    echo json_encode($answer);
}else{
    echo "error";
};
$database=null;
