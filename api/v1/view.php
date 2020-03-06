<?php
require_once "autoload.php";
use Config\Database;
use Object\Books;
use Object\Users;

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

if( !empty($data['isbn']) ){

    // set product property values
  $bookObj->isbn = $data['isbn'];

    // create the product
  if($bookObj->bookExists()){
    http_response_code(200);

    $response = [
      "book" => $bookObj->getBookDetails()
    ];

    echo json_encode($response);
  }else{
    http_response_code(404);

    echo json_encode(array("message" => "No book in record matches the given ISBN"));
  }
} else {
  http_response_code(503);

    // tell the user
  echo json_encode(array("message" => "Please pass the book's ISBN with the request"));
}
?>
