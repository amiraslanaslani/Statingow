<?php
require_once __DIR__ . '/DatabaseConnected.php';
require_once __DIR__ . '/StatExtention.php';

class Stat extends DatabaseConnected
{
  private $Extentions = array();
  public const tmpTable = '';
  public const primaryTable = '';

  function saveUserData($DataSendedByClient){
    foreach ($this->Extentions as $Extention) {
      $Extention->doOnSaveUserdata(&$DataSendedByClient);
    }
  }

  function addExtention($Extention){
    if(is_subclass_of($Extention,'StatExtention')){
      $this->Extentions[] = $Extention;
    }
    else{
      throw new Exception("This is not an extention!", 1);
    }
  }

  function loadJSClient(){
    $JSClient = file_get_contents(__DIR__ . "/Client.js");
    foreach ($this->Extentions as $Extention) {
      $JSClient .= $Extention->getClientJS();
    }
  }

  function getAllCollectedDataAlongPeriod(){
    $Result = $this->DB->query("");
    return &$Result;
  }

  function checkPeriodEnds(){

  }

  function periodProcess(){
    foreach ($this->Extentions as $Extention) {
      $Extention->doOnPeriodProcess($this->DB);
    }
  }
}

?>
