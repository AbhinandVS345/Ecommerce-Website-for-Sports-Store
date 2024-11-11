<?php
session_start();
include('Connection.php');

$cart_id = $_POST['cart_id'];
$quantity = $_POST['quantity'];

// Update the cart quantity
$sql = "UPDATE cart SET quantity = '$quantity' WHERE cart_id = '$cart_id'";
mysqli_query($conn, $sql);

// Calculate new subtotal
$sql = "SELECT SUM(p.price * c.quantity) AS subtotal FROM cart c JOIN product p ON c.product_id = p.product_id WHERE c.customer_id = '{$_SESSION['userid']}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode(['subtotal' => $row['subtotal']]);
?>
