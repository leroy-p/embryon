<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/controllers/ItemsController.php";

$data = file_get_contents('php://input');
$ic = new ItemsController();
$json = $ic->edit(json_decode($data, true));
echo $json;
?>
