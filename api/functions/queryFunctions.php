<?php
function createUsersQueryFromData($data, $id) {
  $query = "UPDATE users SET ";
  $date = date("Y-m-d H:i:s");
  $usersColumns = [
    "password",
    "firstname",
    "lastname",
    "pic_url",
    "phone",
    "building",
    "floor",
    "location"
  ];
  foreach ($usersColumns as $value) {
    if (strlen($data[$value])) {
      $query .= "$value = '$data[$value]', ";
    }
  }
  $query .= "date_modification = '$date' WHERE id = $id";
  return $query;
}
 ?>
