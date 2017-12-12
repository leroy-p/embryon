<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/models/User.php";

class UsersController {
  public function signup($email, $password) {
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$email'";
    $res = dbQuery($db, $query);
    $response = [];
    if ($res->fetchColumn(0) == 1) {
      $response["status"] = 0;
      $response["message"] = "Email déjà utilisé.";
      $response["user_id"] = null;
      return json_encode($response);
    } else {
      $user = new User($email, $password, true);
      $response["status"] = 1;
      $response["message"] = "Utilisateur créé.";
      $response["user_id"] = $user->getId();
      return json_encode($response);
    }
  }

  public function login($email, $password) {
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$email' AND password = '$password'";
    $res = dbQuery($db, $query);
    if ($res->fetchColumn(0) == 0) {
      $response["status"] = 0;
      $response["message"] = "Email ou mot de passe incorrect.";
      $response["user_id"] = null;
      return json_encode($response);
    } else {
      $user = new User($email, $password, false);
      $response["status"] = 1;
      $response["message"] = "Utilisateur connecté.";
      $response["user_id"] = $user->getId();
      return json_encode($response);
    }
  }
}

 ?>
