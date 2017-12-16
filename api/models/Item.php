<?php
  require "User.php";

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
