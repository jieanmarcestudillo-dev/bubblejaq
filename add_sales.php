<!-- BACKEND -->
  <?php
    $page_title = 'Add Sale';
    require_once('includes/load.php');
    page_require_level(3);
    if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
  ?>
  <?php
    if(isset($_POST['add_sale'])){
      $req_fields = array('s_id','quantity','price','total', 'date' );
      validate_fields($req_fields);
          if(empty($errors)){
            $p_id      = $db->escape((int)$_POST['s_id']);
            $s_qty     = $db->escape((int)$_POST['quantity']);
            $s_total   = $db->escape($_POST['total']);
            $date      = $db->escape($_POST['date']);
            $s_date    = make_date();

            $sql  = "INSERT INTO sales (";
            $sql .= "product_id, qty, price, employee, date";
            $sql .= ") VALUES (";
            $sql .= "'{$p_id}', '{$s_qty}', '{$s_total}', '$_SESSION[user_id]','{$s_date}'";
            $sql .= ")";

                  if($db->query($sql)){
                    update_product_qty($s_qty,$p_id);
                    $session->msg('s',"Sale added. ");
                    redirect('add_sale.php', false);
                  } else {
                    $session->msg('d',' Sorry failed to add!');
                    redirect('add_sale.php', false);
                  }
          } else {
            $session->msg("d", $errors);
            redirect('add_sale.php',false);
          }
    }
    if(isset($_POST['filterCategory']) && $_POST['filterCategory'] != 'all'){
      $all_products = search_product_by_category($_POST['filterCategory']);
    }else{
      $all_products = join_product_table();
    }
    $all_categories = find_all('categories');
    $count = 0;
  ?>
<!-- BACKEND -->

