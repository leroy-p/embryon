<?php
function createUserResponse($status, $message, $id) {
  $response["status"] = $status;
  $response["message"] = $message;
  $response["user_id"] = $id;
  return json_encode($response);
}
 ?>
