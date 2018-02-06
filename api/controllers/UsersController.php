<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/models/User.php";
require_once "$root/embryon/api/functions/jsonFunctions.php";
require_once "$root/embryon/api/functions/formatFunctions.php";

class UsersController {
  /*
    http://localhost/embryon/api/actions/user/login
    POST
    request :
    {
      "email": required,
      "password": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }
  */
  public function login($req) {
    if (isset($req["password"])) {
      $req["password"] = md5($req["password"]);
    }
    $url = "http://localhost/embryon/api/actions/user/login";
    logRequest($url, $req, "POST");
    $requiredColumns = ["email", "password"];
    foreach ($requiredColumns as $value) {
      if (!isset($req[$value])) {
        return createResponse($url, -1, mb_convert_case($value, MB_CASE_TITLE, "UTF-8") . " required.", 0);
      }
      if (!$req[$value]) {
        return createResponse($url, -1, mb_convert_case($value, MB_CASE_TITLE, "UTF-8") . " required.", 0);
      }
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE active = 2 AND email = '$req[email]' AND password = '$req[password]'";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "Incorrect email or password.", 0);
    }
    return createResponse($url, 1, "User logged in.", $res);
  }

  /*
    http://localhost/embryon/api/actions/user/add
    POST
    request :
    {
      "email": required,
      "password": required,
      "confirmation": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }
  */
  public function add($req) {
    $url = "http://localhost/embryon/api/actions/user/add";
    logRequest($url, $req, "POST");
    $requiredColumns = ["email", "password", "confirmation"];
    foreach ($requiredColumns as $value) {
      if (!isset($req[$value])) {
        return createResponse($url, -1, mb_convert_case($value, MB_CASE_TITLE, "UTF-8") . " required.", 0);
      }
      if (!$req[$value]) {
        return createResponse($url, -1, mb_convert_case($value, MB_CASE_TITLE, "UTF-8") . " required.", 0);
      }
    }
    if (!isEmail($req["email"])) {
      return createResponse($url, 0, "Invalid email.", 0);
    }
    if (!isPassword($req["password"])) {
      return createResponse($url, 0, "Invalid password.", 0);
    }
    $req["password"] = md5($req["password"]);
    $req["confirmation"] = md5($req["confirmation"]);
    if (strcmp($req["password"], $req["confirmation"]) != 0) {
      return createResponse($url, 0, "Password and confirmation are different.", 0);
    }
    $db = dbConnect();
    $query = "SELECT COUNT(*) FROM users WHERE email = '$req[email]'";
    $res = dbQuery($db, $query);
    if ($res->fetchColumn(0) == 1) {
      return createResponse($url, 0, "Email already taken.", 0);
    }
    $token = date("HisYmd") . strtoupper(substr($req["email"], 0, 2));
    $user = new User();
    $user->add($token, $req["email"], $req["password"]);
    $query = "SELECT id FROM users WHERE email = '$req[email]'";
    $id = dbQuery($db, $query)->fetchColumn(0);
    return createResponse($url, 1, "User created.", $id);
  }

