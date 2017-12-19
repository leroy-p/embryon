<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/controllers/TradesController.php";

$tc = new TradesController();
$json = $tc->getTrades($_GET);
echo $json;
?>
