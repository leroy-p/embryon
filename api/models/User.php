<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/functions/dbFunctions.php";
require_once "$root/embryon/api/functions/queryFunctions.php";
require_once "$root/embryon/api/functions/logFunctions.php";

class User {
  public function add($email, $password) {
    $db = dbConnect();
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
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
}
?>
