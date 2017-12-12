<?php
  require "../api/controllers/UsersController.php";

  $uc = new UsersController();
  session_start();
  session_destroy();
  header("Location: index.php");
  exit();
 ?>
