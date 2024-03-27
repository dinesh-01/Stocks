
<?php

//including common files

require_once './include/common.php';
require_once './template/header.php';


use Twilio\Rest\Client;


$headers = [
    'Content-Type' => 'application/json',
    'X-Kite-Version' => '3',
    'Authorization' => 'token '.KEY.':'.TOKEN
];

$client = new GuzzleHttp\Client([
    'headers' => $headers
]);

//Checking stock already exists in table
$query  = "SELECT `cSymbol`,`support_value`,`grow` FROM `stocklist` WHERE `isWatch` = 'Yes'";
$result = mysqli_query($GLOBALS['mysqlConnect'],$query);
$data = $result->fetch_all(MYSQLI_ASSOC);


//Rending to tbl file

$i = 0;

foreach ($data as $value) {

    $api_symbol = $value['cSymbol'];
    $support_value = $value['support_value'];

    if(str_contains($api_symbol,"&")) {
        $api_symbol = str_replace("&", "%26", $api_symbol);
    }


    $end_point = "https://api.kite.trade/quote?i=NSE:$api_symbol";
    $res = $client->request('GET', $end_point);
    $response = $res->getBody()->getContents();
    $response = (json_decode($response, true));

    if(str_contains($api_symbol,"%26")) {
        $api_symbol = str_replace("%26", "&", $api_symbol);
    }

    $close = $response['data']["NSE:$api_symbol"]['last_price'];
    $last_price = str_replace(",", "", $close);


    if($last_price <= $support_value ) {

        $match[$i]['cSymbol'] = $api_symbol;
        $match[$i]['last_price'] = $last_price;
        $match[$i]['support_value'] = $support_value;
        $match[$i]['grow'] = $value['grow'];


        //Sending alert to mobile
        $sid    = "**";
        $token  = "**";
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("+**", // to
                array(
                    "from" => "+**",
                    "body" => "$api_symbol reached Support Level"
        )
      );



        $i++;

    }



}



//Rending to tbl file
$smarty->assign("datas",$match);
$smarty->display("support_monitor.tpl");

?>
