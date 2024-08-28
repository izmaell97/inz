<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../configs/ConfigAdmin.php';
include_once '../models/DELETE.php';

$database = new AdminDatabase();
$db = $database->tryConnect();
$delete = new DELETE($db);
$data=json_decode(file_get_contents('php://input'));
$check=$delete->VerifyToken($data->admlogin, $data->token);
$check2=$delete->VerifyAdmin($data->admlogin);
if($check&&$check2){
$result=$delete->deleteDesc($data->id);
if($result){
    echo "done";
}else{
    echo "no";
}
}else{
    echo json_encode($data);
}
