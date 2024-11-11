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


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) { ?>
        <div class="col-lg-3 col-sm-6 col-md-4 p-b-35">
            <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>">
                <div class="single_product_item">
                    <div class="single_product_item_thumb">
                        <img src="./uploads/<?php echo $row['image']; ?>" alt="#" class="img-fluid">
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4 class="txt-overflow"> <?php echo $row['name']; ?> </h4>
                        <a href="login.php" class="like_us"> <i class="fa-regular fa-heart icon" style="color: #B08EAD; font-size: 20px;"></i> </a>
                    </div>
                    <h4><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $row['price']; ?></h4>
                    <a href="login.php" class="genric-btn primary-border radius col-md-12" style="font-size: 15px;">
                        Add to cart</a>
                </div>
            </a>
        </div>
    <?php }
} else { ?>
    <div class="col-md-12 text-center">
        <h3>No products match your search.</h3>
    </div>
<?php }
?>