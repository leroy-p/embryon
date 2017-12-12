<?php
session_start();
if (isset($_SESSION["user_id"])) {
  header("Location: profile.php");
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
    <h2>S'inscrire</h2>
    <form action="signup.php" method="post">
      <p>
        <input type="email" name="email" id="signup_email" />Email<br />
        <input type="password" name="password" id="signup_password" />Password<br />
        <input type="submit" value="S'inscrire" />
      </p>
    </form>
    <br />
    <br />
    <br />
    <h2>Se connecter</h2>
    <form action="login.php" method="post">
      <p>
        <input type="email" name="email" id="login_email" />Email<br />
        <input type="password" name="password" id="login_password" />Password<br />
        <input type="submit" value="Connexion" />
      </p>
    </form>
  </body>
</html>
