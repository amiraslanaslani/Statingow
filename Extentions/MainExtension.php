<?php

class MainExtension extends StatExtension
{
  private $URL;
  private $DB;

  public function __construct($URL,$DB)
  {
    $this->DB = $DB;
    $this->URL = $URL;
  }
  public function doOnPeriodProcess($DatabaseConnection){
    echo 'All Removed From TMP';
    //$this->DB->query("DELETE FROM `" + MainExtention::tmpTable + "` WHERE 1");
  }
  public function doOnSaveUserdata($DataSendedByClient){
    $url = $_POST['url'];
    $ip = getRealIpAddr();

    $this->DB->query("INSERT INTO `" . MainExtention::tmpTable . "`
                      (`url`, `ip`, `date`, `time`) VALUES
                      ('{$url}','{$ip}',CURDATE(),CURTIME())");
  }
  public function getClientJS(){
    return "
      var Parameters = {
        url: statedPage
      }
      function sendStat(statedPage){
        var ajax = $.post(
          '{$this->URL}/?get',
          Parameters
        )
      }
      $(function(){
        sendStat(window.location);
      }
    ";
  }
}

function getRealIpAddr()
{
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>