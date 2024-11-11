<?php
session_start();
include 'connection.php'; // include your database connection

$single_product_id = $_GET["id"];
$customer_id = $_SESSION['customer_id']; // Assuming customer_id is stored in session

$sql = "DELETE FROM cart WHERE customer_id='$customer_id' AND single_product_id='$single_product_id'";

if (mysqli_query($conn, $sql)) {
    // Deletion was successful
    echo json_encode(['status' => 'success']);
} else {
    // Failed to delete
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete product from cart.']);
}
