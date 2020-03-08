<?php

namespace Config;

class Database{
  private $host;
  private $db_name;
  private $username;
  private $password;

  public $conn;

  public function __construct(){
    $this->host = _env("db_host", "localhost");
    $this->db_name = _env("db_name", "API_BOOKLIBRARY");
    $this->username = _env("db_user", "root");
    $this->password = _env("db_pass", "");
  }

  public function getConnection(){
    $this->conn = NULL;

    try{
      $this->conn = new \PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception){
      echo "Connection error: ".$exception->getMessage();
      die();
    }

    return $this->conn;
  }
}
