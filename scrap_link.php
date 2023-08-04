<?php
require_once './include/common.php';

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;




// Chrome
$serverUrl = 'http://localhost:4444'; // if you don't start chromedriver with "--port=4444" as above, default port will be 9515
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
$window = $driver->manage()->window();
$window->maximize();



$query  = "Select Csymbol,id,murl from stocklist where mcurl = '' ";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$row = mysqli_fetch_all($result);

foreach ($row as $data) {

  $company =  $data[0];
  $sid = $data[1];
  $google = $data[2];
  $driver->get($google);
  sleep(5);

  $driver->findElement(WebDriverBy::xpath("(//a[contains(@href,'https://www.moneycontrol.com/india/stockpricequote')])[1]"))->click();

  sleep(10);
  $ticker_url =  $driver->getCurrentURL();

  echo $query = "UPDATE stocklist SET mcurl='$ticker_url' WHERE id = '$sid'";
  echo "\n";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


}

$driver->close();


?>
