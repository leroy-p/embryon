<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/functions/dbFunctions.php";
require "$root/embryon/api/functions/queryFunctions.php";

$usersColumns = [
  "password",
  "firstname",
  "lastname",
  "pic_url",
  "phone",
  "building",
  "floor",
  "location"
];

class User {
  private $id;
  private $email;
  private $password;
  private $firstname;
  private $lastname;
  private $pic_url;
  private $phone;
  private $building;
  private $floor;
  private $location;
  private $date_creation;
  private $date_modification;
  private $admin;
  private $active;

  public function __construct($data, $mode) {
    if ($mode === "create") {
      $this->create($data["email"], $data["password"]);
    }
    else if ($mode === "get") {
      $this->get($data["email"]);
    }
    else if ($mode === "edit") {
      $this->edit($data["data"], $data["id"]);
    }
  }

  public function create($email, $password) {
    $db = dbConnect();
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $res = dbQuery($db, $query);
    $this->setId($db);
    $this->email = $email;
    $this->password = $password;
    $this->firstname = null;
    $this->lastname = null;
    $this->pic_url = null;
    $this->phone = null;
    $this->building = null;
    $this->floor = null;
    $this->location = null;
    $this->date_creation = date("Y-m-d H:i:s");
    $this->date_modification = date("Y-m-d H:i:s");
    $this->admin = 0;
    $this->active = 1;
  }

  public function get($email) {
    $db = dbConnect();
    $query = "SELECT * FROM users WHERE email = '$email'";
    $res = dbQuery($db, $query)->fetchAll()[0];
    $this->id = $res["id"];
    $this->email = $res["email"];
    $this->password = $res["password"];
    $this->firstname = $res["firstname"];
    $this->lastname = $res["lastname"];
    $this->pic_url = $res["pic_url"];
    $this->phone = $res["phone"];
    $this->building = $res["building"];
    $this->floor = $res["floor"];
    $this->location = $res["location"];
    $this->date_creation = $res["date_creation"];
    $this->date_modification = $res["date_modification"];
    $this->admin = $res["admin"];
    $this->active = $res["active"];
  }

  public function edit($data, $id) {
    $db = dbConnect();
    $query = createUsersQueryFromData($data, $id, $usersColumns);
    $res = dbQuery($db, $query)->fetchAll()[0];
    if ($data["password"]) $this->password = $data["password"];
    if ($data["firstname"]) $this->password = $data["firstname"];
    if ($data["lastname"]) $this->password = $data["lastname"];
    if ($data["pic_url"]) $this->password = $data["pic_url"];
    if ($data["phone"]) $this->password = $data["phone"];
    if ($data["building"]) $this->password = $data["building"];
    if ($data["location"]) $this->password = $data["location"];
  }

  public function getId() {
    return $this->id;
  }

  public function setId($db) {
    $query = "SELECT id FROM users WHERE email = '$this->email'";
    $this->id = dbQuery($db, $query)->fetchAll()[0]["id"];
  }
}
 ?>
