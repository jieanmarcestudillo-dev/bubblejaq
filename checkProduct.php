<?php
require_once('includes/load.php');
$productID = $_POST['product']['id']; 
$sql = "SELECT quantity FROM products WHERE id = '$productID'";
$result = $db->query($sql);
$productData = array();
while ($row = $result->fetch_assoc()) {
    $productData[] = $row;
}

echo json_encode($productData);
?>
