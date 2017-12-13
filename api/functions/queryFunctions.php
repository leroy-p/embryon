<?php
function createUsersQueryFromData($data, $id, $usersColumns) {
  $query = "UPDATE users SET ";
  $count = 0;
  foreach ($usersColumns as $value) {
    if ($data[$value]) {
      if ($count > 0) {
        $query .= ", ";
      }
      $query .= "$value = '$data[$value]'";
      ++$count;
    }
  }
  $query .= " WHERE id = $id";
}
 ?>
