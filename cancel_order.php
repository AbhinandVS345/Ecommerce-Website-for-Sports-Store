<?php
session_start();
include('Connection.php');

$response = ["success" => false, "message" => "", "payment_method" => ""];

if (isset($_POST['ordermaster_id'])) {
    $customer_id = $_SESSION['userid'];
    $ordermaster_id = $_POST['ordermaster_id'];

    $sql = "UPDATE ordermaster SET status = 'Cancelled' WHERE ordermaster_id = '$ordermaster_id'";
    if (mysqli_query($conn, $sql)) {

        $payment_sql = "SELECT payment_method FROM payment WHERE ordermaster_id = '$ordermaster_id'";
        $result = mysqli_query($conn, $payment_sql); // Corrected variable name

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $payment_method = $row['payment_method'];
        }

        $response["success"] = true;
        $response["message"] = "Cancelled";
        $response["payment_method"] = $payment_method;

    } else {
        $response["message"] = "Order status updation failed!";
    }
}

echo json_encode($response);  // Return response as JSON
