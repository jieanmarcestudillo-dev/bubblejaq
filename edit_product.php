<!-- BACKEND -->
  <!-- FETCH -->
    <?php
      require_once('includes/load.php');
      $product = find_by_common_id('products',(int)$_GET['id']);
      $all_categories = find_all('categories');
      $all_photo = find_all('media');
    ?>
  <!-- FETCH -->

  <!-- UPDATE PRODUCTS -->
    <?php
      if (isset($_POST['update_product'])) {
          require_once('includes/load.php');
          $common_id = $_POST['common_id'];
          $p_name = $_POST['product-title'];
          $p_cat = $_POST['product-categories'];

          $query = "UPDATE products SET name = '$p_name', categorie_id = '$p_cat' WHERE common_id = '$common_id'";
          $result = $db->query($query);

          $sizes = array(
              'XL' => array('xl-qty', 'xl-buy', 'xl-price'),
              'L' => array('large-qty', 'large-buy', 'large-price'),
              'M' => array('medium-qty', 'medium-buy', 'medium-price'),
              'S' => array('small-qty', 'small-buy', 'small-price')
          );

          foreach ($sizes as $size => $fields) {
              list($qtyField, $buyField, $priceField) = $fields;
              $qty = $_POST[$qtyField];
              $buy = $_POST[$buyField];
              $price = $_POST[$priceField];

              $query = "UPDATE products SET quantity = '$qty', buy_price = '$buy', sale_price = '$price' WHERE common_id = '$common_id' AND item_size = '$size'";
              $result = $db->query($query);
          }

          if ($result) {
              date_default_timezone_set('Asia/Manila');
              $content = "he/she updated the product of $p_name";
              $user = $_SESSION['user_id'];
              $date = date('Y-m-d H:i:s');
              $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";

              if ($db->query($sqlInsertLog)) {
                  $session->msg('s', "Product information has been updated.");
              }
          } else {
              $session->msg('d', "Failed to update product information.");
          }

          if (isset($_FILES['product-photo']) && $_FILES['product-photo']['error'] != UPLOAD_ERR_NO_FILE) {
              $productPhoto = uniqid() . '_' . $_FILES['product-photo']['name'];

              if ($_FILES['product-photo']['size'] <= 10048576) {
                  $targetDir = 'uploads/products/';
                  $targetFile = $targetDir . $productPhoto;

                  if (move_uploaded_file($_FILES['product-photo']['tmp_name'], $targetFile)) {
                      $query = "UPDATE products SET picture = '$productPhoto' WHERE common_id = '$common_id'";
                      $result = $db->query($query);
                      if ($result) {
                          $session->msg('s', "Product photo has been updated.");
                      } else {
                          $session->msg('d', "Failed to update product photo in the database.");
                      }
                  } else {
                      $session->msg('d', "Failed to move uploaded product photo.");
                  }
              } else {
                  $session->msg('d', 'The file size is too large.');
              }
          }

          redirect('edit_product.php?id=' . $common_id, false);
      }
    ?>
  <!-- UPDATE PRODUCTS -->
