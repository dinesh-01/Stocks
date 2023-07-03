<?php
require_once './include/common.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;

#reseting the dailyentry
if($argv[1] == "reset") {
  $query = "UPDATE stocklist SET dailyEntry='no'";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
}


 $query  = "Select id,tickertape from stocklist where dailyEntry = 'no' ";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$records = $result->fetch_all(MYSQLI_ASSOC);


// Set up desired capabilities
$capabilities = DesiredCapabilities::chrome();


$serverUrl = 'http://172.17.0.3:4444';

// Chrome
$driver = RemoteWebDriver::create($serverUrl, $capabilities);
$window = $driver->manage()->window();
$window->maximize();

$new = "No New Stocks Today";
$date = date('d-m-Y');

foreach ($records as $record) {

 echo $url =  $record['tickertape'];


    $driver->manage()->deleteAllCookies();
    echo "\n";
    $driver->get($url);
    sleep("10");
    
   /* $element = $driver->findElement(WebDriverBy::xpath("//span[@id='week52lowVal']"));
    $driver->wait(10, 1000)->until(WebDriverExpectedCondition::visibilityOf($element));
    //sleep(5);
    $open     = $driver->findElement(WebDriverBy::xpath("(//table[@id='priceInfoTable']//tr/td)[1]"))->getText();
    $high     = $driver->findElement(WebDriverBy::xpath("(//table[@id='priceInfoTable']//tr/td)[2]"))->getText();
    $low      = $driver->findElement(WebDriverBy::xpath("(//table[@id='priceInfoTable']//tr/td)[3]"))->getText();
    $chng     = $driver->findElement(WebDriverBy::xpath("(//span[@id='priceInfoStatus']/span)[0]"))->getText();
    $chng_per = $driver->findElement(WebDriverBy::xpath("(//span[@id='priceInfoStatus']/span)[1]"))->getText();
    $volume   = $driver->findElement(WebDriverBy::xpath("//td[@id='tradevolshare']//following-sibling::td/span"))->getText();
    $value    = $driver->findElement(WebDriverBy::xpath("//td[@id='tradevalshare']//following-sibling::td/span"))->getText();
    $alllow   = $driver->findElement(WebDriverBy::xpath("//span[@id='week52lowVal']"))->getText();
    $allhigh  = $driver->findElement(WebDriverBy::xpath("//span[@id='week52highVal']"))->getText();
    $close    = $driver->findElement(WebDriverBy::xpath("(//table[@id='priceInfoTable']//tr/td)[4]"))->getText();

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


  */

}


$driver->close();


?>
