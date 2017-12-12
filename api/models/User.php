<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/embryon/api/functions/dbFunctions.php";

class User {
  private $_id;
  private $_email;
  private $_password;
  private $_firstname;
  private $_lastname;
  private $_pic_url;
  private $_phone;
  private $_building;
  private $_floor;
  private $_location;
  private $_date_creation;
  private $_date_modification;
  private $_admin;
  private $_active;

  public function __construct($email, $password, $creation) {
    if ($creation)
      $this->create($email, $password);
    else
      $this->get($email);
  }

  public function create($email, $password) {
    $db = dbConnect();
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $res = dbQuery($db, $query);
    $this->id = $res["id"];
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

  public function getId() {
    return $this->id;
  }

  public function jsonSerialize() {
    return json_encode($this);
  }
}



 ?>
