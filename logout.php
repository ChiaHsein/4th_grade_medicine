<?php
  session_start();
  
  unset($_SESSION["account"]);
  unset($_SESSION["password"]);
 
  session_unset();
  echo "登出成功";
 
?>