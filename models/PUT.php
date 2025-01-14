<?php

class PUT
{
  private $conn;
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function PutProject($id, $projectname)
  {
    try{
    $query = $this->conn->prepare('UPDATE projects SET EX_NAME=:project WHERE ID_PROJECTS=:ID;');
    $query->execute(['project' => $projectname, 'ID' => $id]);

    return true;
    }catch(Exception $e){
return false;
    }
  }
  public function PutPhoto($link, $note, $alt, $owner, $id)
  {
    try{
    $query = $this->conn->prepare('UPDATE picture SET  LINK=:link, NOTE=:note, ALT=:alt, Owner=:owner WHERE ID_PICTURE=:id');
    $query->execute(['link' => $link, 'note' => $note, 'alt'=> $alt, 'owner'=> $owner, 'id'=>$id]);

    return true;
    }catch(Exception $e){
return false;
    }
  }
  public function PutObject($id, $nam, $note )
  {
    
      $query = $this->conn->prepare('UPDATE object SET TITLE=:nam, NOTE=:note WHERE ID_OBJECT=:ID');
      $query->execute(['nam' => $nam, 'note'=>$note, 'ID' => $id]);
  
      return $id;
  
  }
  public function PutRoom($id, $nam, $note )
  {
    try{
      $query = $this->conn->prepare('UPDATE rooms SET TITLE=:oname, NOTE=:note WHERE ID_ROOMS=:ID;');
      $query->execute(['oname' => $nam, 'note'=>$note, 'ID' => $id]);
  
      return true;
      }catch(Exception $e){
  return false;
      }
  }
  public function PutDescription($id, $desc1, $desc2, $desc3 )
  {
    try{
      $query = $this->conn->prepare('UPDATE descryption SET LNG1=:lng1, LNG2=:lng2, LNG3=:lng3 WHERE ID_DESC=:ID;');
      $query->execute([ 'lng1' => $desc1, 'lng2' => $desc2, 'lng3' => $desc3, 'ID' => $id]);
  
      return true;
      }catch(Exception $e){
  return false;
     }
  }
  public function PutAdditionalWorkers($project, $login, $position)
  {
    $query = $this->conn->prepare('INSERT INTO work_proj (ID_PROJ, ID_WORK, STANOWISKO) VALUES (:idProject, :idLogin,  :position)');
    $query->execute(['ID_PROJ' => $project, 'idLogin' => $login, 'possition' => $position]);
  }
  public function VerifyAdmin($id)
  {

      $query1 = $this->conn->prepare('SELECT Privlage FROM workers WHERE ID_WORKERS=:id');
      $query1->execute(['id' => $id]);
      $answer = $query1->fetch(PDO::FETCH_ASSOC);
      if ($answer['Privlage'] == 0) {
          return true;
      } else {
          return false;
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

  public function PutUpdateUsers($id, $login, $nam, $surNam, $psswd)
  {
    if ($id != '') {
      $setingquery = 'UPDATE workers SET ';
      $parm['id'] = $id;
       
      if ($nam != '') {
        
        $setingquery = $setingquery . 'NAM= :nam, ';
        $parm['nam']= $nam;
      }
      if ($surNam != '') {
        $setingquery = $setingquery . 'SURNAME= :surnam, ';
        $parm['surnam'] = $surNam;
      }
      if ($psswd != '') {
        $setingquery = $setingquery . 'PASSWORD_HASH= :psswd, ';
        $parm['psswd'] = $psswd;
      }
      if ($login != '') {
        $setingquery = $setingquery . 'userNam= :login, ';
        $parm['login'] = $login;
      }
      
      if (sizeof($parm) > 1) {
       $setingquery= rtrim($setingquery, ", ");
      
        $setingquery = $setingquery . ' WHERE ID_WORKERS= :id;';
       // try{
        $query = $this->conn->prepare($setingquery);
        $query->execute($parm);
        return true;
        /* }catch (Exception $e) {
          return false;
         }
          */
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function deleteFromProject($idProj, $idWorker ){
    try{
      $query = $this->conn->prepare('DELETE FROM work_proj WHERE ID_WORK = :idWorker AND ID_PROJ = :idProj');
      $query->execute(['idProj' => $idProj, 'idWorker' => $idWorker]);
      return true;
 }catch (Exception $e) {
    return false;
   
  }

  }
  public function deleteRoom($id ){
    try{

    $query= $this -> conn ->prepare('DELETE FROM rooms where ID_ROOMS=:id');
    $query->execute(['id'=>$id]);
    return true;
  }catch (Exception $e) {
    return false;
   
  }

  }
  public function deleteItem($id ){
    try{

    $query= $this -> conn ->prepare('DELETE FROM object where ID_OBJECT=:id');
    $query->execute(['id'=>$id]);
  }catch (Exception $e) {
    return false;
   
  }

  }
  public function AddDescryption()
  {
  }
  public function SuspendProject($userID, $projID){
    $query= $this -> conn ->prepare('SELECT STANOWISKO FROM `work_proj` WHERE `ID_PROJ` = :idProjektu AND `ID_WORK` = :idPrac');
    $query ->execute(['idProjektu'=>$projID, 'idPrac'=>$userID]);
    $answer =$query->fetch(PDO::FETCH_ASSOC);
    
if(!empty($answer)&&$answer['STANOWISKO']=="kurator"){
  $query2= $this -> conn ->prepare('UPDATE projects SET CURRENT =false, susp_date= CURDATE()  WHERE ID_PROJECTS=:idProjektu');
  $query2 ->execute(['idProjektu'=>$projID]);

return 'DONE';
}else{
  $query4= $this -> conn ->prepare('SELECT `Privlage` FROM `workers` where ID_WORKERS=:id');
    $query4 ->execute(['id'=>$userID]);
    $answer2 =$query4->fetch(PDO::FETCH_ASSOC);
    $query5= $this -> conn ->prepare('SELECT * FROM projects where ID_PROJECTS=:id');
    $query5 ->execute(['id'=>$projID]);
    $answer3 =$query5->fetch(PDO::FETCH_ASSOC);



if(!$answer2['Privlage']&& !empty($answer3)){

  $query2= $this -> conn ->prepare('UPDATE projects SET CURRENT =false, susp_date= CURDATE()  WHERE ID_PROJECTS=:idProjektu');
  $query2 ->execute(['idProjektu'=>$projID]);
}

  }
  }

  public function PasswordDone($id){
    try{
    $query= $this -> conn ->prepare('UPDATE workers SET ISACTIVE=1, num_of_wrong_login=0  where ID_WORKERS=:id');
    $query ->execute(['id'=>$id]);
    return true;
    }catch (Exception $e) {
      return false;
     }

  }
  public function UnSuspendProject($userID, $projID){
   
  $query= $this -> conn ->prepare('SELECT `Privlage` FROM `workers` where ID_WORKERS=:id');
    $query ->execute(['id'=>$userID]);
    $answer2 =$query->fetch(PDO::FETCH_ASSOC);
    $query5= $this -> conn ->prepare('SELECT * FROM projects where ID_PROJECTS=:id');
    $query5 ->execute(['id'=>$projID]);
    $answer3 =$query5->fetch(PDO::FETCH_ASSOC);



if(!$answer2['Privlage']&& !empty($answer3)){

  $query2= $this -> conn ->prepare('UPDATE projects SET CURRENT =true, susp_date= null  WHERE ID_PROJECTS=:idProjektu');
  $query2 ->execute(['idProjektu'=>$projID]);
  return "problem";
}else{
  return ($answer2['Privlage']);
}

  }
  public function resetUser($ID, $password){
    try{
    $query = $this->conn->prepare('UPDATE workers SET PASSWORD_HASH=:psswd,ISACTIVE=3,SUSPDATE=null,num_of_wrong_login=0 WHERE ID_WORKERS=:id');
    $query ->execute(['psswd'=>$password, 'id'=>$ID]);
    return true;
  }catch (Exception $e) {
    return false;
   }
    
  }
  public function UpgradeUser($ID){
    try{
    $query = $this->conn->prepare('UPDATE workers SET Privlage=0 WHERE ID_WORKERS=:id');
    $query ->execute(['id'=>$ID]);
    return true;
  }catch (Exception $e) {
    return false;
   }
    
  }
  public function DowngradeUser($ID){
    try{
    $query = $this->conn->prepare('UPDATE workers SET Privlage=1 WHERE ID_WORKERS=:id');
    $query ->execute(['id'=>$ID]);
    return true;
  }catch (Exception $e) {
    return false;
   }
    
  }
  public function SuspUser($ID){
    try{
      $query = $this->conn->prepare('UPDATE workers SET ISACTIVE =0, SUSPDATE=CURDATE() WHERE ID_WORKERS=:id');
      $query ->execute(['id'=>$ID]);
      return true;
    }catch (Exception $e) {
      return false;
     }
  }
  public function UnSuspUser($ID){
    try{
      $query = $this->conn->prepare('UPDATE workers SET ISACTIVE =3, SUSPDATE=null,num_of_wrong_login=0  WHERE ID_WORKERS=:id');
      $query ->execute(['id'=>$ID]);
      return true;
    }catch (Exception $e) {
      return false;
     }
  }
  
}
