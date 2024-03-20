<?php
require_once('includes/load.php');
$sql = "SELECT id, name, quantity, sale_price, item_size
FROM products WHERE common_id = '$_POST[prodId]'";
$result = $db->query($sql);
$productData = array();
while ($row = $result->fetch_assoc()) {
    $productData[] = $row;
}
echo json_encode($productData);
?>