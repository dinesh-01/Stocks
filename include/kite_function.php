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

function place_order_index($symbol,$quantity,$type) {

    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

    $res = "";


    $end_point = "https://api.kite.trade/orders/regular";

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


?>