<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/controllers/ItemsController.php";

$ic = new ItemsController();
$json = $ic->getAll();
echo $json;
?>
