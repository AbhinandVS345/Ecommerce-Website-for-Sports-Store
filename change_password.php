<?php
session_start();
include 'connection.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['userid'];
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    if ($new_password !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'New password and confirm password do not match.']);
        exit;
    }
    // Retrieve the customer email from the customer table
    $sql = "SELECT email FROM customer WHERE customer_id='$customer_id'";
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_assoc($result);

    if ($customer) {
        $email = $customer['email'];

        // Retrieve the current password from the login table
        $login_sql = "SELECT password FROM login WHERE email='$email'";
        $login_result = mysqli_query($conn, $login_sql);
        $login = mysqli_fetch_assoc($login_result);

        // Verify the current password
        if ($login && ($current_password == $login['password'])) {
            // Update the password
            $update_sql = "UPDATE login SET password='$new_password' WHERE email='$email'";
            
            if (mysqli_query($conn, $update_sql)) {
                // Logout the user
                session_destroy();
                $response = [
                    'status' => 'success',
                    'message' => 'Password changed successfully! Logging out...'
                ];
                echo json_encode($response);
            } else {
                // Handle error if the update fails
                echo json_encode(['status' => 'error', 'message' => 'Error updating password: ' . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Customer not found.']);
    }
}
?>
