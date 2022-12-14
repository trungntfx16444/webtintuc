<?php
$link = "https://sjc.com.vn/xml/tygiavang.xml";
$context = stream_context_create(array('ssl' => array(
    'verify_peer' => false,
    "verify_peer_name" => false
)));
libxml_set_streams_context($context);
$xml = simplexml_load_file($link)->ratelist->city;
$xml = json_encode($xml);
$xml = json_decode($xml, true);

$htmlGold = "";
foreach ($xml['item'] as $gold) {
    $htmlGold .= sprintf('
        <tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>', $gold['@attributes']['type'], $gold['@attributes']['buy'], $gold['@attributes']['sell']);
}
?>
<table class="table table-sm">
    <thead>
        <tr>
            <th><b>Loại vàng</b></th>
            <th><b>Mua vào</b></th>
            <th><b>Bán ra</b></th>
        </tr>
    </thead>
    <tbody>
        <?php echo $htmlGold ?>
    </tbody>
</table>