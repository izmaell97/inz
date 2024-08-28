<?php

use function PHPSTORM_META\elementType;

class POST{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
      }
    
      public function UpdateLogginCount($login){
        $query= $this -> conn ->prepare('UPDATE workers SET num_of_wrong_login = num_of_wrong_login+1 where userNam =:login');
        $query ->execute(['login'=>$login]);
        $query2= $this -> conn ->prepare('UPDATE workers SET ISACTIVE= 0, SUSPDATE=sysdate() where num_of_wrong_login=3');
        $query2->execute();

    }
    public function   WriteArchive(){

    }
    public function UpdateDescrytpion(){

    }
    public function UpdatePicture() {
        
    }
    public function CreateNewUser($login, $nam, $surNam, $psswd, $isAdmin ){
   
$query1= $this->conn->prepare('SELECT * from workers where userNam=:login');
$query1->execute(['login'=>$login]);
$answer1 =$query1->fetchall(PDO::FETCH_ASSOC);
if(count($answer1)<1){ try{


     $query = $this->conn->prepare('INSERT INTO workers (NAM, SURNAME, userNam, PASSWORD_HASH, Privlage, ISACTIVE ) Values
        ( :nam, :surnam, :login, :psswd, :adm, true )');
        if($isAdmin==0){
        $query->execute(['nam'=>$nam, 'surnam'=>$surNam, 'login'=>$login, 'psswd'=>$psswd, 'adm'=>0]);
        }
        else{
          $query->execute(['nam'=>$nam, 'surnam'=>$surNam, 'login'=>$login, 'psswd'=>$psswd,'adm'=>1]);
          }
        return true;
      }catch(Exception $e){
          return false;
          }}else{
return false;
          }

  }
  public function CheckProject($ex_name) {
    $query=$this->conn->prepare('SELECT ID_PROJECTS FROM projects where EX_NAME=:nazwa');
    $query->execute(['nazwa'=>$ex_name]);
   $answer =$query->fetchall(PDO::FETCH_ASSOC);
   if(empty($answer)){
    return true;
    
   }else{
    return false;
   }
  }
  public function PostPhoto($link, $textalt,  $notes, $creator) {

    try{
    $query=$this->conn->prepare('INSERT INTO `picture`( `LINK`, `NOTE`, `ALT`, `Owner`) VALUES (:val1, :val2, :val3, :val4)');
    $query->execute(['val1'=>$link, 'val2'=>$textalt, 'val3'=>$notes, 'val4'=>$creator]);
    $newId = $this->conn->lastInsertId();
return $newId;
}catch(Exception $e){
return $e;
}
  }
  public function postDescryption($description1,  $description2, $description3) {

    try{
    $query=$this->conn->prepare('INSERT INTO descryption (LNG1, LNG2, LNG3) values (:lng1, :lng2, :lng3)');
    $query->execute(['lng1'=>$description1, 'lng2'=>$description2, 'lng3'=>$description3]);
    $newId = $this->conn->lastInsertId();
return $newId;}catch(Exception $e){
return false;
}
  }
  public function PostNewProjectNew($ex_name, $desc_id, $pic_id){
    try{
    $query4= $this->conn->prepare('INSERT INTO projects (EX_NAME, CURRENT,  CREATION_DATE, DESC_ID, ID_PIC ) VALUES (:ex_name, true, SYSDATE(), :descid, :picid)');
    $query4->execute(['ex_name'=>$ex_name,'descid'=>$desc_id,'picid'=>$pic_id]);
    $newId = $this->conn->lastInsertId();
    
    return $newId;
        }catch (Exception $e) {
      return false;
     
    }


  }
  public function Postkurator($userId, $projectId){
    try{
    $tworca="kurator";
    // dodaj relacje worker project
      $query6=$this->conn->prepare('INSERT INTO work_proj(ID_WORK, ID_PROJ, STANOWISKO) VALUES (:worker, :project, :tworca)');
    $query6->execute(['worker'=>$userId, 'project'=>$projectId,'tworca'=>$tworca]);
    return "added";
      }catch (Exception $e) {
    return false;
   }
  }

/*

public function PostNewProject($ex_name,  $notes, $userNumber, $description1,  $description2, $description3, $numberforusers ){
  //znajdź czy jest projekt
   $query=$this->conn->prepare('SELECT ID_PROJECTS FROM projects where EX_NAME=:nazwa');
   $query->execute(['nazwa'=>$ex_name]);
  $answer =$query->fetchall(PDO::FETCH_ASSOC);
  if(!$answer){
    //wstaw opis
    $query2=$this->conn->prepare('INSERT INTO descryption (LNG1, LNG2, LNG3) values (:lng1, :lng2, :lng3)');
$query2->execute(['lng1'=>$description1, 'lng2'=>$description2, 'lng3'=>$description3]);
//znajdź numer opisu
$query3=$this->conn->prepare('SELECT ID_DESC FROM descryption where LNG1=:desc order by ID_DESC DESC');
$query3->execute(["desc"=>$description1]);
$answer2 =$query3->fetch(PDO::FETCH_ASSOC);
//stwórz projekt
  $query4= $this->conn->prepare('INSERT INTO projects (EX_NAME, CURRENT, NOTES, CREATION_DATE,DESC_ID, APP_ID ) VALUES (:ex_name, true, :notatka, SYSDATE(), :id, :app_id)');
  $query4->execute(['ex_name'=>$ex_name,'notatka'=>$notes,'id'=>end($answer2), 'app_id'=>$numberforusers]);

  //znajdź numer projektu
  $query5=$this->conn->prepare('SELECT ID_PROJECTS FROM projects where DESC_ID=:desc');
  $query5->execute(['desc'=>end($answer2)]);
  $answer3=$query5->fetch(PDO::FETCH_ASSOC);
$tworca="kurator";
// dodaj relacje worker project
  $query6=$this->conn->prepare('INSERT INTO work_proj(ID_WORK, ID_PROJ, STANOWISKO) VALUES (:worker, :project, :tworca)');
$query6->execute(['worker'=>$userNumber, 'project'=>end($answer3),'tworca'=>$tworca]);
return "added";
  }
  else{
    return $answer;
  }


}
    */
public function PostNewRoom($title, $note, $id_proj, $id_pic, $id_desc){
  try{
    $query= $this->conn->prepare('INSERT INTO rooms(TITLE, NOTE, ID_PROJECT, ID_PIC, DESC_ID) VALUES (:title, :note, :ID_proj, :ID_pic, :ID_desc )');
    $query->execute(['title'=>$title, 'note'=>$note, 'ID_proj'=>$id_proj, 'ID_pic'=>$id_pic, 'ID_desc'=>$id_desc]);
    $newId = $this->conn->lastInsertId();

  return true;
   }catch (Exception $e) {
    return false;
   }


}
    public function PostNewItem($title, $note, $id_proj, $id_pic, $id_desc ){
     try{
      $query= $this->conn->prepare('INSERT INTO object(TITLE, NOTE, ID_PROJECT, ID_PIC, DESC_ID) VALUES (:title, :note, :ID_proj, :ID_pic, :ID_desc )');
      $query->execute(['title'=>$title, 'note'=>$note, 'ID_proj'=>$id_proj, 'ID_pic'=>$id_pic, 'ID_desc'=>$id_desc]);
      $newId = $this->conn->lastInsertId();

    return true;
     }catch (Exception $e) {
      return false;
     }
    }



    public function AddNewUser($UserId, $ownerId, $idProject){
      $query=$this->conn->prepare('SELECT ID_WORKERS FROM workers WHERE Privlage= 0 and ID_WORKERS= :userId');
      $query->execute(['userId'=>$ownerId]);
      $answer =$query->fetch(PDO::FETCH_ASSOC);
      $canAdd=false;
if($answer){
$canAdd=true;
}
$rola="kurator";
$query1=$this->conn->prepare('SELECT STANOWISKO FROM work_proj WHERE ID_WORK= :idWorker AND ID_PROJ = :idProj AND STANOWISKO= :tworca');
$query1->execute(['idWorker'=>$ownerId, 'idProj'=> $idProject, 'tworca'=> $rola]);
$answer1 =$query1->fetch(PDO::FETCH_ASSOC);
if(!is_null($answer1)){
  $canAdd=true;
  }
  if($canAdd){
$rola2="wykonawca";
 
  $query2=$this->conn->prepare('INSERT INTO work_proj(ID_WORK, ID_PROJ, STANOWISKO) VALUES (:userid, :projid, :wykonawca)');
    $query2->execute(['userid'=>$UserId, 'projid'=>$idProject, 'wykonawca'=>$rola2]);
    
}
return  $canAdd;

    }
    public function Loging($login, $password)
    {
        $query = $this->conn->prepare('SELECT ID_WORKERS, privlage, PASSWORD_HASH, num_of_wrong_login, ISACTIVE from workers where userNam = :userNam and ISACTIVE<>0');
        $query->execute(['userNam' => $login]);
        $answer = $query->fetch(PDO::FETCH_ASSOC);
        if($answer!=null){
        if (password_verify($password, $answer['PASSWORD_HASH'])&&  $answer["num_of_wrong_login"]<5) {
            return $answer;
        } else {
            return false;
        }}else{
          return "error";
        }
    }
    public function GenerateToken($id)
    {
      $query1 = $this->conn->prepare('SELECT COUNT(*) FROM tokens where User=:ID ');
      $query1->execute(['ID' => $id]);
      $answer = $query1->fetch(PDO::FETCH_ASSOC);

if($answer['COUNT(*)']<10){
  $token = bin2hex(random_bytes(32));
  $query = $this->conn->prepare('INSERT INTO tokens(Token, DATE_OF_CREATION, User) VALUES (:token, SYSDATE(), :userId)');
  $query->execute(['token' => $token, 'userId' => $id]);

  return $token;
}else{
  return "error";
}
        
    }
    public function VerifyToken($id, $token)
    {
        $query = $this->conn->prepare('SELECT Token FROM tokens WHERE User=:user');
        $query->execute(['user' => $id]);
       
        $answer = $query->fetchall(PDO::FETCH_ASSOC);
        $tokenExists = false;
foreach ($answer as $tokenData) {
    if ($tokenData["Token"] === $token) {
        $tokenExists = true;
        break; // Exit the loop once found
    }
}
        if ($tokenExists){
            return  true;
        } else {
            return  false;
        }
    }
 
    }