<?php
require_once 'libs/Database.class.php';
$params = [
    'server' => 'localhost',
    'user' => 'root',
    'password' => '1234',
    'database' => 'manage_rss',
    'table' => 'rss'
];
$database = new Database($params);