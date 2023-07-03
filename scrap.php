<?php
// Make HTTP request
$curl = curl_init();
$url = 'https://www.nseindia.com/get-quotes/equity?symbol=ADANIENT';
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

// Check for errors and handle the response
if ($response === false) {
    die('Error occurred during HTTP request.');
}

// Parse HTML content
$dom = new DOMDocument();
$dom->loadHTML($response);

// Extract data
$data = [];
$table = $dom->getElementsByTagName('table')->item(0);  // Adjust the index based on the HTML structure
$rows = $table->getElementsByTagName('tr');
foreach ($rows as $row) {
    $cells = $row->getElementsByTagName('td');
    if ($cells->length > 0) {
        $values = [];
        foreach ($cells as $cell) {
            $values[] = $cell->nodeValue;
        }
        $data[] = $values;
    }
}

// Store data
$fp = fopen('nse_data.csv', 'w');
foreach ($data as $values) {
    fputcsv($fp, $values);
}
fclose($fp);
?>
