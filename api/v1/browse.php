<?php
require_once "../config/database.php";
require_once "../objects/Books.php";
require_once "../objects/Users.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
http_response_code(200);

$dbObj = new Database();
$db = $dbObj->getConnection();
$booksObj = new Books($db);

$listStmt = $booksObj->listAvailable();

$bookList = [];
if ($listStmt->rowCount() > 0){
  while ($row = $listStmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $bookList[] = [
      "book_id" => $id,
      "isbn" => $isbn,
      "title" => $title
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

