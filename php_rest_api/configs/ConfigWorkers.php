<?php
class WorkerDatabase{
private $host = ''; //place for database host adress
private $db_name =''; // place for database name
private $username =''; // place for workers account login
private $password = ''; // place for workers account password
private $conn;


public function tryConnect() {
$this -> conn = null;

try{
$this -> conn = new PDO('mysql:host=' . $this-> host . ';dbname='. $this->db_name, $this -> username, $this -> password);
$this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
} catch(PDOException $e) {
    echo $e ->getMessage();

}

return $this -> conn;
}
  
}
