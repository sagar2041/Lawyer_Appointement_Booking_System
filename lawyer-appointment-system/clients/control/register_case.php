<?php
   /* ini_set('display_errors', 1);
   error_reporting(E_ALL); */
   session_start();
    if(!isset($_SESSION['username'])){
   	header('location:login.php');
   }
   
   include("../auth/header.php");
   include 'connection1.php';
   
   
   
   ?>
<?php include("../auth/sidebar.php");?>
<?php
   $username = $_SESSION['username'];
   $get_client_sql = "select * from clients where email = '$username'";
   $client_list_result = $conn->query($get_client_sql);
   
   $case_stage_sql = "select * from case_stage where status='0'";
   $case_stage_result = $conn->query($case_stage_sql);
   
   $court_sql = "select * from court";
   $court_result = $conn->query($court_sql);
   
   $case_type_sql = "select * from case_types ";
   $case_type_result = $conn->query($case_type_sql);
   
   $act_sql = "select * from legel_acts where status='0'";
   $act_result = $conn->query($act_sql);

   $lawyer_sql = "select * from lawyers";
   $lawyer_result_list = $conn->query($lawyer_sql);
   
   ?>
<html>
   <head>
   </head>
   <body>
      <div class="page-content">
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <h6 class="card-title">Registered Case</h6>
                     <form action="upi/transaction.php" method="post" enctype="multipart/form-data" class="row">
                     	<div class="col-md-6">
	                        <label>Case Title</label>
	                        <input type="text" name="title" class="form-control">
	                    </div>
	                    <div class="col-md-6">
                        	<label>Case No</label>
                        	<input type="text" name="case_no" value="<?php echo rand(1,1000000); ?>" class="form-control">
                    	</div>
                        <div class="col-md-6 mb-3">
                           <?php 
                              if($client_list_result->num_rows > 0){
                                 	$row = $client_list_result->fetch_array();
                           ?>
                           <label class="form-label">Client Name</label>
                           <input type="text" name="client_name" class="form-control" value="<?php echo $row['name'] ?>">
                           <?php } ?>
                           <br><br>	
                     
                        </div>
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Court </label>
                           <select class="form-select form-select-sm mb-3" name="court">
                              <option selected>Select Court</option>
                              <?php 
                                 if($court_result->num_rows > 0){
                                 	while($row = $court_result->fetch_array()){
                                 		/* echo "<option value='".$row['id']."'>".$row['name']."</option>"; */
                                 														?>
                              <option value="<?php echo $row['id'];?>" ><?php echo $row['court_category']; ?></option>
                              <?php
                                 }
                                 }
                                 ?> 
                           </select>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Case Type</label>
                           <select class="form-select form-select-sm mb-3" name="case_type">
                              <option selected>Select Case Type</option>
                              <?php 
                                 if($case_type_result->num_rows > 0){
                                 	while($row = $case_type_result->fetch_array()){
                                 		/* echo "<option value='".$row['id']."'>".$row['name']."</option>"; */
                                 	?>
                              <option value="<?php echo $row['id']; ?>" ><?php echo $row['case_type']; ?></option>
                              <?php
                                 }
                                 }
                                 ?>
                           </select>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Case Stage</label>
                           <select class="form-select form-select-sm mb-3" name="case_stage">
                              <option selected>Select Case Stage</option>
                              <?php 
                                 if($case_stage_result->num_rows > 0){
                                 	while($row = $case_stage_result->fetch_array()){
                                 		/* echo "<option value='".$row['id']."'>".$row['name']."</option>"; */
                                 		
                                 		
                                 		?>
                              <option value="<?php echo $row['id']; ?>" ><?php echo $row['name']."-".$row['status']; ?></option>
                              <?php
                                 }
                                 }
                                 ?>
                           </select>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Legel Acts</label>
                           <select class="form-select form-select-sm mb-3" name="legel_acts">
                              <option selected>--- Select ---</option>
                              <?php 
                                 if($act_result->num_rows > 0){
                                 	while($row = $act_result->fetch_array()){
                                 		/* echo "<option value='".$row['id']."'>".$row['name']."</option>"; */
                                 		
                                 		
                                 		?>
                              <option value="<?php echo $row['id']; ?>" ><?php echo $row['act_name']."-".$row['status']; ?></option>
                              <?php
                                 }
                                 }
                                 ?>
                           </select>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="exampleFormControlTextarea1" class="form-label">
                              Description
                              <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5" cols="150"></textarea>
                        </div>
                        <!-- <div class="col-md-6 mb-3">
                           <label class="form-label">Lawyer Name</label>
                           <select class="form-select form-select-sm mb-3" name="client_name">
                              <option selected>Select Lawyer Name</option>
                              <?php 
                                 if($client_list_result->num_rows > 0){
                                    while($row = $act_result->fetch_array()){
                                 		//echo "<option value='".$row['id']."'>".$row['name']."</option>"; 
                                 		?>
                                       <option value="<?php echo $row['id'];?>" selected><?php echo strtoupper($row['name']) ;?></option>
                                    
                              <?php
                                 }
                              }
                                 ?>
                           </select>
                        </div> -->
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Select Lawyer</label>
                           <select class="form-select form-select-sm mb-3" name="lawyer_name">
                           <option selected>--- Select ---</option>
                              <?php 
                                 if($lawyer_result_list->num_rows > 0){
                                 	   while($row = $lawyer_result_list->fetch_array()){
                                 		 //echo "<option value='".$row['id']."'>".$row['name']."</option>"; 
                                 		?>
                                       <option value="<?php echo $row['id'];?>" ><?php echo strtoupper($row['name']) ;?></option>
                                    
                              <?php
                                 }
                              }
                                 ?>
                           </select>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label class="form-label">Filling Date</label>
                        <div class="input-group date datepicker" id="datePickerExample">
                        <input type="text" name="filling_date" class="form-control">
                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                        </div>	
                        </div>
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Hearing Date</label>
                           <div class="input-group date datepicker" id="datePickerExample1">
                              <input type="text" name="hearing_date" class="form-control">
                              <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                           </div>
                        </div>
                        <div class="col-md-6 mb-3">			
                           <label>Apposite Lawyer</label>
                           <input type="text" name="opposite_lawyer" class="form-control">
                           <br><br>			
                        </div>
                        <!-- <div class="col-md-6 mb-3">
                           <label for="exampleInputNumber1" class="form-label">Total Fees</label>
                           <input type="number" name="total_fees" class="form-control" id="exampleInputNumber1" value="<?php echo $amount ?>">
                        </div> -->
                        <!-- <div class="col-md-6 mb-3">
                           <label for="exampleInputNumber1" class="form-label">Unpaid</label>
                           <input type="number" name="unpaid" class="form-control" id="exampleInputNumber1" value="0">
                        </div> -->
                        <div class="col-md-12">
                        	<input type="submit" class="btn btn-primary" name="register" value="Submit">
                    	</div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<?php
   include("../auth/footer.php");
?>