<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/controllers/UsersController.php";

session_start();
$uc = new UsersController();
$_POST["password"] = md5($_POST["password"]);
$_POST["confirmation"] = md5($_POST["confirmation"]);
$json = $uc->edit($_POST, $_SESSION["user_id"]);
$response = json_decode($json);
$_SESSION["message"] = $response->message;
if ($response->status == 0) {
  header("Location: ../../user/edit.php");
  die();
}
header("Location: ../../user");
die();
?>
