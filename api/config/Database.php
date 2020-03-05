<?php

class Database{
  private $host = "localhost";
  private $db_name = "api_bklib";
  private $username = "root";
  private $password = "";

  public $conn;

  public function getConnection(){
    $this->conn = NULL;

    try{
      $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception){
      echo "Connection error: ".$exception->getMessage();
      die();
    }

    return $this->conn;
  }
}
