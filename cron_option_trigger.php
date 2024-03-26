<html lang="en">
<head>
    <link rel="stylesheet" type="text/css"  href="css/all.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="js/common.js"></script>
    <script src="js/process.js"></script>
    <title>Stock Data</title>
</head>
<center>
    <table class="gridtable">
        <tr>
            <th colspan="2">Stock Data Analysis</th>
        </tr>
    </table>
</center>
<br/>


<center>
<br/>



<div id="show_list">


    <table class="gridtable">
        <tr>
            <th> No </th>
            <th>Stock Name</th>
            <th>Stock Option Symbol </th>
            <th> Strick Price</th>
            <th> Current Price</th>
            <th> Status</th>
        </tr>






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

$query = "SELECT * FROM `optionTrigger`";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$result = $result->fetch_all(MYSQLI_ASSOC);





$i =1 ;
?>



<?php foreach ($result as $list) {

    $symbol =  $list['symbol'];
    $option_symbol = $list['option_symbol'];
    $order_trigger_id = $list['order_id'];



    //Checking the status
    if(str_contains($symbol,"_")) {
        $symbol = str_replace("_", "&", $symbol);
        $api_symbol = str_replace("&", "%26", $symbol);
        $end_point = "https://api.kite.trade/quote?i=NSE:$api_symbol";
    }else{
        $end_point = "https://api.kite.trade/quote?i=NSE:$symbol";
    }

    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));
    $current_price = $response['data']["NSE:$symbol"]['last_price'];
    $current_price = str_replace(",", "", $current_price);

    if(is_null($order_trigger_id)) {

         if ($current_price <= $list['price']) {

             $end_point = "https://api.kite.trade/quote?i=NFO:$option_symbol";
             $res = $client->request('GET', $end_point);
             $response = $res->getBody()->getContents();
             $response = (json_decode($response, true));

             $last_price = $response['data']["NFO:$option_symbol"]['last_price'];
             $last_price = str_replace(",", "", $last_price); //last price

             $query = "SELECT lot_size FROM `stockOption` WHERE `tradingsymbol` = '$option_symbol'";
             $result = mysqli_query($GLOBALS['mysqlConnect'], $query);
             $result = $result->fetch_all(MYSQLI_ASSOC);

             $amount = $result[0]['lot_size'] * $last_price;

             $lot    = (ALLOCATE_PRICE / $amount) ;
             $lot    = (int)$lot; //quantity
             $quantity = $lot * $result[0]['lot_size'];



             $percentage_value = 0.25 / 100;
             $amount_value = $last_price * $percentage_value;
             $final_amount = $last_price + $amount_value;
             $final_amount = round($final_amount, 1);


             $date = date('d-m-Y');



             //Place Order
             $end_point = "https://api.kite.trade/orders/regular";

             $res = $client->request('POST', $end_point, [
                 'form_params' => [
                     'tradingsymbol' => $option_symbol,
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
             $response = (json_decode($response, true));

             //Fetching order id
             $order_id = $response['data']['order_id'];


             $query = "UPDATE `optionTrigger` SET `status`='completed', order_id='$order_id' WHERE option_symbol = '$option_symbol'";
             $result = mysqli_query($GLOBALS['mysqlConnect'],$query);



         }

    } else {


        $end_point = "https://api.kite.trade/orders/$order_trigger_id/trades";
        $res = $client->request('GET', $end_point);
        $response = $res->getBody()->getContents();
        $response = (json_decode($response, true));

        print_r($response);


    }


?>

    <tr class="show">
        <td> <?php echo $i ?> </td>
        <td>
            <a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A<?php echo $list['symbol'] ?>"  target="blank"><?php echo $list['symbol'] ?></a>
        </td>
        <td><?php echo  $list['option_symbol'] ?></td>
        <td><?php echo $list['price'] ?></td>
        <td><?php echo $current_price ?></td>
        <td><?php echo  $list['status'] ?></td>
    </tr>

<?php $i++; } ?>

</table>

    <br/>
    <a href="option_trigger.php"><h2>Back</h2></a>
</div>
</center>





