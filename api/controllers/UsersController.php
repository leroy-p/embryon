<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/models/User.php";
require "$root/embryon/api/functions/jsonFunctions.php";
require "$root/embryon/api/functions/formatFunctions.php";

class UsersController {
  // /user/signup POST
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

  // /user/login POST
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

  // /user/edit POST
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

  // /user/getUser?id=x GET
  public function getUser($id) {
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE id = $id";
    $res = dbQuery($db, $query);
    if ($res->fetchColumn(0) == 0) {
      return createGetUserResponse(0, "User not found.", null);
    }
    $data["id"] = $id;
    $user = new User($data, "get");
    return createGetUserResponse(1, "Success.", json_decode($user->serialize()));
  }

  // /user/getAll GET
  public function getAll() {
    $db = dbConnect();
    $query = "SELECT * FROM users";
    $res = dbQuery($db, $query);
    $users = [];
    foreach ($res as $user) {
      $users[] = $user;
    }
    return createGetAllResponse(1, "Success.", $users);
  }
}
 ?>
