<?php
// get_stock.php
include ('connection.php');  // Database connection file

if (isset($_POST['single_product_id'])) {
    $singleproduct_id = $_POST['single_product_id'];
    $sql_stock = "SELECT stock FROM single_product WHERE single_product_id='$singleproduct_id'";
    $result = mysqli_query($conn, $sql_stock);

    if ($result && $stk_result = mysqli_fetch_assoc($result)) {
        $stock = $stk_result['stock'];
        echo json_encode(['stock' => $stock]);
    } else {
        echo json_encode(['stock' => 0]);  // Return 0 stock if query fails
    }
} else {
    echo json_encode(['stock' => 0]);  // Return 0 stock if no product ID is provided
}
?>
