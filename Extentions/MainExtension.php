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

    $this->DB->query("DELETE FROM `" . MainExtension::tmpTable . "` WHERE 1");
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

  public function setAPIOutput(& $output){
    $output['PagesVisits'] = $this->getAllPagesVisits();
    $output['WebsiteVisits'] = $this->getWebsiteVisits();
  }

  public function getAllPagesVisits()
  {
    $list = array();
    $result = $this->DB->query("SELECT `date`, `url`, `view`
                                FROM `each_page_view`
                                ORDER BY `date` DESC
                                LIMIT 10000");

    while($row = $result->fetch_assoc()){
      $list[] = $row;
    }
    return $list;
  }

  public function getWebsiteVisits()
  {
    $list = array();
    $result = $this->DB->query("SELECT `date`, `view`
                                FROM `days_view`
                                ORDER BY `date` DESC
                                LIMIT 1000");
    while($row = $result->fetch_assoc()){
      $list[] = $row;
    }
    return $list;
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
