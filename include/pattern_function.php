<?php

function format($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function window($type,$company) {


   $result = false;
   $data = get_value_price($company,"two");

  if($type == "nwindow") {

    if($data[0]['high'] < $data[1]['low']) {
	     	 $result = true; 
	     }
   }


  if($type == "pwindow") {

         if($data[1]['high'] < $data[0]['low']) {
	     	 $result = true; 
	     }
   }


 return $result;

}

function hammer($type,$company) {

  $result = false;
  $data = get_value_price($company,"one");

  
  if($type == "phammer") {

	     if( ($data['high'] == $data['close'])  && ($data['open'] != $data['high']) ) {
	     	return $result = true; 
	     }
   }

   if($type == "nhammer") {

	     if( ($data['low'] == $data['close']) && ($data['open'] != $data['close']) ) {
	     	return $result = true; 
	     }
   }
}

function doji($company) {

 $result = false;
 $data = get_value_price($company,"one");

    if( ($data['open'] == $data['close']) && ($data['open'] != $data['high']) ) {
        return $result = true; 
       }
  

}

function gdoji($company) {

 $result = false;
   $data = get_value_price($company,"one");

    if( ($data['close'] == $data['high']) && ($data['open'] == $data['high']) ) {
        return $result = true; 
       }
  

}

function all_time_low($company) {

   $result = false;
   $data = get_value_price($company,"one");

    if($data['low'] == $data['allLow']) {
        return $result = true; 
       }

}


function sptop($company) {

   $result = false;
   $data = get_value_price($company,"one");


    $percentage = 1;
    $total      = $data['open'];
    $perValue   = ($percentage / 100) * $total;
    $range      = range($total, $total + $perValue);
    $value      = intval($data['close']);
    
     if (in_array($value, $range)) {
             return $result = true;
     }
}


function enpattern($company) {

   $result = false;
   $data = get_value_price($company,"two");


     if( ($data[0]['high']  < $data[1]['close']) &&  ($data[0]['low']  < $data[1]['open']) ){
        return $result = true; 
       }
  

}


function get_value_price($company,$pattern="") {



    $field     =  array("open,close,low,high,allLow,schange");
    $table     =  "stockvalues";
    $condition =  "sid='$company'";
    
    if($pattern == "one") {
       $limit = "0,1";
       $fetchType = "one";
    }

    
    if($pattern == "two") {
       $limit = "0,2";
       $fetchType = "many";
    }

    

    $order     =  "id desc";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order,"limit" => $limit);
    $data      =  select($arugment,$fetchType);
    return $data;

}


?>