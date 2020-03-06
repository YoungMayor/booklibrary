<?php

namespace Object;
use \PDO;

class Books{
  private $conn;
  private $table_name = "books";

  public $id, $isbn, $title, $author, $description, $inStock, $invalidBook;
  protected $bookDetails;

  public function __construct($db){
    $this->conn = $db;
  }

  protected function sanitizeProperties(){
    $this->isbn = htmlspecialchars(strip_tags($this->isbn));
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->description = htmlspecialchars(strip_tags($this->description));
  }

  public function listAvailable(){
    $query = "SELECT * FROM {$this->table_name} WHERE in_stock > 0 ORDER BY id DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  protected function setProperties($row = false){
    if(!$row){
      $row = $this->bookDetails;
    }
    if (!$row){
      return false;
    }
    $this->id = $row->id;
    $this->isbn = $row->isbn;
    $this->title = $row->title;
    $this->author = $row->author;
    $this->description = $row->description;
    $this->inStock = $row->in_stock;
  }

  // check if the book with the given ISBN exists in record
  public function bookExists(){
    $query = "SELECT * FROM {$this->table_name} WHERE isbn = :isbn";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":isbn", $this->isbn);
    $stmt->execute();

    if ($stmt->rowCount()){
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $this->bookDetails = $row;
      $this->setProperties();

      $this->invalidBook = false;
      return true;
    }else{
      $this->invalidBook = true;
      return false;
    }
  }

  // increase stock count of a book
  public function increaseStock(){
    $query = "UPDATE {$this->table_name} SET `in_stock` = in_stock + 1 WHERE {$this->table_name}.`id` = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    return $stmt->execute();
  }

  // reduce stock count of a book
  public function reduceStock(){
    $query = "UPDATE {$this->table_name} SET `in_stock` = in_stock - 1 WHERE {$this->table_name}.`id` = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    return $stmt->execute();
  }

  // create product
  public function create(){
    if ($this->bookExists()){
      // if book already exists then increase stock
      return $this->increaseStock();
    }else{

      $query = "INSERT INTO {$this->table_name} SET isbn = :isbn, title = :title, author = :author, description = :description";
      $stmt = $this->conn->prepare($query);

      // sanitize inputs
      $this->sanitizeProperties();

      // bind values
      $stmt->bindParam(":isbn", $this->isbn);
      $stmt->bindParam(":title", $this->title);
      $stmt->bindParam(":author", $this->author);
      $stmt->bindParam(":description", $this->description);

      // execute query
      return $stmt->execute();
    }
  }

  public function getBookDetails(){
    return (array) $this->bookDetails;
  }
}
