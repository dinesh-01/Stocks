
<?php

//including common files
require_once './include/common.php';
require_once './template/header.php';

// setting up end headers
$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);

  $index = ['NIFTY 50','NIFTY BANK','NIFTY MID SELECT','NIFTY FIN SERVICE'];
  //$index = ['NIFTY 50'];

  $i = 0;
  foreach ($index as $in) {

      $res = $client->request('GET', "https://api.kite.trade/quote?i=NSE:$in");
      $response = $res->getBody()->getContents();
      $response = (json_decode($response, true));
      $current_price = $response['data']["NSE:$in"]['last_price'];
      $current_price = str_replace(",", "", $current_price);


      $percentage_value = 0.3 / 100 ;
      $amount_value = $current_price * $percentage_value;

      $final_amount = $current_price + $amount_value;
      $range1 = round($final_amount, 0);

      $final_amount = $current_price - $amount_value;
      $range2 = round($final_amount, 0);



      if($in == 'NIFTY 50') {

          $global = 'NIFTY';
          $expiry = NIFTY;

      }

      if($in == 'NIFTY BANK') {

          $global = 'BANKNIFTY';
          $expiry = BANK;

      }

      if($in == 'NIFTY MID SELECT') {

          $global = 'MIDCP';
          $expiry = MID;

      }

      if($in == 'NIFTY FIN SERVICE') {

          $global = 'FINNIFTY';
          $expiry = FIN;

      }


      $orderBy = "asc";
      $ce_query = "SELECT * FROM `stockOption` WHERE `tradingsymbol` LIKE '$global%' 
                                and `expiry` LIKE '$expiry'
                                and strike BETWEEN $range2 AND $current_price 
                                and instrument_type = 'CE' order by strike asc limit 0,1";

      $ce_result = mysqli_query($GLOBALS['mysqlConnect'], $ce_query);
      $ce_data = mysqli_fetch_assoc($ce_result);



      $pe_query = "SELECT * FROM `stockOption` WHERE `tradingsymbol` LIKE '$global%' 
                                and `expiry` LIKE '$expiry'
                                and strike BETWEEN $current_price AND $range1 
                                and instrument_type = 'PE' order by strike desc limit 0,1";

      $pe_result = mysqli_query($GLOBALS['mysqlConnect'], $pe_query);
      $pe_data = mysqli_fetch_assoc($pe_result);





     $datas[$i]['ce_link'] = $ce_data['tradingsymbol'];
     $datas[$i]['pe_link'] = $pe_data['tradingsymbol'];


      $i++;



  }




    $smarty->assign("datas",$datas);
    $smarty->display("list_futures_stocks.tpl");
    
            
?>