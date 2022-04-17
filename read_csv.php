<?php
require_once './include/common.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;



$file = fopen('data/MW-NIFTY-200-17-Apr-2022.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  $records[] =  $line;
}
fclose($file);

array_shift($records); // Removing header

#$query = "UPDATE stocklist SET dailyEntry='no'";

$serverUrl = 'http://localhost:4444';

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


  $symbol =  $record[0];
  $symbol = urlencode($symbol);
  $open =    str_replace( ',', '', $record[1] );
  $high =    str_replace( ',', '', $record[2] );
  $low =     str_replace( ',', '', $record[3] );
  $chng =    str_replace( ',', '', $record[6] );
  $chng_per =  $record[7];
  $volume =  str_replace( ',', '', $record[8] );
  $value =   str_replace( ',', '', $record[9] );
  $alllow =  str_replace( ',', '', $record[11] );
  $allhigh = str_replace( ',', '', $record[10] );


  $query  = "Select id from stocklist where Csymbol = '$symbol' and dailyEntry = 'no' ";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row = mysqli_fetch_assoc($result);

  if(!empty($row['id'])) {

    $driver->manage()->deleteAllCookies();
    #$driver->get("https://www.nseindia.com/get-quotes/equity?symbol=$symbol");
    echo $url = "https://www1.nseindia.com/live_market/dynaContent/live_watch/get_quote/GetQuote.jsp?symbol=$symbol";
    echo "\n";
    $driver->get($url);
    sleep(2);
    $element = $driver->findElement(WebDriverBy::xpath("//div[@id='closePrice']"));
    $driver->wait(10, 1000)->until(WebDriverExpectedCondition::visibilityOf($element));
    $close  = $driver->findElement(WebDriverBy::xpath("//div[@id='closePrice']"))->getText();

    $sid = $row['id'];
    $query = "INSERT INTO stockvalues(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockValues, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_per','$volume','$value','$date')";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    $query = "UPDATE stocklist SET dailyEntry='yes' WHERE id = '$sid'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

  }

}


/*
$money_control = "https://www.google.com/search?q=".$symbol."+moneycontrol";
$charink = "https://chartink.com/stocks/$symbol.html";

$query  = "INSERT INTO stocklist(sName, cSymbol, murl, curl, ntype) VALUES ('$symbol','$symbol','$money_control','$charink','N200')";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
*/

$driver->close();
?>
