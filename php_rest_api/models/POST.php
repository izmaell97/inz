<?php

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
    public function PostNewUser( $login, $nam, $surNam, $psswd){
     
        $parm['nam']= $nam;
        $parm['surnam'] = $surNam;
        $parm['psswd'] = $psswd;
        $parm['login'] = $login;
      
        $query = $this->conn->prepare('INSERT INTO workers (NAM, FIRST_NAM, userNam, PASSWORD_HASH, ISACTIVE) Values
        ( :nam, :surnam, :login, :psswd, true )');
        $query->execute(['nam'=>$nam, 'surnam'=>$surNam, 'login'=>$login, 'psswd'=>$psswd]);
        return $query;
    
    
  }

    
    
    
    }