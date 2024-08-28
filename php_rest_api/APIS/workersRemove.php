<?php
// Headers
header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers:Access-Control-Allow-Methods, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
include_once '../configs/ConfigWorkers.php';
include_once '../models/PUT.php';

$database = new WorkerDatabase();
$db = $database->tryConnect();
$PUT = new PUT($db);
$data=json_decode(file_get_contents('php://input'));
$isVerified=$PUT->VerifyToken($data->user, $data->token);
if($isVerified){
if($data->task=="deleteProject"){
   if( $result=$PUT->SuspendProject($data->user, $data->project)){
    echo "done";
   }
else{
echo "no";
}
}elseif($data->task=="deleteWorker"){
    $result=$PUT->deleteFromProject($data->project, $data->idu);
    if($result ){
        echo "done";
       }
    else{
    echo "no";
    } 
}elseif($data->task=="delete_item_or_project"){
    if($data->type=="room"){
        if( $result=$PUT->deleteRoom($data->id)){
        echo "done";
       }
    else{
    echo "no";
    }  
    }else{
        if( $result=$PUT->deleteItem($data->id)){
            echo "done";
           }
        else{
        echo "no";
        } 
    }
   
}




}