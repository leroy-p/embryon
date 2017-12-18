<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once "$root/embryon/api/controllers/UsersController.php";

$uc = new UsersController();
$json = $uc->getAll();
echo $json;
?>
