<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
include '../connection1.php';

$client_name = $_SESSION['client_name'];
$client_id = $_SESSION['client_id'];
$lawyer_id = $_SESSION['lawyer_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transaction_id'])) {
    $payment_date = date('Y-m-d H:i:s');
    $payee = $_POST['payee_name'];
    $transaction_id = htmlspecialchars($_POST['transaction_id']);

       

    if ($transaction_id) {
            $sql = "INSERT INTO bookings (payee, transaction_id, payment_date, clientname,lawyer_name) VALUES ('$payee','$transaction_id','$payment_date', '$client_name' ,$lawyer_id)";

            if(mysqli_query($conn, $sql)){
                //mail
                $clientsql = "select * from clients where id = $client_id";
                $clientResult = $conn->query($clientsql);
                $clientRow = $clientResult->fetch_assoc();
                $client_email = $clientRow['email'];

                $lawyersql = "select * from lawyers where id = $lawyer_id";
                $lawyerResult = $conn->query($lawyersql);
                $lawyerRow = $lawyerResult->fetch_assoc();
                $lawyer_email = $lawyerRow['email'];
                $lawyer_name = $lawyerRow['name'];

                $casesql = "select * from case_register";
                $caseResult = $conn->query($casesql);
                $caseRow = $caseResult->fetch_assoc();
                $case_date =$caseRow['filling_date'];
                $appointment_date = date("Y-m-d", strtotime($case_date .'+ 3 days'));

                require("Email/PHPMailer.php");
                require("Email/SMTP.php");
                require("Email/Exception.php");
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                        //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'patilsagar1722@gmail.com';                 //SMTP username
                    $mail->Password   = 'kqbt qqwr utrr zuih';                        //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('patilsagar1722@gmail.com', 'attorneyandlaw');
                    // $mail->addAddress($lawyer_email);
                    $mail->addAddress($client_email);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Appointment Booked!';
                    $mail->Body    = "<div ><b>Dear Client, Your Appointment has been booked on {$appointment_date}</b><br><br>
                        We are informing you that your appointment has been booked.<br>
                        If you have any questions or require further assistance, please contact our customer support team at 8007682776.<br><br>
                        Name = {$lawyerRow['name']}
                        Best regards,<br>
                        Attorney and Law<br>
                        Attorney Team</div>";

                    $mail->send();

                //echo json_encode(["book_status" => "success", "message" => "Booking cancelled and emails sent"]);
            } catch (Exception $e) {
                echo "Email Not Sent";
                //echo json_encode(["book_status" => "success", "message" => "Booking cancelled but failed to send email", "error" => $mail->ErrorInfo]);
            }

            header('location: payment_success.php');
            exit;
        }
            
    } else {
        echo "Invalid Transaction ID.";
    }
} else {
    echo "Form not submitted or transaction_id not set.";
    header('Location: ./clients/control/dashboard.php');
    
    exit;
}

