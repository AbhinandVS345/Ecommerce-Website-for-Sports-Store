<?php
header('Content-Type: application/json');
include('connection.php');

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_status = $_POST['order_status'] ?? '';
    $order_master_id = $_POST['order_master_id'] ?? '';

    if ($order_status && $order_master_id) {
        $update_query = "UPDATE ordermaster SET status='$order_status' WHERE ordermaster_id='$order_master_id'";
        if (mysqli_query($conn, $update_query)) {

            $updatePaymentStatusQuery = "UPDATE payment SET payment_status = 'Completed' WHERE ordermaster_id ='$order_master_id'";

            mysqli_query($conn, $updatePaymentStatusQuery);
            $response = ['status' => 'success', 'message' => 'Order status updated!'];
            $response['updated_status'] = $order_status;
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to update status.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Missing required data.'];
    }
}

// For debugging purposes only, temporarily uncomment this line
//echo '<pre>' . print_r($response, true) . '</pre>';

echo json_encode($response);
