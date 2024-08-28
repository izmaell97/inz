<?php
// Headers
header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');
include_once '../models/PUT.php';
include_once '../configs/ConfigWorkers.php';
$contentType = getallheaders()["Content-Type"];

$headers = getallheaders();
if(isset($headers['Authorization'])){
    $tokenParts = explode(':',$headers['Authorization']);
    $database = new WorkerDatabase();
$db = $database->tryConnect();
$put = new Put($db);
$answer=$put->VerifyToken($tokenParts[1],$tokenParts[0] );
if($answer){

$uploaddir = '../../pictures/'; 

$uploadfile = $uploaddir . basename($_FILES['nazwa']['name']);
if(file_exists($uploadfile)){
    echo "this file already exist ";
}else{ 
    $filename = $_FILES['nazwa']['name'];
$extension = pathinfo($filename, PATHINFO_EXTENSION);
if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
    // Valid image file (JPEG or PNG)

    if (move_uploaded_file($_FILES['nazwa']['tmp_name'], $uploadfile)) {
    // Return the image URL (you can customize this based on your server setup)
    echo "/pictures/" . basename($_FILES['nazwa']['name']);
} else {
    echo "Upload failed.";
}}else{
    echo "wrong file";
}
}}else echo "verification failed";
}else echo "verification failed";
