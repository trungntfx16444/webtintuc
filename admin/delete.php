<?php 
    require_once "connect.php";
    $id = $_GET['id'];
    $query = "DELETE FROM `rss` WHERE `id` = '$id'";
    $database->query($query);
    header("Location: list.php");