<?php
function isPhoneNumber($number) {
  return is_numeric($number) && strlen($number) == 10 && strncmp($number, "0", 1) == 0;
}

function isImg($str) {
  $imgFormats = [
    ".jpg",
    ".png",
    ".svg",
    ".bmp",
    ".ico"
  ];
  $ext = substr($str, -4);
  foreach ($imgFormats as $value) {
    if (strcmp($ext, $value) == 0) {
      return true;
    }
  }
  return false;
}

function isPassword($str) {
  return preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $str);
}

function createGetUrl($url, $req) {
  $count = 0;
  foreach ($req as $key => $value) {
    $url .= $count ? "&" : "?";
    ++$count;
    $url .= "$key=$value";
  }
  return $url;
}
1?>
