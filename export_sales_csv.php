<?php
require_once('includes/load.php');
page_require_level(3);

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
  $start_date = date('Y-m-d 00:00:00', strtotime(remove_junk($db->escape($_POST['start_date']))));
  $end_date = date('Y-m-d 23:59:59', strtotime(remove_junk($db->escape($_POST['end_date']))));

  $results = find_sale_by_dates($start_date, $end_date);

  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="sales_report.csv"');

  $output = fopen('php://output', 'w');
  fputcsv($output, array('#', 'Product Title', 'Size', 'Date', 'Buying Price', 'Selling Price', 'Total Qty', 'TOTAL'));

  $count = 1;
  foreach ($results as $result) {
    fputcsv($output, array(
      $count++,
      remove_junk(ucfirst($result['name'])),
      $result['item_size'],
      remove_junk($result['created_date']),
      '₱' . remove_junk($result['buy_price']),
      '₱' . remove_junk($result['sale_price']),
      remove_junk($result['total_qty']),
      '₱' . remove_junk($result['total_price']),
    ));
  }
  fclose($output);
} else {
  $session->msg("d", "Error: Invalid dates.");
  redirect('sales_report.php', false);
}
