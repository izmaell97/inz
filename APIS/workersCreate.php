<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
include_once '../configs/ConfigWorkers.php';
include_once '../models/POST.php';
$database = new WorkerDatabase();
$db = $database->tryConnect();
$post = new POST($db);
$data = json_decode(file_get_contents('php://input'));

$isVerified = $post->VerifyToken($data->user, $data->token);
if ($isVerified) {

    if ($data->type == 'post_project') {
        $result = $post->CheckProject($data->name);
        if ($result) {
            $descid = $post->PostDescryption($data->description->lng1, $data->description->lng2, $data->description->lng3);
            if (is_numeric($descid)) {
                if (!isset($data->photo->id)) {


                    $picid = $post->PostPhoto($data->photo->link, $data->photo->textalt, $data->photo->notes, $data->photo->creator);
                } else {
                    $picid = $data->photo->id;
                }
                if (is_numeric($picid)) {
                    $projid = $post->PostNewProjectNew($data->name, $descid, $picid);
                    if (is_numeric($projid)) {
                        $answer = $post->Postkurator($data->user, $projid);
                        echo $projid;
                    } else {
                        echo "no";
                    }
                } else {
                    echo "no";
                }
            }
        } else {
            echo "no";
        }
    }elseif($data->type == 'post_object_room'){
        if($data->typeof=="room"|| $data->typeof=="object"){
        $descid = $post->PostDescryption($data->description->lng1, $data->description->lng2, $data->description->lng3);


        if (is_numeric($descid)) {


                $picid = $post->PostPhoto($data->photo->link, $data->photo->textalt, $data->photo->notes, $data->photo->creator);
           
            if (is_numeric($picid)) {
              if( $data->typeof=="room"){
                $answerfinal=$post->PostNewItem($data->title, $data->note, $data->projid, $picid, $descid);
                if($answerfinal){
                    echo "done";
                }else{
                    echo "no1";
                }
              
              }elseif($data->typeof=="object"){
                $answerfinal=$post->PostNewItem($data->title, $data->note, $data->projid, $picid, $descid);
                if($answerfinal){
                    echo "done";
                }else{
                    echo "no1";
                }
              }
            } else {
                echo "no2";
            }
        }else {
            echo "no3";
        }}else{
            echo  "no";
        }
        

    }elseif($data->type == 'post_user'){
        $answer=$post->AddNewUser($data->newUser, $data->user, $data->project);
if($answer){
    echo "done";
}else{
    echo "no";
}
    }
} else {
    echo "no2";
}




/*
if($data->type='project'){
$result=$post->PostNewProject($data->name, $data->notes, $data->userId, $data->description->lng1, $data->description->lng2, $data->description->lng3, $data->appId);
}elseif($data->type='room'){
    $result=$post->PostNewRoom($data->name,$data->id_proj,$data->appId, $data->description->lng1, $data->description->lng2, $data->description->lng3);
}elseif($data->type='item'){
 $result=$post->PostNewItem($data->name,$data->id_proj,$data->appId,$data->owner, $data->description->lng1, $data->description->lng2, $data->description->lng3);
}else{
    $result='error';
}
echo json_encode($result);
*/