<!-- BACKEND -->

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
                              <h4 class="text-uppercase">Edit Products</h4>
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
                        <form method='post' action='edit_product.php' enctype='multipart/form-data' class='clearfix'> 
                        <?php echo display_msg($msg); ?>
                          <!-- PRODUCT IMAGE -->
                            <div class="row">
                              <div class="col-3 text-center mx-auto">
                                <img src="uploads/products/<?php echo $product['picture']; ?>" class="img-fluid rounded-start">
                              </div>
                            </div>
                          <!-- PRODUCT IMAGE -->

                          <!-- PRODUCT MAIN INFO -->
                              <div class="row mt-2">
                                <div class="col-4">
                                  <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input required type="text" class="form-control rounded-0" name="product-title" value="<?php echo $product['name']?>">
                                    <input required type="hidden" class="form-control rounded-0" name="common_id" value="<?php echo $product['common_id']?>">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="mb-3">
                                    <label class="form-label">Product Image</label>
                                    <input type="file" class="custom-file-input form-control rounded-0" id="customFile" style="display:block" name="product-photo">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="mb-3">
                                  <label class="form-label">Product Category</label>
                                    <select class="form-select rounded-0" name="product-categories">
                                      <option selected value="<?php echo $product['categorie_id'] ?>"><?php echo $product['categorie'] ?></option>
                                      <?php  foreach ($all_categories as $cat): ?>
                                        <option value="<?php echo (int)$cat['id'] ?>">
                                          <?php echo $cat['name'] ?>
                                        </option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                          <!-- PRODUCT MAIN INFO -->

                          <!-- PRODUCT SUB INFO -->
                            <div class="form-group">
                              <div class="row">
                                  <!-- SMALL -->
                                    <div class="col-3">
                                      <div class="card rounded-0">
                                        <div class="card-header text-center fw-bold text-muted bg-body">
                                          SMALL SIZE
                                        </div>
                                        <?php
                                          $sql = "SELECT * FROM products WHERE common_id = '$product[common_id]' AND quantity != 0 AND item_size = 'S'";
                                          $result = $db->query($sql);
                                          while ($data = $result->fetch_assoc()) {
                                              echo "
                                                  <ul class='list-group list-group-flush'>
                                                    <li class='list-group-item'>
                                                        <label class='form-label'>Buying Price ₱</label>
                                                        <div class='input-group'>
                                                            <input type='hidden' name='common_id' value='{$data['common_id']}'>
                                                            <input type='hidden' name='productName' value='{$data['name']}'>
                                                            <input required type='number' min='0' min='0' class='form-control rounded-0' name='small-buy' value='{$data['buy_price']}'>
                                                        </div>
                                                    </li>
                                                    <li class='list-group-item'>
                                                        <label class='form-label'>Selling Price ₱</label>
                                                        <div class='input-group'>
                                                            <input required type='number' min='0' class='form-control rounded-0' name='small-price' value='{$data['sale_price']}'>
                                                        </div>
                                                    </li>
                                                    <li class='list-group-item'>
                                                        <label class='form-label'>Quantity</label>
                                                        <div class='input-group'>
                                                            <input required type='number' min='0' class='form-control rounded-0' name='small-qty' value='{$data['quantity']}'>
                                                        </div>
                                                    </li>
                                                  </ul> 
                                                  ";
                                          }if ($result->num_rows == 0) {
                                              echo "
                                                  <ul class='list-group list-group-flush'>
                                                    <li class='list-group-item'>
                                                        <label class='form-label'>Buying Price ₱</label>
                                                        <div class='input-group'>

                                                            <input placeholder='Not Available' type='number' min='0' min='0' class='form-control rounded-0' name='small-buy' >
                                                        </div>
                                                    </li>
                                                    <li class='list-group-item'>
                                                        <label class='form-label'>Selling Price ₱</label>
                                                        <div class='input-group'>
                                                            <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='small-price'>
                                                        </div>
                                                    </li>
                                                    <li class='list-group-item'>
                                                        <label class='form-label'>Quantity</label>
                                                        <div class='input-group'>
                                                            <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='small-qty'>
                                                        </div>
                                                    </li>     
                                                  </ul>                                     
                                                  ";
                                          }
                                        ?>
                                      </div>
                                    </div>
                                  <!-- SMALL -->

                                  <!-- MEDIUM -->
                                    <div class="col-3">
                                      <div class="card rounded-0">
                                          <div class="card-header text-center fw-bold text-muted bg-body">
                                            MEDIUM SIZE
                                          </div>
                                          <?php
                                            $sql = "SELECT * FROM products WHERE common_id = '$product[common_id]' AND quantity != 0  AND item_size = 'M'";
                                            $result = $db->query($sql);
                                            while ($data = $result->fetch_assoc()) {
                                                echo "
                                                    <ul class='list-group list-group-flush'>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Buying Price ₱</label>
                                                          <div class='input-group'>
                                                              <input type='hidden' name='common_id' value='{$data['common_id']}'>
                                                              <input type='hidden' name='productName' value='{$data['name']}'>
                                                              <input required type='number' min='0' min='0' class='form-control rounded-0' name='medium-buy' value='{$data['buy_price']}'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Selling Price ₱</label>
                                                          <div class='input-group'>
                                                              <input required type='number' min='0' class='form-control rounded-0' name='medium-price' value='{$data['sale_price']}'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Quantity</label>
                                                          <div class='input-group'>
                                                              <input required type='number' min='0' class='form-control rounded-0' name='medium-qty' value='{$data['quantity']}'>
                                                          </div>
                                                      </li>
                                                    </ul>
                                                    ";
                                            }if ($result->num_rows == 0) {
                                                echo "
                                                    <ul class='list-group list-group-flush'>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Buying Price ₱</label>
                                                          <div class='input-group'>
                                                              <input placeholder='Not Available' type='number' min='0' min='0' class='form-control rounded-0' name='medium-buy'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Selling Price ₱</label>
                                                          <div class='input-group'>
                                                              <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='medium-price'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Quantity</label>
                                                          <div class='input-group'>
                                                              <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='medium-qty'>
                                                          </div>
                                                      </li>
                                                    </ul>
                                                    ";
                                            }
                                          ?> 
                                      </div>
                                    </div>
                                  <!-- MEDIUM -->

                                  <!-- LARGE -->
                                    <div class="col-3">
                                      <div class="card rounded-0">
                                        <div class="card-header text-center fw-bold text-muted bg-body">
                                            LARGE SIZE
                                          </div>
                                          <?php
                                            $sql = "SELECT * FROM products WHERE common_id = '$product[common_id]' AND quantity != 0  AND item_size = 'L'";
                                            $result = $db->query($sql);
                                            while ($data = $result->fetch_assoc()) {
                                                echo "
                                                    <ul class='list-group list-group-flush'>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Buying Price ₱</label>
                                                          <div class='input-group'>
                                                          <input type='hidden' name='common_id' value='{$data['common_id']}'>
                                                          <input type='hidden' name='productName' value='{$data['name']}'>
                                                              <input required type='number' min='0' min='0' class='form-control rounded-0' name='large-buy' value='{$data['buy_price']}'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Selling Price ₱</label>
                                                          <div class='input-group'>
                                                              <input required type='number' min='0' class='form-control rounded-0' name='large-price' value='{$data['sale_price']}'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Quantity</label>
                                                          <div class='input-group'>
                                                              <input required type='number' min='0' class='form-control rounded-0' name='large-qty' value='{$data['quantity']}'>
                                                          </div>
                                                      </li>
                                                    </ul>
                                                    ";
                                            }if ($result->num_rows == 0) {
                                                echo "
                                                    <ul class='list-group list-group-flush'>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Buying Price ₱</label>
                                                          <div class='input-group'>
                                                              <input placeholder='Not Available' type='number' min='0' min='0' class='form-control rounded-0' name='large-buy'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Selling Price ₱</label>
                                                          <div class='input-group'>
                                                              <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='large-price'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Quantity</label>
                                                          <div class='input-group'>
                                                              <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='large-qty'>
                                                          </div>
                                                      </li>
                                                    </ul>
                                                    ";
                                            }
                                          ?> 
                                      </div>
                                    </div>
                                  <!-- LARGE -->

                                  <!-- X LARGE -->
                                    <div class="col-3">
                                      <div class="card rounded-0">
                                        <div class="card-header text-center fw-bold text-muted bg-body">
                                            EXTRA LARGE SIZE
                                          </div>
                                            <?php
                                              $sql = "SELECT * FROM products WHERE common_id = '$product[common_id]' AND quantity != 0  AND item_size = 'XL'";
                                              $result = $db->query($sql);
                                              while ($data = $result->fetch_assoc()) {
                                                  echo "
                                                    <ul class='list-group list-group-flush'>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Buying Price ₱</label>
                                                          <div class='input-group'>
                                                              <input type='hidden' name='common_id' value='{$data['common_id']}'>
                                                              <input type='hidden' name='productName' value='{$data['name']}'>
                                                              <input required type='number' min='0' min='0' class='form-control rounded-0' name='xl-buy' value='{$data['buy_price']}'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Selling Price ₱</label>
                                                          <div class='input-group'>
                                                              <input required type='number' min='0' class='form-control rounded-0' name='xl-price' value='{$data['sale_price']}'>
                                                          </div>
                                                      </li>
                                                      <li class='list-group-item'>
                                                          <label class='form-label'>Quantity</label>
                                                          <div class='input-group'>
                                                              <input required type='number' min='0' class='form-control rounded-0' name='xl-qty' value='{$data['quantity']}'>
                                                          </div>
                                                      </li>
                                                    </ul>
                                                      ";
                                              }if ($result->num_rows == 0) {
                                                  echo "
                                                      <ul class='list-group list-group-flush'>
                                                        <li class='list-group-item'>
                                                            <label class='form-label'>Buying Price ₱</label>
                                                            <div class='input-group'>
                                                                <input placeholder='Not Available' type='number' min='0' min='0' class='form-control rounded-0' name='xl-buy'>
                                                            </div>
                                                        </li>
                                                        <li class='list-group-item'>
                                                            <label class='form-label'>Selling Price ₱</label>
                                                            <div class='input-group'>
                                                                <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='xl-price'>
                                                            </div>
                                                        </li>
                                                        <li class='list-group-item'>
                                                            <label class='form-label'>Quantity</label>
                                                            <div class='input-group'>
                                                                <input placeholder='Not Available' type='number' min='0' class='form-control rounded-0' name='xl-qty'>
                                                            </div>
                                                        </li>
                                                      </ul>
                                                      ";
                                              }
                                            ?> 
                                      </div>
                                    </div>
                                  <!-- X LARGE -->
                              </div>
                            </div>
                          <!-- PRODUCT SUB INFO -->
                          <div class="row">
                                <div class="col-4 text-end ms-auto">
                                  <button type="submit" name="update_product" class="btn rounded-0 mt-3 px-5" style="background-color:#F48C06; color:#fff !important;">SAVE CHANGES</button>
                                </div>
                              </div> 
                          </div>
                        </form>
                      </div>
                    </div>
                  <!-- MAIN CONTENT -->
              </div>
          <!-- MAIN CONTENT -->
      </div>
    <!-- CONTENT -->
<?php include_once('layouts/footer.php'); ?>