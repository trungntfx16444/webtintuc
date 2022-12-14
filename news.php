<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); //! chuyền về múi giờ việt nam
error_reporting(0);

require_once "admin/connect.php";
$sql = "SELECT `link` FROM `rss` WHERE `status` = 'active' ORDER BY `ordering` ASC LIMIT 1 ";
$queryResult = $database->query($sql);
$linkResult = $database->getSingleRecord($queryResult);
$link = $linkResult['link'];
$address = parse_url($link, PHP_URL_HOST); //! lấy tên host từ URL
$xml = simplexml_load_file($link, 'SimpleXMLElement', LIBXML_NOCDATA); //! lấy dữ liệu từ link xml, và chuyển về thành dạng mảng
$xmlJson = json_encode($xml); // từ mảng object chuyển về dạng json
$xmlArr = json_decode($xmlJson, TRUE); // chuyển về dạng mảng để dể sử lý
$items = $xmlArr['channel']['item'];
$result = [];
$i = 0;
foreach ($items as $key => $item) {
    if ($i == 24) break;
    // lay description va img
    preg_match('#src="(.*)"#imsU', $item['description'], $img);
    preg_match('#br.*>\s*(.*)#i', $item['description'], $description);
    $result[$key] = [
        'title' => $item['title'],
        'link' => $item['link'],
        'img' => $img[1],
        'description' => $description[1],
        'pubDate' => date('d/m/y H:i:s', strtotime($item['pubDate']))
    ];
    $i++;
}
// do du lieu vao
$newsHtml = '';

foreach ($result as $new) {
    $newsHtml .= sprintf(
        '<div class="col-md-6 col-lg-4 p-3">
    <div class="entry mb-1 clearfix">
        <div class="entry-image mb-3">
            <a href=""
                data-lightbox="image"
                style="background: url(%s) no-repeat center center; background-size: cover; height: 278px;"></a>
        </div>
        <div class="entry-title">
            <h3><a  href="%s"
                    target="_blank">%s</a>
            </h3>
        </div>
        <div class="entry-content">
        %s
        </div>
        <div class="entry-meta no-separator nohover">
            <ul class="justify-content-between mx-0">
                <li><i class="icon-calendar2"></i>%s</li>
                <li>%s</li>
            </ul>
        </div>
        <div class="entry-meta no-separator hover">
            <ul class="mx-0">
                <li><a href="%s"
                        target="_blank">Xem &rarr;</a></li>
            </ul>
        </div>
    </div>
</div>',
        $new['img'],
        $new['link'],
        $new['title'],
        $new['description'],
        $new['pubDate'],
        $address,
        $new['link']
    );
}

echo $newsHtml;