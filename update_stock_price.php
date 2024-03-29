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
    $id = $_GET['id'];
    $query  = "Select cSymbol from stocklist where id=$id";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
    $row    = mysqli_fetch_row($result);

    //Symbol
    $symbol = $row[0];

    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));

    $last_price = $response['data']["NSE:$symbol"]['last_price'];
    $last_price = str_replace(",", "", $last_price); //last price



    $quantity = (ALLOCATE_PRICE / $last_price) ;
    $quantity = (int)$quantity; //quantity


    $percentage_value = 0.1 / 100 ;
    $amount_value = $last_price * $percentage_value;
    $final_amount = $last_price + $amount_value;
    $final_amount = round($final_amount, 1);



    $date = date('d-m-Y');


    //Place Order
    $end_point = "https://api.kite.trade/orders/regular";

    $res = $client->request('POST', $end_point, [
    'form_params' => [
        'tradingsymbol' => $symbol,
        'exchange' => 'NSE',
        'transaction_type' => "BUY",
        'order_type' => 'LIMIT',
        'quantity' => $quantity,
        'price' => $final_amount,
        'product' => 'CNC',
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
    $query  = "INSERT INTO stockAmo(symbol, order_id, quanity, price, created_date) VALUES ('$symbol','$order_id','$quantity','$price','$date')";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

    //Updating in stocklist
    $query = "UPDATE `stocklist` SET `order_status`='1' WHERE id = $id";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);


    header("location:list_watch.php");
    exit;














?>
