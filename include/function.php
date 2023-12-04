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


?>