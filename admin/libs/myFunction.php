<?php 
    public function renderNews(){

        $result = [];

    foreach ($items as $key => $item) {
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
}
    }