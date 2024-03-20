<?php
    require_once('includes/load.php');

    $monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // Get the current year
    $currentYear = date('Y');

    $sql = "SELECT DATE_FORMAT(created_date, '%M') AS monthName, SUM(price) AS totalSales 
            FROM sales 
            WHERE YEAR(created_date) = $currentYear
            GROUP BY monthName 
            ORDER BY MONTH(created_date) DESC";

    $results = $db->query($sql);

    $formattedOrders = array_fill_keys($monthNames, 0);

    foreach ($results as $result) {
        $formattedOrders[$result['monthName']] = $result['totalSales'];
    }

    $response = ['months' => $monthNames, 'sales' => array_values($formattedOrders)];

    echo json_encode($response);
?>
