<?php
class VisitorDatabase{
private $host = ''; // place for database host adress
private $db_name =''; // place for database name
private $username =''; // login of visitor account
private $password = ''; // password of visitor account
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
