<?php

function format($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

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
    $two_digit = substr($value,0,2);
    $turn_over = "0";

    if(strlen($value) == 6) {
        $digit = substr($value,0,1);
        return $turn_over = $digit . " lakh";
    }

    if(strlen($value) == 7) {
        $digit = substr($value,0,2);
        return $turn_over = $digit . " lakhs";
    }

    if(strlen($value) == 8) {
        $digit = substr($value,0,3);
        return $turn_over = $digit . " lakhs";
    }

    if(strlen($value) == 9) {
        $digit = substr($value,0,4);
        return $turn_over = $digit . " lakhs";
    }

    if(strlen($value) == 10) {
        $digit = substr($value,0,5);
        return $turn_over = $digit . " lakhs";
    }

    if(strlen($value) == 11) {
        $digit = substr($value,0,6);
        return $turn_over = $digit . " lakhs";
    }

    if(strlen($value) == 12) {
        $digit = substr($value,0,7);
        return $turn_over = $digit . "lakhs";
    }

    if(strlen($value) == 13) {
        $digit = substr($value,0,8);
        return $turn_over = $digit . "lakhs";
    }




}


?>