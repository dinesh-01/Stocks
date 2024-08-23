<?php


// setting up end headers


function get_current_price_index($symbol) {

/*
    if (str_contains($symbol, "MIDCP")) {
        $symbol = 'NIFTY MID SELECT';
    }elseif (str_contains($symbol, "BANKNIFTY")) {
        $symbol = 'NIFTY BANK';
    }elseif (str_contains($symbol, "FINNIFTY")) {
        $symbol = 'NIFTY FIN SERVICE';
    }else{
        $symbol = 'NIFTY 50';
    }
*/

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

   // $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
     $end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
    $res =   $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));

  //  $current_price = $response['data']["NSE:$symbol"]['last_price'];
    $current_price = $response["data"]["NFO:".$symbol]["last_price"];
    $current_price = str_replace(",", "", $current_price);
    return $current_price;

}

function place_order_buy_index($symbol,$quantity,$type) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

    $res = "";



    if($type == 'limit') {

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

        $end_point = "https://api.kite.trade/orders/regular";

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


    }

    if($type == 'market') {

        $end_point = "https://api.kite.trade/orders/regular";
        $res = $client->request('POST', $end_point, [
            'form_params' => [
                'tradingsymbol' => $symbol,
                'exchange' => 'NFO',
                'transaction_type' => "BUY",
                'order_type' => 'MARKET',
                'quantity' => $quantity,
                'product' => 'NRML',
                'validity' => 'DAY'

            ]
        ]);
    }

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
    $order_id = $response['data']['order_id'];

    return $order_id;


}

function place_order_buy_index_iceberg($symbol,$quantity,$leg,$type) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

    $res = "";
    echo $quantity;
    echo "\n";
    echo $leg;



    if($type == 'limit') {

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

        $end_point = "https://api.kite.trade/orders/iceberg";

        $res = $client->request('POST', $end_point, [
            'form_params' => [
                'tradingsymbol' => $symbol,
                'exchange' => 'NFO',
                'transaction_type' => "BUY",
                'order_type' => 'LIMIT',
                'iceberg_legs' => $leg,
                'quantity' => $quantity,
                'price' => $final_amount,
                'product' => 'NRML',
                'validity' => 'DAY'

            ]
        ]);


    }

    if($type == 'market') {

        $end_point = "https://api.kite.trade/orders/regular";
        $res = $client->request('POST', $end_point, [
            'form_params' => [
                'tradingsymbol' => $symbol,
                'exchange' => 'NFO',
                'transaction_type' => "BUY",
                'order_type' => 'MARKET',
                'iceberg_legs' => $leg,
                'iceberg_quantity' => $quantity,
                'product' => 'NRML',
                'validity' => 'DAY'

            ]
        ]);
    }

    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
    $order_id = $response['data']['order_id'];

    return $order_id;


}



function place_order_sell_index($symbol,$quantity,$last_price) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);



        $last_price = str_replace(",", "", $last_price); //last price
        $percentage_value = PROFIT_BOOKING / 100 ;
        $amount_value = $last_price * $percentage_value;
        $final_amount = $last_price + $amount_value;
        $final_amount = round($final_amount, 1);

        $end_point = "https://api.kite.trade/orders/regular";

        $res = $client->request('POST', $end_point, [
            'form_params' => [
                'tradingsymbol' => $symbol,
                'exchange' => 'NFO',
                'transaction_type' => "SELL",
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

    return $order_id;


}

function place_order_sell_index_iceberg($symbol,$quantity,$leg) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);



        $end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
        $res = $client->request('GET', $end_point);
        $response = $res->getBody()->getContents();
        $response = (json_decode($response, true));

        $last_price = $response['data']["NFO:$symbol"]['last_price'];
        $last_price = str_replace(",", "", $last_price); //last price

        $percentage_value = PROFIT_BOOKING / 100 ;
        $amount_value = $last_price * $percentage_value;
        $final_amount = $last_price + $amount_value;
        $final_amount = round($final_amount, 1);

        $end_point = "https://api.kite.trade/orders/iceberg";

        $res = $client->request('POST', $end_point, [
            'form_params' => [
                'tradingsymbol' => $symbol,
                'exchange' => 'NFO',
                'transaction_type' => "SELL",
                'order_type' => 'LIMIT',
                'iceberg_legs' => $leg,
                'iceberg_quantity' => $quantity,
                'price' => $final_amount,
                'product' => 'NRML',
                'validity' => 'DAY'

            ]
        ]);



    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    //Fetching order id
    $order_id = $response['data']['order_id'];

    return $order_id;


}


function order_last_price($order_id) {


    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

    $end_point = "https://api.kite.trade/orders/$order_id";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));

    $length = count($response['data']);
    $length =  $length-1;

    //Fetching Status
    $status = $response['data'][$length]['status'];

    //Fetching average price
    $last_price = $response['data'][$length]['average_price'];
    $last_price = str_replace(",", "", $last_price); //last price

    return $last_price;



}


?>