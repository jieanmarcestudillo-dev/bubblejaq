<!-- BACKEND -->
    <?php
        $page_title = 'Add Sale';
        require_once('includes/load.php');
        page_require_level(3);
        if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
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
                                  <button class="btn btn-outline-light rounded-0 dropdown-toggle px-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                      <?php echo remove_junk(ucfirst($user['name'])); ?>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="add_sales.php">Home</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                  </ul>
                              </div>
                          </div>
                      </nav>
                  <!-- NAV BAR -->

                  <!-- MAIN CONTENT -->
                      <div class="container-fluid mb-5 mainBar">
                        <div class="row">
                            <div class="px-5 pt-5"><?php echo display_msg($msg); ?></div>
                            <div class="col-md-4 px-5">
                                <div class="card rounded-0 p-5 shadow bg-body">
                                    <div class="row">
                                        <h4 class="text-center mb-4">UPDATE PICTURE</h4>
                                        <div class="col-6 mx-auto text-center">
                                            <img class="img-fluid" src="/uploads/users/<?php echo $user['image'];?>" style="width:220px;">
                                        </div>
                                        <form class="mt-4" action="edit_account.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <input type="file" class="form-control rounded-0" name="userImage">
                                            </div>
                                            <div class="mb-3 text-center">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                                                <button style="border:1px solid #F48C06; color:#F48C06;" type="submit" name="uploadImage" class="btn rounded-0 px-5 text-uppercase">Change Image</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 px-5">
                                <div class="card p-5 rounded-0 shadow bg-body">
                                    <div class="panel-body">
                                    <h4 class="text-center mb-4">UPDATE INFORMATION</h4>
                                        <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control rounded-0" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control rounded-0" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
                                            </div>
                                            <div class="form-group text-center">
                                                <button style="border:1px solid #F48C06; color:#F48C06;" type="submit" name="updateInfo" class="btn rounded-0 px-5 text-uppercase">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 px-5 mx-auto">
                                <div class="card p-5 rounded-0 shadow bg-body">
                                    <div class="panel-body">
                                    <h4 class="text-center mb-4">CHANGE PASSWORD</h4>
                                        <form method="post" action="change_password.php">
                                            <div class="mb-3">
                                                <label class="form-label">New password</label>
                                                <input type="password" class="form-control rounded-0" name="new-password" placeholder="New password">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Old password</label>
                                                <input type="password" class="form-control rounded-0" name="old-password" placeholder="Old password">
                                            </div>
                                            <div class="mb-3 text-center">
                                                <button style="border:1px solid #F48C06; color:#F48C06;" type="submit" name="update" class="btn rounded-0 px-5 text-uppercase">Save Changes</button>
                                                <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="libs/js/function.js"></script>
        <script type="text/javascript" src="libs/js/saleFunction.js"></script>
      <!-- FUNCTION -->
<!-- CONTENT -->