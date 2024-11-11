<?php
session_start();
include('Connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['userid']; // Get customer ID from session
    $name = $_POST['username'];
    $phone = $_POST['phone'];

    // Update customer details in the database
    $update_query = "UPDATE customer SET name = ?, phno = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssi', $name, $phone, $customer_id);

    if ($stmt->execute()) {
        // Update session values after successful update
        $_SESSION['CustomerName'] = $name;
        $_SESSION['phone'] = $phone;

        // Send response as JSON
        echo json_encode([
            'status' => 'success',
            'updated_name' => $name,
            'updated_phone' => $phone
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conn->close();
}
?>
