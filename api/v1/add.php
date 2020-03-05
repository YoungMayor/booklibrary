<?php
require_once "../config/database.php";
require_once "../objects/Books.php";
require_once "../objects/Users.php";

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");

$dbObj = new Database();
$db = $dbObj->getConnection();

// get posted data
$data = json_decode(file_get_contents("php://input")) ?? $_REQUEST;

$bookObj = new Books($db);

if( !empty($data['isbn']) && !empty($data['title']) && !empty($data['author']) && !empty($data['description']) ){

    // set product property values
  $bookObj->isbn = $data['isbn'];
  $bookObj->title = $data['title'];
  $bookObj->author = $data['author'];
  $bookObj->description = $data['description'];

    // create the product
  if($bookObj->create()){

    // set response code - 201 created
    http_response_code(201);

    // tell the user
    echo json_encode(array("message" => "Book was added successfully"));
  }else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to add book "));
  }
} else {
  // set response code - 400 bad request
  http_response_code(400);

    // tell the user
  echo json_encode(array("message" => "Unable to add book. Data is incomplete."));
}
?>
