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


    //Fetching stock Symbol
    $symbol = $_GET['option_symbol'];

    $quantity = $_GET['lot_size'];
    $s = $_GET['s'];
    $o = $_GET['o'];

    if($o == "CE") {
        $order_decide_type = "regular";
    }

    if($o == "PE") {
        $order_decide_type = "regular";
    }


    $end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));

    $last_price = $response['data']["NFO:$symbol"]['last_price'];
    $last_price = str_replace(",", "", $last_price); //last price

    $percentage_value = 1 / 100 ;
    $amount_value = $last_price * $percentage_value;
    $final_amount = $last_price + $amount_value;
    $final_amount = round($final_amount, 1);


    $date = date('d-m-Y');



    //Place Order
    $end_point = "https://api.kite.trade/orders/$order_decide_type";

    $res = $client->request('POST', $end_point, [
    'form_params' => [
        'tradingsymbol' => $symbol,
        'exchange' => 'NFO',
        'transaction_type' => "BUY",
        'order_type' => 'LIMIT',
        'quantity' => $quantity,
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


    //Update for AMO
     $query  = "INSERT INTO optionAmo(symbol, order_id, quanity, price, created_date) VALUES ('$symbol','$order_id','$quantity','$price','$date')";
     $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



    header("location:stock_options_orders.php?s=$s&o=$o");
    exit;



?>
