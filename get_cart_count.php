<?php
session_start();
include('connection.php');

$response = array();

if (isset($_SESSION['userid'])) {
    $customer_id = $_SESSION['userid'];
    
    // Get the count of items in the cart
    $sql = "SELECT SUM(quantity) AS cartCount FROM cart WHERE customer_id='$customer_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $response['status'] = 'success';
    $response['cartCount'] = $row['cartCount'] ?? 0; // Default to 0 if no items in cart
} else {
    $response['status'] = 'notLoggedIn';
}

echo json_encode($response);
?>
