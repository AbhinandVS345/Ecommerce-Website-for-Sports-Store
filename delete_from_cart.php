<?php
session_start();
include('Connection.php');

$response = ["success" => false, "message" => "", "subtotal" => ""];

if (isset($_POST['single_product_id'])) {
  $customer_id = $_SESSION['userid'];
  $single_product_id = $_POST['single_product_id'];

  $sql = "DELETE FROM cart WHERE customer_id='$customer_id' AND single_product_id='$single_product_id'";
  if (mysqli_query($conn, $sql)) {
    $response["success"] = true;
    $response["message"] = "Product deleted from cart successfully!";
  } else {
    $response["message"] = "Product deletion from cart failed!";
  }

  $total_sql = "SELECT c.*, sp.*, p.*, s.size as size, cust.customer_id  FROM cart c 
        JOIN single_product sp ON c.single_product_id = sp.single_product_id 
        JOIN product p ON sp.product_id = p.product_id 
        JOIN size s ON sp.size_id = s.size_id 
        JOIN customer cust ON c.customer_id = cust.customer_id 
        WHERE cust.customer_id = '$customer_id'";
  $result = mysqli_query($conn, $total_sql);
  if (mysqli_num_rows($result) > 0) {
    $subtotal = 0;
    while ($product = mysqli_fetch_array($result)) {
      $total_price = $product['price'] * $product['quantity'];
      $subtotal += $total_price;
    }
    $response["subtotal"] = $subtotal;
  }
}

echo json_encode($response);  // Return response as JSON
