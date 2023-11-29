<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../configs/Config.php';
  include_once '../models/GET.php';
  include_once'../models/POST.php';
  $database = new Database();
  $db = $database->tryConnect();
  $get = new GET($db);
  $update=new POST($db);
  $login =$_GET['login'];
  $psswd= $_GET['psswd'];
  $result =$get->GetLoging($login, $psswd);
if( $result !=null){
echo json_encode($result);
} else {
    $update->UpdateLogginCount($login);
    echo 'no' ;
}
