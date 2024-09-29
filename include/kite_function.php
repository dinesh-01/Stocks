<?php


// setting up end headers


function get_current_price_index($symbol) {


    if (str_contains($symbol, "MIDCP")) {
        $symbol = 'NIFTY MID SELECT';
    }elseif (str_contains($symbol, "BANKNIFTY")) {
        $symbol = 'NIFTY BANK';
    }elseif (str_contains($symbol, "FINNIFTY")) {
        $symbol = 'NIFTY FIN SERVICE';
    }else{
        $symbol = 'NIFTY 50';
    }


    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

    $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    $res =   $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));

    $current_price = $response['data']["NSE:$symbol"]['last_price'];
    $current_price = str_replace(",", "", $current_price);
    return $current_price;

}

function place_order_buy_index($symbol,$quantity,$type,$final_amount='') {

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


        if(empty($final_amount)) {

            $end_point = "https://api.kite.trade/quote?i=NFO:$symbol";
            $res = $client->request('GET', $end_point);
            $response = $res->getBody()->getContents();
            $response = (json_decode($response, true));
            $last_price = $response['data']["NFO:$symbol"]['last_price'];
            $last_price = str_replace(",", "", $last_price); //last price

            $percentage_value = 0.1 / 100 ;
            $amount_value = $last_price * $percentage_value;
            $final_amount = $last_price + $amount_value;
            $final_amount = round($final_amount, 1);

        }



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

function place_stop_loss_index($symbol,$quantity,$last_price) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);



    $stop_loss_trigger_percentage_value = STOPLOSS_BOOKING - 1;
    $stop_loss_trigger_percentage = ($stop_loss_trigger_percentage_value/100) ;
    $stop_loss_diff =  $last_price * $stop_loss_trigger_percentage;
    $stop_loss_trigger = $last_price - $stop_loss_diff;
    $stop_loss_trigger = number_format($stop_loss_trigger ,1);
    $stop_loss_trigger = str_replace(",","",$stop_loss_trigger);

    $stop_loss_percentage = (STOPLOSS_BOOKING/100) ;
    $stop_loss_diff =  $last_price * $stop_loss_percentage;
    $stop_loss = $last_price - $stop_loss_diff;
    $stop_loss = number_format($stop_loss ,1);
    $stop_loss = str_replace(",","",$stop_loss);


    //Set Stoploss
    $end_point = "https://api.kite.trade/orders/regular";
    $res = $client->request('POST', $end_point, [
        'form_params' => [
            'tradingsymbol' => $symbol,
            'exchange' => 'NFO',
            'transaction_type' => "SELL",
            'order_type' => 'SL',
            'price' => $stop_loss,
            'trigger_price' => $stop_loss,
            'quantity' => $quantity,
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

function place_stop_loss_index_sample($symbol,$quantity,$stop_loss_price) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);




    $stop_loss_trigger_percentage_value = STOPLOSS_BOOKING - 3;
    $stop_loss_trigger_percentage = ($stop_loss_trigger_percentage_value/100) ;
    $trigger_price = symbol_last_price($symbol);
    $stop_loss_diff =  $trigger_price * $stop_loss_trigger_percentage;
    $stop_loss_trigger = $trigger_price - $stop_loss_diff;
    $stop_loss_trigger = number_format($stop_loss_trigger ,1);
    $stop_loss_trigger = str_replace(",","",$stop_loss_trigger);

    $stop_loss = str_replace(",","",$stop_loss_price);


    //Set Stoploss
    $end_point = "https://api.kite.trade/orders/regular";
    $res = $client->request('POST', $end_point, [
        'form_params' => [
            'tradingsymbol' => $symbol,
            'exchange' => 'NFO',
            'transaction_type' => "SELL",
            'order_type' => 'SL',
            'price' => $stop_loss,
            'trigger_price' => $stop_loss_trigger,
            'quantity' => $quantity,
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

function symbol_last_price($symbol) {

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
    return $last_price;

}


function match_condition( $trigger_value, $last_price) {

    $return = false;

      if($last_price >= $trigger_value) {
            $return = true;
      }

    return $return;

}


function support_match_condition($symbol, $support_value) {

    $return = false;
    echo $index_price = get_current_price_index($symbol);

    if($index_price <= $support_value) {
        $return = true;
    }

    return $return;


}


function resistance_match_condition($symbol, $resistance_value) {

    $return = false;
    echo $index_price = get_current_price_index($symbol);

    if($index_price >= $resistance_value) {
        $return = true;
    }

    return $return;


}


?>