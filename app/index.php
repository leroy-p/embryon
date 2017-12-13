<?php
session_start();
if (isset($_SESSION["user_id"])) {
  header("Location: user");
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
    <h2>S'inscrire</h2>
    <form action="actions/user/signup.php" method="post">
      <p>
        <input type="email" name="email" id="signup_email" />Email<br />
        <input type="password" name="password" id="signup_password" />Mot de passe<br />
        <input type="password" name="confirmation" id="login_confirmation" />Confirmation du mot du passe<br />
        <input type="submit" value="S'inscrire" />
      </p>
    </form>
    <br />
    <br />
    <br />
    <h2>Se connecter</h2>
    <form action="actions/user/login.php" method="post">
      <p>
        <input type="email" name="email" id="login_email" />Email<br />
        <input type="password" name="password" id="login_password" />Mot de passe<br />
        <input type="submit" value="Connexion" />
      </p>
    </form>
  </body>
</html>
