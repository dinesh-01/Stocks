<?php
require_once './include/common.php';


if ( (time() > strtotime("09:15:00")) &&  (time() < strtotime("15:30:00"))  ) {
    $order_decide_type = "regular";
    $per = "3%";
}else{
    $order_decide_type = "amo";
    $per = "5%";
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


$field     =  array("id,order_id,symbol,price,quanity,stop_loss,target,iceberg_leg,created_date");
$table     =  "optionAmo";
$condition =  "status = 'open'";
$arugment  =  array( "field" => $field , "table" => $table, 'condition' => $condition);
$data      =  select($arugment,"many");



foreach ($data as $value) {

    #fetch order details
    $order_id = $value['order_id'];
    $symbol   = $value['symbol'];
    $quantity = $value['quanity'];
    $last_price = $value['price'];
    $iceberg_leg = $value['iceberg_leg'];


    if(empty($last_price) || is_null($last_price)) {


        //Fetch Average Price
        $end_point = "https://api.kite.trade/orders/$order_id";
        $res = $client->request('GET', $end_point);

        $response = $res->getBody()->getContents();
        $response = (json_decode($response,true));



        $length = count($response['data']);
        $length =  $length-1;


        //Fetching average price
        $price = $response['data'][$length]['average_price'];
        $last_price = $price;

    }


    $target_percentage = ($per/100) ;
    $target_diff =  $last_price * $target_percentage;
    $target = $last_price + $target_diff;
    $target =  number_format($target,1);
    $target = str_replace(",","",$target);

    $stoploss_percentage = ($per/100) ;
    $stoploss_diff =  $last_price * $target_percentage;
    $stoploss = $last_price - $stoploss_diff;
    $stoploss =  number_format($stoploss,1);
    $stoploss = str_replace(",","",$stoploss);




    //Set target


        $end_point = "https://api.kite.trade/orders/regular";
        $res = $client->request('POST', $end_point, [
            'form_params' => [
                'tradingsymbol' => $symbol,
                'exchange' => 'NFO',
                'transaction_type' => "SELL",
                'order_type' => 'LIMIT',
                'price' => $target,
                'quantity' => $quantity,
                'product' => 'NRML',
                'validity' => 'DAY'

            ]
        ]);


    $response = $res->getBody()->getContents();
    $response = (json_decode($response,true));


    //Fetching order id
    $order_id = $response['data']['order_id'];
    echo "Target for $symbol : $target";
    echo "\n";


    /*

    //Set stoploss
    $end_point = "https://api.kite.trade/orders/$order_decide_type";
    $res = $client->request('POST', $end_point, [
        'form_params' => [
            'tradingsymbol' => $symbol,
            'exchange' => 'NFO',
            'transaction_type' => "SELL",
            'order_type' => 'SL',
            'trigger_price' => $stoploss,
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
    echo "Stoplss for $symbol : $stoploss";
    echo "\n";


*/

    $sl_order_id = "Sample";


    #reseting the dailyentry
    $id = $value['id'];
    $query = "UPDATE `optionAmo` SET `order_id`='$order_id', `price`='$last_price',`target`='$target',`sl_order_id`='$sl_order_id', `status`= 'completed' WHERE id = '$id'";
    $result = mysqli_query($GLOBALS['mysqlConnect'],$query);




}


















?>
