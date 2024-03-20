<!-- BACKEND -->
    <!-- PAGINATION -->
    <?php
        $page_title = 'Edit User';
        require_once('includes/load.php');
        page_require_level(1);
      ?>
    <!-- PAGINATION -->

    <!-- GET THE USERS INFO -->
      <?php
        $e_user = find_by_id('users',(int)$_GET['id']);
        $groups  = find_all('user_groups');
        if(!$e_user){
          $session->msg("d","Missing user id.");
          redirect('users.php');
        }
      ?>
    <!-- GET THE USERS INFO -->

    <!-- UPDATE USERS INFO -->
      <?php
        if(isset($_POST['update'])) {
          $req_fields = array('name','username','level');
          validate_fields($req_fields);
          if(empty($errors)){
                  $id = (int)$e_user['id'];
                $name = remove_junk($db->escape($_POST['name']));
            $username = remove_junk($db->escape($_POST['username']));
                $level = (int)$db->escape($_POST['level']);
            $status   = remove_junk($db->escape($_POST['status']));
                  $sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
              $result = $db->query($sql);
                if($result && $db->affected_rows() === 1){
                  date_default_timezone_set('Asia/Manila');
                  $content = "he/she updated the user of $name";
                  $user = $_SESSION['user_id'];
                  $date = date('Y-m-d H:i:s');
                  $sqlInsertLog = "INSERT INTO logs(content, user, created_at) VALUES('$content', '$user', '$date')";
                  if ($db->query($sqlInsertLog)) {
                      $session->msg('s',"Account Updated ");
                      redirect('edit_user.php?id='.(int)$e_user['id'], false);
                  }
                } else {
                  $session->msg('d',' Sorry failed to updated!');
                  redirect('edit_user.php?id='.(int)$e_user['id'], false);
                }
          } else {
            $session->msg("d", $errors);
            redirect('edit_user.php?id='.(int)$e_user['id'],false);
          }
        }
      ?>
    <!-- UPDATE USERS INFO -->

    <!-- UPDATE USER PASSWORD -->
      <?php
        if(isset($_POST['update-pass'])) {
          if($_POST['password'] != $_POST['confirmPassword']){
            $session->msg('d',"User password not equal to Confirm Password ");
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          }else{
            $req_fields = array('password');
            validate_fields($req_fields);
            if(empty($errors)){
              $id = (int)$e_user['id'];
              $password = remove_junk($db->escape($_POST['password']));
              $h_pass = sha1($password);
                $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
                $result = $db->query($sql);
                  if($result && $db->affected_rows() === 1){
                    $session->msg('s',"User Password has been updated ");
                    redirect('edit_user.php?id='.(int)$e_user['id'], false);
                  }else {
                    $session->msg('d',' Sorry failed to updated user password!');
                    redirect('edit_user.php?id='.(int)$e_user['id'], false);
                  }
            }else{
              $session->msg("d", $errors);
              redirect('edit_user.php?id='.(int)$e_user['id'],false);
            }
          }
        }
      ?>
    <!-- UPDATE USER PASSWORD -->

    <!-- FETCH USERS -->
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
                            <h4 class="text-uppercase">EDIT USERS</h4>
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
                            <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
                              <h5 class="fw-bold">USERS INFORMATION</h5>
                              <div class="my-3">
                                <label class="form-label">Name</label>
                                <input type="name" class="form-control rounded-0" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control rounded-0" name="username" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select rounded-0" name="level">
                                  <?php foreach ($groups as $group ):?>
                                    <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                                  <?php endforeach;?>
                                </select>
                              </div>
                              <div class="text-end">
                                <button type="submit" name="update" class="btn rounded-0 mt-2" style="background-color:#F48C06; color:#fff !important;">Save Changes</button>
                              </div>
                            </form>
                          </div>
                        <!-- USER INFORMATION -->

                        <!-- USER PASSWORD -->
                          <div class="col-6">
                            <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
                            <h5 class="fw-bold">USERS CREDENTIALS</h5>
                              <div class="my-3">
                                  <label class="form-label">New Password</label>
                                  <input type="password" class="form-control rounded-0" name="password" placeholder="Type user new password">
                              </div>
                              <div class="my-3">
                                  <label class="form-label">Confirm Password</label>
                                  <input type="password" class="form-control rounded-0" name="confirmPassword" placeholder="Re-type user new password">
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