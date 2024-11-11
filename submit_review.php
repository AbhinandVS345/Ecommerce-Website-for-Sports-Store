<?php
session_start();
include('connection.php');

// Get POST data
$product_id = $_POST['pro_id']; // Assuming this is sent from the form or as part of the URL
$customer_id = $_SESSION['userid'];
$review = $_POST['message'];
$rating = $_POST['rating']; // Rating from the hidden input

if ($review) {
    // Insert the review into the product_review table
    $sql_review = "INSERT INTO product_review (customer_id, product_id, review_date, review) VALUES (?, ?, NOW(), ?)";
    $stmt_review = $conn->prepare($sql_review);
    $stmt_review->bind_param('iis', $customer_id, $product_id, $review);
    $stmt_review->execute();
}

// Check if a rating already exists
$sql_rate = "SELECT * FROM rating WHERE product_id = ? AND customer_id = ?";
$stmt_rate = $conn->prepare($sql_rate);
$stmt_rate->bind_param('ii', $product_id, $customer_id);
$stmt_rate->execute();
$result_rate = $stmt_rate->get_result();

if ($result_rate->num_rows > 0) {
    // Update existing rating
    $sql_update = "UPDATE rating SET ratingcount = ? WHERE product_id = ? AND customer_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('iii', $rating, $product_id, $customer_id);
    $stmt_update->execute();
} else {
    // Insert new rating
    $sql_insert = "INSERT INTO rating (customer_id, product_id, ratingcount) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('iii', $customer_id, $product_id, $rating);
    $stmt_insert->execute();
}


header("Location: cust_singleproduct.php?id=" . $product_id); // Change this to your actual product page URL
exit();

$stmt_review->close();
$conn->close();
