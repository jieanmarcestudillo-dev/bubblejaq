<!-- BACKEND -->
    <?php
      $page_title = 'My profile';
      require_once('includes/load.php');
      // Checkin What level user has permission to view this page
      page_require_level(3);
    ?>
    <?php
      $user_id = (int)$_GET['id'];
      if(empty($user_id)):
        redirect('home.php',false);
      else:
        $user_p = find_by_id('users',$user_id);
      endif;
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
                                    <li><a class="dropdown-item" href="profile.php?id=<?php echo (int)$user['id'];?>">Profile</a></li>
                                    <li><a class="dropdown-item" href="edit_account.php">Edit Account</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                  </ul>
                              </div>
                          </div>
                      </nav>
                  <!-- NAV BAR -->

                  <!-- MAIN CONTENT -->
                      <div class="container-fluid mb-5 mainBar">
                        <div class="row">
                          <div class="col-md-4">
                              <div class="panel profile">
                                <div class="jumbotron text-center bg-red">
                                  <img class="img-thumbnail img-size-2" src="uploads/users/<?php echo $user_p['image'];?>" alt="">
                                  <h3><?php echo first_character($user_p['name']); ?></h3>
                                </div>
                                <?php if( $user_p['id'] === $user['id']):?>
                                <ul class="nav nav-pills nav-stacked">
                                  <li><a href="edit_account.php"> <i class="glyphicon glyphicon-edit"></i> Edit profile</a></li>
                                </ul>
                              <?php endif;?>
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

<div class="row">
   <div class="col-md-4">
       <div class="panel profile">
         <div class="jumbotron text-center bg-red">
            <img class="img-circle img-size-2" src="uploads/users/<?php echo $user_p['image'];?>" alt="">
           <h3><?php echo first_character($user_p['name']); ?></h3>
         </div>
        <?php if( $user_p['id'] === $user['id']):?>
         <ul class="nav nav-pills nav-stacked">
          <li><a href="edit_account.php"> <i class="glyphicon glyphicon-edit"></i> Edit profile</a></li>
         </ul>
       <?php endif;?>
       </div>
   </div>
</div>

