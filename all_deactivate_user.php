<?php
  $page_title = 'All User';
  require_once('includes/load.php');
?>
<?php include_once('layouts/header.php'); ?>

  <!-- BACKEND -->
      <!-- FETCH USERS -->
        <?php
          require_once('includes/load.php');
          $all_users = find_all_deactivate_user();
        ?>
      <!-- FETCH USERS -->

      <!-- FETCH ROLE -->
        <?php
          require_once('includes/load.php');
          $groups = find_all('user_groups');
        ?>
      <!-- FETCH ROLE -->

      <!-- ADD USER -->
        <?php
          if(isset($_POST['add_user'])){
            $req_fields = array('full-name','username','password','level' );
            validate_fields($req_fields);

            if(empty($errors)){
                    $name   = remove_junk($db->escape($_POST['full-name']));
                $username   = remove_junk($db->escape($_POST['username']));
                $password   = remove_junk($db->escape($_POST['password']));
                $user_level = (int)$db->escape($_POST['level']);
                $password = sha1($password);
                  $query = "INSERT INTO users (";
                  $query .="name,username,password,user_level,status";
                  $query .=") VALUES (";
                  $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
                  $query .=")";
                  if($db->query($query)){
                    //sucess
                    $session->msg('s',"User account has been creted! ");
                    redirect('add_user.php', false);
                  } else {
                    //failed
                    $session->msg('d',' Sorry failed to create account!');
                    redirect('add_user.php', false);
                  }
            } else {
              $session->msg("d", $errors);
                redirect('add_user.php',false);
            }
          }
        ?>
      <!-- ADD USER -->
  <!-- BACKEND -->

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
                            <h4 class="text-uppercase">Users</h4>
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
                          <ul class="nav nav-tabs mb-4">
                              <li class="nav-item">
                                  <a class="nav-link" href="users.php">Active</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link active" href="#">Not Active</a>
                              </li>
                              <li class="nav-item ms-auto">
                                  <button type="button" class="btn text-white rounded px-4 py-2 rounded-0" data-bs-toggle="modal" data-bs-target="#addUser" style="background-color:#F48C06; color:#fff !important;">Add User</button>
                              </li>
                          </ul>
                              <table id="table" class="table table-border text-center align-middle">
                                  <thead>
                                      <tr>
                                          <th class="text-center">No.</th>
                                          <th class="text-center">Name</th>
                                          <th class="text-center">Username</th>
                                          <th class="text-center">User Role</th>
                                          <th class="text-center">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach($all_users as $a_user): ?>
                                    <tr>
                                      <td class="text-center"><?php echo count_id();?></td>
                                      <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
                                      <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
                                      <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name']))?></td>
                                      <td class="text-center col-2">
                                        <button type="button" data-toggle="tooltip" title="Activate" onclick="activateUser(<?php echo (int)$a_user['id'];?>)" class="btn btn-xs btn-outline-success rounded-0"><i class="bi bi-check2-square"></i></button>
                                        <a role="button" href="edit_user.php?id=<?php echo (int)$a_user['id'];?>" data-toggle="tooltip" title="Edit" onclick="editUser(<?php echo (int)$a_user['id'];?>)" class="btn btn-xs btn-outline-warning rounded-0"><i class="bi bi-pencil-square"></i></a>
                                        <!-- <button type="button" data-toggle="tooltip" title="Remove" onclick="deleteUser(<?php echo (int)$a_user['id'];?>)" class="btn btn-xs btn-outline-danger rounded-0"><i class="bi bi-trash3"></i></button> -->
                                      </td>
                                    </tr>
                                  <?php endforeach;?>
                                </tbody>
                              </table>
                      </div>
                    </div>
                <!-- MAIN CONTENT -->
            </div>
        <!-- MAIN CONTENT -->

        <!-- MODAL -->
          <!-- ADD USER -->
            <div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body px-4">
                      <form method="post" action="add_user.php">
                      <div class="mb-2">
                          <label class="form-label" for="name">Name</label>
                          <input type="text" class="form-control" name="full-name" placeholder="Full Name">
                      </div>
                      <div class="mb-2">
                          <label class="form-label" for="username">Username</label>
                          <input type="text" class="form-control" name="username" placeholder="Username">
                      </div>
                      <div class="mb-2">
                          <label class="form-label" for="password">Password</label>
                          <input type="password" class="form-control" name ="password"  placeholder="Password">
                      </div>
                      <div class="mb-2">
                        <label class="form-label" for="level">User Role</label>
                          <select class="form-select" name="level">
                            <?php foreach ($groups as $group ):?>
                              <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                            <?php endforeach;?>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer mx-auto">
                    <button type="button" class="btn btn-secondary rounded-0 px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_user" style="background-color:#F48C06; color:#fff !important;" class="btn rounded-0 px-4">Submit</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          <!-- ADD USER -->
        <!-- MODAL -->

        <!-- JAVASCRIPT -->
          <!-- FOR TABLE -->
            <script>
                  $('#table').dataTable({
                    "language": {
                      "emptyTable": "No Users Found"
                    },
                    "lengthChange": true,
                    "scrollCollapse": true,
                    "paging": true,
                    "info": true,
                    "responsive": true,
                    "ordering": false,
                    "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
                    "iDisplayLength": 25,
                  });
            </script>
          <!-- FOR TABLE -->
        <!-- JAVASCRIPT -->
    </div>
  <!-- CONTENT -->

  <!-- FUNCTION --> 
    <script>
        function editUser(id){
          $('#editUserModal').modal('show')
          $.ajax({
              url: 'getUsers.php',
              type: 'GET',
              dataType: 'json',
              data: {userId: id},
          })
          .done(function(response) {
              console.log(response);
              // $('#supp_id').val(response[0].id)
          })
        }
        function deleteUser(id){
          Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to delete this user?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#F48C06',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it'
          }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
              url: 'delete_user.php',
              type: 'POST',
              dataType: 'json',
              data: {userId: id},
          });
          Swal.fire({
              title: 'Delete Successfully',
              text: "User was delete successfully",
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

        function activateUser(id){
          Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to activate this user?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#F48C06',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Activate it'
          }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
              url: 'activate_user.php',
              type: 'POST',
              dataType: 'json',
              data: {userId: id},
          });
          Swal.fire({
              title: 'Activate Successfully',
              text: "User was activate successfully",
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
  <!-- FUNCTION -->
<?php include_once('layouts/footer.php'); ?>
