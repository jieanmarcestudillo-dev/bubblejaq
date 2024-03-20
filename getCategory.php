<?php
    require_once('includes/load.php');
    $catId = $_POST['catId'];
    $sql = "SELECT * FROM `categories` WHERE `id` = '$catId' ";
    $result = $db->query($sql);
    $categoryData = $result->fetch_assoc();
    echo json_encode($categoryData);
?>
