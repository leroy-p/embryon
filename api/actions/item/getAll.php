<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/controllers/ItemsController.php";

$ic = new ItemsController();
$json = $ic->getAll();
echo $json;
?>
