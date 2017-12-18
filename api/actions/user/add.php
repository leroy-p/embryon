<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once "$root/embryon/api/controllers/UsersController.php";

$data = file_get_contents('php://input');
$uc = new UsersController();
$json = $uc->add(json_decode($data, true));
echo $json;
?>
