<?php
if(isset($_GET['get'])){
  $pageToLoad = 'Control/get.php';
}
elseif(isset($_GET['client'])) {
  $pageToLoad = 'Control/client.php';
}
elseif(isset($argv[1]) && $argv[1] == '--period') {
  $pageToLoad = 'Control/period.php';
}
else{
  throw new HttpException(404);
}
?>
