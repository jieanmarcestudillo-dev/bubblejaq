<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
  if(isset($_POST['add_product'])){
    $randomNumber = random_int(000001, 999999);
    $sql = "INSERT INTO item(common_id) VALUES ('$randomNumber')";
    if ($db->query($sql) === TRUE) {
        $req_fields = array('product-title','product-categorie');
        validate_fields($req_fields);
        $p_name  = remove_junk($db->escape($_POST['product-title']));
        $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
        $p_qty1   = remove_junk($db->escape($_POST['small-qty']));
        $p_buy1   = remove_junk($db->escape($_POST['small-buy']));
        $p_sale1  = remove_junk($db->escape($_POST['small-price']));
        $p_qty2   = remove_junk($db->escape($_POST['medium-qty']));
        $p_buy2   = remove_junk($db->escape($_POST['medium-buy']));
        $p_sale2  = remove_junk($db->escape($_POST['medium-price']));
        $p_qty3   = remove_junk($db->escape($_POST['large-qty']));
        $p_buy3   = remove_junk($db->escape($_POST['large-buy']));
        $p_sale3  = remove_junk($db->escape($_POST['large-price']));
        $p_qty4   = remove_junk($db->escape($_POST['xl-qty']));
        $p_buy4   = remove_junk($db->escape($_POST['xl-buy']));
        $p_sale4  = remove_junk($db->escape($_POST['xl-price']));

        if (!isset($_FILES['product-photo']) || $_FILES['product-photo']['error'] == UPLOAD_ERR_NO_FILE) {
          $product_photo = 'default.png';
        }else{
          $productPhoto = uniqid() . '_' . $_FILES['product-photo']['name'];

          if ($_FILES['product-photo']['size'] > 10048576) {
            die('The file size is too large.');
          }
          $targetDir = 'uploads/products/';
          $targetFile = $targetDir . $productPhoto;
          move_uploaded_file($_FILES['product-photo']['tmp_name'], $targetFile);
          $product_photo = $productPhoto;
        }
        $date = date('Y-m-d H:i:s');
        
        try {
          $successMessage = '';
          //small
            if ($p_qty1 != '' || $p_buy1 != '' || $p_sale1 != '') {
                $query  = "INSERT INTO products (";
                $query .= " common_id,name,quantity,buy_price,sale_price,categorie_id,picture,date,item_size";
                $query .= ") VALUES (";
                $query .= " '{$randomNumber}', '{$p_name}', '{$p_qty1}', '{$p_buy1}', '{$p_sale1}', '{$p_cat}', '{$product_photo}', '{$date}', 'S'";
                $query .= ")";
                $db->query($query);
            }
          //small
      
          //medium
            if ($p_qty2 != '' || $p_buy2 != '' || $p_sale2 != '') {
                $query  = "INSERT INTO products (";
                $query .= " common_id, name,quantity,buy_price,sale_price,categorie_id,picture,date,item_size";
                $query .= ") VALUES (";
                $query .= " '{$randomNumber}', '{$p_name}', '{$p_qty2}', '{$p_buy2}', '{$p_sale2}', '{$p_cat}', '{$product_photo}', '{$date}', 'M'";
                $query .= ")";
                $db->query($query);
            }
          //medium
      
          //large
            if ($p_qty3 != '' || $p_buy3 != '' || $p_sale3 != '') {
                $query  = "INSERT INTO products (";
                $query .= " common_id, name,quantity,buy_price,sale_price,categorie_id,picture,date,item_size";
                $query .= ") VALUES (";
                $query .= " '{$randomNumber}', '{$p_name}', '{$p_qty3}', '{$p_buy3}', '{$p_sale3}', '{$p_cat}', '{$product_photo}', '{$date}', 'L'";
                $query .= ")";
                $db->query($query);
            } 
          //large
      
          //x-large
            if ($p_qty4 != '' || $p_buy4 != '' || $p_sale4 != '') {
                $query  = "INSERT INTO products (";
                $query .= " common_id, name,quantity,buy_price,sale_price,categorie_id,picture,date,item_size";
                $query .= ") VALUES (";
                $query .= " '{$randomNumber}', '{$p_name}', '{$p_qty4}', '{$p_buy4}', '{$p_sale4}', '{$p_cat}', '{$product_photo}', '{$date}', 'XL'";
                $query .= ")";
                $db->query($query); 
            }

            
          //LOGS
            date_default_timezone_set('Asia/Manila');
            $content = "he/she added the product of $p_name";
            $user = $_SESSION['user_id'];
            $date = date('Y-m-d H:i:s');
            $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";
            if ($db->query($sqlInsertLog)) {
                $session->msg('s',"Product added ");
                redirect('add_product.php', false);
            }
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
        }
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
    <!-- CONTENT -->
    <div class="d-flex" id="wrapper">
          <!-- SIDE BAR -->
              <?php include('layouts/admin_menu.php'); ?>
          <!-- SIDE BAR -->

          <!-- MAIN CONTENT -->
              <div id="page-content-wrapper">
                  <!-- NAV BAR -->
                      <nav class="navbar navbar-expand-lg border-bottom">
                          <div class="container-fluid">
                              <h4 class="text-uppercase">Add Product</h4>
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
                      <div class="bg-body py-4 px-5 bg-body rounded shadow-lg mx-5">
                        <?php echo display_msg($msg); ?>
                        <form method="post" action="add_product.php" enctype="multipart/form-data" class="clearfix">
                          <div class="row">
                            <div class="col-4">
                              <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input required type="text" class="form-control rounded-0" name="product-title" placeholder="Insert here the product name">
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="mb-3">
                              <label class="form-label">Product Category</label>
                                <select required class="form-select rounded-0" name="product-categorie">
                                    <option value="">Select Product Category</option>
                                  <?php  foreach ($all_categories as $cat): ?>
                                    <option value="<?php echo (int)$cat['id'] ?>">
                                      <?php echo $cat['name'] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="file" class="custom-file-input form-control rounded-0" id="customFile" style="display:block" name="product-photo">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                  <div class="card rounded-0">
                                    <div class="card-header text-center fw-bold text-muted bg-body">
                                      SMALL SIZE
                                    </div>
                                    <ul class="list-group list-group-flush">
                                      <li class="list-group-item">
                                        <label class="form-label">Buying Price ₱</label>
                                        <div class="input-group">
                                          <input type="number" min="0" min="0" class="form-control rounded-0" name="small-buy" placeholder="Buying Price">
                                        </div>
                                      </li>
                                      <li class="list-group-item">
                                        <label class="form-label">Selling Price ₱</label>
                                        <div class="input-group">
                                          <input type="number" min="0" class="form-control rounded-0" name="small-price" placeholder="Selling Price">
                                        </div>
                                      </li>
                                      <li class="list-group-item">
                                        <label class="form-label">Quantity</label>
                                        <div class="input-group">
                                          <input type="number" min="0" class="form-control rounded-0" name="small-qty" placeholder="Quantity">
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="card rounded-0">
                                      <div class="card-header text-center fw-bold text-muted bg-body">
                                        MEDIUM SIZE
                                      </div>
                                      <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                          <label class="form-label">Buying Price ₱</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="medium-buy" placeholder="Buying Price">
                                          </div>
                                        </li>
                                        <li class="list-group-item">
                                          <label class="form-label">Selling Price ₱</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="medium-price" placeholder="Selling Price">
                                          </div>
                                        </li>
                                        <li class="list-group-item">
                                          <label class="form-label">Quantity</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="medium-qty" placeholder="Quantity">
                                          </div>
                                        </li>
                                      </ul>
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="card rounded-0">
                                    <div class="card-header text-center fw-bold text-muted bg-body">
                                        LARGE SIZE
                                      </div>
                                      <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                          <label class="form-label">Buying Price ₱</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="large-buy" placeholder="Buying Price">
                                          </div>
                                        </li>
                                        <li class="list-group-item">
                                          <label class="form-label">Selling Price ₱</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="large-price" placeholder="Selling Price">
                                          </div>
                                        </li>
                                        <li class="list-group-item">
                                          <label class="form-label">Quantity</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="large-qty" placeholder="Quantity">
                                          </div>
                                        </li>
                                      </ul>
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="card rounded-0">
                                    <div class="card-header text-center fw-bold text-muted bg-body">
                                        EXTRA LARGE SIZE
                                      </div>
                                      <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                          <label class="form-label">Buying Price ₱</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="xl-buy" placeholder="Buying Price">
                                          </div>
                                        </li>
                                        <li class="list-group-item">
                                          <label class="form-label">Selling Price ₱</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="xl-price" placeholder="Selling Price">
                                          </div>
                                        </li>
                                        <li class="list-group-item">
                                          <label class="form-label">Quantity</label>
                                          <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="xl-qty" placeholder="Quantity">
                                          </div>
                                        </li>
                                      </ul>
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-3 text-end ms-auto">
                                <button type="submit" name="add_product" class="btn rounded-0 mt-3 px-5" style="background-color:#F48C06; color:#fff !important;">SUBMIT</button>
                              </div>
                            </div> 
                          </div>
                        </form>
                      </div>
                    </div>
                  <!-- MAIN CONTENT -->
              </div>
      </div>
    <!-- CONTENT -->
<?php include_once('layouts/footer.php'); ?>
