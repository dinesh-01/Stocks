<?php
require_once './include/common.php';

    // setting up end headers
    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);


    $symbol = $_GET['option_symbol']; //Fetching stock Symbol
    $quantity = $_GET['lot_size']; //Fetching lot size
    $s = $_GET['s']; //Index
    $o = $_GET['o']; //option_type



    $date = date('d-m-Y');


    if($s=="NIFTY") {
        $lot = 1800;
        $min_lot = 25;
    }

    if($s=="MIDCPNIFTY") {
        $lot = 1800;
        $min_lot = 75;
    }

    if($s=="BANKNIFTY") {
        $lot = 900;
        $min_lot = 15;


    }

    if($s=="FINNIFTY") {
        $lot = 1800;
        $min_lot = 40;


    }




    //Split Order
    if($quantity > $lot) {
        $split = ceil($quantity / $lot);
    }else {
        $split = 1;
    }

$quantity_split_total = 0;

  for($i=1;$i<=$split;$i++) {

         $quantity_split =  $lot;


         if($i==$split) {
              $quantity_split =   $quantity - $quantity_split_total;
           }


      // Fetching last price of the symbol
      $end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
      $res = $client->request('GET', $end_point);
      $response = $res->getBody()->getContents();
      $response = (json_decode($response, true));

      $last_price = $response['data']["NFO:$symbol"]['last_price'];
      $last_price = str_replace(",", "", $last_price); //last price

      $percentage_value = 0.2 / 100 ;
      $amount_value = $last_price * $percentage_value;
      $final_amount = $last_price + $amount_value;
      $final_amount = round($final_amount, 1);


    //Place Order

       $end_point = "https://api.kite.trade/orders/regular";
       $res = $client->request('POST', $end_point, [
           'form_params' => [
               'tradingsymbol' => $symbol,
               'exchange' => 'NFO',
               'transaction_type' => "BUY",
               'order_type' => 'LIMIT',
               'quantity' => $quantity_split,
               'price' => $final_amount,
               'product' => 'NRML',
               'validity' => 'DAY'

           ]
       ]);





       $response = $res->getBody()->getContents();
       $response = (json_decode($response,true));

       //Fetching order id
       $order_id = $response['data']['order_id'];


       //Fetch Average Price
       $end_point = "https://api.kite.trade/orders/$order_id";
       $res = $client->request('GET', $end_point);

       $response = $res->getBody()->getContents();
       $response = (json_decode($response,true));



       $length = count($response['data']);
       $length =  $length-1;


       //Fetching average price
       $price = $response['data'][$length]['average_price'];


       //Update order status
       $query  = "INSERT INTO optionAmo(symbol, order_id, quanity, price, iceberg_leg, created_date) VALUES ('$symbol','$order_id','$quantity_split','$price','$split','$date')";
       $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


       $quantity_split_total = $quantity_split_total + $lot;


}


   if($s == "MIDCPNIFTY") {
       $s="MIDCP";
   }

    header("location:stock_global_options_orders.php?s=$s&o=$o");
    exit;


?>
