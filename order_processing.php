<?php
session_start();
include('Connection.php');
$customer_id = $_SESSION['userid'];

if (isset($_POST["submit"])) {
    // Fetch and sanitize the POST data
    $customername = $_POST['name']; // Ensure the customer name is sanitized
    $house_num = $_POST['house_num'];
    $location = $_POST['location'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $phno = $_POST['phno'];
    $pincode = $_POST['pincode'];
    $payment_method = $_POST['payment_method']; // Assuming this is sent from the form
    $payment_status = "Completed"; // This can be dynamic based on the actual payment flow

    // Insert Delivery Address
    $insertAddressQuery = "INSERT INTO deliveryaddress (customer_id, name, house_num, location, city, pincode, district, phno) 
                           VALUES ('$customer_id', '$customername', '$house_num', '$location', '$city', '$pincode', '$district', '$phno')";
    if (!mysqli_query($conn, $insertAddressQuery)) {
        die("Error inserting delivery address: " . mysqli_error($conn));
    }

    $lastAddressId = mysqli_insert_id($conn); // Get the last inserted address ID

    // Calculate total amount from the cart
    $cartItemsQuery = "SELECT SUM(p.price * cart.quantity) as totalAmount 
                       FROM cart 
                       JOIN single_product sp ON cart.single_product_id = sp.single_product_id 
                       JOIN product p ON sp.product_id = p.product_id 
                       WHERE cart.customer_id = '$customer_id'";
    $cartItemsResult = mysqli_query($conn, $cartItemsQuery);
    if (!$cartItemsResult) {
        die("Error fetching cart items: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($cartItemsResult);
    $totalAmount = $row['totalAmount'] + 50; // Add shipping charge of ₹50

    // Insert into Order Master
    $insertOrderMasterQuery = "INSERT INTO ordermaster (customer_id, order_date, totalamount, status, deliveryaddress_id) 
                               VALUES ('$customer_id', NOW(), '$totalAmount', 'Successful', '$lastAddressId')";
    if (!mysqli_query($conn, $insertOrderMasterQuery)) {
        die("Error inserting order master: " . mysqli_error($conn));
    }

    $lastOrderMasterId = mysqli_insert_id($conn); // Get the last inserted order master ID
    $_SESSION['master_id'] = $lastOrderMasterId;

    // Fetch cart items again for orderdetails insertion
    $cartItemsQuery = "SELECT c.*, p.price FROM cart c 
    JOIN single_product sp ON c.single_product_id = sp.single_product_id 
    JOIN product p ON sp.product_id = p.product_id 
    WHERE c.customer_id = '$customer_id'";
    $cartItemsResult = mysqli_query($conn, $cartItemsQuery);
    if (!$cartItemsResult) {
        die("Error fetching cart items: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($cartItemsResult)) {
        $singleProductId = $row['single_product_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $totalPrice = $quantity * $price;

        // Debugging output
        //echo "Debug - Product ID: $productId, Quantity: $quantity, Price: $price, Total Price: $totalPrice<br>";

        $insertOrderQuery = "INSERT INTO orderdetails (ordermaster_id, single_product_id, quantity, total_price)
      VALUES ('$lastOrderMasterId', '$singleProductId', '$quantity', '$totalPrice')";
        if (!mysqli_query($conn, $insertOrderQuery)) {
            die("Error inserting order: " . mysqli_error($conn));
        }

        $stock_sql= "UPDATE single_product SET stock=stock-$quantity WHERE single_product_id=$singleProductId";
        mysqli_query($conn, $stock_sql);

    }

    // Insert payment details
    $insertPaymentQuery = "INSERT INTO payment (ordermaster_id, payment_method, payment_date, payment_status) 
    VALUES ('$lastOrderMasterId', '$payment_method', NOW(), '$payment_status')";
    if (!mysqli_query($conn, $insertPaymentQuery)) {
    die("Error inserting payment details: " . mysqli_error($conn));
    }

    // Delete Cart Items
    $deleteCartItemsQuery = "DELETE FROM cart WHERE customer_id = '$customer_id'";
    if (!mysqli_query($conn, $deleteCartItemsQuery)) {
        die("Error deleting cart items: " . mysqli_error($conn));
    }
?>

    <script type="text/javascript" src="swal/jquery.min.js"></script>
    <script type="text/javascript" src="swal/bootstrap.min.js"></script>
    <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert initialization code goes here
            Swal.fire({
                icon: 'success',
                text: 'Your order has been placed successfully.',
                didClose: () => {
                    window.location.replace('order_success.php');
                }
            });
        });
    </script>

<?php
}
?>

<?php
include('connection.php');
require 'vendor/autoload.php';
use Dompdf\Dompdf; 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

$master_id = $_SESSION['master_id'];
date_default_timezone_set('Asia/Kolkata');

// Fetch product details based on the master_id
$sql = "SELECT om.*, od.*, sp.*, p.* FROM ordermaster om
JOIN orderdetails od ON om.ordermaster_id = od.ordermaster_id 
JOIN single_product sp ON od.single_product_id = sp.single_product_id 
JOIN product p ON sp.product_id = p.product_id 
WHERE om.ordermaster_id = $master_id";

$result = mysqli_query($conn, $sql);

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Generate HTML content for the invoice
$invoiceHtml = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GST Bill</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        .bill { border: 1px solid #000; padding: 20px; }
        .header, .company, .description { text-align: center; }
        .customer-info, .total { margin-bottom: 20px; }
        .items { width: 100%; border-collapse: collapse; }
        .items th, .items td { border: 1px solid #000; padding: 10px; text-align: left; }
        .total p, .total h3 { text-align: right; }
    </style>
</head>
<body>
<div class="bill">
    <div class="header">
        <h1>Track Sports</h1>
        <h3>GSTIN: 32ABEPN1239AA<br>Kottayam,Kerela</h3>
    </div>
    <div class="customer-info">
        <p>Invoice No: ' . $_SESSION['master_id'] . '<br>Name: ' . $_SESSION['CustomerName'] . '</p>
        <p>Date: ' . date('d-m-Y') . '<br>Time: ' . date('h:i A') . '</p>
    </div>
    <table class="items">
        <thead>
            <tr><th>SI NO</th><th>Item</th><th>Quantity</th><th>Price (per unit)</th><th>Total</th></tr>
        </thead>
        <tbody>';

$serialNumber = 1;
foreach ($products as $product) {
    $invoiceHtml .= "<tr><td>{$serialNumber}</td><td>{$product['name']}</td><td>{$product['quantity']}</td><td>&#8377;{$product['price']}</td><td>&#8377;{$product['total_price']}</td></tr>";
    $serialNumber++;
}

$totalAmount = array_reduce($products, function ($sum, $product) {
    return $sum + $product['total_price'];
}, 0);

$Shipping = 50.00;
$grandTotal = $totalAmount + $Shipping;

$invoiceHtml .= '
        </tbody>
    </table>
    <div class="total">
        <p>Total Amount: ₹' . number_format($totalAmount, 2) . '</p>
        <p>Shipping: ₹' . number_format($Shipping, 2) . '</p>
        <h3>Grand Total: ₹' . number_format($grandTotal, 2) . '</h3>
    </div>
    <div class="description">
        <h4><u>DESCRIPTION</u></h4>
        <p>I/ We hereby certify that my / our Registration certificate under The GST Act 2017 <br>
        is in force on the date on which the sale of the goods specified in this bill / cash <br>
        Memorandum is made by me / us and that the transaction of sale covered by this bill/ cash <br>
        memorandum has been effected by my / us in the regular course of my / our business.</p>
    </div>
    <div class="company">
        <p><b>Track Sports</b></p>
    </div>
</div>
</body>
</html>';

// Generate PDF using Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($invoiceHtml);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$pdfOutput = $dompdf->output();

// Define a safe path to save the PDF
$tempDir = sys_get_temp_dir(); 
$pdfPath = $tempDir . DIRECTORY_SEPARATOR . 'invoice_' . $master_id . '.pdf';

if (file_put_contents($pdfPath, $pdfOutput) === false) {
    echo "Error: Unable to write PDF file to $pdfPath";
    exit;
}

// Send email with attachment
$email = $_SESSION['email'];
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = 'gentriusprojects@gmail.com';
$mail->Password = 'lbef xirr qxgq tsix'; // Replace with your actual password
$mail->setFrom('gentriusprojects@gmail.com', 'Track Sports');
$mail->addAddress($email);
$mail->Subject = 'Order Placed Successfully. Your Invoice';
$mail->Body = 'Dear customer, please find attached the invoice for your recent purchase.';
$mail->addAttachment($pdfPath);

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    // echo 'Invoice sent successfully!';
}

exit; // Prevents further output
?>
