<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once('connection.php');
session_start();

$otp = rand(100000, 999999);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    echo "EMAIL" . $email;

    //$_SESSION['usertypeforpwdchange']=$usertype;
    $_SESSION['emailforpwdchange'] = $email;
    echo "EMAIL in session" . $_SESSION['emailforpwdchange'];
    //$email="aswathyashokmanalil@gmail.com";
    // Generate a 6-digit OTP
    $sql1 = "select * from login where email='" . $email . "'";
    $rslt1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($rslt1)) {


        $sql = "INSERT INTO otp_table (email, otp, timestamp, status) VALUES ('$email', '$otp', NOW(), 'unused')";
        $rslt = mysqli_query($conn, $sql);

        require 'vendor/autoload.php'; //Create an instance; passing true enables exceptions
        $mail = new PHPMailer();

        // Use SMT
        $mail->isSMTP();

        // SMTP settings
        $mail->SMTPDebug = 1;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'gentriusprojects@gmail.com';
        $mail->Password = 'lbef xirr qxgq tsix';

        // Set 'from' email address and name
        $mail->setFrom('gentriusprojects@gmail.com', 'Track Sports');

        // Add a recipient email address
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'OTP for change Password';
        $mail->Body = $otp; // Your email content


        // Send the email
        if (!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
            exit();
        }
    } else {
        echo "<script>alert('invalid mailID');</script>";
        header("location:login.php");
    }
}
