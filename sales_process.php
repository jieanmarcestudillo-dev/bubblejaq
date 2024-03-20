<?php
	
	require_once('includes/load.php');
	$item = json_decode($_POST['dataSent']);
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d h:i:s');
	for($x = 0; $x < sizeof($item); $x++){
		$productID = $item[$x]->id;
		$qty = $item[$x]->qty;
		$price = $item[$x]->price;
		$employee = $_SESSION['user_id'];
		uploadSales($productID,$qty,$price,$employee,$date);
	}
?>