<?php
session_start();
include('connection.php');

if (!isset($_SESSION['userid'])) {
    // Redirect to login page or send an error response
    $response['status'] = 'notLoggedIn';
    echo json_encode($response);
    exit;
}


$customer_id = $_SESSION['userid'];
$singleproduct_id = $_POST['singleproduct_id'];  // Use POST method to receive data
$qty = 1;

$response = array();  // Initialize response array

// Validate inputs
if (empty($singleproduct_id) || empty($customer_id)) {
    $response['status'] = 'error';
    echo json_encode($response);
    exit;
}

// Check stock availability
$sql_stock = "SELECT stock FROM single_product WHERE single_product_id='$singleproduct_id'";
$stk_result = mysqli_fetch_array(mysqli_query($conn, $sql_stock));
$stock = $stk_result['stock'];

if ($stock > 0) {
    // Check if the product is already in the cart
    $sql1 = "SELECT * FROM cart WHERE customer_id='$customer_id' AND single_product_id='$singleproduct_id'";
    $result = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result) > 0) {
        // Product exists in cart, update quantity
        $sql2 = "UPDATE cart SET quantity=quantity+$qty WHERE customer_id='$customer_id' AND single_product_id='$singleproduct_id'";
        if (mysqli_query($conn, $sql2)) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 'error';
        }
    } else {
        // Product not in cart, insert new record
        $sql3 = "INSERT INTO cart (customer_id, single_product_id, quantity) VALUES ('$customer_id', '$singleproduct_id', $qty)";
        if (mysqli_query($conn, $sql3)) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 'error';
        }
    }
} else {
    // Stock unavailable
    $response['status'] = 'outOfStock';
}

// Return JSON response
echo json_encode($response);
?>
