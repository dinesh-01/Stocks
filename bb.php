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


// Function to calculate Simple Moving Average (SMA)
function calculateSMA($prices, $period)
{
    $sma = [];
    $priceCount = count($prices);

    for ($i = 0; $i <= $priceCount - $period; $i++) {
        $subset = array_slice($prices, $i, $period);
        $sma[] = array_sum($subset) / $period;
    }

    return $sma;
}

// Function to calculate Standard Deviation
function calculateSD($prices, $sma, $period)
{
    $sd = [];
    $priceCount = count($prices);

    for ($i = 0; $i <= $priceCount - $period; $i++) {
        $subset = array_slice($prices, $i, $period);
        $mean = $sma[$i];
        $variance = 0;

        foreach ($subset as $price) {
            $variance += pow($price - $mean, 2);
        }

        $variance /= $period;
        $sd[] = sqrt($variance);
    }

    return $sd;
}

// Function to calculate Bollinger Bands and trigger buy/sell signals
function calculateBollingerBandsAndSignals($prices, $period = 20, $multiplier = 2)
{
    // Step 1: Calculate SMA
    $sma = calculateSMA($prices, $period);

    // Step 2: Calculate Standard Deviation
    $sd = calculateSD($prices, $sma, $period);

    // Step 3: Calculate Bollinger Bands and trigger signals
    $bollingerBands = [];
    $signals = [];  // Array to store buy/sell signals
    for ($i = 0; $i < count($sma); $i++) {
         $upperBand = $sma[$i] + ($multiplier * $sd[$i]);
        $lowerBand = $sma[$i] - ($multiplier * $sd[$i]);
        $currentPrice = $prices[$i + $period - 1]; // The current price in the period

        $bollingerBands[] = [
            'sma' => $sma[$i],
            'upper' => $upperBand,
            'lower' => $lowerBand,
            'price' => $currentPrice
        ];

        // Trigger Buy Signal: if the price crosses below the lower band
        if ($currentPrice < $lowerBand) {
            $signals[] = ['signal' => 'buy', 'price' => $currentPrice, 'index' => $i + $period - 1];
        } // Trigger Sell Signal: if the price crosses above the upper band
        elseif ($currentPrice > $upperBand) {
            $signals[] = ['signal' => 'sell', 'price' => $currentPrice, 'index' => $i + $period - 1];
        } else {
            $signals[] = ['signal' => 'hold', 'price' => $currentPrice, 'index' => $i + $period - 1];
        }
    }

    return ['bollingerBands' => $bollingerBands, 'signals' => $signals];
}

// Example usage
$end_point = "https://api.kite.trade/instruments/historical/9903874/15minute?from=2024-09-05+09:15:00&to=2024-09-05+15:30:00";
$res = $client->request('GET', $end_point);
$response = $res->getBody()->getContents();
$response = (json_decode($response,true));

$price = $response['data']['candles'];
foreach ($price as $p) {
    $prices[] = $p[4];
}

$period = 1;
$result = calculateBollingerBandsAndSignals($prices, $period);

foreach ($result['signals'] as $signal) {
    echo "Index " . $signal['index'] . " | Price: " . $signal['price'] . " | Signal: " . strtoupper($signal['signal']) . "\n";
}







?>
