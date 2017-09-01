<?php
require_once "Stat/BasicAuth.php";

$AuthUser = function($user, $pass){
  $u = 'aslan';
  $p = '123';
  if($uset == $u && $pass == $p)
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
