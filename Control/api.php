<?php
require_once "Stat/BasicAuth.php";

$AuthUser = function($user, $pass){
  if($user == USERNAME && $pass == PASSWORD)
    return true;
  else
    return false;
};

$Auth = new BasicAuth($AuthUser);
if($Auth->isAuthenticated()){
  echo $Statistics->getApiOutput();
  header('Content-Type: application/json');
}
else{
  $Auth->unauthorized()
       ->wantToBasicAuth();
}
?>
