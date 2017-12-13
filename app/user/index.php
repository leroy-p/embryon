<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ..");
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
    <?php
      if (isset($_SESSION["message"])) {
        echo "<p>" . $_SESSION['message'] . "</p>";
        unset($_SESSION["message"]);
      }
    ?>
    <a href="edit.php">Modifier ses informations personnelles</a><br />
    <a href="../actions/user/logout.php">Deconnexion</a>
  </body>
</html>
