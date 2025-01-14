
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
$data=json_decode(file_get_contents('php://input'));

$result =$post->AddNewUser($data->userID, $data->OwnerId, $data->IdProj);

echo $result;
