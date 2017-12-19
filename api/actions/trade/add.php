<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/controllers/TradesController.php";

$data = file_get_contents('php://input');
$tc = new TradesController();
$json = $tc->add(json_decode($data, true));
echo $json;
?>
