<?php
  $page_title = 'All categories';
  require_once('includes/load.php');
  page_require_level(1);
  $all_categories = find_all('categories')
?>
<?php
 if(isset($_POST['add_cat'])){
    $sql  = "INSERT INTO categories (name)";
    $sql .= " VALUES ('$_POST[categoriesName]')";
    if($db->query($sql)){   
        date_default_timezone_set('Asia/Manila');
        $content = "he/she added the product of $_POST[categoriesName]";
        $user = $_SESSION['user_id'];
        $date = date('Y-m-d H:i:s');
        $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";
        if ($db->query($sqlInsertLog)) {
            $session->msg("s", "Successfully Added New Category");
            redirect('categories.php',false);
        }
    } else {
      $session->msg("d", "Sorry Failed to insert.");
      redirect('categories.php',false);
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
                                <h4 class="text-uppercase">Categories</h4>
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
                        <div class="bg-body py-4 ps-5 bg-body rounded shadow-lg">
                            <div class="pe-5"><?php echo display_msg($msg); ?></div>
                            <div class="div text-end me-5">
                                <button type="button" class="btn rounded-0 px-4" style="background-color:#F48C06; color:#fff !important;" data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</button>
                            </div>
                            <div class="row mt-2">
                                <?php foreach ($all_categories as $cat):?>
                                <div class="col-4 mb-3">
                                <div class="card text-center rounded-0 shadow" style="width: 18rem;">
                                    <img src="./orig_pic/bglogo.jpg" class="card-img-top mx-auto" style="height:10rem; width:10rem;">
                                    <div class="card-body">
                                    <h5 class="card-title text-uppercase mt-1 mb-3"><?php echo remove_junk(ucfirst($cat['name'])); ?></h5>
                                    <div class="row g-0 mx-3">
                                        <div class="col-6">
                                            <button style="background-color:#F48C06; color:#fff !important;" type="button" onclick="getCategory(<?php echo (int)$cat['id'];?>)" class="btn btn-sm rounded-0 px-4">UPDATE</button>
                                        </div>
                                        <div class="col-6">
                                            <button style="background-color:#F48C06; color:#fff !important;" type="button" onclick="deleteCategory(<?php echo (int)$cat['id'];?>)" class="btn btn-sm rounded-0 px-4">REMOVE</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        </div>
                    <!-- MAIN CONTENT -->
                </div>
            <!-- MAIN CONTENT -->

            <!-- MODAL -->
                <!-- ADD CATEGORY -->
                    <div class="modal fade" id="addCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">Add Category</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4">
                            <form method="post" action="categories.php">
                            <div class="mb-2">
                                <input type="text" class="form-control py-3 rounded-0 text-center" name="categoriesName">
                            </div>
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="button" class="btn btn-secondary rounded-0 px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add_cat" style="background-color:#F48C06; color:#fff !important;" class="btn rounded-0 px-4">Submit</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                <!-- ADD CATEGORY -->

                <!-- EDIT CATEGORY -->
                    <div class="modal fade" id="editCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">Edit Category</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4">
                            <form method="post" action="edit_categories.php">
                            <div class="mb-2">
                                <input type="hidden" class="form-control py-3 rounded-0 text-center" name="categoryId" id="categoryId">
                                <input type="text" required class="form-control py-3 rounded-0 text-center fs-3" name="categoriesName" id="categoriesName">
                            </div>
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="button" class="btn btn-secondary rounded-0 px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit_cat" style="background-color:#F48C06; color:#fff !important;" class="btn rounded-0 px-4">Submit</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>         
                <!-- EDIT CATEGORY -->
            <!-- MODAL -->

            <!-- FUNCTION -->
                <!-- DELETE CATEGORY -->
                    <script>
                        function deleteCategory(id){
                        Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to delete this Category?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#F48C06',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                            url: 'delete_categories.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {catId: id},
                        });
                        Swal.fire({
                            title: 'Delete Successfully',
                            text: "Category was delete successfully",
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
                    </script>
                <!-- EDIT CATEGORY -->
            <!-- FUNCTION -->
        </div>
    <!-- CONTENT -->
<?php include_once('layouts/footer.php'); ?>