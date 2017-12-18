<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/controllers/UsersController.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$uc = new UsersController();
$json = $uc->edit($data);
echo $json;
?>
