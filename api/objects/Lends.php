<?php

class Lends{
  private $conn;
  private $table_name = "lend_outs";

  public $id, $bookID, $recipentID, $collected, $returned, $isOutStanding;

  public function __construct($db){
    $this->conn = $db;
  }

  public function logLendOut(){
    $query = "INSERT INTO {$this->table_name} SET book_id = :book_id, recipent_id = :recipent_id";
    $stmt = $this->conn->prepare($query);

      // sanitize inputs
    $this->bookID = htmlspecialchars(strip_tags($this->bookID));
    $this->recipentID = htmlspecialchars(strip_tags($this->recipentID));;

      // bind values
    $stmt->bindParam(":book_id", $this->bookID);
    $stmt->bindParam(":recipent_id", $this->recipentID);

      // execute query
    return $stmt->execute();
  }

  public function logReturn(){
    $now = date('Y-m-d h:i:s');
    $query = "UPDATE {$this->table_name} SET returned = :now WHERE book_id = :book_id AND recipent_id = :recipent_id AND returned IS NULL";
    $stmt = $this->conn->prepare($query);

      // sanitize inputs
    $this->bookID = htmlspecialchars(strip_tags($this->bookID));
    $this->recipentID = htmlspecialchars(strip_tags($this->recipentID));;

      // bind values
    $stmt->bindParam(":now", $now);
    $stmt->bindParam(":book_id", $this->bookID);
    $stmt->bindParam(":recipent_id", $this->recipentID);

      // execute query
    return $stmt->execute();
  }

  public function isOutStanding(){
    $query = "SELECT * FROM {$this->table_name} WHERE book_id = :book_id AND recipent_id = :recipent_id AND returned IS NULL";
    $stmt = $this->conn->prepare($query);

      // sanitize inputs
    $this->bookID = htmlspecialchars(strip_tags($this->bookID));
    $this->recipentID = htmlspecialchars(strip_tags($this->recipentID));;

      // bind values
    $stmt->bindParam(":book_id", $this->bookID);
    $stmt->bindParam(":recipent_id", $this->recipentID);
    // print_r($stmt);
    print_r($this->bookID);
    print_r($this->recipentID);

      // execute query
    $stmt->execute();

    if ($stmt->rowCount()){
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $this->collected = $row->collected;
      $this->collected = date("F jS, Y", strtotime($row->collected));

      $this->isOutStanding = true;
    }else{
      $this->isOutStanding = false;
    }

    return $this->isOutStanding;
  }

}
