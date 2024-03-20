<?php
require_once('includes/load.php');
global $db;

if (isset($_POST['action']) && $_POST['action'] === 'disableProduct') {
    $data = $_POST['data'];
    $productCommonId = $data[0]['productCommonId']; 
    $sql = "UPDATE products SET status = 1 WHERE common_id = '$productCommonId'";
    $result = $db->query($sql);
    echo $result ? 1 : 0;
}

if (isset($_POST['action']) && $_POST['action'] === 'enableProduct') {
    $data = $_POST['data'];
    $productCommonId = $data[0]['productCommonId']; 
    $sql = "UPDATE products SET status = 0 WHERE common_id = '$productCommonId'";
    $result = $db->query($sql);
    echo $result ? 1 : 0;
}
?>