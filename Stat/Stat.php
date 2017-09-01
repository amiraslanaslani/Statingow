<?php
require_once __DIR__ . '/DatabaseConnected.php';
require_once __DIR__ . '/StatExtension.php';

class Stat extends DatabaseConnected
{
  private $Extensions = array();

  public function saveUserData(){
    foreach ($this->Extensions as $Extension) {
      $Extension->doOnSaveUserdata();
    }
  }

  public function addExtention($Extension){
    if(is_subclass_of($Extension,'StatExtension')){
      $this->Extensions[] = $Extension;
    }
    else{
      throw new Exception("This is not an extention!", 1);
    }
  }

  public function loadClientJS(){
    $JSClient = file_get_contents(__DIR__ . "/Client.js");
    foreach ($this->Extensions as $Extension) {
      $JSClient .= $Extension->getClientJS() . "\n\r";
    }
    return $JSClient;
  }

  public function periodProcess(){
    foreach ($this->Extensions as $Extension) {
      $Extension->doOnPeriodProcess($this->DB);
    }
  }

  public function getApiOutput(){
    $output = array();
    foreach ($this->Extensions as $Extension) {
      $Extension->setAPIOutput(&$output);
    }
    return json_encode($output);
  }
}

?>
