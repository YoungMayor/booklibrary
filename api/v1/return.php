<?php
require_once "../config/database.php";
require_once "../objects/Books.php";
require_once "../objects/Users.php";
require_once "../objects/Lends.php";

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
$userObj = new Users($db);
$lendObj = new Lends($db);

if( !empty($data['isbn']) && !empty($data['user']) ){

  $bookObj->isbn = $data['isbn'];
  $userObj->id = $data['user'];
  $userObj->email = $data['user'];

  if ($bookObj->bookExists() && $userObj->userExists()){
    $lendObj->bookID = $bookObj->id;
    $lendObj->recipentID = $userObj->id;

    if ($lendObj->isOutstanding()){

      if($lendObj->logReturn() && $bookObj->increaseStock()){
        http_response_code(201);

        $response = [
          "message" => "Book '{$bookObj->title}' with ISBN {$bookObj->isbn} has been returned by {$userObj->name}"
        ];
        echo json_encode($response);
      }else{
        http_response_code(503);

        echo json_encode(array("message" => "Unexpected service failure!"));
      }
    }else{
      http_response_code(503);

      echo json_encode(array("message" => "User holds no copy of this book"));
    }
  } else {
    echo json_encode(array("message" => "User not registered"));
  }
}
?>
