<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = totalProduct('products');
 $c_sale          = totalSales('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('15')
?> 

<?php include_once('layouts/header.php'); ?>
    <div class="d-flex" id="wrapper">
        <!-- SIDE BAR -->
            <?php include('layouts/admin_menu.php'); ?>
        <!-- SIDE BAR -->

        <!-- MAIN CONTENT -->
            <div id="page-content-wrapper">
                <!-- NAV BAR -->
                    <nav class="navbar navbar-expand-lg border-bottom">
                        <div class="container-fluid">
                            <h4 class="text-uppercase">Dashboard</h4>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                    <li>
                                        <a class="nav-link me-3">
                                            <span class="fw-bold"><?php echo remove_junk(ucfirst($user['name'])); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                <!-- NAV BAR -->

                <!-- MAIN CONTENT -->
                    <div class="container-fluid mb-5 mainBar">
                        <!-- CARDS -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <div class="card shadow pb-3 rounded-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <i class="bi bi-people-fill"></i>
                                                </div>
                                                <div class="col-8 text-center cardInfo">
                                                    <p class="card-text fw-bold cardText">TOTAL USERS</p>
                                                    <p class="card-text fw-bold cardNo"> <?php  echo $c_user['total']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card shadow pb-3 rounded-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <i class="bi bi-receipt-cutoff"></i>
                                                </div>
                                                <div class="col-8 text-center cardInfo">
                                                    <p class="card-text fw-bold cardText">CATEGORIES</p>
                                                    <p class="card-text fw-bold cardNo"><?php  echo $c_categorie['total']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card shadow pb-3 rounded-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <i class="bi bi-diagram-3-fill"></i>
                                                </div>
                                                <div class="col-8 text-center cardInfo">
                                                    <p class="card-text fw-bold cardText">TOTAL PRODUCTS</p>
                                                    <p class="card-text fw-bold cardNo"><?php  echo $c_product['total']; ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card shadow pb-3 rounded-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <i class="bi bi-cash-coin"></i>
                                                </div>
                                                <div class="col-8 text-center cardInfo">
                                                    <p class="card-text fw-bold cardText">TOTAL SALES</p>
                                                    <p class="card-text fw-bold cardNo">₱<?php  echo $c_sale['total']; ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- CARDS -->
                        <!-- CHART -->
                            <div class="row ps-3 pe-2">
                                <div class="card shadow ps-3 py-5">
                                    <canvas id="salesPerMonth"></canvas>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="card p-4 shadow">
                                        <h5 class="text-uppercase text-center mb-2">RECENTLY ADDED PRODUCTS</h5>
                                        <?php
                                          require_once('includes/load.php');
                                          $sql = "SELECT p.id, p.common_id, p.name, p.date, c.name AS categorie, picture AS image
                                          FROM products p LEFT JOIN categories c ON c.id = p.categorie_id LEFT JOIN media m ON m.id = p.media_id
                                          GROUP BY p.name ORDER BY p.date DESC LIMIT 3";
                                          $result = $db->query($sql);
                                          while ($data = $result->fetch_assoc()) {
                                            $newDate = date('F j, Y | g:i A', strtotime($data['date']));
                                            echo"
                                            <div class='card mb-2'>
                                                <div class='row g-0'>
                                                  <div class='col-md-4 text-center'>
                                                    <img style='width:100%; height:160px;' src='uploads/products/$data[image]' class='img-fluid rounded-start p-3'>
                                                  </div>
                                                  <div class='col-md-8'>
                                                    <div class='card-body'>
                                                      <h5 class='card-title'>$data[name]</h5>
                                                      <p class='card-text'>Savor the rich, indulgent flavors of our signature shakes. Creamy, delicious, and the perfect treat for any craving. Try one today!</p>
                                                      <p class='card-text'><small class='text-muted'>Added At $newDate</small></p>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            ";
                                          }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card p-4 shadow" style="height:37.7rem;">
                                        <h5 class="text-uppercase text-center mb-2">TOP 5 MOST SELLING PRODUCTS</h5>
                                        <div class="card p-4" id="common">
                                            <canvas id="pie" width="300" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- CHART -->
                    </div>
                <!-- MAIN CONTENT -->
            </div>
        <!-- MAIN CONTENT -->

        <!-- FUNCTION -->
          <script>
            $(document).ready(function(){
              graph();
              function graph(){
                $.ajax({
                    url: 'salesPerMonth.php',
                    method: 'GET',
                    success : function(data) {
                        if(data != ""){
                          const sales = JSON.parse(data);
                            const ctx = document.getElementById('salesPerMonth').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                labels: sales.months,
                                datasets: [{
                                    label: 'Sales Per Month',
                                    data : sales.sales,
                                    borderWidth: 1,
                                    backgroundColor: [
                                        '#F48C06',
                                    ],
                                    borderColor: [
                                        '#F48C065e',
                                    ],
                                }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max:5000
                                        },
                                    }
                                }
                            });
                        }else{
                            var target = document.getElementById("visualization");
                            target.innerHTML += "<div class='text-danger fs-4 text-center' style='position:absolute; top:19rem; width:100%' role='alert'>NO DATA AVAILABLE</div>";
                        }
                    }
                })
              }
            });
          </script>

          <script>
            $(document).ready(function(){
              highestSales();
              function highestSales(){
                $.ajax({
                    url: 'highestSales.php',
                    method: 'GET',
                    success : function(data) {
                      const newData = JSON.parse(data);
                      if(data != ""){
                            const ctx = document.getElementById('pie').getContext('2d');
                                let highestSales  = new Chart(ctx,{
                                type: 'pie',
                                data:{
                                    datasets: [{
                                    data: newData.totals,
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',   
                                        'rgb(54, 162, 235)',   
                                        'rgb(255, 205, 86)', 
                                        'rgb(75, 192, 192)',   
                                        'rgb(153, 102, 255)',
                                    ],
                                }],

                                    labels:newData.products
                                },
                                options:{
                                    responsive: true,
                                }
                            })
                        }
                    }
                })
              }
            });
          </script>
        <!-- FUNCTION -->
    </div>
<?php include_once('layouts/footer.php'); ?>