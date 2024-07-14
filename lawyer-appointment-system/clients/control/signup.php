<?php
error_reporting(0);
session_start();
include 'connection1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender =  $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $msg = "Passwords do not match!";
    } else {
        $passw = hash('sha256', $password);
        function createSalt()
        {
            return '2123293dsj2hu2nikhiljdsd';
        }
        $salt = createSalt();
        $pass = hash('sha256', $salt . $passw);

        // Check if username or email already exists
        $sql_check = "SELECT * FROM clients WHERE name='$name' OR email='$email' LIMIT 1";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $msg = "Error";
            echo '<div class="popup popup--icon -error js_error-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
               <h3 class="popup__content__title">
                  Error 
               </h3>
               <p>Invalid Email or Password</p>
               <p>
                  <a href="signup.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
               </p>
            </div>
         </div>';
        } else {
            $sql_query = "INSERT INTO clients (name, gender, dob, email, password, mobile, address) VALUES ('$name','$gender','$dob','$email','$pass','$mobile','$address')";
            if ($conn->query($sql_query) === TRUE) {
                $msg = "Signup successful!";
                // echo "<script>alert('Signup successful!'); setTimeout(function(){ location.href = 'signup.php'; }, 1000);</script>";
                echo '<div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                   <h3 class="popup__content__title">
                      Success 
                   </h3>
                   <p>Login Successfully</p>
                   <p>
                        <a href="login.php"><button class="button button--success" data-for="js_success-popup"></button></a>
                    </p>
                </div>
             </div>';
            } else {
                $msg = "Error: " . $sql_query . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Signup</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->
    <!-- core:css -->
    <link rel="stylesheet" href="../assets/vendors/core/core.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/demo1/style.css">
    <!-- End layout styles -->
    <!-- <link rel="shortcut icon" href="../assets/images/favicon.png" /> -->
    <link rel="stylesheet" href="popup_style.css">
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center p-0">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-6 login-img p-0">
                        <img src="../assets/images/login-img.jpg" width="100%" class="vh-100" style="object-fit: cover;">
                    </div>
                    <div class="col-md-6 bg-white">
                    <a class="btn btn-secondary" style="margin :15px 0px 0px 500px;" href="..\..\..\lawyer-appointment-system\" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
</svg> Back</a>
                        <div class="col-md-8 mx-auto">
                            <div class="auth-form-wrapper px-4 py-7 vh-100">
                                <div>
                                    <h4 class="mb-3 mb-md-0" style="text-align : center;">Client Sign Up </h4>
                                </div>
                                <form class="forms-sample signup-form" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" id="dob" placeholder="DOB" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">Mobile No.</label>
                                        <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile No." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <input type="text" class="form-control" name="gender" id="gender" placeholder="Gender" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" id="Address" placeholder="Address" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" placeholder="Password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="new-password" placeholder="Confirm Password" required>
                                    </div>
                                    <div>
                                        <input type="submit" name="signup" value="Signup" class="btn btn-primary w-100 me-2 mb-2 mb-md-0 text-white">
                                    </div>
                                    <?php if (isset($msg) && $msg != '') : ?>
                                        <div class="alert alert-info mt-3"><?php echo $msg; ?></div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- core:js -->
    <script src="../assets/vendors/core/core.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/vendors/feather-icons/feather.min.js"></script>
    <script src="../assets/js/template.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->

    <script>
        // Function to check for spaces
        function checkForSpaces(event) {
            if (event.target.value.includes(' ')) {
                alert('Space is not allowed!');
                event.target.value = event.target.value.replace(/\s/g, ''); // Remove spaces from input
            }
        }

        // Get input elements
        var usernameInput = document.getElementById('username');
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var confirmPasswordInput = document.getElementById('confirm_password');

        // Attach event listeners to input elements
        usernameInput.addEventListener('input', checkForSpaces);
        emailInput.addEventListener('input', checkForSpaces);
        passwordInput.addEventListener('input', checkForSpaces);
        confirmPasswordInput.addEventListener('input', checkForSpaces);
    </script>
</body>

</html>