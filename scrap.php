<?php

// Function to scrape stock closing data from Moneycontrol
function scrapeStockClosingData($symbol) {
  $url = "https://www.moneycontrol.com/india/stockpricequote/trading/adanienterprises/AE13";
  $headers = [
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
      'Referer: https://www.moneycontrol.com/',
  ];

  // Initialize cURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute the request
  $response = curl_exec($ch);
  curl_close($ch);

  return $response;
}

// Specify the stock symbol
$stockSymbol = "RELIANCE";

// Scrape the closing data for the stock
$closingPrice = scrapeStockClosingData($stockSymbol);

// Display the closing price
if ($closingPrice) {
  echo "Closing price of $stockSymbol: $closingPrice";
} else {
  echo "Failed to retrieve closing price for $stockSymbol";
}
?>
