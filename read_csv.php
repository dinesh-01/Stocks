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


$filename = 'data/MW-NIFTY-200-08-Aug-2023.csv'; // Replace with your file name or path
$date = date('d-m-Y');

// Open the CSV file for reading
$file = fopen($filename, 'r');

if ($file) {
    // Read the header row
    $header = fgetcsv($file);


    // Read and output the remaining rows
    while (($row = fgetcsv($file)) !== false) {

        $open     = $row[1];
        $high     = $row[2];
        $low      = $row[3];
        $prev_close = $row[4];
        $close  = $row[5];
        $chng   = $row[6];
        $chng_percentage = $row[7];
        $volume   = $row[8];
        $value    = $row[9];
        $alllow   = $row[10];
        $allhigh  = $row[11];

        $open =    str_replace( ',', '', $open );
        $high =    str_replace( ',', '', $high );
        $low =     str_replace( ',', '', $low );
        $prev_close =     str_replace( ',', '', $prev_close );
        $close = str_replace( ',', '', $close );
        $chng =    str_replace( ',', '', $chng );
        $volume =  str_replace( ',', '', $volume );
        $value =   str_replace( ',', '', $value );
        $alllow =  str_replace( ',', '', $alllow );
        $allhigh = str_replace( ',', '', $allhigh );


       $query  = "Select id from stocklist where cSymbol = '$row[0]' ";
       $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
       $id = $result->fetch_all(MYSQLI_ASSOC);
       $sid = $id[0]['id'];

         $query = "INSERT INTO stockvalues(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockValues, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value','$date')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

        $query = "UPDATE stocklist SET dailyEntry='yes' WHERE id = '$sid'";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


        echo "$row[0]  Completed";
        echo "\n";

    }

    // Close the file
    fclose($file);
} else {
    echo "Failed to open the file.";
}


?>
