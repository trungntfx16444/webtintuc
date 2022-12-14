<?php
setlocale(LC_MONETARY, 'vie_VN');
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [
    'start' => '1',
    'limit' => '10',
    'convert' => 'VND'
];

$headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: 01d568be-4358-46e6-9b82-2b4b7f66b4f7'
];
$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}?{$qs}"; // create the request URL


$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => $request,            // set the request URL
    CURLOPT_HTTPHEADER => $headers,     // set the headers 
    CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
));

$response = curl_exec($curl); // Send the request, save the response
curl_close($curl); // Close request

$arrCoin = json_decode($response, true)['data'];

$htmlCoint = "";
foreach ($arrCoin as $coin) {
    $price = number_format($coin['quote']['VND']['price'], 2);
    $change24h = number_format($coin['quote']['VND']['percent_change_24h'], 2);
    $textColor = $change24h > 0 ? "danger" : "success";
    $htmlCoint .= sprintf('
        <tr>
            <td>%s</td>
            <td>%s</td>
            <td><span class="text-%s">%s</span></td>
        </tr>', $coin['name'], $price, $textColor, $change24h);
}

?>

<table class="table table-sm">
    <thead>
        <tr>
            <th><b>Name</b></th>
            <th><b>Price (VND)</b></th>
            <th><b>Change (24h)</b></th>
        </tr>
    </thead>
    <tbody>
        <?php echo $htmlCoint ?>
    </tbody>
</table>