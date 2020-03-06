<?php
require_once "autoload.php";
use Config\Database;
use Object\Books;
use Object\Lends;
use Object\Users;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
http_response_code(200);

$dbObj = new Database();
$db = $dbObj->getConnection();

// get posted data
$data = json_decode(file_get_contents("php://input")) ?? $_REQUEST;
$booksObj = new Books($db);


if( isset($data['page']) ){
  $booksObj->page = $data['page']--;
}
if( isset($data['size']) && is_numeric($data['size']) && $data['size'] > 1){
  $booksObj->booksPerPage = $data['size'];
}


$listStmt = $booksObj->listAvailable();

$bookList = [];
if ($listStmt->rowCount() > 0){
  while ($row = $listStmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $bookList[] = [
      "book_id" => $id,
      "isbn" => $isbn,
      "title" => $title,
      "available" => $in_stock
    ];
  }

  $response = [
    "book_count" => $listStmt->rowCount(),
    "book_list" => $bookList
  ];
}else{
  $response = [
    "message" => "No Books currently available"
  ];
}

echo json_encode($response);
exit();

