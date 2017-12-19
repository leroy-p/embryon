<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  require_once "$root/embryon/api/functions/dbFunctions.php";
  require_once "$root/embryon/api/functions/queryFunctions.php";
  require_once "$root/embryon/api/functions/logFunctions.php";

  class Trade {
    public function add($data) {
      $db = dbConnect();
      $date = date("Y-m-d H:i:s");
      $query = "INSERT INTO trades (user_id, item_id, token, date_creation, date_modification, expected_date_start, expected_date_end, status)
                VALUES ($data[user_id], $data[item_id], '$data[token]', '$date', '$date', '$data[date_start]', '$data[date_end]', 1)";
      $res = dbQuery($db, $query);
    }

    public function editStatus($data) {
      $db = dbConnect();
      $query = "UPDATE trades SET status = $data[status] WHERE id = $data[id]";
      $res = dbQuery($db, $query);
      if ($data) {
        $query = "UPDATE items SET available = 0, status = 3 WHERE id = $data[item_id]";
        $res = dbQuery($db, $query);
      }
    }

    public function editDate($data, $column) {
      $db = dbConnect();
      $query = "UPDATE trades SET $column = '$data[$column]', status = $data[status] WHERE id = $data[id]";
      $res = dbQuery($db, $query);
      if (!strcmp($column, "date_end")) {
        $query = "UPDATE items SET available = 1, status = 1 WHERE id = $data[item_id]";
        $res = dbQuery($db, $query);
      }
    }
  }
?>
