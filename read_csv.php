<?php
require_once './include/common.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use League\Csv\Reader;
use League\Csv\Statement;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;


$serverUrl = 'http://localhost:4444';

// Chrome
$chromeOptions = new ChromeOptions();
#$chromeOptions->addArguments(['--headless']);
$capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
$driver = RemoteWebDriver::create($serverUrl, $capabilities);

$csv = Reader::createFromPath('data/MW-NIFTY-200-30-Jul-2021.csv', 'r');
$csv->setHeaderOffset(0); //set the CSV header offset

$stmt = Statement::create()->offset(1)->limit(300);

$records = $stmt->process($csv);

$new = "No New Stocks Today";
$date = date('d-m-Y');

#$query = "UPDATE stocklist SET dailyEntry='no'";

foreach ($records as $record) {



  $symbol =  $record['SYMBOL '];
  $symbol = urlencode($symbol);
  $open =    str_replace( ',', '', $record['OPEN '] );
  $high =    str_replace( ',', '', $record['HIGH '] );
  $low =     str_replace( ',', '', $record['LOW '] );
  $chng =    str_replace( ',', '', $record['CHNG '] );
  $chng_per =  $record['%CHNG '];
  $volume =  str_replace( ',', '', $record['VOLUME (shares)'] );
  $value =   str_replace( ',', '', $record['VALUE '] );
  $alllow =  str_replace( ',', '', $record['52W L '] );
  $allhigh = str_replace( ',', '', $record['52W H '] );


  $query  = "Select id from stocklist where Csymbol = '$symbol' and dailyEntry = 'no' ";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
  $row = mysqli_fetch_assoc($result);

  if(!empty($row['id'])) {

    $driver->manage()->deleteAllCookies();
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
