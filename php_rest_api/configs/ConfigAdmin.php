<?php
class AdminDatabase{
private $host = ''; // here put name of host
private $db_name =''; // here put database name
private $username =''; // here put admin username from database
private $password = ''; //here put password
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