  /*
    http://localhost/embryon/api/actions/user/edit
    POST
    request :
    {
      "id": required,
      "firstname": optional,
      "lastname": optional,
      "pic_url": optional,
      "phone": optional,
      "building": optional,
      "floor": optional,
      "location": optional
    }
    response :
    {
      "status",
      "message",
      "id"
    }
  */
  public function edit($req) {
    $url = "http://localhost/embryon/api/actions/user/edit";
    logRequest($url, $req, "POST");
    if (!isset($req["id"])) {
      return createResponse($url, -1, "Id required.", 0);
    }
    if (!$req["id"]) {
      return createResponse($url, -1, "Id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "User not found.", 0);
    }
    if (isset($req["phone"]) && strlen($req["phone"]) > 0 && !isPhoneNumber($req["phone"])) {
      return createResponse($url, 0, "Invalid phone number.", 0);
    }
    if (isset($req["pic_url"]) && strlen($req["pic_url"]) > 0 && !isImg($req["pic_url"])) {
      return createResponse($url, 0, "Invalid image format.", 0);
    }
    $user = new User();
    $user->edit($req);
    return createResponse($url, 1, "User updated.", $req["id"]);
  }

  /*
    http://localhost/embryon/api/actions/user/delete
    POST
    request :
    {
      "id": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }
  */
  public function delete($req) {
    $url = "http://localhost/embryon/api/actions/user/delete";
    logRequest($url, $req, "POST");
    if (!isset($req["id"])) {
      return createResponse($url, -1, "Id required.", 0);
    }
    if (!$req["id"]) {
      return createResponse($url, -1, "Id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE active > 0 AND id = $req[id]";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "User not found.", 0);
    }
    $user = new User();
    $user->delete($req["id"]);
    return createResponse($url, 1, "User deleted.", $req["id"]);
  }

  /*
    http://localhost/embryon/api/actions/user/confirmEmail
    POST
    request :
    {
      "token": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }
  */
  public function confirmEmail($req) {
    $url = "http://localhost/embryon/api/actions/user/confirmEmail";
    logRequest($url, $req, "POST");
    if (!isset($req["token"])) {
      return createResponse($url, -1, "Token required.", 0);
    }
    if (!$req["token"]) {
      return createResponse($url, -1, "Token required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE token = '$req[token]'";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "User not found.", 0);
    }
    $user = new User();
    $user->confirmEmail($req["token"]);
    return createResponse($url, 1, "Email confirmed.", $res);
  }

  /*
    http://localhost/embryon/api/actions/user/setPassword
    POST
    request :
    {
      "token": required,
      "old_password": required,
      "password": required,
      "confirmation": required
    }
    response :
    {
      "status",
      "message",
      "id"
    }
  */
  public function editPassword($req) {
    $url = "http://localhost/embryon/api/actions/user/setPassword";
    logRequest($url, $req, "POST");
    $requiredColumns = ["token", "password", "confirmation"];
    foreach ($requiredColumns as $value) {
      if (!isset($req[$value])) {
        return createResponse($url, -1, mb_convert_case($value, MB_CASE_TITLE, "UTF-8") . " required.", 0);
        if (!$req[$value]) {
          return createResponse($url, -1, mb_convert_case($value, MB_CASE_TITLE, "UTF-8") . " required.", 0);
        }
      }
    }
    if (!isPassword($req["password"])) {
      return createResponse($url, 0, "Invalid password.", 0);
    }
    $req["password"] = md5($req["password"]);
    $req["confirmation"] = md5($req["confirmation"]);
    if (strcmp($req["password"], $req["confirmation"]) != 0) {
      return createResponse($url, 0, "Password and confirmation are different.", 0);
    }
    $db = dbConnect();
    $query = "SELECT id FROM users WHERE token = '$req[token]'";
    $res = dbQuery($db, $query)->fetchColumn(0);
    if (!$res) {
      return createResponse($url, 0, "User not found.", 0);
    }
    $user = new User();
    $user->editPassword($req["token"], $req["password"]);
    return createResponse($url, 1, "Password updated.", $res);
  }

  /*
    http://localhost/embryon/api/actions/user/getUser?id=$id
    GET
    response :
    {
      "status",
      "message",
      "user": {
                "id",
                "email",
                "password",
                "firstname",
                "lastname",
                "pic_url",
                "phone",
                "building",
                "floor",
                "location",
                "date_creation",
                "date_modification",
                "admin",
                "active"
              }
    }
  */
  public function getUser($req) {
    if (!isset($req["id"])) {
      $url = "http://localhost/embryon/api/actions/user/getUser?id=";
      logRequest($url, $req, "GET");
      return createResponse($url, -1, "Id required.", 0);
    }
    $url = "http://localhost/embryon/api/actions/user/getUser?id=$req[id]";
    logRequest($url, $req, "GET");
    if (!$req["id"]) {
      return createResponse($url, -1, "Id required.", 0);
    }
    $db = dbConnect();
    $query = "SELECT * FROM users WHERE active = 2 AND id = $req[id]";
    $res = dbQuery($db, $query)->fetch(PDO::FETCH_ASSOC);
    if (!$res) {
      return createGetUserResponse($url, 0, "User not found.", null);
    }
    return createGetUserResponse($url, 1, "Success.", $res);
  }

  /*
    http://localhost/embryon/api/actions/user/getAll
    GET
    response :
    {
      "status",
      "message",
      "users": [
                {
                  "id",
                  "email",
                  "password",
                  "firstname",
                  "lastname",
                  "pic_url",
                  "phone",
                  "building",
                  "floor",
                  "location",
                  "date_creation",
                  "date_modification",
                  "admin",
                  "active"
                },
                {
                  "id",
                  "email",
                  "password",
                  "firstname",
                  "lastname",
                  "pic_url",
                  "phone",
                  "building",
                  "floor",
                  "location",
                  "date_creation",
                  "date_modification",
                  "admin",
                  "active"
                },
                ...
              ]
    }
  */
  public function getAll() {
    $url = "http://localhost/embryon/api/actions/user/getAll";
    logRequest($url, [], "GET");
    $db = dbConnect();
    $query = "SELECT * FROM users WHERE active = 2";
    $res = dbQuery($db, $query);
    $users = [];
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      $users[] = $row;
    }
    return createGetAllUsersResponse($url, 1, "Success.", $users);
  }
}
?>
