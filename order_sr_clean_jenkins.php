<?php
require_once './include/common.php';


$field     =  array("*");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");
$iceberg_status = 'no';

 foreach ($data as $value) {

    $id = $value['id'];
    $symbol   = $value['symbol'];
    $support_value = $value['support_value'];
    $resistance_value = $value['resistance_value'];
    $main_symbol = explode("24",$symbol);
    $main_symbol = $main_symbol[0];
    $condition = false;


       //Support
       if(!empty($support_value)) {
           $condition = support_match_condition($main_symbol, $support_value);
       }

       //Resistance
        if(!empty($resistance_value)) {
            $condition = resistance_match_condition($main_symbol, $resistance_value);
        }




        if($condition === true) {

                $query = "DELETE FROM optionAmo  WHERE id = '$id'";
                $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


                $query  = "UPDATE stocklistIntra SET order_status = 'Open' WHERE cSymbol = '$main_symbol'";
                $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                echo "Clean Up : $symbol";


            }

         echo "\n";

   }


















?>
