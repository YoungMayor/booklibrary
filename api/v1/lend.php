<?php
require_once "autoload.php";
use Config\Database;
use Object\Books;
use Object\Users;
use Object\Lends;

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


$bookObj->isbn = $data['isbn'] ?? false;
$userObj->id = $data['user'] ?? false;
$userObj->email = $data['user'] ?? false;

if ($bookObj->bookExists() && $userObj->userExists()){
  if ($bookObj->inStock > 0){
    $lendObj->bookID = $bookObj->id;
    $lendObj->recipentID = $userObj->id;

    if (!$lendObj->isOutstanding()){
      if($lendObj->logLendOut() && $bookObj->reduceStock()){
        http_response_code(201);

        echo json_encode([
          "message" => "Book '{$bookObj->title}' with ISBN {$bookObj->isbn} has been lent out to {$userObj->name}"
        ]);
      }else{
        http_response_code(503);

        echo json_encode([
          "message" => "Unexpected service failure!",
          "error" => "LND-102"
        ]);
      }
    }else{
      http_response_code(200);

      echo json_encode([
        "message" => "User has already collected a copy of this book without returns"
      ]);
    }

  }else{
    http_response_code(200);

    echo json_encode(array("message" => "{$bookObj->title} is currently out of stock"));
  }
} else if ($bookObj->invalidBook) {
  http_response_code(200);

  echo json_encode(array("message" => "The Book does not exists"));
}else if (!$userObj->validUser){
  http_response_code(200);

  echo json_encode([
    "message" => "User Not registered"
  ]);

}else{
  http_response_code(503);

  echo json_encode([
    "message" => "Unexpected Service Failure",
    "error" => "LND-103"
  ]);
}
// }
?>
