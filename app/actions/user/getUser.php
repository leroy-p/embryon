<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/controllers/UsersController.php";

session_start();
if (isset($_GET["id"])) {
  $uc = new UsersController();
  $json = $uc->getUser($_GET["id"]);
  echo $json;
}
?>
