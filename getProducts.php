<?php
include('connection.php');

if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    $sql = "SELECT c.name as cat_name, p.*, s.name as sports_name, b.name as brand_name
            FROM product p 
            JOIN category c ON c.category_id = p.category_id 
            JOIN sports s ON p.sports_id = s.sports_id 
            JOIN brand b ON p.brand_id=b.brand_id
            WHERE p.product_id = '$productId'";

    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Failed to fetch product details.']);
    }
} else {
    echo json_encode(['error' => 'Product ID not specified.']);
}
?>
