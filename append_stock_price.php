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
    $symbol    = $_GET['s'];


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
    $price = $final_amount;


    $field     =  array("id,quanity","price");
    $table     =  "stockAmo";
    $condition =  "symbol = '$symbol'";
    $arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
    $data      =  select($arugment,"one");

    $previous_quantity = $data['quanity'];
    $id = $data['id'];
    $final_quantity =  $previous_quantity + $quantity;
    $price = ($data['price'] + $final_amount) / 2 ;
    $price = (int) $price;



//Update for AMO
    $query = "UPDATE `stockAmo` SET `price`='$price',`quanity`='$final_quantity' WHERE id = '$id'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



    header("location:list_watch.php");
    exit;














?>
