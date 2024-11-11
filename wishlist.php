<?php
header('Content-Type: application/json');
include('connection.php');
session_start();

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $cust_id = $_SESSION['userid'] ?? '';

    if ($product_id && $cust_id) {
        // Check if product is already in wishlist
        $check_query = "SELECT * FROM wishlist WHERE product_id = ? AND customer_id = ?";
        $stmt = $conn->prepare($check_query);
        
        if ($stmt) {
            $stmt->bind_param('ii', $product_id, $cust_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // If product is already in wishlist, remove it
                $delete_query = "DELETE FROM wishlist WHERE product_id = ? AND customer_id = ?";
                $stmt = $conn->prepare($delete_query);
                
                if ($stmt) {
                    $stmt->bind_param('ii', $product_id, $cust_id);
                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Product removed from wishlist', 'action' => 'removed'];

                        // Get updated wishlist count
                        $count_query = "SELECT COUNT(*) AS count FROM wishlist WHERE customer_id = ?";
                        $stmt = $conn->prepare($count_query);
                        $stmt->bind_param('i', $cust_id);
                        $stmt->execute();
                        $count_result = $stmt->get_result();
                        $count_row = $count_result->fetch_assoc();
                        $response['wishlistCount'] = $count_row['count'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Failed to remove product from wishlist'];
                    }
                }
            } else {
                // If not in wishlist, add it
                $insert_query = "INSERT INTO wishlist (product_id, customer_id) VALUES (?, ?)";
                $stmt = $conn->prepare($insert_query);
                
                if ($stmt) {
                    $stmt->bind_param('ii', $product_id, $cust_id);
                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Product added to wishlist', 'action' => 'added'];

                        // Get updated wishlist count
                        $count_query = "SELECT COUNT(*) AS count FROM wishlist WHERE customer_id = ?";
                        $stmt = $conn->prepare($count_query);
                        $stmt->bind_param('i', $cust_id);
                        $stmt->execute();
                        $count_result = $stmt->get_result();
                        $count_row = $count_result->fetch_assoc();
                        $response['wishlistCount'] = $count_row['count'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Failed to add product to wishlist'];
                    }
                }
            }
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Customer not logged in'];
    }
}

echo json_encode($response);
?>
