<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/controllers/UsersController.php";

session_start();
$uc = new UsersController();
$json = $uc->signup($_POST["email"], $_POST["password"], $_POST["confirmation"]);
$response = json_decode($json);
$_SESSION["message"] = $response->message;
header("Location: ../../index.php");
die();
?>
