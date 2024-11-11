<?php
include 'connection.php';
session_start();

$categories = isset($_POST['categories']) ? json_decode($_POST['categories']) : [];
$sports = isset($_POST['sports']) ? json_decode($_POST['sports']) : [];
$brands = isset($_POST['brands']) ? json_decode($_POST['brands']) : [];
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$minPrice = isset($_POST['minPrice']) && $_POST['minPrice'] !== '' ? (float) $_POST['minPrice'] : null;
$maxPrice = isset($_POST['maxPrice']) && $_POST['maxPrice'] !== '' ? (float) $_POST['maxPrice'] : null;

// Build the query
$query = "SELECT p.*, c.name as category, s.name as sports, b.name as brand FROM product p 
            INNER JOIN category c ON p.category_id = c.category_id
            INNER JOIN sports s ON p.sports_id = s.sports_id 
            INNER JOIN brand b ON p.brand_id = b.brand_id 
            WHERE 1";

// Filter categories if "All" is not selected
if (!empty($categories) && !in_array("all", $categories)) {
    $categoriesList = implode(",", array_map('intval', $categories));
    $query .= " AND p.category_id IN ($categoriesList)";
}

// Filter sports if "All" is not selected
if (!empty($sports) && !in_array("all", $sports)) {
    $sportsList = implode(",", array_map('intval', $sports));
    $query .= " AND p.sports_id IN ($sportsList)";
}

// Filter brands if "All" is not selected
if (!empty($brands) && !in_array("all", $brands)) {
    $brandsList = implode(",", array_map('intval', $brands));
    $query .= " AND p.brand_id IN ($brandsList)";
}

// Filter by search term if provided
if (!empty($searchTerm)) {
    $searchTerm = $conn->real_escape_string($searchTerm); // Prevent SQL injection
    $query .= " AND (p.name LIKE '%$searchTerm%' OR p.description LIKE '%$searchTerm%')";
}

// Filter by price range if provided
if ($minPrice !== null) {
    $query .= " AND p.price >= $minPrice";
}
if ($maxPrice !== null) {
    $query .= " AND p.price <= $maxPrice";
}

$result = $conn->query($query);

if (mysqli_num_rows($result) > 0) {
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
    <?php }
} else { ?>
    <div class="col-md-12 text-center">
        <h3>No products match your filters. Try adjusting the criteria.</h3>
    </div>
<?php }
?>

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