<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  require_once "$root/embryon/api/functions/dbFunctions.php";
  require_once "$root/embryon/api/functions/queryFunctions.php";
  require_once "$root/embryon/api/functions/logFunctions.php";

  class Item {
    public function add($data) {
      $db = dbConnect();
      $query = createAddItemQueryFromData($data);
      $res = dbQuery($db, $query);
    }

    public function edit($data) {
      $db = dbConnect();
      $query = createEditItemQueryFromData($data, $data["id"]);
      $res = dbQuery($db, $query);
    }

    public function delete($id) {
      $db = dbConnect();
      $query = "UPDATE items SET active = 0 WHERE id = $id";
      $res = dbQuery($db, $query);
    }
  }
?>
