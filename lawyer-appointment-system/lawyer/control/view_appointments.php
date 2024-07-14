<?php
   /* ini_set('display_errors', 1);*/
   error_reporting(E_ALL);
   session_start();
   if(!isset($_SESSION['username'])){
      header('location:login.php');
   }
   include("../auth/header.php");
?>
<?php include("../auth/sidebar.php"); ?>
<link rel="stylesheet" href="popup_style.css">
<div class="page-content">
   <?php
      if(isset($_GET['id']))
      { ?>
   <div class="popup popup--icon -question js_question-popup popup--visible">
      <div class="popup__background"></div>
      <div class="popup__content">
         <h3 class="popup__content__title">
         Sure
         </h3>
         <p>Are You Sure To Delete This Appointment?</p>
         <p>
            <a href="delete_appointment.php?id=<?php echo $_GET['id']; ?>" class="btn btn-success" data-for="js_success-popup">Yes</a>
            <a href="view_appointments.php" class="btn btn-danger" data-for="js_success-popup">No</a>
         </p>
      </div>
   </div>
   <?php } ?>
   <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
         <div class="card">
            <div class="card-body">
               <h6 class="card-title">View Appointments</h6>
               <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Title</th>
                           <th>Client Name</th>
                           <th>Filling Date</th>
                           <th>Description</th>
                           <th>Status</th>
                           <th>Total Fees</th>
                           <!-- <th>Unpaid</th> -->
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
                              $client_id = $row['client_name'];
                              $client_sql = "SELECT * FROM clients WHERE id = '$client_id'";
                              $clientResult = $conn->query($client_sql);
                              $clientRow = $clientResult->fetch_assoc();
                              $client_name = $clientRow['name'];
                        ?>
                        <tr>
                           <td><?=$row['id'];?></td>
                           <td><?=$row['title'];?></td>
                           <td><?=$client_name; ?></td>
                           <td><?=$row['filling_date'];?></td>
                           <td><?=$row['description'];?></td>
                           <td><?= ($row['case_stage'])==1 ? "Inactive" : "Active";?></td>
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
<!-- partial:../../partials/_footer.html -->
<?php 
   include("../auth/footer.php");
?>
