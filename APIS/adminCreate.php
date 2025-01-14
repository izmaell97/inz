<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');

include_once '../configs/ConfigAdmin.php';
include_once '../models/POST.php';
include_once '../models/GET.php';

$database = new AdminDatabase();
$db = $database->tryConnect();
$post = new POST($db);
$get=new GET($db);

$data=json_decode(file_get_contents('php://input'));
$check=$get->VerifyToken($data->admlogin, $data->token);
$check2=$get->VerifyAdmin($data->admlogin);
if($check&&$check2){
    if($data->task=="create_user"){
     $password= password_hash("muzeum", PASSWORD_DEFAULT);
$result =$post->CreateNewUser($data->login, $data->nam, $data->surnam, $password, $data->isAdmin);   
if($result){
   echo "done"; 
}else{
    echo "no";
}

    }else{
        echo "no";
    }

}else{
    echo "no";
}
