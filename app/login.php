<?php
  require "../api/controllers/UsersController.php";

  session_start();
  $uc = new UsersController();
  $json = $uc->login($_POST["email"], $_POST["password"]);
  // echo $json;
  $response = json_decode($json);
  $_SESSION["message"] = $response->message;
  $_SESSION["user_id"] = $response->user_id;
  header("Location: profile.php");
  exit();
 ?>