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
    $this->DB->query("INSERT INTO `days_view` (`date`, `view`)
                      SELECT `date`,COUNT(DISTINCT `ip`)
                      FROM `tmp`");

    $this->DB->query("INSERT INTO `each_page_view` (`date`, `url`, `view`)
                      SELECT `date`,`url`,COUNT(`ip`)
                      FROM `tmp`
                      GROUP BY `url`");

    echo 'All Removed From TMP';
    //$this->DB->query("DELETE FROM `" + MainExtention::tmpTable + "` WHERE 1");
  }
  public function doOnSaveUserdata(){
    $url = isset($_POST['url'])?$_POST['url']:'';
    $ip = getRealIpAddr();

    $this->DB->query("INSERT INTO `" . MainExtension::tmpTable . "`
                      (`url`, `ip`, `date`, `time`) VALUES
                      ('{$url}','{$ip}',CURDATE(),CURTIME())");
    echo "INSERT INTO `" . MainExtension::tmpTable . "`
                      (`url`, `ip`, `date`, `time`) VALUES
                      ('{$url}','{$ip}',CURDATE(),CURTIME())";
  }
  public function getClientJS(){
    return "
      function sendStat(statedPage){
        var Parameters = {
          url: statedPage
        }
        var ajax = $.post(
          '{$this->URL}/?get',
          Parameters
        )

      }
      $(document).ready(function($){
        sendStat(window.location.href);
      });
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
