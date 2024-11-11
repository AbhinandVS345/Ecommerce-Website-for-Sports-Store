<?php
// get_product_details.php
include 'connection.php'; // Your database connection file

if(isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $sql = "SELECT * FROM product WHERE product_id = $productId";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid product ID']);
}
?>
