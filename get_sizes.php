<?php
// get_sizes.php
include 'connection.php'; // Include your database connection

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql1 = "SELECT * FROM product WHERE product_id=$product_id";
    $pr_details = mysqli_query($conn, $sql1);
    while ($row1 = mysqli_fetch_assoc($pr_details)) {
        echo 
        '<div class="row" style="display: flex; align-items: flex-start;">' . 
            // Image and SIZE text within col-lg-3
            '<div class="col-lg-3" style="display: flex; flex-direction: column; align-items: left;">' . 
                '<img src="./uploads/' . $row1['image'] . '" style="width: 100px; height: 100px; margin-right: 20px;"/>' .
                '<p style="margin-top: 10px; font-weight: bold; font-size: 14px;">SELECT SIZE</p>' .
            '</div>' .
            // Name, Description, and Price within col-lg-9
            '<div class="col-lg-9">' . 
                '<button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="right: 10px;"></button>'.
                '<div style="font-weight: bold; font-size: 16px; text-transform: uppercase;">' . $row1['name'] . '</div>' .
                '<div style="font-size: 16px;">' . $row1['description'] . '</div>' .
                '<div style="font-size: 16px;">₹' . $row1['price'] . '</div>' .
            '</div>' .
        '</div>';
    }
    

    // Query to get available sizes based on product_id and stock > 0
    $sql = "SELECT size.size_id, size.size,single_product.single_product_id
            FROM size 
            INNER JOIN single_product ON size.size_id = single_product.size_id 
            WHERE single_product.product_id = $product_id AND single_product.stock > 0";
    
    $result = mysqli_query($conn, $sql);
    $sizes = [];

    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through the result and build the size buttons
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="size-option" data-size-id="' . $row['size_id'] . '" data-single-product-id="' . $row['single_product_id'] . '">
            <input type="hidden" name="single_pr_id" value="' . $row['size_id'] . '">
            ' . $row['size'] . '
          </div>';
        }
    } else {
        echo '<p>No sizes available for this product.</p>';
    }
}
?>
