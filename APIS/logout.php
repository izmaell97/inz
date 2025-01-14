<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
header('Access-Control-Allow-Methods: DELETE');
  include_once '../configs/Config.php';
  include_once '../models/DELETE.php';
  $database = new Database();
  $db = $database->tryConnect();

  $data=json_decode(file_get_contents('php://input'));
  $DELETE=new DELETE($db);
$result=$DELETE->logout($data->login, $data->token);
$database=null;

echo ($result);




 