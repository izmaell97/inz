<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
header('Access-Control-Allow-Methods: POST');
  include_once '../configs/Config.php';
  include_once '../models/POST.php';
  $database = new Database();
  $db = $database->tryConnect();


  $data=json_decode(file_get_contents('php://input'));
  $post=new POST($db);
 
  $result =$post->Loging($data->login, $data->psswd);
if( $result !=false&&$result!="error"){
extract($result);
$token=$post->GenerateToken($ID_WORKERS);

if($token!="error"){

$array=[
  'Id'=> $ID_WORKERS,
  'forerror'=>$ISACTIVE,
  'privilege'=> $privlage,
  'token'=>$token
];
$database=null;
echo json_encode($array);
}else{
  $post->UpdateLogginCount($data->login);

  echo $token;
}
} else {
  if($result!="error"){
    $post->UpdateLogginCount($data->login);
    echo $result;

  }else{

    echo "error";

  }
}
