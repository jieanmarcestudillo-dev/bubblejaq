<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = date('Y-m-d 00:00:00', strtotime(remove_junk($db->escape($_POST['start-date']))));
      $end_date     = date('Y-m-d 23:59:59', strtotime(remove_junk($db->escape($_POST['end-date']))));
      $results      = find_sale_by_dates($start_date,$end_date);
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }

  $total_markup = 0;
  $total_nomarkup = 0;
  $count = 1;
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Sales Report</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if($results): ?>
    <div class="page-break">
    <div class="text-right">
  <a href="export_sales_csv.php?start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="btn btn-primary">Export CSV</a>
       <div class="sale-head">
           <h1>Bubble JAQ - Sales Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> TILL DATE <?php if(isset($end_date)){echo $end_date;}?> </strong>
          
</div>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>#</th>
              <th>Product Title</th>
              <th>Size</th>
              <th>Date</th>
              <th>Buying Price</th>
              <th>Selling Price</th>
              <th>Total Qty</th>
              <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
           <tr>
              <td class=""><?=$count++?></td>
              <td>
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td><?=$result['item_size']?></td>
              <td class=""><?php echo remove_junk($result['created_date']);?></td>
              <td class="text-right">₱<?php echo remove_junk($result['buy_price']);?></td>
              <td class="text-right">₱<?php echo remove_junk($result['sale_price']);?></td>
              <td class="text-right"><?php echo remove_junk($result['total_qty']);?></td>
              <td class="text-right">₱<?php echo remove_junk($result['total_price']);?></td>
          </tr>
          <?php
            $total_markup += $result['total_price'];
            $total_nomarkup += $result['buy_price'] * $result['total_qty'];
          ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
         <tr class="text-right">
           <td colspan="6"></td>
           <td colspan="1">Grand Total</td>
           <td> ₱ <?=$total_markup?>.00
           
          </td>
         </tr>
         <tr class="text-right">
           <td colspan="6"></td>
           <td colspan="1">Profit</td>
           <td> ₱ <?=$total_markup - $total_nomarkup?>.00</td>
         </tr>

        </tfoot>
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Sorry no sales has been found. ");
        redirect('sales_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
