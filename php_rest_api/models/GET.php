<?php

class GET{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
      }
  
    public function GetLoging($login, $password){
        $query= $this -> conn ->prepare('SELECT ID_WORKERS, privlage, PASSWORD_HASH from workers where userNam = :userNam');
        $query ->execute(['userNam'=>$login]);
        $answer =$query->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $answer['PASSWORD_HASH'])){
        return $answer; }
        else{ 
            return 'error';
        }
    }
    public function GetProjects($login){
        $query= $this -> conn ->prepare('SELECT  PROJECTS.EX_NAME, PROJECTS.CREATION_DATE, DESCRYPTION.LNG1 FROM WORK_PROJ LEFT JOIN PROJECTS ON WORK_PROJ.ID_PROJ=PROJECTS.ID_PROJECTS LEFT JOIN DESCRYPTION ON PROJECTS.DESC_ID= DESCRYPTION.ID_DESC WHERE WORK_PROJ.ID_WORK= :ID AND PROJECTS.CURRENT=1');
        $query ->execute(['userNam'=>$login]);
        $answer =$query->fetch(PDO::FETCH_ASSOC);
        return $answer; 
    }  
    public function GetWorkers($Project){
        $query= $this -> conn ->prepare('SELECT WORKERS.NAM, WORKERS.FIRST_NAM FROM WORK_PROJ LEFT JOIN WORKERS ON WORK_PROJ.ID_WORK=WORKERS.ID_WORKERS WHERE WORK_PROJ.ID_PROJ =:PROJEKT');
        $query ->execute(['PROJEKT'=>$Project]);
        $answer =$query->fetch(PDO::FETCH_ASSOC);
        return $answer; 
    } 
    public function getNonWorkers($Project){
        $query= $this -> conn ->prepare('SELECT WORKERS.ID_WORKERS, WORKERS.NAM, WORKERS.FIRST_NAM from workers where ID_WORKERS not in (SELECT ID_WORK from work_proj where id_proj =:PROJEKT)');
        $query ->execute(['PROJEKT'=>$Project]);
        $answer =$query->fetch(PDO::FETCH_ASSOC);
        return $answer; 
        
    }
    public function getObjects($Project){
        $query= $this -> conn ->prepare('select Z1.id, Z1.nazwa, PICTURE.LINK FROM (SELECT * from(select TITLE AS nazwa, ID_OBJECT AS ID, ID_PIC AS PIC FROM OBJECT WHERE ID_PROJECT =:ID UNION SELECT TITLE AS nazwa,  ID_ROOMS, PIC_ID FROM ROOMS WHERE ID_WYSTAWY =:ID)AS Z) AS Z1 LEFT JOIN PICTURE ON Z1.PIC = PICTURE.ID_PICTURE');
        $query ->execute(['ID'=>$Project]);
        $answer =$query->fetch(PDO::FETCH_ASSOC);
        return $answer; 
    }
   public function getObjectsParametrs($object){
    $query= $this -> conn ->prepare('select descryption.LNG1, descryption.LNG2, descryption.LNG3, PICTURE.LINK, PICTURE.ID_AUTHOR, object.TITLE, object.ownership, object.date  from object left join descryption on object.DESC_ID=ID_DESC left join picture on object.ID_PIC=picture.ID_PICTURE where object.ID_OBJECT=:ID');
    $query ->execute(['ID'=>$object]);
        $answer =$query->fetch(PDO::FETCH_ASSOC);
        return $answer; 
   }


}