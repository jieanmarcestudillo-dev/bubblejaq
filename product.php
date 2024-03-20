<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
   page_require_level(2);
  $products = join_product_table();
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
                              <h4 class="text-uppercase">Active Products</h4>
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
                        <div class="bg-body py-4 px-5 bg-body rounded shadow-lg">
                            <div><?php echo display_msg($msg); ?></div>
                            <div class="div text-end">
                                <a href="in_active_product.php" role="button" class="btn rounded-0 px-4 me-3" style="border-bottom: 1px solid #F48C06 !important; color: #F48C06">In-Active Product</a>
                                <a href="add_product.php" role="button" class="btn rounded-0 px-4" style="background-color:#F48C06; color:#fff !important;">Add Product</a>
                            </div>
                            <div class="row mt-2">
                              <?php if (!empty($products)): ?>
                              <?php foreach ($products as $product):?>
                                <div class="col-6 mb-3">
                                  <div class="card pb-0 shadow">
                                    <div class="row g-0">
                                      <div class="col-md-5 pt-5 text-end">
                                        <img src="uploads/products/<?php echo $product['image']; ?>" class="img-fluid rounded-start" style="height:236px;">
                                      </div>
                                      <div class="col-md-7">
                                        <div class="card-body pt-4" style="line-height:15px;">
                                          <p class="card-title fw-bold text-center text-uppercase" style="font-size:16px; letter-spacing:1px;"><?php echo remove_junk($product['name']); ?></p>
                                          <p class="card-title fw-bold text-muted text-center text-uppercase" style="font-size:12px;"><?php echo remove_junk($product['categorie']); ?></p>
                                          <table id="table" class="table table-border table-striped text-center align-middle mt-3">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Size</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Buying</th>
                                                    <th class="text-center">Selling</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                  <?php
                                                    $sql = "SELECT * FROM products WHERE name = '$product[name]'";
                                                    $result = $db->query($sql);
                                                    while ($data = $result->fetch_assoc()) {
                                                      echo"
                                                      <tr>
                                                        <td>{$data['item_size']}</td>
                                                        <td>{$data['quantity']}</td>
                                                        <td>₱{$data['buy_price']}</td>
                                                        <td>₱{$data['sale_price']}</td>
                                                      </tr>
                                                      ";
                                                    }
                                                  ?>            
                                            </tbody>
                                          </table>
                                          <div class="row text-center mb-1 g-0 mx-3">
                                            <div class="col-6 mx-auto">
                                                <a role="button" href="edit_product.php?id=<?php echo (int)$product['common_id'];?>" style="background-color:#F48C06; color:#fff !important;" type="button" onclick="getCategory(<?php echo (int)$cat['id'];?>)" class="btn btn-sm rounded-0 px-4 py-2">UPDATE</a>
                                            </div>
                                            <div class="col-6 mx-auto">
                                                <a role="button" style="background-color:#F48C06; color:#fff !important;" type="button" onclick="disableProduct(<?php echo (int)$product['common_id'];?>)" class="btn btn-sm rounded-0 px-4 py-2">DISABLE</a>
                                            </div>
                                            <!-- <div class="col-6 mx-auto ">
                                                <a role="button" href="#" style="background-color:#F48C06; color:#fff !important;" type="button" onclick="removeProduct(<?php echo (int)$product['common_id'];?>)" class="btn btn-sm rounded-0 px-4">REMOVE</a>
                                            </div> -->
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <div class="text-center">
                                    <H5 class="my-5 text-uppercase text-dark">No active products found.</H5>
                                </div>
                              <?php endif; ?>
                            </div>
                        </div>
                      </div>
                  <!-- MAIN CONTENT -->
              </div>
          <!-- MAIN CONTENT -->

          <!-- FUNCTION -->
              <!-- DELETE CATEGORY -->
                  <!-- <script>
                      function removeProduct(id){
                      Swal.fire({
                      title: 'Are you sure?',
                      text: "Do you want to delete this Product?",
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonColor: '#F48C06',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it'
                      }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                          url: 'delete_product.php',
                          type: 'POST',
                          dataType: 'json',
                          data: {prodId: id},
                      });
                      Swal.fire({
                          title: 'Delete Successfully',
                          text: "Product was delete successfully",
                          icon: 'success',
                          showConfirmButton: false,
                          timer: 1500,
                      }).then((result) => {
                          if (result) {
                            location.reload();
                          }
                      });
                      }
                      });
                      }
                  </script> -->
              <!-- DELETE CATEGORY -->

              <!-- EDIT CATEGORY -->
                  <script>
                      function getCategory(id){
                          $('#editCategory').modal('show')
                          $.ajax({
                              url: 'getCategory.php',
                              type: 'POST',
                              dataType: 'json',
                              data: {catId: id},
                          })
                          .done(function(response) {
                              $('#categoryId').val(response.id)
                              $('#categoriesName').val(response.name)
                          })
                      }

                      function disableProduct(id){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to disable this product?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#F48C06',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, disable it'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                url: 'productStatus.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                  action: 'disableProduct',
                                  data: [{productCommonId: id}]
                                }
                            });
                            Swal.fire({
                                title: 'Change Status',
                                text: "Product was DISABLE successfully",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500,
                            }).then((result) => {
                            if (result) {
                                location.reload();
                            }
                            });
                            }
                            });
                      }
                  </script>
              <!-- EDIT CATEGORY -->
          <!-- FUNCTION -->
      </div>
    <!-- CONTENT -->
<?php include_once('layouts/footer.php'); ?>
