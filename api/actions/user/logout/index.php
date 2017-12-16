<?php
  session_start();
  $res = [];
  echo json_encode($res);
  session_destroy();
  exit();
 ?>
