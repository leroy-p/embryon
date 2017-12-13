<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/controllers/UsersController.php";

session_start();
$uc = new UsersController();
$json = $uc->edit($_POST, $_SESSION["user_id"]);
// $response = json_decode($json);
// $_SESSION["message"] = $response->message;
// header("Location: ../../user");
die();
?>
