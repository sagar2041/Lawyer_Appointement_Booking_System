<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */
session_start();
if(!isset($_SESSION['username'])){
	header('location:login.php');

}
?>
 <?php 
include("../auth/header.php");
  ?>
<?php include("../auth/sidebar.php");?>


			<div class="page-content">
				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">All cases</h6>,
                
                <div class="table-responsive">
				<table id="dataTableExample" class="table">
                     <thead>
                        <tr>
                           <th>Id</th>
                           <th>Title</th>
                           <th>Case No</th>
                           <!-- <th>Client Name</th> -->
                           <th>Court</th>
                           <th>Case Type</th>
                           <th>Case stage</th>
                           <th>Legel Acts</th>
                           <th>Description</th>
                           <th>Filling Date</th>
                           <th>Hearing Date</th>
                           <th>Opposite Lawyer</th>
                           <th>Total fees</th>
                           <!-- <th>Unpaid</th> -->
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           include 'connection1.php';
                           $user_id = $_SESSION['id'];

                           $case_sql = "select * from case_register where case_register.client_name = $user_id";
                           //$case_sql = "select *,case_register.id as case_register_id, clients.name as clients_name from case_register,clients,case_types,court,case_stage,legel_acts where case_register.client_name = clients.id and case_register.case_type =case_types.id and case_register.court=court.id and case_register.case_stage = case_stage.id and case_register.legel_acts = legel_acts.id "; 
                           
                           /* $case_sql =	"SELECT *,case_register.id, clients.client_name, court.court_category, case_stage.status, legel_acts.act_name
                           FROM case_register
                           INNER JOIN clients
                           ON case_register.client_name = clients.id
                           INNER JOIN case_types
                           ON case_register.case_type = case_types.id
                           ";  */
                           
                           	 
                           $result = $conn->query($case_sql);
                           
                           /* print_r($result->fetch_assoc()); */
                           /* print_r($result->fetch_all()); */
                           /* exit; */
                           
                           if($result->num_rows > 0){
                           while($row = $result->fetch_assoc()){

                            $court_id = $row['court'];
                            $court_sql = "select * from court where court.id = $court_id";
                            $court_result = $conn->query($court_sql);
                            $courtRow = $court_result->fetch_assoc();

                            $caseType_id = $row['case_type'];
                            $case_sql = "select * from case_types where case_types.id = $caseType_id";
                            $case_result = $conn->query($case_sql);
                            $caseRow = $case_result->fetch_assoc();

                            $legel_id = $row['legel_acts'];
                            $legel_sql = "select * from legel_acts where legel_acts.id = $legel_id";
                            $legel_result = $conn->query($legel_sql);
                            $legelRow = $legel_result->fetch_assoc();
                           ?>
                        <tr>
                           <td class="sorting_1"><?=$row['id'];?></td>
                           <td class="sorting_1"><?=$row['title'];?></td>
                           <td class="sorting_1"><?=$row['case_no'];?></td>
                           <!-- <td class="sorting_1"><?=$row['client_name'];?></td> -->
                           <td class="sorting_1"><?=$courtRow['court_category'];?></td>
                           <td class="sorting_1"><?=$caseRow['case_type'];?></td>
                           <td class="sorting_1"><?php  if($row['case_stage']=="0") 
                              echo "Active";
                               else 
                              echo "Inactive";?></td>
                           <td class="sorting_1"><?=$legelRow['act_name'];?></td>
                           <td class="sorting_1"><?=$row['description'];?></td>
                           <td class="sorting_1"><?=$row['filling_date'];?></td>
                           <td class="sorting_1"><?=$row['hearing_date'];?></td>
                           <td class="sorting_1"><?=$row['opposite_lawyer'];?></td>
                           <td class="sorting_1"><?=$row['total_fees'];?></td>
                           <!-- <td class="sorting_1"><?=$row['unpaid'];?></td> -->
                           <td><a class="btn btn-danger" href="delete_register.php?case_register_id=<?=$row['id'];?>"><i class="fa fa-trash text-white" aria-hidden="true"></i></a>
                                 <a class="btn btn-success" href="edit_register.php?case_register_id=<?=$row['id'];?>"><i class="fa fa-edit text-white" aria-hidden="true"></i></a>
                           </td>
                           <td></td>
                        </tr>
                        <?php		
                           }
                           }
                           
                           else{
                           	echo"sql error".$sql."<br>".$conn->error;
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