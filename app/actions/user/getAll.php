<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/controllers/UsersController.php";

session_start();
$uc = new UsersController();
$json = $uc->getAll();
echo $json;
?>
