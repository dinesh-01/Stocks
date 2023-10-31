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


    $url    = $_GET['trading_view_url'];
    $price  = $_GET['price'];
    $option = $_GET['option'];
    $date = date('d-m-Y');


    $quantity = (ALLOCATE_PRICE / $price) ;
    $quantity = (int)$quantity;

  // fetching symbol from the url
    $split_array = explode(":",$url);
    $symbol = $split_array[2];

   // Triggering API
    $end_point = "https://api.kite.trade/orders/regular";

   $res = $client->request('POST', $end_point, [
    'form_params' => [
        'tradingsymbol' => $symbol,
        'exchange' => 'NSE',
        'transaction_type' => $option,
        'order_type' => 'MARKET',
        'quantity' => $quantity,
        'product' => 'CNC',
        'validity' => 'DAY'

    ]
  ]);

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

        //Fetching order id
        $order_id = $response['data']['order_id'];
        $query  = "INSERT INTO stockAmo(symbol, order_id, quanity, created_date) VALUES ('$symbol','$order_id','$quantity' ,'$date')";
        $result = mysqli_query($GLOBALS['mysqlConnect'],$query);
        echo "$symbol Executed Successfully";



        /*

        $condition = "{\"exchange\":\"NSE\",\"tradingsymbol\":\"$symbol\",\"trigger_values\":[$stop_loss,$target],\"last_price\":$last_price}";
        $orders = "[{\"exchange\":\"NSE\",\"tradingsymbol\":\"$symbol\",\"transaction_type\":\"SELL\",
                     \"quantity\":$quantity,\"order_type\":\"LIMIT\",\"product\":\"CNC\",\"price\":$stop_loss},
                     {\"exchange\":\"NSE\",\"tradingsymbol\":\"$symbol\",\"transaction_type\":\"SELL\",
                     \"quantity\":$quantity,\"order_type\":\"LIMIT\",\"product\":\"CNC\",\"price\":$target}]";

        $end_point = "https://api.kite.trade/gtt/triggers";

        $gtt = $client->request('POST', $end_point, [
            'form_params' => [
                'type' => 'two-leg',
                'exchange' => 'NSE',
                'transaction_type' => 'SELL',
                'condition' => $condition,
                'orders' => $orders
            ]
        ]);

      */











?>
