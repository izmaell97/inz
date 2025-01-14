  <?php

class DELETE{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
      }
    
   
    
    public function deleteDesc($idDesc  ){
      try{

      $query= $this -> conn ->prepare('DELETE FROM descryption where ID_DESC=:id');
      $query->execute(['id'=>$idDesc]);
      return true;
    }catch (Exception $e) {
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
            return true;
        } else {
            return false;
        }
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
    /*
public function AdminRemoweProject( $projID ){    
$query2= $this -> conn ->prepare(' SELECT  SET ID_PROJECT =0 WHERE ID_PROJECT= :idProjektu');
$query2 ->execute(['idProjektu'=>$projID]);
$query5=$this->conn->prepare('INSERT INTO archiv (DESC1, DESC2, DESC3) SELECT LNG1, LNG2, LNG3 from descryption where ID_DESC in (SELECT DESC_ID from projects where ID_PROJECTS=:idProjektu)');
$query5->execute(['idProjektu'=>$projID]);
$query6=$this->conn->prepare('INSERT INTO archiv (DESC1, DESC2, DESC3) SELECT LNG1, LNG2, LNG3 from descryption where ID_DESC in (SELECT DESC_ID from rooms where ID_WYSTAWY=:idProjektu)');
$query6->execute(['idProjektu'=>$projID]);
$query7=$this->conn->prepare('INSERT INTO archiv (DESC1, DESC2, DESC3) SELECT LNG1, LNG2, LNG3 from descryption where ID_DESC in (SELECT DESC_ID from object where ID_PROJECT=:idProjektu)');
$query7->execute(['idProjektu'=>$projID]);
$query3= $this -> conn ->prepare(' DELETE FROM rooms WHERE ID_WYSTAWY= :idProjektu');
$query3 ->execute(['idProjektu'=>$projID]);
$query4=$this -> conn ->prepare(' DELETE FROM work_proj where  `ID_PROJ` = :idProjektu');
$query4 ->execute(['idProjektu'=>$projID]);
$query4=$this -> conn ->prepare(' DELETE FROM projects where  `ID_PROJ ECTS` = :idProjektu');
$query4 ->execute(['idProjektu'=>$projID]);
$query8=$this -> conn ->prepare('DELETE FROM descryption WHERE ID_DESC in (SELECT DESC_ID from projects where ID_PROJECTS=:idProjektu)');
$query8 ->execute(['idProjektu'=>$projID]);
$query9=$this -> conn ->prepare('DELETE FROM descryption WHERE ID_DESC in (SELECT DESC_ID from rooms where ID_WYSTAWY=:idProjektu)');
$query9 ->execute(['idProjektu'=>$projID]);
$query10=$this -> conn ->prepare('DELETE FROM descryption WHERE ID_DESC in (SELECT DESC_ID from object where ID_PROJECT=:idProjektu)');
$query10 ->execute(['idProjektu'=>$projID]);
}
*/
 public function logout($userID, $token, ){
  $query= $this->conn->prepare('SELECT TokenID FROM tokens WHERE User=:ID and Token=:token  ');
  $query ->execute(['ID'=>$userID, 'token'=>$token]);
  $answer=$query->fetch(PDO::FETCH_ASSOC);
if($answer!=null){
  $query2= $this->conn->prepare('DELETE FROM tokens WHERE TokenID=:token  ');
  $query2 ->execute(['token'=>$answer['TokenID']]);

  return true;
}else{
  return false;
}
 }


    
    }