<?php
require_once './include/common.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;


$serverUrl = 'http://172.17.0.3:4444';

// Chrome
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
$driver->manage()->deleteAllCookies();
$window = $driver->manage()->window();
$window->maximize();



$query  = "Select Csymbol,id from stocklist where tickertape = '' ";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$row = mysqli_fetch_all($result);

foreach ($row as $data) {

  $company =  $data[0];
  $sid = $data[1];
  $driver->get("https://groww.in/stocks");
  $element = $driver->findElement(WebDriverBy::xpath("//input[contains(@id,'globalSearch')]"));
  $driver->wait(10, 1000)->until(WebDriverExpectedCondition::visibilityOf($element));
  $driver->findElement(WebDriverBy::xpath("//input[contains(@id,'globalSearch')]"))->sendKeys($company);

  sleep(5);

  $driver->findElement(WebDriverBy::xpath("//div[contains(@class,'SuggestionText')]"))->click();

  sleep(10);
  $ticker_url =  $driver->getCurrentURL();

  echo $query = "UPDATE stocklist SET tickertape='$ticker_url' WHERE id = '$sid'";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


}

$driver->close();


?>
