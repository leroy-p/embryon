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
    "available"
  ];
  foreach ($itemsColumns as $value) {
    if (isset($data[$value])) {
      $query .= "$value, ";
    }
  }
  $query .= "date_creation, date_modification) VALUES (";
  foreach ($itemsColumns as $value) {
    if (isset($data[$value])) {
      $query .= "'$data[$value]', ";
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
    "available"
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

 ?>
