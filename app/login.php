<?php
  require "../api/controllers/UsersController.php";

  $uc = new UsersController();
  $json = $uc->login($_POST["email"], $_POST["password"]);
  // echo $json;
  session_start();
  $response = json_decode($json);
  $_SESSION["user_id"] = $response->user_id;
  header("Location: profile.php");
  exit();
 ?>
