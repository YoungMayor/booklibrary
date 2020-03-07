<?php

namespace Object;
use \PDO;

class Users{
  private $conn;
  private $table_name = "users";

  public $id, $name, $email, $roleRaw, $role, $createdAt;
  public $roleStr, $createdAtFMT;
  public $validUser;
  protected $userDetails;

  public function __construct($db){
    $this->conn = $db;
  }

  public function userExists(){
    $query = "SELECT * FROM {$this->table_name} WHERE id = :id OR email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":email", $this->email);
    $stmt->execute();

    if ($stmt->rowCount()){
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $this->id = $row->id;
      $this->validUser = true;
      $this->userDetails = $row;
      $this->setProperties();
    }else{
      $this->validUser = false;
    }
    return $this->validUser;
  }

  protected function setProperties($row = false){
    if(!$row){
      $row = $this->userDetails;
    }
    if (!$row){
      return false;
    }
    $this->id = $row->id;
    $this->name = $row->name;
    $this->email = $row->email;
    $this->role = $row->role;
    $this->createdAt = $row->created_at;

    switch ($this->role){
      case "1":
      $str = "Junior Student";
      break;
      case "2":
      $str = "Senior Student";
      break;
      case "3":
      $str = "Teacher";
      break;
    }
    $this->roleStr = $str;

    $this->createdAtFMT = date("F js, Y", strtotime($row->created_at));
  }

}
