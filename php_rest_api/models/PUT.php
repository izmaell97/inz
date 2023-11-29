<?php

class PUT
{
  private $conn;
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function PutProject($login, $projectname)
  {
  }
  public function PutObject($login, $objectname)
  {
  }
  public function PutDescription($login, $objectid)
  {
  }
  public function PutAdditionalWorkers($project, $login, $position)
  {
    $query = $this->conn->prepare('INSERT INTO work_proj (ID_PROJ, ID_WORK, STANOWISKO) VALUES (:idProject, :idLogin,  :position)');
    $query->execute(['ID_PROJ' => $project, 'idLogin' => $login, 'possition' => $position]);
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
        $setingquery = $setingquery . 'FIRST_NAM= :surnam, ';
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
        
        $query = $this->conn->prepare($setingquery);
        $query->execute($parm);
        return $setingquery;
      } else {
        return $parm;
      }
    } else {
      return 'error2';
    }
  }

  public function PutPicture()
  {
  }
  public function AddDescryption()
  {
  }
}
