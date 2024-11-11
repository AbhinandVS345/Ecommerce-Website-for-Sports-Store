<?php
session_start();
$ordermaster_id = $_POST['ordermaster_id'];
$payment_method = $_POST['payment_method'];
$email = $_SESSION['email'];
$customerName = $_SESSION['CustomerName'];

//for email
require 'vendor/autoload.php'; //Create an instance; passing true enables exceptions
$mail = new PHPMailer\PHPMailer\PHPMailer();

// Use SMT
$mail->isSMTP();

// SMTP settings
$mail->SMTPDebug = 0;
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

if ($payment_method === "Cash on Delivery") {
    $mail->Subject = 'Your Order Has Been Canceled';
    $mail->Body = "Dear $customerName,\n\n" .
        "We regret to inform you that your order (Order ID: $ordermaster_id) has been canceled.\n\n" .
        "Best regards,\nHELPZ\n+91 9856985674\nwww.helpz.org";
} else {
    $mail->Subject = "Your Order Has Been Canceled - Refund Processing Soon";
    $mail->Body = "Dear $customerName,\n\n" .
        "We wanted to inform you that your order has been canceled and your refund is being processed.\n\n" .
        "Best regards,\nHELPZ\n+91 9856985674\nwww.helpz.org";
}


// Send email
if (!$mail->send()) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
} else {
    echo json_encode(['success' => true]);
}
?>