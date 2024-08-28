<?php

class GET
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

   
    public function GetProjects($login)
    {
   $query = $this->conn->prepare('SELECT Privlage FROM workers where ID_WORKERS=:ID');
   $query->execute(['ID'=>$login]);
   $answer1 = $query->fetch(PDO::FETCH_ASSOC);
if(!$answer1['Privlage']){
    $query1 = $this->conn->prepare('SELECT  PROJECTS.ID_PROJECTS, PROJECTS.EX_NAME, PROJECTS.CURRENT from PROJECTS ');
    $query1->execute([]);
    $answer = $query1->fetchall(PDO::FETCH_ASSOC);
    return $answer;


}else{
        $query2 = $this->conn->prepare('SELECT  PROJECTS.ID_PROJECTS, PROJECTS.EX_NAME, PROJECTS.CURRENT, WORK_PROJ.STANOWISKO  FROM WORK_PROJ LEFT JOIN PROJECTS ON WORK_PROJ.ID_PROJ=PROJECTS.ID_PROJECTS 
        WHERE WORK_PROJ.ID_WORK= :ID   AND PROJECTS.CURRENT=1  ');
        $query2->execute(['ID' => $login]);
        $answer2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        return $answer2;
}
    }
    public function GetWorkers($Project)
    {
        $query = $this->conn->prepare('SELECT WORKERS.NAM, WORKERS.ID_WORKERS, WORKERS.SURNAME FROM WORK_PROJ LEFT JOIN WORKERS ON WORK_PROJ.ID_WORK=WORKERS.ID_WORKERS WHERE WORK_PROJ.ID_PROJ =:PROJEKT');
        $query->execute(['PROJEKT' => $Project]);
        $answer = $query->fetchAll(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function getNonWorkers($Project)
    {
        $query = $this->conn->prepare('SELECT WORKERS.ID_WORKERS, WORKERS.NAM, WORKERS.SURNAME from workers where ID_WORKERS not in (SELECT ID_WORK from work_proj where id_proj =:PROJEKT)');
        $query->execute(['PROJEKT' => $Project]);
        $answer = $query->fetchall(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function getObjects($Project)
    {
        $query = $this->conn->prepare('select Z1.id, Z1.nazwa, Z1.catnumber, Z1.tab FROM (SELECT * from(select TITLE AS nazwa, ID_OBJECT AS ID, DESC_ID as catnumber, "object" AS tab FROM OBJECT WHERE ID_PROJECT =:ID UNION SELECT TITLE AS nazwa, ID_ROOMS AS ID, DESC_ID as catnumber, "room" as tab FROM ROOMS WHERE ID_PROJECT =:ID)AS Z) AS Z1;');
        $query->execute(['ID' => $Project]);
        $answer = $query->fetchAll(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function getObjectsParametrs($object)
    {
        $query = $this->conn->prepare('select "object" as "TABLE", descryption.ID_DESC, descryption.LNG1, descryption.LNG2, descryption.LNG3, PICTURE.LINK, PICTURE.ID_PICTURE, picture.ALT, picture.NOTE as"PICTURE_NOTE", picture.Owner, object.TITLE, object.NOTE, object.ID_OBJECT as ID from object left join descryption on object.DESC_ID=ID_DESC left join picture on object.ID_PIC=picture.ID_PICTURE where object.ID_OBJECT=:ID');
        $query->execute(['ID' => $object]);
        $answer = $query->fetch(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function getRoomParametrs($Room)
    {
        $query = $this->conn->prepare('select "room" as "TABLE", descryption.ID_DESC, descryption.LNG1, descryption.LNG2, descryption.LNG3, PICTURE.LINK, PICTURE.ID_PICTURE, picture.ALT, picture.NOTE as "PICTURE_NOTE", picture.Owner, rooms.TITLE, rooms.NOTE, rooms.ID_ROOMS as ID from rooms left join descryption on rooms.DESC_ID=ID_DESC left join picture on rooms.ID_PIC=picture.ID_PICTURE where rooms.ID_ROOMS=:ID    ');
        $query->execute(['ID' => $Room]);
        $answer = $query->fetch(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function getUserDataForUpdate($id)
    {
        $query = $this->conn->prepare('SELECT NAM, SURNAME, userNam, Privlage FROM workers WHERE ID_WORKERS= :id');
        $query->execute(['id' => $id]);
        $answer = $query->fetch(PDO::FETCH_ASSOC);
        return $answer;
    }
   
    public function CheckCreator($Project, $login)
    {
        $query = $this->conn->prepare('SELECT ID_WORK FROM work_proj WHERE ID_PROJ = :ID AND STANOWISKO = "kurator"    ');
        $query->execute(['ID' => $Project]);
        $answer = $query->fetch(PDO::FETCH_ASSOC);
        if ($answer == $login) {
            return true;
        } else {
            return false;
        }
    }
    public function DescSearch($element)
    {
        $query = $this->conn->prepare('SELECT * FROM descryption WHERE LNG1 LIKE :element;');
        $query->execute(['element' => '%' . $element . '%']);
        $answer = $query->fetchall(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function DescSearchArc($element)
    {
        $query = $this->conn->prepare('SELECT * FROM ARCHIVES WHERE LNG1 LIKE :element;');
        $query->execute(['element' => '%' . $element . '%']);
        $answer = $query->fetchall(PDO::FETCH_ASSOC);
        return $answer;
    }
    public function GetProjectInfo($Project)
    {
        $query = $this->conn->prepare('SELECT projects.ID_PROJECTS, projects.EX_NAME, picture.ID_PICTURE, picture.LINK, picture.ALT, picture.NOTE as "PICTURE_NOTE", picture.Owner, descryption.ID_DESC,  descryption.LNG1, descryption.LNG2, descryption.LNG3 FROM projects LEFT JOIN picture ON projects.ID_PIC = picture.ID_PICTURE LEFT JOIN descryption ON projects.DESC_ID=descryption.ID_DESC where ID_PROJECTS=:project');
        $query->execute(['project' => $Project]);
        $answer = $query->fetch(PDO::FETCH_ASSOC);
        return $answer;
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
    public function getUserAdmin($admin){
        try{
        $query1 = $this->conn->prepare('SELECT ID_WORKERS, NAM, SURNAME, userNam, ISACTIVE, CASE WHEN ISACTIVE = 0 OR num_of_wrong_login > 5 THEN 1 ELSE 0 END AS Suspended, Privlage  FROM workers where ID_WORKERS <> :adminid');
        $query1->execute(['adminid'=>$admin]);
        $answer = $query1->fetchall(PDO::FETCH_ASSOC);
        return $answer;
        }catch(Exception $e){
            return false;
        }
    }
    public function getDescAdmin(){
        $query1 = $this->conn->prepare('SELECT descryption.ID_DESC as ID, descryption.LNG1, descryption.LNG2, descryption.LNG3, "desc" as tab FROM descryption LEFT JOIN rooms on descryption.ID_DESC=rooms.DESC_ID left join object on descryption.ID_DESC=object.DESC_ID LEFT JOIN projects on descryption.ID_DESC=projects.DESC_ID where projects.ID_PROJECTS is null and rooms.ID_ROOMS is null and object.ID_OBJECT is null UNION SELECT ID_ARCHIVES as ID, LNG1, LNG2, LNG3, "archiv" as tab FROM archives');
        $query1->execute();
        $answer = $query1->fetchall(PDO::FETCH_ASSOC);
        return $answer;

    }
	 public function getObjectGuest($Id){
        $query1 = $this->conn->prepare('SELECT Z.nazwa, descryption.LNG1 as jezyk1, descryption.LNG2 as jezyk2, descryption.LNG3 as jezyk3, picture.LINK, picture.ALT from (select Title as nazwa, DESC_ID as DESC_ID, ID_PIC as ID_PIC from object UNION select TITLE as nazwa, DESC_ID as DESC_ID, ID_PIC as ID_PIC from rooms UNION select EX_NAME as nazwa, DESC_ID as DESC_ID, ID_PIC as ID_PIC from projects) as Z left join descryption on Z.DESC_ID=descryption.ID_DESC LEFT JOIN picture on Z.ID_PIC=picture.ID_PICTURE WHERE DESC_ID=:ID');
		
        $query1->execute(['ID' => $Id]);
        $answer = $query1->fetchall(PDO::FETCH_ASSOC);
        return $answer;

    }

    public function getPhotos(){
        $query1 = $this->conn->prepare('SELECT DISTINCT( LINK) FROM picture');
        $query1->execute([]);
        $answer = $query1->fetchall(PDO::FETCH_ASSOC);
        return $answer;
    }
}
