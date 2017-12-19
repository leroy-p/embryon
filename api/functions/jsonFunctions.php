<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/functions/logFunctions.php";

function createResponse($url, $status, $message, $id) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["id"] = $id;
  logResponse($response, $url);
  return json_encode($response);
}

function createGetUserResponse($url, $status, $message, $user) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["user"] = $user;
  logResponse($response, $url);
  return json_encode($response);
}

function createGetAllUsersResponse($url, $status, $message, $users) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["users"] = $users;
  logResponse($response, $url);
  return json_encode($response);
}

function createGetItemResponse($url, $status, $message, $item) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["item"] = $item;
  logResponse($response, $url);
  return json_encode($response);
}

function createGetAllItemsResponse($url, $status, $message, $items) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["items"] = $items;
  logResponse($response, $url);
  return json_encode($response);
}

function createGetTradeResponse($url, $status, $message, $trade) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["trade"] = $trade;
  logResponse($response, $url);
  return json_encode($response);
}

function createGetAllTradesResponse($url, $status, $message, $trades) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["trades"] = $trades;
  logResponse($response, $url);
  return json_encode($response);
}

?>
