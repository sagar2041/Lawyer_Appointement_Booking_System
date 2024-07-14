<?php
   session_start();
   error_reporting(0);
   if(!isset($_SESSION['username'])){
   	header('location:login.php');
   }
   
   ?>
<?php    /* <!--  Author Name- Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website - www.mayurik.com -->
      } */
   include("../auth/header.php");
   ?>
<?php include("../auth/sidebar.php");?>
<div class="page-content">
   <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
      <div>
         <h4 class="mb-3 mb-md-0">Hello, <?= $_SESSION['name'] ?></h4>
      </div>
      <div class="d-flex align-items-center flex-wrap text-nowrap">
         <div class="input-group date datepicker wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
            <span class="input-group-text input-group-addon bg-transparent border-primary"><i data-feather="calendar" class=" text-primary"></i></span>
            <input type="text" class="form-control border-primary bg-transparent">
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12 col-xl-12 stretch-card">
         <div class="row flex-grow-1">
            <div class="col-md-4 grid-margin stretch-card">
               <div class="card bg-warning text-white box">
                  <div class="card-body">
                     <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Total Clients</h6>
                        <div class="dropdown mb-2">
                           <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                           </button>
                        </div>
                     </div>
                     <?php
                        include 'connection1.php';
                        $result = mysqli_query($conn,"SELECT * FROM clients");
                        $rows = mysqli_num_rows($result);
                        /* echo "There are " . $rows . " rows in my table"; */
                        ?>
                     <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                           <h3 class="mb-2"><?php echo $rows; ?></h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
               <div class="card bg-danger text-white box">
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
                        include 'connection1.php';
                        $result1 = mysqli_query($conn,"SELECT * FROM case_register");
                        $row1 = mysqli_num_rows($result1);
                        
                        ?>
                     <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                           <h3 class="mb-2"><?php echo $row1; ?></h3>
                           <div class="d-flex align-items-baseline">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
               <div class="card bg-success text-white box">
                  <div class="card-body">
                     <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Active Case</h6>
                        <div class="dropdown mb-2">
                           <button class="btn p-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                           </button>
                        </div>
                     </div>
                     <?php
                        include 'connection1.php';
                        $results = mysqli_query($conn,"SELECT * FROM case_stage where status='0'");
                        $row2 = mysqli_num_rows($results);
                        
                        ?>
                     <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                           <h3 class="mb-2"><?php echo $row2; ?></h3>
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
               <h6 class="card-title">Recent cases</h6>
               <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                     <thead>
                        <tr>
                           <th>Id</th>
                           <th>Title</th>
                           <th>Case No</th>
                           <th>Client Name</th>
                           <th>Court</th>
                           <th>Status</th>
                           <th>Case Stage</th>
                           <th>Legel Acts</th>
                           <th>Description</th>
                           <th>Filling Date</th>
                           <th>Hearing Date</th>
                           <th>Opposite Lawyer</th>
                           <th>Total fees</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                           include 'connection1.php';
                           $lawyer_id = $_SESSION['id'];
                           $appointment_sql = "SELECT * FROM case_register 
                                               WHERE lawyer_name = $lawyer_id";
                           $result = $conn->query($appointment_sql);

                           if($result->num_rows > 0){
                              while($row = $result->fetch_assoc()){
                              //fetch client data
                              $client_id = $row['client_name'];
                              $client_sql = "SELECT * FROM clients WHERE id = '$client_id'";
                              $clientResult = $conn->query($client_sql);
                              $clientRow = $clientResult->fetch_assoc();
                              $client_name = $clientRow['name'];

                              //fetch court data
                              $court_id = $row['court'];
                              $court_sql = "SELECT * FROM court WHERE id = '$court_id'";
                              $courtResult = $conn->query($court_sql);
                              $courtRow = $courtResult->fetch_assoc();
                              $court_name = $courtRow['court_category'];

                              //fetch caseStage data
                              $case_id = $row['case_stage'];
                              $case_sql = "SELECT * FROM case_stage WHERE id = '$case_id'";
                              $caseResult = $conn->query($case_sql);
                              $caseRow = $caseResult->fetch_assoc();
                              $case_stage_name = $caseRow['name'];

                              //fetch caseStage data
                              $legel_id = $row['legel_acts'];
                              $legel_sql = "SELECT * FROM legel_acts WHERE id = '$legel_id'";
                              $legelResult = $conn->query($legel_sql);
                              $legelRow = $legelResult->fetch_assoc();
                              $legel_name = $legelRow['act_name'];
                        ?>
                        <tr>
                           <td><?=$row['id'];?></td>
                           <td><?=$row['title'];?></td>
                           <td><?=$row['case_no'];?></td>
                           <td><?=$client_name; ?></td>
                           <td><?=$court_name; ?></td>
                           <td><?=($row['case_stage'])==1 ? "Inactive" : "Active";?></td>
                           <td><?=$case_stage_name; ?></td>
                           <td><?=$legel_name; ?></td>
                           <td><?=$row['description'];?></td>
                           <td><?=$row['filling_date'];?></td>
                           <td><?=$row['hearing_date'];?></td>
                           <td><?=$row['opposite_lawyer'];?></td>
                           <td><?=$row['total_fees'];?></td>
                           <!-- <td><?=$row['unpaid'];?></td> -->
                           <td>
                              <a class="btn btn-danger" href="delete_register.php?case_register_id=<?=$row['id'];?>"><i class="fa fa-trash text-white" aria-hidden="true"></i></a>
                              <a class="btn btn-success" href="edit_register.php?case_register_id=<?=$row['id'];?>"><i class="fa fa-edit text-white" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                        <?php		
                              }
                           } else {
                              echo "<tr><td colspan='9'>No Appointments Found</td></tr>";
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