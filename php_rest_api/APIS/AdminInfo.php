<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');

include_once '../configs/ConfigAdmin.php';
include_once '../models/GET.php';

$database = new AdminDatabase();
$db = $database->tryConnect();
$get=new GET($db);
$headers = getallheaders();

if(isset($headers['Authorization'])){
  $tokenParts = explode(':',$headers['Authorization']);

if($get->VerifyToken($tokenParts[1],$tokenParts[0] )){


if($get->VerifyAdmin($tokenParts[1])){
    $task =$_GET['task'];
if($task == "get_users"){
$answer=$get->getUserAdmin($tokenParts[1]);
$database=null;
if($answer){
echo json_encode($answer);
}else{
    echo "no1";
}
}elseif($task == "getDescryptions"){
    $answer=$get->getDescAdmin();
$database=null;
    echo json_encode($answer);  

}
else{
    echo 'nie ma takiej funkcji';

}
}
else{
    echo "no";
}

}else{
echo "no";
}
}else{
    echo "no";
}