<!-- CONTENT -->
  <?php include_once('layouts/header_user.php'); ?>
      <div class="d-flex" id="wrapper">
          <!-- MAIN CONTENT -->
              <div id="page-content-wrapper">
                  <!-- NAV BAR -->
                      <nav class="navbar navbar-expand-lg border-bottom">
                          <div class="container-fluid mx-3">
                              <ul class="navbar-nav me-auto mt-lg-0 text-center">
                                  <li class="nav-item">
                                      <h4 class="text-uppercase">BUBBLEJAQ</h4>
                                  </li>
                              </ul>
                              <div class="dropdown ms-auto">
                                  <button class="btn btn-outline-light rounded-0 dropdown-toggle px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <?php echo remove_junk(ucfirst($user['name'])); ?>
                                  </button>
                                  <ul class="dropdown-menu" >
                                    <li><a class="dropdown-item" href="usersAccount.php">Edit Account</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                  </ul>
                              </div>
                          </div>
                      </nav>
                  <!-- NAV BAR -->

                  <!-- MAIN CONTENT -->
                  <div class="container-fluid mb-5 mainBar">
                        <div class="card mx-3 mt-3 pt-4 pb-3 bg-body shadow rounded-0">
                          <div class="row" style="margin-left:37px;">
                          <form action="add_sales.php" method="post">
                            <p class="fs-5 fw-bolder text-uppercase">Product Categories</p>
                            <ul class="nav nav-tabs mb-4">
                              <li class="nav-item">
                                <button type="submit" name="submitCategory" value="all" class="nav-link active rounded-0 border-bottom" style="color:#303030">All</button>
                              </li>
                              <?php
                                require_once('includes/load.php');
                                $sql = "SELECT * FROM categories";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    $categoryId = $row['id'];
                                    $categoryName = $row['name'];
                                    echo '
                                    <li class="nav-item">
                                      <button type="submit" name="filterCategory" onclick="clickFilter();" value="' . $categoryId . '" class="nav-link active rounded-0 border-bottom" style="color:#303030">
                                          ' . $categoryName . '
                                      </button>
                                    </li>
                                    ';
                                }
                              ?>
                            </ul>
                            <button hidden id="filterBtn">submit</button>
                          </form>
                          </div>
                          <div class="row">
                            <!-- PRODUCT -->
                              <div class="col-6" style="overflow-y: scroll; height:520px;">
                              <div class="row align-middle">
                                <div class="col-5"><p class="fs-5 text-uppercase fw-bolder ps-5 pt-2">Products</p></div>
                                <div class="col-7 text-end ps-5"><input class="form-control rounded-0 border-2" id="searchProduct" type="search" placeholder="Search Product" aria-label="Search" style="width:275px;"></div>
                              </div>
                              <div class="row px-5 g-2" id="productOutput">
                              <div class="alert text-center rounded-0 bg-body alert-light d-none fw-bold" role="alert" id="noResultsMessage">
                                NO PRODUCTS FOUND
                              </div>
                                <?php if (!empty($all_products)): ?>
                                  <?php foreach ($all_products as $product): ?>
                                      <div class="col-4">
                                          <div class="card pb-0 rounded-0 shadow">
                                              <img src="uploads/products/<?php echo $product['image']; ?>" class="img-fluid rounded-start px-4 pt-3">
                                              <div class="card-body text-center">
                                                  <h5 class="fw-bold text-uppercase" style="font-size: 14px;"><?php echo $product['name']; ?></h5>
                                                  <div class="row g-0 text-center">
                                                      <button style="border:1px solid #F48C06; color:#F48C06;" class="btn rounded-0 btn-sm" onclick="addToCart('<?php echo $product['common_id']; ?>')">ADD TO CART</button>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <div class="alert text-center rounded-0 bg-body alert-light fw-bold" role="alert">
                                      NO PRODUCTS FOUND
                                  </div>
                                <?php endif; ?>
                                </div>
                              </div>
                            <!-- PRODUCT -->
                          
                            <!-- CART -->
                              <div class="col-6">
                                <div class="row">
                                  <div class="col-8">
                                    <p class="fs-5 text-uppercase fw-bold">Customer's Cart</p>
                                  </div>
                                  <div class="col-4 text-end">
                                    <button class="btn text-uppercase border-0 border-bottom fw-bold form-control btn-sm rounded-0" style="border:1px solid #F48C06; color:#F48C06;" onclick="removeAllItems()">Clear Cart</button>
                                  </div>
                                </div>
                                <table class="table table-hovered" style="background-color: white;">
                                  <thead class="text-center text-uppercase fw-bold" style="font-size:14px">
                                      <th>No.</th>
                                      <th>Item</th>
                                      <th>Qty</th>
                                      <th>Price</th>
                                      <th>Sub Total</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tableSales" class="align-middle text-center" style="font-size:14px"> </tbody>
                                  <tfoot>
                                    <tr>
                                      <td colspan="2" class="fw-bold">Total:</td>
                                      <td colspan="3"> ₱<span id="totalValue"></span>.00</td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" class="fw-bold">Amount Rendered:</td>
                                      <td colspan="3"> <input type="number" class="form-control rounded-0 bg-body" onchange="calculate(this.value)" id="cash" placeholder="Enter the amount here"></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" class="fw-bold">Change:</td>
                                      <td colspan="3"> <span id="balance"></span></td>
                                    </tr>
                                  </tfoot>
                                </table>
                                <button class="btn form-control rounded-0 text-white py-2 fw-bold" style="background-color:#F48C06; letter-spacing:2px; width:98%;" onclick="place_order()">CONFIRM ORDER</button>
                              </div>
                            <!-- CART -->
                          </div> 
                        </div>
                      </div>
                  <!-- MAIN CONTENT -->
              </div>
          <!-- MAIN CONTENT -->
      </div>

      <!-- FUNCTION -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="libs/js/function.js"></script>
        <script type="text/javascript" src="libs/js/saleFunction.js"></script>
      <!-- FUNCTION -->

      <!-- MODAL -->
        <div class="modal fade" id="addToCartModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">CHOOSE SIZES</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="row text-center">
                    <div class="col-12">
                      <div id="product-container"></div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      <!-- MODAL -->
<!-- CONTENT -->