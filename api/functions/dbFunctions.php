<?php
function dbConnect() {
  try {
    $db = new PDO("mysql:host=localhost;dbname=embryon;charset=utf8", "root", "");
  }
  catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
  }
  return $db;
}

function dbQuery($db, $query) {
  try {
    $res = $db->query($query);
  }
  catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
  }
  return $res;
}

function getLastInsertId($db) {
  try {
    $res = $db->lastInsertId();
  }
  catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
  }
  return $res;
}
?>
