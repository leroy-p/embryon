<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/controllers/TradesController.php";

$tc = new TradesController();
$json = $tc->getAll();
echo $json;
?>