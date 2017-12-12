<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Embryon</title>
  </head>
  <body>
    <p><?php print_r($_SESSION["user_id"]); ?></p>
    <a href="logout.php">Deconnexion</a>
  </body>
</html>
