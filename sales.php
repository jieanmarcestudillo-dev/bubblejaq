<!-- BACKEND -->
  <?php
    $page_title = 'All sale';
    require_once('includes/load.php');
    page_require_level(3);
  ?>
  <?php
  $sales = find_all_sale();

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
                                <h4 class="text-uppercase">SALES</h4>
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
                            <div><?php echo display_msg($msg); ?></div>
                                <div class="row">
                                <div class="col-4 ms-auto text-end">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#generateReportsInCSV" class="btn text-white rounded px-4 py-2 rounded-0 btn-sm text-uppercase" style="background-color: #F48C06; color:#fffff !important;">
                                        Generate CSV
                                    </button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#generateReportsInPDF" class="btn text-white rounded px-4 py-2 rounded-0 btn-sm text-uppercase" style="background-color: #F48C06; color:#fffff !important;">
                                        Generate PDF
                                    </button>
                                </div>
                                </div>
                            </ul>
                            <div class="row mt-2">
                                <table id="table" class="table table-border text-center align-middle">  
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Size</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Sold by</th>
                                            <th class="text-center">Date and Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($sales as $sale):?>
                                    <tr>
                                        <td class="text-center"><?php echo count_id();?></td>
                                        <td><img src="uploads/products/<?=$sale['image']?>" style="height: 40px;"></td>
                                        <td><?php echo remove_junk($sale['name']); ?></td>
                                        <td><?=$sale['item_size']?></td>
                                        <td class="col-1"><?php echo (int)$sale['qty']; ?></td>
                                        <td>₱<?php echo remove_junk($sale['price']); ?></td>
                                        <td><?php echo remove_junk($sale['employee']); ?></td>
                                        <td><?php echo date("F j, Y | g:i A", strtotime($sale['created_date'])); ?></td>
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
                "aLengthMenu": [[10, 50, 75, -1], [10, 50, 75, "All"]],
                "iDisplayLength": 10,
                });
        </script>
        <!-- FOR TABLE -->
    <!-- JAVASCRIPT -->

    <!-- MODAL -->
        <!-- {{-- CHOOSE CAT --}} -->
            <div class="modal fade" id="generateReportsInPDF" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5">Generate Reports Into PDF</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row text-center">
                          <div class="col-3">
                              <a href='print_sales.php' class='btn rounded-0' style="border:1px solid #F48C06; color:#F48C06;">All Sales</a>
                          </div>
                          <div class="col-3">
                              <a href='print_daily_sales.php' class='btn rounded-0 px-4' style="border:1px solid #F48C06; color:#F48C06;">Daily</a>
                          </div>
                          <div class="col-3">
                              <button type="button" class="btn rounded-0 px-4" style="border:1px solid #F48C06; color:#F48C06;" data-bs-toggle="modal" data-bs-target="#monthlyReport">Monthly</button>
                          </div>
                          <div class="col-3">
                              <button type="button" class="btn rounded-0 px-4" style="border:1px solid #F48C06; color:#F48C06;" data-bs-toggle="modal" data-bs-target="#yearlyReport">Yearly</button>
                          </div>
                      </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- {{-- CHOOSE CAT --}} -->

        <!-- {{-- MONTHLY --}} -->
          <div class="modal fade" id="monthlyReport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Monthly Report</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="printMonthlyReports.php" id="selectMonthlyReports">
                <div class="modal-body">
                   <div class="row">
                    <div class="col-6">
                        <label for="exampleFormControlInput1" class="form-label">Select Month</label>
                        <select class="form-select" aria-label="Default select example" name="month" id="month" required>
                            <option selected>Open this select month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                        <div class="col-6">
                            <label for="exampleFormControlInput1" class="form-label">Select Year</label>
                            <select class="form-select" aria-label="Default select example" name="year" id="year" required>
                                <option selected>Open this select year</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" id="resetMonthlyReports">Refresh</button>
                    <a href="#" id="selectMonthButton" class="btn btn-primary rounded-0">Submit</a>
                </div>
                </form>
                </div>
            </div>
          </div>
        <!-- {{-- MONTHLY --}} -->

        <!-- {{-- YEARLY --}} -->
          <div class="modal fade" id="yearlyReport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Yearly Report</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form name='selectYearReports' method="POST" action="printYearlyReports.php" id="selectYearReports">
                  <div class="modal-body">
                  <div class="row">
                      <div class="col-7">
                          <label for="exampleFormControlInput1" class="form-label">Select Year</label>
                          <select class="form-select rounded-0" aria-label="Default select example" name="year" id="year" required>
                              <option selected>Open this select year</option>
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                              <option value="2023">2023</option>
                              <option value="2024">2024</option>
                              <option value="2025">2025</option>
                              <option value="2026">2026</option>
                          </select>
                      </div>
                      <div class="col-5">
                          <label for="exampleFormControlInput1" class="form-label me-5 pe-5">Action</label>
                          <button type="button" class="btn btn-secondary rounded-0" id="resetYear">Refresh</button>
                          <a href='#' class="btn btn-primary rounded-0" id="selectYearButton">Submit</a>
                      </div>
                      </div>
                  </div>
                  </form>
                  </div>
              </div>
          </div>
        <!-- {{-- YEARLY --}} -->

        <!-- GENERATE REPORTS IN CSV -->
            <div class="modal fade" id="generateReportsInCSV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">GENERATE REPORT IN CSV</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="export_sales_csv.php">
                    <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                            <input type="date" class="form-control rounded-0" name="start_date">
                        </div>
                            <div class="col-6">
                                <label for="exampleFormControlInput1" class="form-label">End Date</label>
                                <input type="date" class="form-control rounded-0" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-0">Submit</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        <!-- GENERATE REPORTS IN CSV -->
    <!-- MODAL -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // YEAR
                $('#selectYearReports #year').change(function() {
                    var selectedYear = $(this).val();
                    var href = 'printYearlyReports.php?year=' + selectedYear;
                    $('#selectYearButton').attr('href', href);
                });
                $('#resetYear').click(function() {
                    var href = 'printYearlyReports.php';
                    $('#selectYearButton').attr('href', '#');
                    $('#selectYearReports #year option:selected').prop('selected', false);
                    $('#selectYearReports #year option:first').prop('selected', true);
                });
                setInterval(function() {
                    if ($('#selectYearButton').attr('href') == '#') {
                        $('#selectYearButton').css({'pointer-events': 'none','cursor': 'not-allowed','text-decoration': 'line-through'});
                    }else {
                        $('#selectYearButton').css({'pointer-events': 'auto','cursor': 'pointer','text-decoration': 'none'});
                        $('#selectYearButton').prop('disabled', false);
                    }                   
                }, 1);
            // YEAR

            // MONTH
                setInterval(function() {
                    if ($('#selectMonthButton').attr('href') == '#') {
                        $('#selectMonthlyReports #year').prop('disabled', true)
                    }else {
                        $('#selectMonthlyReports #year').prop('disabled', false)
                    }               
                }, 1);

                $('#selectMonthlyReports #month').change(function() {
                    var selectedMonth= $(this).val();
                    var href = 'printMonthlyReports.php?month=' + selectedMonth;
                    $('#selectMonthButton').attr('href', href);
                });

                $('#selectMonthlyReports #year').change(function() {
                    var monthlyHref = $('#selectMonthButton').attr('href');
                    var selectedYear = $(this).val(); 
                    var newHref = monthlyHref + "&year=" + selectedYear; 
                    $('#selectMonthButton').attr('href', newHref); 
                });

                setInterval(function() {
                    var hrefValue = $('#selectMonthButton').attr('href');
                    if (hrefValue.indexOf('year=') === -1) {
                        $('#selectMonthButton').css({'pointer-events': 'none','cursor': 'not-allowed','text-decoration': 'line-through'});
                    } else {
                        $('#selectMonthButton').css({'pointer-events': 'auto','cursor': 'pointer','text-decoration': 'none'});
                    }
                }, 1); 

                $('#resetMonthlyReports').click(function() {
                    var href = 'printYearlyReports.php';
                    $('#selectMonthButton').attr('href', '#');
                    $('#selectMonthlyReports #year option:selected').prop('selected', false);
                    $('#selectMonthlyReports #year option:first').prop('selected', true);
                    
                    $('#selectMonthlyReports #month option:selected').prop('selected', false);
                    $('#selectMonthlyReports #month option:first').prop('selected', true);
                });
            // MONTH
        });
    </script>
<?php include_once('layouts/footer.php'); ?>
