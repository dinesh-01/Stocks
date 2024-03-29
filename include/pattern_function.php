<?php

function format($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function window($type,$company,$trade) {


   $result = false;
   $data = get_value_price($company,"two",$trade);

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

function hammer($type,$company,$trade) {

  $result = false;
  $data = get_value_price($company,"one",$trade);


  $close = $data['close'];
  $open  = $data['open'];
  $high  = $data['high'];
  $low   = $data['low'];
  $change = $data['schange'];

  //Positive Hammer
  if($type == "phammer") {

     if($open == $high) {

         // Calculate the real body size
         $realBody = abs($close - $open);

         // Calculate the shadow sizes
         $upperShadow = $high - max($open, $close);
         $lowerShadow = min($open, $close) - $low;

         // Check if it's a positive hammer pattern
         if ($lowerShadow >= 2 * $realBody && $upperShadow < $realBody && $change >= 0) {
             $result = true;
         }

     }



   }

   //Negative Hammer
   if($type == "nhammer") {

    if($close == $low) {

        // Calculate the real body size
        $realBody = abs($close - $open);

        // Calculate the shadow sizes
        $upperShadow = $high - max($open, $close);
        $lowerShadow = min($open, $close) - $low;

        // Check if it's a negative hammer pattern
        if ($upperShadow >= 2 * $realBody && $lowerShadow < $realBody) {
            $result = true;
        }

    }



   }

   return $result;
}

function doji($company,$trade) {

     $result = false;
     $data = get_value_price($company,"one",$trade);
     $close = $data['close'];
     $open  = $data['open'];
     $high  = $data['high'];
     $low   = $data['low'];
     $change = $data['schange'];
     $tolerance = 0.1;

     $close_near = $close / 100 ;
     $close_up  = $close + $close_near;
     $close_down  = $close - $close_near;

     $range = range(intval($close_down), intval($close_up));


    if (in_array($open, $range) && ($open < $high)) {

         $bodySize = abs($open - $close);
         $totalRange = $high - $low;
         $dojiTolerance = $totalRange * $tolerance;
         $result = $bodySize <= $dojiTolerance;

     }

    return $result;
  

}

function gdoji($company,$trade) {

    $result = false;
    $data = get_value_price($company,"one",$trade);
    $close = $data['close'];
    $open  = $data['open'];
    $high  = $data['high'];
    $low   = $data['low'];
    $change = $data['schange'];
    $tolerance = 0.1;

    $close_near = $close / 100 ;
    $close_up  = $close + $close_near;
    $close_down  = $close - $close_near;

    $range = range(intval($close_down), intval($close_up));


    if (in_array($low, $range)) {

        $bodySize = abs($open - $close);
        $totalRange = $high - $low;
        $dojiTolerance = $totalRange * $tolerance;
        $result = $bodySize <= $dojiTolerance;

    }

    return $result;

}

//Dragon Fly Doji
function dfdoji($company,$trade) {

    $result = false;
    $data = get_value_price($company,"one",$trade);
    $close = $data['close'];
    $open  = $data['open'];
    $high  = $data['high'];
    $low   = $data['low'];
    $change = $data['schange'];
    $tolerance = 0.1;

    $close_near = $close / 100 ;
    $close_up  = $close + $close_near;
    $close_down  = $close - $close_near;

    $range = range(intval($close_down), intval($close_up));


    if (in_array($high, $range)) {

        $bodySize = abs($open - $close);
        $totalRange = $high - $low;
        $dojiTolerance = $totalRange * $tolerance;
        $result = $bodySize <= $dojiTolerance;

    }

    return $result;


}


function all_time_low($company,$trade) {

   $result = false;
   $data = get_value_price($company,"one",$trade);


        if($data['low'] == $data['allLow']) {
             $result = true;
        }



    return $result;



}

function all_time_high($company,$trade) {

    $result = false;
    $data = get_value_price($company,"one",$trade);


    if($data['high'] == $data['allHigh']) {
        $result = true;
    }



    return $result;



}

function sptop($company,$trade) {

    $result = false;
    $data = get_value_price($company,"two",$trade);

    $previous_open   = $data[1]['open']; // Day 1: Open
    $previous_close  = $data[1]['close']; // Day 1: Close
    $previous_high   = $data[1]['high']; // Day 1: High
    $previous_low    = $data[1]['low'];  // Day 1: Low
    $current_open    = $data[0]['open']; // Day 2: Open
    $current_close   = $data[0]['close'];  // Day 2: Close
    $current_high    = $data[0]['high']; // Day 2: High
    $current_low     = $data[0]['low']; // Day 2: Low
    $previous_change = $data[1]['schange'];
    $current_change  = $data[0]['schange'];


  if($previous_close < $current_low || $current_high < $previous_close) {

      $target = ($current_high + $current_low) / 2;
      $arr  = array($current_open, $current_close);

      $target = intval($target);
      $open = intval($current_open);
      $close = intval($current_close);

      if($close < $target) {
          $range = range($close,$target);
          $result = in_array($open, $range);
      }
  }


    return $result;
}

function enpattern($company,$trade) {

   $result = false;
   $data = get_value_price($company,"two",$trade);

        $previous_open   = $data[1]['open']; // Day 1: Open
        $previous_close  = $data[1]['close']; // Day 1: Close
        $previous_high   = $data[1]['high']; // Day 1: High
        $previous_low    = $data[1]['low'];  // Day 1: Low
        $current_open    = $data[0]['open']; // Day 2: Open
        $current_close   = $data[0]['close'];  // Day 2: Close
        $current_high    = $data[0]['high']; // Day 2: High
        $current_low     = $data[0]['low']; // Day 2: Low
        $previous_change = $data[1]['schange'];
        $current_change  = $data[0]['schange'];

    $threshold = 5; // You can adjust this value
    $bodyLength = abs($current_open - $current_close);
    $day_1_change = $previous_open > $previous_close;
    $day_2_change = $current_close > $current_open;


        if ($day_1_change == true && $day_2_change == true) {

            // Checking if the second candle completely engulfs the first
            if ( ($previous_close > $current_open) && ($previous_open < $current_close) ) {
                $result = true;
            }

        }




    return $result;

}

function morningstar($company,$trade) {

    $result = false;
    $data = get_value_price($company,"three",$trade);

    # 0 is day 3
    # 1 is day 2
    # 2 is day 1


    $day_1_open   = $data[2]['open']; // Day 1: Open
    $day_1_close  = $data[2]['close']; // Day 1: Close
    $day_1_high   = $data[2]['high']; // Day 1: High
    $day_1_low    = $data[2]['low'];  // Day 1: Low
    $day_1_change = $data[2]['schange']; //Day 1: change

    $day_2_open   = $data[1]['open']; // Day 2: Open
    $day_2_close  = $data[1]['close']; // Day 2: Close
    $day_2_high   = $data[1]['high']; // Day 2: High
    $day_2_low    = $data[1]['low'];  // Day 2: Low
    $day_2_change = $data[1]['schange']; //Day 2: change

    $day_3_open   = $data[0]['open']; // Day 3: Open
    $day_3_close  = $data[0]['close']; // Day 3: Close
    $day_3_high   = $data[0]['high']; // Day 3: High
    $day_3_low    = $data[0]['low'];  // Day 3: Low
    $day_3_change = $data[0]['schange']; //Day 3: change


    if( $day_1_change < 0 && $day_2_change > 0 && $day_3_change > 0 ) {

        if($day_1_close > $day_2_close && $day_3_open > $day_2_close) {
            $result = true;
        }
    }



    return $result;

}

function brtrap($company,$trade) {

    $result = false;
    $data = get_value_price($company,"three",$trade);

    # 0 is day 3
    # 1 is day 2
    # 2 is day 1


    $day_1_open   = $data[2]['open']; // Day 1: Open
    $day_1_close  = $data[2]['close']; // Day 1: Close
    $day_1_high   = $data[2]['high']; // Day 1: High
    $day_1_low    = $data[2]['low'];  // Day 1: Low
    $day_1_change = $data[2]['schange']; //Day 1: change

    $day_2_open   = $data[1]['open']; // Day 2: Open
    $day_2_close  = $data[1]['close']; // Day 2: Close
    $day_2_high   = $data[1]['high']; // Day 2: High
    $day_2_low    = $data[1]['low'];  // Day 2: Low
    $day_2_change = $data[1]['schange']; //Day 2: change

    $day_3_open   = $data[0]['open']; // Day 3: Open
    $day_3_close  = $data[0]['close']; // Day 3: Close
    $day_3_high   = $data[0]['high']; // Day 3: High
    $day_3_low    = $data[0]['low'];  // Day 3: Low
    $day_3_change = $data[0]['schange']; //Day 3: change


    if( $day_1_change > 0 && $day_2_change < 0 && $day_3_change > 0 ) {

        if($day_1_high > $day_2_high && $day_3_high > $day_2_high) {
            $result = true;
        }
    }



    return $result;

}


function betrap($company,$trade) {

    $result = false;
    $data = get_value_price($company,"three",$trade);

    # 0 is day 3
    # 1 is day 2
    # 2 is day 1


    $day_1_open   = $data[2]['open']; // Day 1: Open
    $day_1_close  = $data[2]['close']; // Day 1: Close
    $day_1_high   = $data[2]['high']; // Day 1: High
    $day_1_low    = $data[2]['low'];  // Day 1: Low
    $day_1_change = $data[2]['schange']; //Day 1: change

    $day_2_open   = $data[1]['open']; // Day 2: Open
    $day_2_close  = $data[1]['close']; // Day 2: Close
    $day_2_high   = $data[1]['high']; // Day 2: High
    $day_2_low    = $data[1]['low'];  // Day 2: Low
    $day_2_change = $data[1]['schange']; //Day 2: change

    $day_3_open   = $data[0]['open']; // Day 3: Open
    $day_3_close  = $data[0]['close']; // Day 3: Close
    $day_3_high   = $data[0]['high']; // Day 3: High
    $day_3_low    = $data[0]['low'];  // Day 3: Low
    $day_3_change = $data[0]['schange']; //Day 3: change


    if( $day_1_change < 0 && $day_2_change > 0 && $day_3_change < 0 ) {

        if($day_1_high > $day_2_high && $day_3_high > $day_2_high) {
            $result = true;
        }
    }



    return $result;

}


function eveningstar($company,$trade) {

    $result = false;
    $data = get_value_price($company,"three",$trade);

    # 0 is day 3
    # 1 is day 2
    # 2 is day 1


    $day_1_open   = $data[2]['open']; // Day 1: Open
    $day_1_close  = $data[2]['close']; // Day 1: Close
    $day_1_high   = $data[2]['high']; // Day 1: High
    $day_1_low    = $data[2]['low'];  // Day 1: Low
    $day_1_change = $data[2]['schange']; //Day 1: change

    $day_2_open   = $data[1]['open']; // Day 2: Open
    $day_2_close  = $data[1]['close']; // Day 2: Close
    $day_2_high   = $data[1]['high']; // Day 2: High
    $day_2_low    = $data[1]['low'];  // Day 2: Low
    $day_2_change = $data[1]['schange']; //Day 2: change

    $day_3_open   = $data[0]['open']; // Day 3: Open
    $day_3_close  = $data[0]['close']; // Day 3: Close
    $day_3_high   = $data[0]['high']; // Day 3: High
    $day_3_low    = $data[0]['low'];  // Day 3: Low
    $day_3_change = $data[0]['schange']; //Day 3: change


    if( $day_1_change > 0 && $day_2_change > 0 && $day_3_change < 0 ) {

        if($day_1_close < $day_2_low && $day_3_open > $day_2_low && $day_1_close > $day_3_low) {
            $result = true;
        }
    }



    return $result;

}


#Piercing pattern
function pipattern($company,$trade) {

    $result = false;
    $data = get_value_price($company,"two",$trade);

    $previous_open   = $data[1]['open']; // Day 1: Open
    $previous_close  = $data[1]['close']; // Day 1: Close
    $previous_high   = $data[1]['high']; // Day 1: High
    $previous_low    = $data[1]['low'];  // Day 1: Low
    $current_open    = $data[0]['open']; // Day 2: Open
    $current_close   = $data[0]['close'];  // Day 2: Close
    $current_high    = $data[0]['high']; // Day 2: High
    $current_low     = $data[0]['low']; // Day 2: Low
    $previous_change = $data[1]['schange']; // Day 1: change
    $current_change  = $data[0]['schange']; // Day 2: change

    $threshold = 5; // You can adjust this value
    $bodyLength = abs($current_open - $current_close);


    $day_1_change = $previous_open > $previous_close;
    $day_2_change = $current_close > $current_open;


        if ($day_1_change == true && $day_2_change == true) {

            if ($previous_low >= $current_open || $previous_low == $current_open || $previous_close == $current_open) {

                $avg = intval(($previous_open + $previous_close) / 2);
                $current_close = intval($current_close);
                $range = range($avg, $previous_open);
                $result = in_array($current_close, $range);
            }

        }


    return $result;

}

#Bearish engulfing pattern
function brpattern($company,$trade) {

    $result = false;
    $data = get_value_price($company,"two",$trade);

    $previous_open   = $data[1]['open']; // Day 1: Open
    $previous_close  = $data[1]['close']; // Day 1: Close
    $previous_high   = $data[1]['high']; // Day 1: High
    $previous_low    = $data[1]['low'];  // Day 1: Low
    $current_open    = $data[0]['open']; // Day 2: Open
    $current_close   = $data[0]['close'];  // Day 2: Close
    $current_high    = $data[0]['high']; // Day 2: High
    $current_low     = $data[0]['low']; // Day 2: Low
    $previous_change = $data[1]['schange'];
    $current_change  = $data[0]['schange'];

    $day_1_change = $previous_open < $previous_close;
    $day_2_change = $current_close < $current_open;


    if ($day_1_change == true && $day_2_change == true) {

        // Checking if the second candle completely engulfs the first
        if ( $previous_open > $current_close && $previous_close < $current_open) {
            $result =  true;
        }


    }



    return $result;

}

#dark cover
function darkcover($company,$trade) {

    $result = false;
    $data = get_value_price($company,"two",$trade);

    $previous_open   = $data[1]['open']; // Day 1: Open
    $previous_close  = $data[1]['close']; // Day 1: Close
    $previous_high   = $data[1]['high']; // Day 1: High
    $previous_low    = $data[1]['low'];  // Day 1: Low
    $current_open    = $data[0]['open']; // Day 2: Open
    $current_close   = $data[0]['close'];  // Day 2: Close
    $current_high    = $data[0]['high']; // Day 2: High
    $current_low     = $data[0]['low']; // Day 2: Low
    $previous_change = $data[1]['schange']; // Day 1: change
    $current_change  = $data[0]['schange']; // Day 2: change

    $threshold = 5; // You can adjust this value
    $bodyLength = abs($current_open - $current_close);


    if ($bodyLength >= $threshold) {

        if ($current_change < 0 && $previous_change > 0) {

            if ($previous_close < $current_open &&  $current_close < $previous_close) {

               $result = true;
            }

        }
    }

    return $result;

}


function upward($company,$trade) {

    $result = false;
    $data = get_value_price($company,"two",$trade);



    if($data[0]['schange'] > 0 && $data[1]['schange'] > 0)  {
            $result = true;
        }

    return $result;

}

function longbullish($company,$trade) {


    $result = false;
    $data = get_value_price($company,"two",$trade);

    $previous_close  = $data[1]['close']; // Day 1: Close
    $current_close   = $data[0]['close'];  // Day 2: Close
    $current_change  = $data[0]['schange'];



    if ($current_change > 0) {

      $close =  $current_close - $previous_close ;
      $percentage = ($close / $current_close) * 100;

      if($percentage > 3) {
          $result = true;
      }


    }



    return $result;

}

function longbearish($company,$trade) {


    $result = false;
    $data = get_value_price($company,"two",$trade);

    $previous_close  = $data[1]['close']; // Day 1: Close
    $current_close   = $data[0]['close'];  // Day 2: Close
    $current_change  = $data[0]['schange'];



    if ($current_change < 0) {

        $close =  $previous_close - $current_close ;
        $percentage = ($close / $current_close) * 100;

        if($percentage > 3) {
            $result = true;
        }


    }



    return $result;

}


function get_value_price($company,$pattern="",$trade="stocks") {


    if($trade == "stocks") {
        $table     =  "stockvalues";
    }

    if($trade == "futures") {
        $table     =  "stockvaluesfutures";
    }

    $field     =  array("open,close,low,high,allLow,schange");
    $condition =  "sid='$company'";
    
    if($pattern == "one") {
       $limit = "0,1";
       $fetchType = "one";
    }

    
    if($pattern == "two") {
       $limit = "0,2";
       $fetchType = "many";
    }

    if($pattern == "three") {
        $limit = "0,3";
        $fetchType = "many";
    }

    

    $order     =  "id desc";
    $arugment  =  array( "field" => $field , "table" => $table, "condition" => $condition,"order" => $order,"limit" => $limit);
    $data      =  select($arugment,$fetchType);



    return $data;

}


?>