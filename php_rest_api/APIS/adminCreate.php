<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');

include_once '../configs/ConfigAdmin.php';
include_once '../models/POST.php';

$database = new AdminDatabase();
$db = $database->tryConnect();
$post = new POST($db);
$data=json_decode(file_get_contents('php://input'));
$password= password_hash($data->psswd, PASSWORD_DEFAULT);
$result =$post->PostNewUser( $data->login, $data->nam, $data->surnam,$password);
echo $succes;