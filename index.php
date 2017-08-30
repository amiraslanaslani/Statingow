<?php
require_once "HttpExceptions.php";
require_once "config.php";
require_once "Stat/Stat.php";
require_once "StatSetup.php";

try {
  require_once "router.php";
  include $pageToLoad;
} catch (HttpException $e) {
  $e->showOutput();
}



?>
