<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../configs/ConfigWorkers.php';
include_once '../models/GET.php';


$database = new WorkerDatabase();
$db = $database->tryConnect();
$get = new Get($db);
$login = $_GET(['login']);
$task = $_GET(['task']);

if ($task == 'getProjects') {
  $result = $get->GetProjects($login);
  if ($result != null) {
    echo json_encode($result);
  } else {

    echo 'no';
  }
} elseif ($task == 'getWorkers') {
  $Project = $_GET(['Project']);
  if ($Project != null) {
    $result = $get->getWorkers($login, $Project);
    if ($result != null) {
      echo json_encode($result);
    } else {

      echo 'no';
    }
  } else {

    echo 'no';
  }
} elseif ($task == 'getNonWorkers') {
  $Project = $_GET(['Project']);
  if ($Project != null) {
    $result = $get->getNonWorkers($Project);
    if ($result != null) {
      echo json_encode($result);
    } else {

      echo 'no';
    }
  } else {

    echo 'no';
  }
} elseif ($task == 'getObjects') {
  $Project = $_GET(['Project']);
  if ($Project != null) {
  $result = $get->getObjects($Project);
  if ($result != null) {
    echo json_encode($result);
  } else {

    echo 'no';
  }
} else {

  echo 'no';
}

}elseif ($task == 'getObjectsParametrs') {
  $object=$_GET(['Object']);
  if ($Object != null) {
  $result = $get->getObjectsParametrs($Object);
  if ($result != null) {
    echo json_encode($result);
  } else {

    echo 'no';
  }
} else {

  echo 'no';
}
} else {
  echo 'nie ma takiej funkcji';
}
