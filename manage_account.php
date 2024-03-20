<!-- BACKEND -->
    <!-- PAGINATION -->
    <?php
        $page_title = 'Edit User';
        require_once('includes/load.php');
        page_require_level(1);
      ?>
    <!-- PAGINATION -->

      <?php
        require_once('includes/load.php');
        $all_users = find_all_user();
      ?>
    <!-- FETCH USERS -->
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
                            <h4 class="text-uppercase">MANAGE ACCOUNT</h4>
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
                      <div class="bg-body pt-2 pb-4 mx-5 bg-body rounded shadow-lg">
                      <div class="row mt-4 px-5">
                        <div class="px-2"><?php echo display_msg($msg); ?></div>
                        <!-- USER INFORMATION -->
                          <div class="col-6">
                            <form action="updateInfo.php" method="post" class="clearfix">
                              <h5 class="fw-bold">MY INFORMATION</h5>
                              <div class="my-3">
                                <label class="form-label">Name</label>
                                <input type="name" class="form-control rounded-0" name="name" value="<?php echo remove_junk(ucfirst($user['name'])); ?>">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control rounded-0" name="username" value="<?php echo remove_junk(ucfirst($user['username'])); ?>">
                                <input type="hidden" class="form-control rounded-0" name="user_id" value="<?php echo remove_junk(ucfirst($user['id'])); ?>">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Role</label>
                                <input readonly type="text" class="form-control rounded-0" value="Admin">
                              </div>
                              <div class="text-end">
                                <button type="submit" name="update" class="btn rounded-0 mt-2" style="background-color:#F48C06; color:#fff !important;">Save Changes</button>
                              </div>
                            </form>
                          </div>
                        <!-- USER INFORMATION -->

                        <!-- USER PASSWORD -->
                          <div class="col-6">
                            <form action="updateInfo.php" method="post" class="clearfix">
                              <h5 class="fw-bold">MY CREDENTIALS</h5>
                                <div class="my-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control rounded-0" name="password" placeholder="Type your new password">
                                </div>
                                <div class="my-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="hidden" class="form-control rounded-0" name="user_id" value="<?php echo remove_junk(ucfirst($user['id'])); ?>">
                                    <input type="password" class="form-control rounded-0" name="confirmPassword" placeholder="Re-type your new password">
                                </div>
                                <div class="form-group clearfix">
                                      <button type="submit" name="update-pass" class="btn pull-right rounded-0" style="background-color:#F48C06; color:#fff !important;">Change Password</button>
                                </div>
                            </form>
                          </div>
                        <!-- USER PASSWORD -->
                      </div>
                      </div>
                    </div>
                <!-- MAIN CONTENT -->
            </div>
        <!-- MAIN CONTENT -->
    </div>
  <!-- CONTENT -->
<?php include_once('layouts/footer.php'); ?>