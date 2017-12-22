<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/functions/dbFunctions.php";
require_once "$root/embryon/api/functions/queryFunctions.php";
require_once "$root/embryon/api/functions/logFunctions.php";

class User {
  public function add($token, $email, $password) {
    $db = dbConnect();
    $query = "INSERT INTO users (token, email, password) VALUES ('$token', '$email', '$password')";
    $res = dbQuery($db, $query);
  }

  public function edit($data) {
    $db = dbConnect();
    $query = createUsersQueryFromData($data, $data["id"]);
    $res = dbQuery($db, $query);
  }

  public function delete($id) {
    $db = dbConnect();
    $query = "UPDATE users SET active = 0 WHERE id = $id";
    $res = dbQuery($db, $query);
  }

  public function confirmEmail($token) {
    $db = dbConnect();
    $query = "UPDATE users SET active = 2 WHERE token = '$token'";
    $res = dbQuery($db, $query);
  }

  public function editPassword($token, $password) {
    $db = dbConnect();
    $query = "UPDATE users SET password = '$password' WHERE token = '$token'";
    $res = dbQuery($db, $query);
  }
}
?>
