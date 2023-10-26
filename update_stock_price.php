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
        'validity' => 'IOC'

    ]
  ]);

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
      $order_id = $response['data']['order_id'];




      /*
      $symbol   = "MARICO" ;
      $order_id = "231026203713829";
      $quantity = 55;
      */

    $stock_exclude = array("NIFTYBEES","NETF","JUNIORBEES");

    if (!in_array($symbol, $stock_exclude))  {

        $end_point = "https://api.kite.trade/orders/$order_id";
        $res = $client->request('GET', $end_point);
        $response = $res->getBody()->getContents();
        $response = (json_decode($response,true));
        $index = sizeof($response['data']) - 1;
        $result = $response['data'][$index];
        $last_price = $result['average_price'];

        //Creating GTT Orders
        $stop_loss_percentage = (0.7/100) ;
        $stop_loss_diff =  $last_price * $stop_loss_percentage;
        $stop_loss = $last_price - $stop_loss_diff;
        $stop_loss = number_format($stop_loss ,1);

        $target_percentage = (1.4/100) ;
        $target_diff =  $last_price * $target_percentage;
        $target = $last_price + $target_diff;
        $target =  number_format($target,1);


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

    }











?>
