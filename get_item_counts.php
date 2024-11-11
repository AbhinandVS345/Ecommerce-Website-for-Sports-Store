<?php
session_start();
include('Connection.php');

$cust_id = $_SESSION['userid'];

// Fetch wishlist count
$sql = "SELECT COUNT(*) AS totalItems FROM wishlist WHERE customer_id = '$cust_id'";
$wishlistResult = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$totalWishlistItems = $wishlistResult['totalItems'] ? $wishlistResult['totalItems'] : 0;

// Fetch cart count
$sql = "SELECT SUM(quantity) AS totalItems FROM cart WHERE customer_id = '$cust_id'";
$cartResult = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$totalCartItems = $cartResult['totalItems'] ? $cartResult['totalItems'] : 0;

// Return JSON response with counts
echo json_encode([
    'wishlistCount' => $totalWishlistItems,
    'cartCount' => $totalCartItems
]);
?>
