<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With');

include_once '../configs/ConfigWorkers.php';
include_once '../models/GET.php';


$database = new WorkerDatabase();
$db = $database->tryConnect();
$get = new Get($db);

$headers = getallheaders();

if(isset($headers['Authorization'])){
  $tokenParts = explode(':',$headers['Authorization']);

$task= $_GET['task'];
if($get->VerifyToken($tokenParts[1],$tokenParts[0] )){
if ($task == 'getProjects') {
  $result = $get->GetProjects($tokenParts[1]);
  if ($result != null) {
   $database=null;
      echo json_encode($result);
    
    
  } else {
$database=null;
    echo json_encode($result); 
  }

} elseif ($task == 'getNonWorkers') {
	$Project = $_GET['Project'];

  if ($Project != null) {
    $result = $get->getNonWorkers($Project);
    if ($result != null) {
$database=null;
      echo json_encode($result);
    } else {
$database=null;
      echo 'no';
    }
  } else {
$database=null;
    echo 'no';
  }
}elseif ($task == 'getParametrs') {
  $Type=$_GET['type'];
  if($Type == 'object'){
  $Object=$_GET['id'];
  if ($Object != null) {
  $result = $get->getObjectsParametrs($Object);
  if ($result != null) {
    $database=null;
    extract($result);
    $resp=["ID"=>$ID,
    "TITLE"=>$TITLE,
    "TYPE"=>$TABLE,
    "PICTURE"=>[
      "LINK"=>$LINK,
      "ALT"=>$ALT,
    "Owner"=>$Owner,
    "ID_PICTURE"=>$ID_PICTURE,
    "NOTE"=>$PICTURE_NOTE
    ],
    "NOTE"=>$NOTE,
    "DESC"=>[
      "ID_DESC"=>$ID_DESC,
      "LNG1"=>$LNG1,
      "LNG2"=>$LNG2,
      "LNG3"=>$LNG3,
    ]
    
        ];
          echo json_encode($resp);
  } else {
$database=null;
    echo 'nie ma takiego obiektu';
    }
} else {
$database=null;
  echo 'nie podano obiektu';
}
  }elseif($Type == 'room'){
    $Room=$_GET['id'];
    if ($Room != null) {
    $result = $get->getRoomParametrs($Room);
    if ($result != null) {
$database=null;
extract($result);
$resp=["ID"=>$ID,
"TITLE"=>$TITLE,
"TYPE"=>$TABLE,
"PICTURE"=>[
  "LINK"=>$LINK,
  "ALT"=>$ALT,
"Owner"=>$Owner,
"ID_PICTURE"=>$ID_PICTURE,
"NOTE"=>$PICTURE_NOTE
],
"NOTE"=>$NOTE,
"DESC"=>[
  "ID_DESC"=>$ID_DESC,
  "LNG1"=>$LNG1,
  "LNG2"=>$LNG2,
  "LNG3"=>$LNG3,
]

    ];
      echo json_encode($resp);
    } else {
  $database=null;
      echo 'no';
    }
  } else {
  $database=null;
    echo 'no';
  }
  }
} elseif($task =='infoupdate'){

$result=$get->getUserDataForUpdate($tokenParts[1]);
if ($result != null) {
  extract($result);
$database=null;
  echo json_encode(["Name"=>$NAM, 'Surname'=>$SURNAME, 'login'=>$userNam, 'privilege'=>$Privlage]);
} else {

  echo 'no';
} 

}elseif($task =='projectData'){
  $Project = $_GET['Project'];
if($Project!=null){
$result=array();
$result["project"]=$get->GetProjectInfo($Project);
$result["creatorCheck"]=$get->CheckCreator($Project, $tokenParts[1]);
$result["objects"]=$get->getObjects($Project);
$result["workers"]=$get->GetWorkers($Project);
echo json_encode($result);
$database=null;
}else{
$database=null;
  echo "error";
}
}elseif($task == 'searchDesc'){
  $IfArc=$_GET['ifArc'];
  $element = $_GET['element'];
if($element!=null){
  $result=$get->DescSearch($element);
  if($IfArc==true){
    $result2=$get->DescSearchArc($element);
    $resultFin=array_merge($result, $result2);
$database=null;
    echo json_encode($resultFin);

  }else{
$database=null;
      echo json_encode($result);

  }

}else{
$database=null;
  echo "error";
}

}elseif($task == 'getPhotos'){
$answer=$get->getPhotos();
echo json_encode($answer);
}else {
  echo 'nie ma takiej funkcji';
}
}else{
  echo "Błąd w połączeniu";
}
}else{
  echo "error1";
}