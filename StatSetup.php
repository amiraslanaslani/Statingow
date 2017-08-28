<?php
require_once "Extentions/MainExtention.php";

$Statistics = new Stat($DB);
$Statistics->addExtention(new MainExtention('http://localhost/Statingow',$DB));
?>
