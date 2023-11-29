<?php
class Database{
private $host = 'localhost';
private $db_name ='muzeum';
private $username ='worker';
private $password = 'workerpassword';
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