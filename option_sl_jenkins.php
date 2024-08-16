<?php
require_once './include/common.php';


if ( (time() > strtotime("09:15:00")) &&  (time() < strtotime("15:30:00"))  ) {
    $order_decide_type = "regular";
    $per = "5%";
}else{
    $order_decide_type = "amo";
    $per = "7%";
}



// setting up end headers
    $headers = [
        'Content-Type' => 'application/json',
        'X-Kite-Version' => '3',
        'Authorization' => 'token '.KEY.':'.TOKEN
    ];

    $client = new GuzzleHttp\Client([
        'headers' => $headers
    ]);

$field     =  array("*");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");



foreach ($data as $value) {



    #fetch order details
    $id = $value['id'];
    $order_id = $value['order_id'];
    $sl_order_id = $value['sl_order_id'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $last_price = $value['price'];
    $sl_percent = $value['sl'];



    if(empty($sl_order_id) || is_null($sl_order_id)) {

        if(!empty($order_id) || !is_null($order_id)) {

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


            if($status == 'COMPLETE') {

                $stoploss_percentage = ($sl_percent/100) ;
                $stoploss_diff =  $last_price * $stoploss_percentage;
                $stoploss = $last_price - $stoploss_diff;
                $stoploss =  number_format($stoploss,1);
                $stoploss = str_replace(",","",$stoploss);

                $trigger_per = $sl_percent - 1;
                $percentage_value = $trigger_per / 100 ;
                $amount_value = $last_price * $percentage_value;
                $trigger_final_amount = $last_price - $amount_value;
                $trigger_stoploss = round($trigger_final_amount, 1);



                //Set stoploss
                $end_point = "https://api.kite.trade/orders/regular";
                $res = $client->request('POST', $end_point, [
                    'form_params' => [
                        'tradingsymbol' => $symbol,
                        'exchange' => 'NFO',
                        'transaction_type' => "SELL",
                        'order_type' => 'SL',
                        'trigger_price' => $trigger_stoploss,
                        'price' => $stoploss,
                        'quantity' => $quantity,
                        'product' => 'NRML',
                        'validity' => 'DAY'

                    ]
                ]);

                $response = $res->getBody()->getContents();
                $response = (json_decode($response,true));

                //Fetching order id
                $sl_order_id = $response['data']['order_id'];

                $query = "UPDATE `optionAmo` SET `sl_order_id`= '$sl_order_id',`track_status` = 'SL PLACED' WHERE id = '$id'";
                $result = mysqli_query($GLOBALS['mysqlConnect'],$query);

                echo "SL PLACED";

            }


        }

    }

}


















?>
