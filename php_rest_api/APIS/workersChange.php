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
$isVerified=$put->VerifyToken($data->user, $data->token);
if($isVerified){
    if($data->task=="deleteProject"){
$answer=$put->SuspendProject($data->user, $data->project   );
$db=null;
echo "worked";

    }elseif($data->task=="undelProject"){
        $answer=$put->UnSuspendProject($data->user, $data->project   );
        $db=null;
        if($answer){
          echo "worked";  
        }else{
        echo "no6";
    }
  
    
}elseif($data->task=="update_project"){
    $result= ["title"=> false, "desc"=>false, "pic"=>false ];
      
        if(isset($data->desc)){
            if($put->PutDescription($data->desc->ID_DESC, $data->desc->LNG1, $data->desc->LNG2, $data->desc->LNG3 )){

            $result["desc"]=true;
            }
        }
        if(isset($data->pic)){
            if($put->PutPhoto($data->pic->LINK, $data->pic->PICTURE_NOTE, $data->pic->ALT ,$data->pic->Owner,$data->pic->ID_PICTURE)){
               $result["pic"]=true; 
            }
        }
  if(isset($data->project)){
   if($put->PutProject($data->project->id, $data->project->title)){
    $result["title"]=true;
   }
        }
        $answer=0;
        foreach ($result as $key => $value) {
            if ($data->edit->$key === $value) {
$answer=$answer+1;
            } 
        }
        if($answer==3){
            echo "done";
        }else{
            echo json_encode($result);
        }
    
}elseif($data->task=="update_object_or_room"){
    $result= ["title"=> false, "desc"=>false, "pic"=>false ];
      
        if(isset($data->desc)){
            if($put->PutDescription($data->desc->ID_DESC, $data->desc->LNG1, $data->desc->LNG2, $data->desc->LNG3 )){

            $result["desc"]=true;
            }
        }
        if(isset($data->pic)){
            if($put->PutPhoto($data->photo->LINK, $data->pic->PICTURE_NOTE, $data->pic->ALT,$data->pic->Owner,$data->pic->ID_PICTURE)){
               $result["pic"]=true; 
            }
        }
  if(isset($data->project)){
    if($data->project->type=="room"){
   if($put->PutRoom($data->project->ID, $data->project->TITLE, $data->project->NOTE)){
    $result["title"]=true;
   }
   }elseif($data->project->type=="object"){
  if( $put->PutObject($data->project->ID, $data->project->TITLE, $data->project->NOTE)){
    $result["title"]=true;
  }
        
    
   }
        }
        $answer=0;
        foreach ($result as $key => $value) {
            if ($data->edit->$key === $value) {
$answer=$answer+1;
            } 
        }
        if($answer==3){
            echo "done";
        }else{
            echo "no";
        }
}elseif($data->task=="update_user_data"){
if($data->psswd!=""){
    $password= password_hash($data->psswd, PASSWORD_DEFAULT);

}else{
    $password="";
}

    $result=$put->PutUpdateUsers($data->user,$data->usernam,$data->nam, $data->surname, $password);
    $db=null;

    if($result){
        if($data->psswd!="")
        $result=$put->PasswordDone($data->user);
    if($result){
        echo "done";

    }else{
        echo "no2";
    }
        
    }
    else{
        echo "no3";
    }
}else{
    echo "no7";
}
}else{
    echo"no8";
}