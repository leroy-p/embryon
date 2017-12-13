<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/models/User.php";
require "$root/embryon/api/functions/jsonFunctions.php";

class UsersController {
  public function signup($email, $password, $confirmation) {
    if (strcmp($password, $confirmation) != 0) {
      return createUserReponse(0, "Le mot de passe et la confirmation ne correspondent pas.", null);
    }
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$email'";
    $res = dbQuery($db, $query);
    $response = [];
    if ($res->fetchColumn(0) == 1) {
      return createUserReponse(0, "Email déjà utilisé.", null);
    }
    else {
      $data["email"] = $email;
      $data["password"] = $password;
      $user = new User($data, "create");
      return createUserReponse(1, "Utilisateur créé.", $user->getId());
    }
  }

  public function login($email, $password) {
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$email' AND password = '$password'";
    $res = dbQuery($db, $query);
    if ($res->fetchColumn(0) == 0) {
      return createUserReponse(0, "Email ou mot de passe incorrect.", null);
    }
    else {
      $data["email"] = $email;
      $user = new User($data, "get");
      return createUserReponse(1, "Utilisateur connecté.", $user->getId());
    }
  }

  public function edit($data, $id) {
    print_r[$data];
  }
}
 ?>
