# Statingow
PHP Website Statistics Script
Minimum Requirements: PHP 7.0

## How it works?
System create a JS content (at "URL/?client") that loaded on pages and send information to the server (on "URL/?get"). After a period collected information on database is processed with an script that run from server and new information is saved in database again.
Command that executed from server:

```
$ php /Path/To/index.php --period
```

#### Note
To execution command on server at specified period you can use Cronjob on UNUX-Like operating systems or Scheduled Tasks on MS-Windows operating systems.

## Extensions
There is every thing is extension! Extensions create URL/?client 's JS file, collecting statistical data and processing collected data after a while.

#### How To Create Extension?
There is a "StatExtension" class at Stat/StatExtension.php. If you want to create extension you should create a class from "StatExtension" and override "getClientJS", "doOnPeriodProcess" and "doOnSaveUserdata" methodes. Then you can add your extension to Statingow like this at "StatSetup.php" with using "addExtention" method:

```php
require_once "Extentions/MainExtension.php";

$Statistics = new Stat($DB); // <- $DB is database connection
$Statistics->addExtention(new MainExtension('http://localhost/Statingow',$DB));
```

There is we are adding "MainExtension" from "Extentions/MainExtension.php" to Statingow.
