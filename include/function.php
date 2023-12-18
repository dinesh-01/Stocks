<?php

function get_company_detail($company,$type) {

$splitDetails = explode("|", $company);


if($type=="symbol") {
	$symbol   = explode(":", $splitDetails[1]);
	return $symbol[1];
}
    



}


function get_future_link($symbol,$param) {

    $param = strtolower($param);
    $currentmonth = strtolower(date('M'));
    $nextmonth = strtolower(date('M',strtotime('first day of +1 month')));
    $futuremonth = strtolower(date('M',strtotime('first day of +2 month')));


    if(str_contains($param, $currentmonth)) {
        $turl = "https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A".$symbol."X2023";
    }

    if(str_contains($param, $nextmonth)) {
        $turl = "https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A".$symbol."Z2023";
    }

    if(str_contains($param, $futuremonth)) {
        $turl = "https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A".$symbol."f2024";
    }

    return $turl;


}


function convert_value_term($value) {

    $value = round($value, 0);
    $single_digit = substr($value,0,1);
    $two_digit = substr($value,0,2);
    $turn_over = "0";


    if(strlen($value) == 6) {
        return $turn_over = $single_digit . " lakh";
    }

    if(strlen($value) == 7) {
        return $turn_over = $two_digit . " lakhs";
    }

    if(strlen($value) == 8) {
        return $turn_over = $single_digit . " crore";
    }

    if(strlen($value) == 9) {
        return $turn_over = $two_digit . " crores";
    }

    if(strlen($value) == 10) {
        return $turn_over = $single_digit . " million";
    }

    if(strlen($value) == 11) {
        return $turn_over = $two_digit . " millions";
    }

    if(strlen($value) == 12) {
        return $turn_over = $single_digit . "trillion";
    }

    if(strlen($value) == 13) {
        return $turn_over = $two_digit . "trillions";
    }




}


?>