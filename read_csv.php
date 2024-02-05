<?php
require_once './include/common.php';


#reseting the dailyentry
  $query = "UPDATE stocklist SET `dailyEntry`='no', `qbuy`='0',`qvolume`='0',
                     `current_volume`='0',`qtotal`='0',`stock_signal`='=> SELECT <=',
                     `order_type`='LIMIT',`target`='0',`stop_loss`='0' ";
  $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



$filename = 'data/200.csv'; // Replace with your file name or path
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
        $alllow   = $row[11];
        $allhigh  = $row[10];

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

         $query = "INSERT INTO stockvalues(sid, open, high, allHigh, low, allLow, close, schange, schangePercent, volume, stockValues, addClear, createdDate)
    VALUES ('$sid','$open','$high','$allhigh','$low','$alllow','$close','$chng','$chng_percentage','$volume','$value',1,'$date')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

        $query = "UPDATE stocklist SET dailyEntry='yes',current_volume='$volume' WHERE id = '$sid'";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


        echo "$row[0]  Completed - $chng";
        echo "\n";
        sleep(1);

    }

    // Close the file
    fclose($file);
} else {
    echo "Failed to open the file.";
}


?>
