<?php

class BasicAuth
{
  private $auth = null;

  public function __construct($authenticate = null)
  {
    $this->auth = $authenticate;
  }

  public function unauthorized(){
    header('HTTP/1.0 401 Unauthorized');
    return $this;
  }

  public function wantToBasicAuth(){
    header('WWW-Authenticate: Basic realm="Statingow"');
    return $this;
  }

  public function authenticate($user,$pass){
    if(!$this->auth == null)
      return ($this->auth)($user,$pass);
    return true;
  }

  public function isAuthenticated(){
    if(isset($_SERVER['PHP_AUTH_USER']) &&
       isset($_SERVER['PHP_AUTH_PW']) &&
       $this->authenticate($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']))
      return true;
    else
      return false;
  }

  public function isAuthenticatedElseDoAuthenticate(){
    if($this->isAuthenticated())
      return true;
      
    $this->unauthorized()
         ->wantToBasicAuth();
    return false;
  }
}

?>
