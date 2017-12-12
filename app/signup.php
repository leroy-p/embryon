<?php
  require "../api/controllers/UsersController.php";

  $uc = new UsersController();
  $json = $uc->signup($_POST["email"], $_POST["password"]);
  echo $json;
  header("Location: index.php");
  die();
 ?>
