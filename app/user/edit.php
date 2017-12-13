<?php
session_start();
if (!isset($_SESSION["user_id"])) {
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
    <h2>Informations personnelles</h2>
    <form action="../actions/user/edit.php" method="post">
      <p>
        <input type="password" name="password" id="signup_password" placeholder="********" />Mot de passe<br />
        <input type="password" name="confirmation" id="login_confirmation" placeholder="********" />Confirmation du mot du passe<br />
        <input type="text" name="firstname" id="firstname" placeholder="" />Prénom<br />
        <input type="text" name="lastname" id="lastname" placeholder="" />Nom<br />
        <input type="file" name="pic_url" id="pic_url" placeholder="" />Image<br />
        <input type="text" name="phone" id="phone" placeholder="" />Téléphone<br />
        <input type="text" name="building" id="building" placeholder="" />Batiment<br />
        <input type="text" name="floor" id="floor" placeholder="" />Etage<br />
        <input type="text" name="location" id="location" placeholder="" />Position<br />
        <input type="submit" value="Enregistrer les modifications" />
        <a href="index.php"><input type="button" value="Annuler" /></a>
      </p>
    </form>
  </body>
</html>
