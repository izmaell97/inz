<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
include_once '../configs/ConfigWorkers.php';
include_once '../models/PUT.php';
$database = new WorkerDatabase();
$db = $database->tryConnect();
$put = new Put($db);
$data=json_decode(file_get_contents('php://input'));

$password= password_hash($data->psswd, PASSWORD_DEFAULT);
$result =$put->PutUpdateUsers($data->id, $data->login, $data->nam, $data->surnam,$password);

echo $result;
