<?php
require_once './include/common.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;


//https://www1.nseindia.com/content/historical/EQUITIES/2022/DEC/cm09DEC2022bhav.csv.zip
//https://www1.nseindia.com/products/content/equities/equities/homepage_eq.htm
$file = fopen('data/500.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

#$query = "UPDATE stocklist SET dailyEntry='no'";

$serverUrl = 'http://172.17.0.2:4444';

// Chrome
$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

$new = "No New Stocks Today";
$date = date('d-m-Y');


foreach ($records as $record) {


  /*

   [0] => SYMBOL
  [1] => OPEN
  [2] => HIGH
  [3] => LOW
  [4] => PREV. CLOSE
  [5] => LTP
  [6] => CHNG
  [7] => %CHNG
  [8] => VOLUME (shares)
  [9] => VALUE
  [10] => 52W H
  [11] => 52W L

  */


  $symbol =  $record[2];


  $query  = "Select id from stocklist where Csymbol = '$symbol' and dailyEntry = 'no' ";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row = mysqli_fetch_assoc($result);

  if(!empty($row['id'])) {

    $driver->manage()->deleteAllCookies();
    #$driver->get("https://www.nseindia.com/get-quotes/equity?symbol=$symbol");
    $symbol_url = urlencode($symbol);
    echo $url = "https://www1.nseindia.com/live_market/dynaContent/live_watch/get_quote/GetQuote.jsp?symbol=$symbol_url";
    echo "\n";
    $driver->get($url);
    sleep(2);
    $element = $driver->findElement(WebDriverBy::xpath("//div[@id='closePrice']"));
    $driver->wait(10, 1000)->until(WebDriverExpectedCondition::visibilityOf($element));
    $open     = $driver->findElement(WebDriverBy::xpath("//div[@id='open']"))->getText();
    $high     = $driver->findElement(WebDriverBy::xpath("//div[@id='dayHigh']"))->getText();
    $low      = $driver->findElement(WebDriverBy::xpath("//div[@id='dayLow']"))->getText();
    $chng     = $driver->findElement(WebDriverBy::xpath("//span[@id='change']"))->getText();
    $chng_per = $driver->findElement(WebDriverBy::xpath("//a[@id='pChange']"))->getText();
    $volume   = $driver->findElement(WebDriverBy::xpath("//span[@id='tradedVolume']"))->getText();
    $value    = $driver->findElement(WebDriverBy::xpath("//span[@id='tradedValue']"))->getText();
    $alllow   = $driver->findElement(WebDriverBy::xpath("//span[@id='low52']"))->getText();
    $allhigh  = $driver->findElement(WebDriverBy::xpath("//span[@id='high52']"))->getText();
    $close    = $driver->findElement(WebDriverBy::xpath("//div[@id='closePrice']"))->getText();

    $open =    str_replace( ',', '', $open );
    $high =    str_replace( ',', '', $high );
    $low =     str_replace( ',', '', $low );
    $chng =    str_replace( ',', '', $chng );
    $volume =  str_replace( ',', '', $volume );
    $value =   str_replace( ',', '', $value );
    $alllow =  str_replace( ',', '', $alllow );
    $allhigh = str_replace( ',', '', $allhigh );
    $close = str_replace( ',', '', $close );


    $sid = $row['id'];
    $query = "INSERT INTO stockvalues(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockValues, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_per','$volume','$value','$date')";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    $query = "UPDATE stocklist SET dailyEntry='yes' WHERE id = '$sid'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

  }

}

$driver->close();
?>
