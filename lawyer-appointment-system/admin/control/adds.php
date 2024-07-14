<?php
   session_start();
   error_reporting(0);
   if(!isset($_SESSION['username'])){
   	header('location:login.php');
   }
   ?>
<?php 
   include("../auth/header.php");
   
   /* <!--  Author Name- Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website - www.mayurik.com -->
      } */
   ?>
<?php include("../auth/sidebar.php");?>
<html>
   <head></head>
   <body>
      <div class="page-content">
         <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <h6 class="card-title">Registration Form</h6>
                     <form action="adds.php" method="post" enctype="multipart/form-data" class="row">
                        <div class="col-md-6 mb-3">
                           <label for="exampleInputText1" class="form-label">Name</label>
                           <input type="text" class="form-control" name="name" id="exampleInputText1" value="" placeholder="Enter Name">
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-evenly">
                            <label class="gender" for="gender">
                             Gender
                            </label>
                            <input type="radio" name="gender" value="Male" class="mgender" id="mgender">
                            <label for="mgender">
                            Male
                            </label>
                            <input type="radio" name="gender" Value="Female" class="fgender" id="fgender">
                            <label for="fgender">
                            Female
                            </label>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label class="form-label">Date Of Birth:</label>
                           <input type="date" class="form-control mb-4 mb-md-0" name="dob" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd/mm/yyyy"/>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="exampleInputEmail3" class="form-label">Email</label>
                           <input type="email" name="email" class="form-control" id="exampleInputEmail3" value="" placeholder="Enter Email">
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="exampleInputEmail3" class="form-label">Password</label>
                           <input type="password" name="pass" class="form-control" id="exampleInputEmail3" value="" placeholder="Enter Password">
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" id="exampleInputMobile" placeholder="Mobile number">
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="exampleInputMobile" class="col-sm-3 col-form-label">Enter Your Fees</label>
                            <input type="text" class="form-control" name="fees" id="exampleInputMobile" placeholder="Enter Your Fees">
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="exampleFormControlTextarea1" class="form-label"> Lawyer Type </label>
                           <input type="text" class="form-control" name="type" id="exampleFormControlTextarea1" placeholder="Enter Your Stream">
                        </div>
                        <div class="col-md-6">
                           <button class="btn btn-primary" name="submit" type="submit">Submit</button>
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
   include 'connection1.php';
   
   if(isset($_POST['submit'])){    
      $name = $_POST['name'];
      $gender= $_POST['gender'];
      $dob= $_POST['dob'];
      $email = $_POST['email'];
      $mobile = $_POST['mobile'];
      $lawyer_type= $_POST['type'];
      $fees = $_POST['fees'];
      $pass1 = $_POST['pass'];
   

   $passw = hash('sha256', $pass1);
   function createSalt()
   {
       return '2123293dsj2hu2nikhiljdsd';
   }
   $salt = createSalt();
   $passw = hash('sha256', $salt . $passw);
   
   
   $sql = "INSERT INTO lawyers(name,gender,dob,email,mobile,lawyer_type,fees,password)
   VALUES ('$name','$gender','$dob','$email','$mobile','$lawyer_type','$fees','$passw')";

   if (mysqli_query($conn, $sql)) {
      //echo "New record has been added successfully !";
      
      // $mail = new PHPMailer;
      // $mail->isSMTP();  
      // $mail->Host = 'mail.raghavinfocom.com';  
      // $mail->SMTPAuth = true;                              
      // $mail->Username   = 'no_reply@raghavinfocom.com';
      // $mail->Password   = 'zo?n6BDVGtdo';
      // $mail->SMTPSecure = 'ssl';
      // $mail->Port = '465';        
      // $mail->isHTML(true);
      // $mail->setFrom('no_reply@raghavinfocom.com','Drkalan Front');
      // $mail->addAddress($email,$name);
      // $mail->Subject ='Registerd successfully.';
      // $mail->Body    =  `Your Username is $email and Password id $pass1`;
      // $mail->send();
      
      ?>
      <link rel="stylesheet" href="popup_style.css">
      <div class="popup popup--icon -success js_success-popup popup--visible">
         <div class="popup__background"></div>
         <div class="popup__content">
            <h3 class="popup__content__title">
               Success 
            </h3>
            <p>Record added Successfully</p>
            <p>
               <a href="lawyer_data.php"><button class="button button--success" data-for="js_success-popup">OK</button></a>
         </p>
         </div>
      </div>
<?php
   } 
   else {
      echo "Error: " . $sql . ":-" . mysqli_error($conn);
      mysqli_close($conn);
   }
   }
   include("../auth/footer.php");

?>