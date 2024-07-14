<?php
error_reporting(0);
session_start();
include 'connection1.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];

    $passw = hash('sha256', $password);
    function createSalt() {
        return '2123293dsj2hu2nikhiljdsd';
    }
    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);

    $msg = '';

    $sql_query = "SELECT * FROM lawyers WHERE email= '$username' AND password = '$pass' LIMIT 1";
    $result = $conn->query($sql_query);

    if ($result->num_rows > 0) {
        $recaptcha = $_POST['g-recaptcha-response'];
        $secret_key = '6LcXEiAhAAAAALaf8ygYOebTAENC3QsvAMjXFuuB';

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;
        $response = file_get_contents($url);
        $response = json_decode($response);

        $row = $result->fetch_assoc();
        if ($response->success == true) {
            if ($row['email'] == $username && $row['password'] == $pass) {
                $name = $row['name'];
                $_SESSION['username'] = $username;
                $_SESSION['name'] = $name;
                $_SESSION['id'] = $row['id'];
                $_SESSION['password'] = $password;
?>
<div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
        <h3 class="popup__content__title">
            Success 
        </h3>
        <p>Login Successfully</p>
        <p>
            <?php echo "<script>setTimeout(\"location.href = 'dashboard.php';\",1500);</script>"; ?>
        </p>
    </div>
</div>
<?php
            } else {
?>
<div class="popup popup--icon -error js_error-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
        <h3 class="popup__content__title">
            Error 
        </h3>
        <p>Invalid Email or Password</p>
        <p>
            <a href="lawyer_login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
        </p>
    </div>
</div>
<?php
            }
        } else {
            echo '<script>alert("Please verify Google reCAPTACHA")</script>';
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
    <title>Lawyer Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendors/core/core.css">
    <link rel="stylesheet" href="../assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/css/demo1/style.css">
    <!-- <link rel="shortcut icon" href="../assets/images/favicon.png" /> -->
    <link rel="stylesheet" href="popup_style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
         <h4 class="mb-3 mb-md-0" style="text-align : center; margin-top: -40px;">Lawyer Login</h4>
      </div>
                                <form class="forms-sample login-form" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Email address</label>
                                        <input type="email" class="form-control" name="email" id="userEmail" placeholder="Email"> 
                                    </div>
                                    <div class="mb-3">
                                        <label for="userPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="userPassword" autocomplete="current-password" placeholder="Password" id="inputField2">
                                        <span toggle="#inputField2" class="fa fa-eye field-icon toggle-password"></span>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="authCheck">
                                        <label class="form-check-label" for="authCheck">
                                        Remember me
                                        </label>
                                    </div>
                                    <div class="g-recaptcha mb-4" data-sitekey="6LcXEiAhAAAAAJRpKyjYMJx0ZXIfmM1COjUj4uAe"></div>
                                    <div>
                                        <input type="submit" name="login" value="Login" class="btn btn-primary w-100 me-2 mb-2 mb-md-0 text-white">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <script src="../assets/vendors/core/core.js"></script>
    <script src="../assets/vendors/feather-icons/feather.min.js"></script>
    <script src="../assets/js/template.js"></script>
    <script>
        function checkForSpaces(event) {
            if (event.target.value.includes(' ')) {
                alert('Space is not allowed!');
                event.target.value = event.target.value.replace(/\s/g, '');
            }
        }

        var usernameInput = document.getElementById('userEmail');
        var passwordInput = document.getElementById('userPassword');

        usernameInput.addEventListener('input', checkForSpaces);
        passwordInput.addEventListener('input', checkForSpaces);
    </script>
</body>
</html>
