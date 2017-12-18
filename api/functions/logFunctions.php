<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/embryon/api/functions/dbFunctions.php";
$logFile = "$root/embryon/api/logs/logs.txt";
function printString($string) {
  echo $string;
  echo "<br />";
}

function printArray($array) {
  print_r($array);
  echo "<br />";
}

function logString($string) {
  $date = date("Y-m-d H:i:s");
  $message = "[" . $date . "][DEBUG] : $string\n";
  file_put_contents($GLOBALS["logFile"], $message, FILE_APPEND);
}

function arrayToString($array) {
  $message = "array(";
  $count = 0;
  foreach ($array as $key => $value) {
    if ($count > 0) {
      $message .= ", ";
    }
    ++$count;
    if (is_string($value) && strncmp($value, "array(", 6)) {
      $message .= "['$key'] => '$value'";
    }
    else {
      $message .= "['$key'] => $value";
    }
  }
  $message .= ")";
  return $message;
}

function logArray($array) {
  $date = date("Y-m-d H:i:s");
  $string = arrayToString($array);
  $message = "[$date][DEBUG] : $string\n";
  file_put_contents($GLOBALS["logFile"], $message, FILE_APPEND);
}

function logRequest($url, $data, $method) {
  $date = date("Y-m-d H:i:s");
  $string = arrayToString($data);
  $message = "[$date][REQUEST][$url][$method] : $string\n";
  file_put_contents($GLOBALS["logFile"], $message, FILE_APPEND);
}

function logResponse($data, $url) {
  foreach ($data as $key => $value) {
    if (!strcmp($key, "user") || !strcmp($key, "item")) {
        $data[$key] = arrayToString($value);
    }
    else if (!strcmp($key, "users") || !strcmp($key, "items")) {
      $i = 0;
      while ($i < count($data[$key])) {
        $data[$key][$i] = arrayToString($data[$key][$i]);
        ++$i;
      }
      $data[$key] = arrayToString($data[$key]);
    }
  }
  $date = date("Y-m-d H:i:s");
  $string = arrayToString($data);
  $message = "[$date][RESPONSE][$url] : $string\n";
  file_put_contents($GLOBALS["logFile"], $message, FILE_APPEND);
}
?>
