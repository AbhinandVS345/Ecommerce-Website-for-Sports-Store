<?php
include('connection.php');

// Get search query from the AJAX request
$searchQuery = $_GET['query'] ?? '';

// SQL query to search products by name (case-insensitive)
$sql = "SELECT * FROM product WHERE name LIKE ? OR description LIKE ?";
$searchTerm = "%$searchQuery%"; // Add wildcards for partial matching
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $searchTerm, $searchTerm); // Bind the same search term for both name and description
$stmt->execute();
$result = $stmt->get_result();


// Output the products
while ($row = mysqli_fetch_array($result)) { ?>
    <div class="col-lg-4 col-sm-6 col-md-4 p-b-35">
        <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>">
            <?php $product_id = $row['product_id']; ?>
            <div class="single_product_item">
                <div class="single_product_item_thumb">
                    <img src="./uploads/<?php echo $row['image']; ?>" alt="#" class="img-fluid">
                </div>
                <div class="d-flex justify-content-between">
                    <h4 class="txt-overflow"> <?php echo $row['name']; ?> </h4>
                    <?php
                    $cust_id = $_SESSION['userid'] ?? '';
                    $in_wishlist = false;

                    if ($cust_id) {

                        $check_query = "SELECT * FROM wishlist WHERE product_id = ? AND customer_id = ?";
                        $stmt = $conn->prepare($check_query);
                        $stmt->bind_param('ii', $product_id, $cust_id);
                        $stmt->execute();
                        $ans = $stmt->get_result();

                        $in_wishlist = $ans->num_rows > 0; // true if product is in wishlist
                    }


                    $color_class = $in_wishlist ? 'text-danger' : 'text-muted'; // red if in wishlist, gray if not
                    ?>
                    <?php if ($in_wishlist) { ?>
                        <a href="#" style="font-size: 20px;" class="like_us wishlist-btn <?php echo $color_class; ?>" data-product-id="<?php echo $product_id; ?>"> <i class="fa-solid fa-heart"></i> </a>
                    <?php } else { ?>
                        <a href="#" style="font-size: 20px;" class="like_us wishlist-btn <?php echo $color_class; ?>" data-product-id="<?php echo $product_id; ?>"> <i class="fa-regular fa-heart"></i> </a>
                    <?php } ?>
                </div>
                <?php $product_id = $row['product_id']; ?>
                <h4><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $row['price']; ?></h4>
                <?php
                $sql2 = "SELECT COUNT(*) FROM single_product WHERE product_id=$product_id";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_row($result2);
                $count = $row2[0];
                if ($count == 1) {
                    $sql3 = "SELECT single_product_id FROM single_product WHERE product_id=$product_id";
                    $result3 = mysqli_query($conn, $sql3);
                    $row3 = mysqli_fetch_row($result3);
                    $single_id = $row3[0];
                ?>
                    <!-- Button for making the AJAX call directly -->
                    <a href="#" data-single-product-id="<?php echo $single_id; ?>" class="add-to-cart genric-btn primary-border radius col-md-12" style="font-size: 15px;">
                        Add to cart
                    </a>
                <?php } else { ?>
                    <!-- Button that opens the modal and passes the product ID -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" data-product-id="<?php echo $product_id; ?>" class="open-size-modal genric-btn primary-border radius col-md-12" style="font-size: 15px;">
                        Add to cart
                    </a>
                <?php } ?>
            </div>
        </a>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        // Declare variables in a higher scope
        let selectedSizeId = null;
        let selectedProductId = null;
        // Click event handler for the modal button
        $('.open-size-modal').click(function() {
            var productId = $(this).data('product-id'); // Get the product ID
            $('#size_prod_id').val(productId); // Assign it to the hidden field in the modal

            // Clear previous sizes
            $('#size-options').html('');

            // Make AJAX request to get sizes
            $.ajax({
                url: 'get_sizes.php',
                type: 'GET',
                data: {
                    product_id: productId
                },
                success: function(response) {
                    // Inject the response (size options) into the size-options div
                    $('#size-options').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred:", status, error);
                }
            });
        });
    });
</script>
