<?php
function createUserResponse($status, $message, $id) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["user_id"] = $id;
  return json_encode($response);
}

function createGetUserResponse($status, $message, $user) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["user"] = $user;
  return json_encode($response);
}

function createGetAllResponse($status, $message, $users) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["users"] = $users;
  return json_encode($response);
}
 ?>
