<!-- BACKEND -->
<?php
    $page_title = 'All sale';
    require_once('includes/load.php');
    page_require_level(3);
  ?>
  <?php
  $logs = find_all_activity();

  ?>
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
                                <h4 class="text-uppercase">ACTIVITY LOGS</h4>
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
                        <div class="bg-body py-4 px-5 mx-3 bg-body rounded shadow-lg">
                            <div class="row mt-2">
                                <table id="table" class="table table-border text-center align-middle">  
                                    <thead>
                                        <tr>
                                            <th class="text-center col-1">No.</th>
                                            <th class="text-center">Activity Logs</th>
                                            <th class="text-center col-2">User</th>
                                            <th class="text-center col-4">Date and Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($logs as $log):?>
                                    <tr>
                                        <td class="text-center col-2"><?php echo count_id();?></td>
                                        <td><?php echo $log['content'] ?></td>
                                        <td><?php echo $log['name'] ?></td>
                                        <td class="text-center"><?php echo date("F j, Y | g:i A", strtotime($log['created_at'])); ?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    <!-- MAIN CONTENT -->
                </div>
            <!-- MAIN CONTENT -->
        </div>
    <!-- CONTENT -->

    <!-- SCRIPT -->
        <!-- FOR TABLE -->
            <script>
                    $('#table').dataTable({
                    "language": {
                        "emptyTable": "No Activity Found"
                    },
                    "lengthChange": true,
                    "scrollCollapse": true,
                    "paging": true,
                    "info": true,
                    "responsive": true,
                    "ordering": false,
                    "aLengthMenu": [[10, 50, 75, -1], [10, 50, 75, "All"]],
                    "iDisplayLength": 10,
                    });
            </script>
        <!-- FOR TABLE -->
    <!-- SCRIPT -->
<?php include_once('layouts/footer.php'); ?>
