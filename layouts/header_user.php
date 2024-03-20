<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#f48c06">
    <title>Bubble JAQ</title>
    <!-- <link rel="stylesheet" href="libs/css/main.css" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/user.css" />
    <link rel="manifest" href="admin-manifest.json">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
     <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('admin-service-worker.js')
        .then(function(registration) {
            console.log('Service Worker registered with scope:', registration.scope);
        }).catch(function(error) {
            console.log('Service Worker registration failed:', error);
        });
    }
    </script>
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <!-- <header id="header" style= "background-color: #fcbf49"> 
      <div class="logo pull-left"> Bubble JAQ</div>
      <div class="header-content" >
      <div class="header-date pull-left">
        <strong><?php 
        date_default_timezone_set('Asia/Manila');
        echo "<span style='color:black;font-weight:bold;'>Date: </span>". date('F j, Y g:i:a');?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Profile
                  </a>
              </li>
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Settings
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Logout
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header> -->
  <?php endif;?>
