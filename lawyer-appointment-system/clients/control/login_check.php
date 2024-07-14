<?php
session_start();
echo "hello";
exit;

// The following code will not be executed because of the 'exit' above. 
// If you want the rest of the code to be executed, remove 'exit'.

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kortex_lite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This line is redundant as the database is already selected in the connection
// $db = mysqli_select_db($conn,'advocate');

// Ensure the script only runs if the form is submitted
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->num_rows;

    if($row > 0){
        echo "login successful";
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "login failed";
        header('Location: login.php');
        exit();
    }
    
    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
