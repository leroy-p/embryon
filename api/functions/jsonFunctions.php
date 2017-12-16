<?php
function createResponse($status, $message, $id) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["id"] = $id;
  return json_encode($response);
}

function createGetUserResponse($status, $message, $user) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["user"] = $user;
  return json_encode($response);
}

function createGetAllUsersResponse($status, $message, $users) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["users"] = $users;
  return json_encode($response);
}

function createGetItemResponse($status, $message, $item) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["item"] = $item;
  return json_encode($response);
}

function createGetAllItemsResponse($status, $message, $items) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["items"] = $items;
  return json_encode($response);
}

?>
