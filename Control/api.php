<?php
require_once "Stat/BasicAuth.php";

$AuthUser = function($user, $pass){

};

$Auth = new BasicAuth($AuthUser);
if($Auth->isAuthenticatedElseDoAuthenticate()){
  echo $Statistics->getApiOutput();
  header('Content-Type: application/json');
}
?>
