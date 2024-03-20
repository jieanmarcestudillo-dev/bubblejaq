<?php
require_once('includes/load.php');

$sql = "SELECT p.name AS product, COUNT(*) AS total
        FROM sales s
        INNER JOIN products p ON s.product_id = p.id
        GROUP BY p.common_id ORDER BY total DESC LIMIT 5";

$results = $db->query($sql);

$data = array();

while ($row = $results->fetch_assoc()) {
    $data[] = array(
        'product' => $row['product'],
        'total' => $row['total']
    );
}

$response = ['products' => array_column($data, 'product'), 'totals' => array_column($data, 'total')];

echo json_encode($response);
?>