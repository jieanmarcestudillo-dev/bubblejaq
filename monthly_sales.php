<?php
  $page_title = 'Monthly Sales';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
    $start  = date('Y-m-01 00:00:00');
    $end = date('Y-m-t 23:59:59');
    $results = find_daily_and_monthly($start,$end);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Monthly Sales</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-border">
            <thead>
              <tr>
                  <th>Date</th>
                  <th>Product Title</th>
                  <th>Size</th>
                  <td><th>Buying Price</th></td>
                  <td><th>Selling Price</th></td>
                  <td><th>Total Qty</th></td>
                  <td><th>Total Price</th></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($results as $result): ?>
               <tr>
                  <td class=""><?php echo remove_junk($result['created_date']);?></td>
                  <td>
                    <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
                  </td>
                  <td><?=$result['item_size']?></td>
                  <td class="text-right"><th>₱<?php echo remove_junk($result['buy_price']);?></th></td>
                  <td class="text-right"><th>₱<?php echo remove_junk($result['sale_price']);?></th></td>
                  <td class="text-right"><th><?php echo remove_junk($result['qty']);?></th></td>
                  <td class="text-right"><th>₱ <?php echo remove_junk($result['qty']) * $result['sale_price']?>.00</th></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
            
          </table>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
