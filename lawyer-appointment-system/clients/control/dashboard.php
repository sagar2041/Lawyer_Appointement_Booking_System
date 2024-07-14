<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

include("../auth/header.php");
include("../auth/sidebar.php");



?>

<div class="page-content">
       
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Hello, <?= $_SESSION['name'] ?></h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group date datepicker wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary">
                    <i data-feather="calendar" class="text-primary"></i>
                </span>
                <input type="text" class="form-control border-primary bg-transparent">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card bg-success text-white box">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Active Cases</h6>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                </div>
                            </div>
                            <?php
                            include 'connection1.php';
                            $userid = $_SESSION['id'];

                            $activeCasesQuery = "
                                SELECT COUNT(*) AS active_cases 
                                FROM case_register 
                                INNER JOIN case_stage ON case_register.case_stage = case_stage.id 
                                WHERE case_register.client_name = $userid AND case_stage.status != '1'
                            ";
                            $result = mysqli_query($conn, $activeCasesQuery);

                            if ($result) {
                                $data = mysqli_fetch_assoc($result);
                                $activeCases = $data['active_cases'];
                            } else {
                                echo "Error: " . mysqli_error($conn);
                                $activeCases = 0;
                            }
                            ?>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"><?php echo $activeCases; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card bg-danger text-white box">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Inactive Cases</h6>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                </div>
                            </div>
                            <?php
                            $inactiveCasesQuery = "
                                SELECT COUNT(*) AS inactive_cases 
                                FROM case_register 
                                INNER JOIN case_stage ON case_register.case_stage = case_stage.id 
                                WHERE case_register.client_name = $userid AND case_stage.status = '1'
                            ";
                            $result = mysqli_query($conn, $inactiveCasesQuery);

                            if ($result) {
                                $data = mysqli_fetch_assoc($result);
                                $inactiveCases = $data['inactive_cases'];
                            } else {
                                echo "Error: " . mysqli_error($conn);
                                $inactiveCases = 0;
                            }
                            ?>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"><?php echo $inactiveCases; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card bg-warning text-white box">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Cases</h6>
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                </div>
                            </div>
                            <?php
                            $totalCasesQuery = "
                                SELECT COUNT(*) AS total_cases 
                                FROM case_register 
                                WHERE client_name = $userid
                            ";
                            $result = mysqli_query($conn, $totalCasesQuery);

                            if ($result) {
                                $data = mysqli_fetch_assoc($result);
                                $totalCases = $data['total_cases'];
                            } else {
                                echo "Error: " . mysqli_error($conn);
                                $totalCases = 0;
                            }
                            ?>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"><?php echo $totalCases; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">My Cases</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Case No</th>
                                    <th>Lawyer Name</th>
                                    <th>Court</th>
                                    <th>Case Type</th>
                                    <th>Case Stage</th>
                                    <th>Legal Acts</th>
                                    <th>Description</th>
                                    <th>Filing Date</th>
                                    <th>Hearing Date</th>
                                    <th>Opposite Lawyer</th>
                                    <th>Total Fees</th>
                                    <th>Payment status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection1.php';

                                $clientSql = "select name from clients where id = $userid";
                                $result = mysqli_query($conn, $clientSql);
                                $row = $result->fetch_assoc();
                                $client_name = strtoupper($row['name']);

                                $caseSql = "select * from case_register where client_name = $userid";
                                $result = mysqli_query($conn, $caseSql); 

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                    
                                    $courtid = $row['court'];
                                    $courtSql = "select court_category from court where id = $courtid";
                                    $court_result = mysqli_query($conn, $courtSql);
                                    $court_row = $court_result->fetch_assoc();
                                    $courtname = $court_row['court_category'];

                                    $caseid = $row['case_type'];
                                    $caseSql = "select case_type from case_types where id = $caseid";
                                    $case_result = mysqli_query($conn, $caseSql);
                                    $case_row = $case_result->fetch_assoc();
                                    $casename = $case_row['case_type'];

                                    $stageid = $row['case_stage'];
                                    $stageSql = "select status from case_stage where id = $stageid";
                                    $stage_result = mysqli_query($conn, $stageSql);
                                    $stage_row = $stage_result->fetch_assoc();
                                    $stagename = $stage_row['status'];

                                    $legelid = $row['legel_acts'];
                                    $legelSql = "select act_name from legel_acts where id = $legelid";
                                    $legel_result = mysqli_query($conn, $legelSql);
                                    $legel_row = $legel_result->fetch_assoc();
                                    $legelname = $legel_row['act_name'];

                                    $lawyerid = $row['lawyer_name'];
                                    $lawyerSql = "select name from lawyers where id = $lawyerid";
                                    $lawyer_result = mysqli_query($conn, $lawyerSql);
                                    $lawyer_row = $lawyer_result->fetch_assoc();
                                    $lawyername = $lawyer_row['name'];
                                    
                                    //if($row['client_name']==$userid){
                                ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['title']; ?></td>
                                        <td><?= $row['case_no']; ?></td>
                                        <td><?= $lawyername ?></td>
                                        <td><?= $courtname//$row['court']; ?></td>
                                        <td><?= $casename//$row['case_type']; ?></td>
                                        <td><?= ($stagename==1) ? "Inactive" : "Active" //$row['case_stage']; ?></td>
                                        <td><?= $legelname//$row['legel_acts']; ?></td>
                                        <td><?= $row['description']; ?></td>
                                        <td><?= $row['filling_date']; ?></td>
                                        <td><?= $row['hearing_date']; ?></td>
                                        <td><?= $row['opposite_lawyer']; ?></td>
                                        <td><?= $row['total_fees']; ?></td>
                                        <td><a class="btn btn-success" href="#">Done</a></td>
                                    </tr>
                                <?php
                                    //}
                                 }
                                } else {
                                    echo "<tr><td colspan='14'>No cases found</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("../auth/footer.php");
?>
