<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
include_once '../configs/ConfigWorkers.php';
include_once '../models/PUT.php';
include_once '../configs/ConfigAdmin.php';
$database = new AdminDatabase();
$db = $database->tryConnect();
$put = new PUT($db);

$data=json_decode(file_get_contents('php://input'));
$check=$put->VerifyToken($data->admlogin, $data->token);
$check2=$put->VerifyAdmin($data->admlogin);
if($check&&$check2){
    if($data->task=="reset_password"){
     $password= password_hash("muzeum", PASSWORD_DEFAULT);
$result =$put->resetUser($data->login, $password );   
if($result){
   echo "done"; 
}else{
    echo "no";
}

    }elseif($data->task=="upg_user"){
        $result =$put->UpgradeUser($data->login);   
        if($result){
           echo "done"; 
        }else{
            echo "no";
        }
    }elseif($data->task=="dwn_user"){
        $result =$put->DowngradeUser($data->login);   
        if($result){
           echo "done"; 
        }else{
            echo "no";
        }
    }elseif($data->task=="susp_user"){
        $result=$put->SuspUser($data->login);
        if($result){
            echo "done"; 
         }else{
             echo "no";
         }

    }elseif($data->task=="un_susp_user"){
        $result=$put->UnSuspUser($data->login);
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