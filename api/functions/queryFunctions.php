<?php
function createUsersQueryFromData($data, $id) {
  $query = "UPDATE users SET ";
  $date = date("Y-m-d H:i:s");
  $usersColumns = [
    "firstname",
    "lastname",
    "pic_url",
    "phone",
    "building",
    "floor",
    "location"
  ];
  foreach ($usersColumns as $value) {
    if (isset($data[$value])) {
      $query .= "$value = '$data[$value]', ";
    }
  }
  $query .= "date_modification = '$date' WHERE id = $id";
  return $query;
}

function createAddItemQueryFromData($data) {
  $query = "INSERT INTO items (";
  $date = date("Y-m-d H:i:s");
  $itemsColumns = [
    "token",
    "user_id",
    "type_id",
    "name",
    "description",
    "pic_url",
    "available",
    "status"
  ];
  foreach ($itemsColumns as $value) {
    if (isset($data[$value])) {
      $query .= "$value, ";
    }
  }
  $query .= "date_creation, date_modification) VALUES (";
  foreach ($itemsColumns as $value) {
    if (isset($data[$value])) {
      if (!strcmp($value, "available")) {
        $available = $data[$value] ? 1 : 0;
        $query .= "$available, ";
      }
      else if (!strcmp($value, "status")) {
        $query .= "$data[$value], ";
      }
      else {
        $query .= "'$data[$value]', ";
      }
    }
  }
  $query .= "'$date', '$date')";
  return $query;
}

function createEditItemQueryFromData($data, $id) {
  $query = "UPDATE items SET ";
  $date = date("Y-m-d H:i:s");
  $itemsColumns = [
    "type_id",
    "name",
    "description",
    "pic_url",
    "available",
    "status"
  ];
  foreach ($itemsColumns as $value) {
    if (isset($data[$value])) {
      if (!strcmp($value, "available")) {
        $available = $data[$value] ? "1" : "0";
        $query .= "$value = $available, ";
      }
      else {
        $query .= "$value = '$data[$value]', ";
      }
    }
  }
  $query .= "date_modification = '$date' WHERE id = $id";
  return $query;
}

function createGetTradesQuery($data) {
  $count = 0;
  $query = "SELECT trades.id, trades.user_id, trades.item_id, trades.token, trades.date_creation, trades.date_modification,
            trades.expected_date_start, trades.expected_date_end, trades.date_start, trades.date_end, trades.status FROM trades";
  if (isset($data["owner_id"])) {
    $query .= " LEFT JOIN items ON trades.item_id = items.id";
  }
  foreach ($data as $key => $value) {
    $query .= $count ? " AND " : " WHERE ";
    ++$count;
    if (strcmp($key, "owner_id")) {
      $query .= "trades.$key = $value";
    }
    else {
      $query .= "items.user_id = $value";
    }
  }
  return $query;
}
?>
