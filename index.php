<?php
require_once "HttpExceptions.php";
require_once "config.php";
require_once "Stat/Stat.php";

try {
  $DB = @new mysqli( DATABASE['HOST'],
                     DATABASE['USERNAME'],
                     DATABASE['PASSWORD'],
                     DATABASE['DATABASE']);
  if($DB->connect_error){
    throw new Exception("Database Error: " . $DB->connect_error);
  }
  require "StatSetup.php";
  require_once "router.php";
  include $pageToLoad;
} catch (HttpException $e) {
  $e->showOutput();
}



?>
