
<?php include '../connection1.php';
session_start();
if(isset($_POST['register'])){   
    $user_id = $_SESSION['id'];

    $title = $_POST['title'];
    $case_no = $_POST['case_no'];
    $client_name =$user_id;
    $court = $_POST['court'];
    $case_type = $_POST['case_type'];
    $case_stage= $_POST['case_stage'];
    $legel_acts = $_POST['legel_acts'];
    $description = $_POST['description'];
      /*  $filling_date = date_format(date_create($_POST['filling_date']),"Y/m/d") ; */
    $filling_date = $_POST['filling_date'];
    /* $hearing_date = date_format(date_create($_POST['hearing_date']),"Y/m/d") ; */
    $hearing_date = $_POST['hearing_date'];
    $opposite_lawyer= $_POST['opposite_lawyer'];
    $lawyer_id = $_POST['lawyer_name'];
    // $total_fees= $_POST['total_fees'];
    //$unpaid = $_POST['unpaid'];


    $cl_sql = "SELECT * FROM clients where id = $user_id";
    $cl_result = $conn->query($cl_sql);
    $clRow = $cl_result->fetch_assoc();

    $_SESSION['client_name'] = $clRow['name'];
    

    $lawyer_sql = "SELECT * FROM lawyers where lawyers.id = $lawyer_id";
    $lawyer_result = $conn->query($lawyer_sql);
    $lawyerRow = $lawyer_result->fetch_assoc();

    $total_fees = $lawyerRow['fees'];
    
    $_SESSION['client_id'] = $user_id;
    $_SESSION['lawyer_id'] = $lawyer_id;
   
   
   /* echo date_format(date_create("2013-03-15"),"d/m/Y");	
   */	
   
       $case_sql = "INSERT INTO case_register(title,case_no,client_name,court,case_type,case_stage,legel_acts,description,filling_date,hearing_date,opposite_lawyer, total_fees, lawyer_name) VALUES('$title','$case_no','$client_name','$court','$case_type','$case_stage','$legel_acts','$description','$filling_date','$hearing_date','$opposite_lawyer','$total_fees','$lawyer_id')";
    
     /*  $case_sql = "INSERT INTO case_register(title,case_no,client_name,court,case_type,case_stage,legel_acts,description,filling_date,hearing_date,opposite_lawyer, total_fees,unpaid) VALUES('$title','$case_no','$client_name','$court','$case_type','$case_stage','$legel_acts','$description', str_to_date('$filling_date','%m-%d-%y'), str_to_date('$hearing_date','%m-%d-%y'),'$opposite_lawyer','$total_fees','$unpaid')";
   */
   
   
   
       if (mysqli_query($conn, $case_sql)) {
          /* echo "New record has been added successfully !"; */
echo ''; ?>
<?php
   } else {
   echo "Error: " . $case_sql . ":-" . mysqli_error($conn);
   }
   
   }
   mysqli_close($conn);?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120vh;
            margin: 0;
        }
        .payment-container {
            background-color: #ffffff;
            /* padding: 20px; */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .payment-container h1 {
            font-size: 22px;
            /* margin-bottom: 20px; */
            color: #333333;
        }
        
        .form-group {
            margin-bottom: 15px;
            text-align: left;
           padding: 0px 50px;
            
        }
        .form-group label {
            display: block;
            /* margin-bottom: 5px; */
            color: #333333;
            
        }
        .form-group input {
            
            width: 100%;
            padding: 10px; 
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 10px;
            color: #333333;
            /* max-width: 80%; */
        }
        .form-group img {
            /* margin-top: 10px; */
            max-width: 100%;
            height: auto;
        }
        .upi-platforms {
            display: flex;
            justify-content: center;
            gap: 10px;
            /* margin-top: 10px; */
        }
        .upi-platforms img {
            width: 250px;
            height: 140px;
            /* border-radius: 4px;
            /* border: 1px solid #dddddd; */
            /* padding: 5px;
            background-color: #ffffff; */
        }
        .btn {
            /* width: 100%;; */
            /* max-width: 80%; */
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            font-size: 14px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="payment-container">
    <h1>Lawment Payment Gateway</h1>
    <form class="upi" action="payment_validation.php" method="post" id="upi_form" target="_self">
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars(7000); ?>">
        <input type="hidden" name="upi_id" value="8007682776@ybl"> <!-- Replace with your UPI ID -->
        <div class="form-group">
            <center><label for="qr_code">Scan QR Code</label></center>
            <!-- Display UPI QR code here -->
            <?php
            include './phpqrcode/qrlib.php';
            // Define UPI parameters
            $upi_id = '8007682776@ybl';
            $payee_name = 'Sagar Patil';
            $currency = 'INR';
            $final_total = htmlspecialchars($total_fees);

            // Create UPI payment URL
            $upi_url = "upi://pay?pa={$upi_id}&pn={$payee_name}&am={$final_total}&cu={$currency}";
            $qr_temp_dir = 'temp/';
            if (!file_exists($qr_temp_dir)) {
                mkdir($qr_temp_dir);
            }
            $qr_file_path = $qr_temp_dir . 'upi_qr.png';
            QRcode::png($upi_url, $qr_file_path, QR_ECLEVEL_L, 4);
            echo "<center><img src='$qr_file_path' alt='UPI QR Code' id='qr_code'><br><b>₹ $total_fees</b></center>";
            ?>
        </div>
        <div class="upi-platforms">
            <img src="./images/upi-options.jpg" alt="Google Pay">
            <!-- <img src="./images/phonepe.jpg" alt="PhonePe">
            <img src="./images/paytm.jpg" alt="Paytm">
            <img src="./images/upi.jpg" alt="BHIM UPI"> -->
        </div>
        <div class="form-container">
        <div class="form-group">
            <label for="Name">Name</label>
            <input type="text" name="payee_name" id="Name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="transaction_id">Transaction ID</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Verify Payment" name="form2" style="font-size: 16px; color: whitesmoke;">
        </div>
        </div>
        
    </form>
</div>
</body>
</html>