<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/models/User.php";
require "$root/embryon/api/functions/jsonFunctions.php";
require "$root/embryon/api/functions/formatFunctions.php";

class UsersController {
  public function signup($email, $password, $confirmation) {
    if (strcmp($password, $confirmation) != 0) {
      return createUserResponse(0, "Le mot de passe et la confirmation ne correspondent pas.", null);
    }
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$email'";
    $res = dbQuery($db, $query);
    $response = [];
    if ($res->fetchColumn(0) == 1) {
      return createUserResponse(0, "Email déjà utilisé.", null);
    }
    $data["email"] = $email;
    $data["password"] = $password;
    $user = new User($data, "create");
    return createUserResponse(1, "Utilisateur créé.", $user->getId());
  }

  public function login($email, $password) {
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$email' AND password = '$password'";
    $res = dbQuery($db, $query);
    if ($res->fetchColumn(0) == 0) {
      return createUserResponse(0, "Email ou mot de passe incorrect.", null);
    }
    $data["email"] = $email;
    $user = new User($data, "get");
    return createUserResponse(1, "Utilisateur connecté.", $user->getId());
  }

  public function edit($data, $id) {
    echo $data["pic_url"] . "<br />";
    if (strcmp($data["password"], $data["confirmation"]) != 0) {
      return createUserResponse(0, "Le mot de passe et la confirmation ne correspondent pas.", null);
    }
    if (strlen($data["phone"]) > 0 && !isPhoneNumber($data["phone"])) {
      return createUserResponse(0, "Le numéro de téléphone est invalide.", null);
    }
    if (strlen($data["pic_url"]) > 0 && !isImg($data["pic_url"])) {
      return createUserResponse(0, "Le format d'image est invalide.", null);
    }
    $data["id"] = $id;
    $user = new User($data, "edit");
    return createUserResponse(1, "Modifications enregistrées.", $id);
  }
}
 ?>
