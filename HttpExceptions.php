<?php

class HttpException extends Exception
{
  public $errorCode;
  function __construct($ErrorCode)
  {
    parent::__construct("Http Error ({$ErrorCode})");
    $this->errorCode = $ErrorCode;
  }

  function showOutput(){
    echo json_encode(array($this->errorCode));
    header('Content-Type: application/json');
    header($this->loadCorrectHeader());
  }

  function loadCorrectHeader(){
    switch ($this->errorCode) {
      case 404:
        return "HTTP/1.0 404 Not Found";
      case 403:
      case 503:
      case 500:
    }
    return '';
  }
}

?>
