<?php
require_once "Extentions/MainExtension.php";

$Statistics = new Stat($DB);
$Statistics->addExtention(new MainExtension('http://localhost/Statingow',$DB));
?>
