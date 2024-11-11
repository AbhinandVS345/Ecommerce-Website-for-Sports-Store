<?php
// Assuming you have a database connection in $conn
include('connection.php');
session_start();
// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product from the database
$sql1 = "SELECT c.name AS cat_name, p.*, s.name AS sports_name, b.name AS brand_name
        FROM product p 
        JOIN category c ON p.category_id = c.category_id 
        JOIN sports s ON p.sports_id = s.sports_id 
        JOIN brand b ON p.brand_id = b.brand_id 
        WHERE p.product_id = '$product_id'";
$result1 = mysqli_query($conn, $sql1);
$product = mysqli_fetch_array($result1);

$sql2 = "SELECT SUM(stock) FROM single_product WHERE product_id= '$product_id' ";
$result2 = mysqli_query($conn, $sql2);
$singleproduct = mysqli_fetch_array($result2);
$totalstock = $singleproduct[0] ?? 0;

// Fetch single_product_id values associated with the product_id
$single_sql = "SELECT single_product_id FROM single_product WHERE product_id = '$product_id'";
$single_result = mysqli_query($conn, $single_sql);
$single_id_list = [];

while ($row = mysqli_fetch_assoc($single_result)) {
    $single_id_list[] = $row['single_product_id'];
}

// Join the single_product_ids into a comma-separated string
$single_id_list_str = implode(',', $single_id_list);
?>

<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Track Sports</title>
    <!-- Bootatrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="mainstyle/img/track.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="mainstyle/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="mainstyle/css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="mainstyle/css/owl.carousel.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="mainstyle/css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="mainstyle/css/flaticon.css">
    <link rel="stylesheet" href="mainstyle/css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="mainstyle/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="mainstyle/css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="mainstyle/css/style.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <style>
        .size-option {
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            margin: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border-color: rgb(148, 148, 148);
        }

        .size-option:hover {
            background-color: #f1f1f1;
        }

        .size-option.selected {
            background-color: #795376;
            color: white;
        }

        .wishlist-btn {

            /* Space between elements */
            text-decoration: none;
            /* Remove underline from link */
            color: #ff6b6b;
            /* Default color for the heart */
        }

        .wishlist-btn:hover {
            color: #ff3b3b;
            /* Change color on hover */
        }

        .text-danger {
            color: red;
        }

        .text-muted {
            color: #ff6b6b;
        }

        .fa-star {
            color: grey;
            /* Default star color */
            cursor: pointer;
            font-size: 24px;
            /* Adjust size as needed */
        }

        .fa-star.filled {
            color: #fbd600;
            /* Filled star color */
        }

        .quantity {
            width: 60px;
            height: 50px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            margin: 0 5px;
            color: #333;
            border-color: rgb(148, 148, 148);
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        .quantity:focus {
            box-shadow: 0 0 5px rgba(130, 126, 126, 0.69);
        }
    </style>
</head>

<body>

    <?php
    if (isset($_SESSION['userid'])) {
        // User is logged in, include the logged-in header
        include("html/cust_header.php");
    } else {
        // User is not logged in, include the default header
        include('html/main_header.php');
    }
    ?>

    <!--================Single Product Area =================-->
    <div class="product_image_area section_padding ">
        <div class="container">
            <div class="row s_product_inner justify-content-between">
                <div class="col-lg-6 col-xl-6">
                    <img src="uploads/<?php echo $product['image']; ?>" width="100%">
                </div>
                <div class="col-lg-6 col-xl-6">
                    <div class="s_product_text">
                        <div class="d-flex justify-content-between">
                            <h3><?php echo $product['name']; ?></h3>
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
                                <a href="#" class="like_us wishlist-btn <?php echo $color_class; ?>" data-product-id="<?php echo $product_id; ?>"> <i class="fa-solid fa-heart"></i> </a>
                            <?php } else { ?>
                                <a href="#" class="like_us wishlist-btn <?php echo $color_class; ?>" data-product-id="<?php echo $product_id; ?>"> <i class="fa-regular fa-heart"></i> </a>
                            <?php } ?>
                        </div>
                        <h2><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $product['price']; ?></h2>
                        <ul class="list">
                            <li>
                                <a class="active" href="#">
                                    <span>Category</span> : <?php echo $product['cat_name']; ?></a>
                            </li>
                            <li class="availability">
                                <span>Availability : </span>
                                <a id="stock" style="<?php echo ($totalstock > 0 && $totalstock < 10) ? 'color: red;' : (($totalstock >= 10) ? 'color: green;' : 'color: red;'); ?>">
                                    <?php
                                    if ($totalstock > 0 && $totalstock < 10) {
                                        echo "Only $totalstock items left!!";
                                    } elseif ($totalstock >= 10) {
                                        echo "In Stock";
                                    } else {
                                        echo "Out of Stock";
                                    }
                                    ?>
                                </a>
                            </li>

                        </ul>
                        <p>
                            <?php echo $product['description']; ?>
                        </p>

                        <?php
                        // Query to get available sizes based on product_id and stock > 0
                        $sql = "SELECT size.size_id, size.size,single_product.single_product_id
                            FROM size 
                            INNER JOIN single_product ON size.size_id = single_product.size_id 
                            WHERE single_product.product_id = $product_id";

                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) == 1) {
                            $size = mysqli_fetch_assoc($result);
                            $singleproduct_id = $size['single_product_id'];
                            if ($size['size'] != "pp") {
                        ?>
                                <p>
                                    <?php echo 'Size: ' . $size['size']; ?>
                                </p>
                            <?php
                            }
                        }

                        if ($result && mysqli_num_rows($result) > 1) { ?>
                            <label for="size" style="font-weight: bold; margin-bottom: 4px;">Size </label>
                            <?php
                            // Loop through the result and build the size buttons
                            while ($size = mysqli_fetch_assoc($result)) { ?>
                                <div class="size-option" id="size" data-size-id="<?php echo $size['size_id']; ?>" data-single-product-id="<?php echo $size['single_product_id']; ?>">
                                    <?php echo $size['size'] ?>
                                </div>
                        <?php }
                        } ?>

                        <div class="card_area d-flex align-items-center">
                            <div class="mr-2">
                                <label for="qty" style="font-weight: bold; margin-bottom: 4px;">Qty</label>
                                <input type="number" name="qty" id="qty" value="1" min="1" max="<?php echo $totalstock; ?>" class="quantity">
                            </div>
                            <!-- Button for "Add to cart" making the AJAX call directly -->
                            <?php
                            if ($result && mysqli_num_rows($result) > 1) { ?>
                                <a href="#" class="add-to-cart-size btn_3 mr-2">
                                    Add to cart
                                </a>
                            <?php } else { ?>
                                <a href="#" data-single-product-id="<?php echo $singleproduct_id; ?>" class="add-to-cart btn_3 mr-2">
                                    Add to cart
                                </a>
                            <?php } ?>
                            <!-- Button for "Buy now" -->
                            <?php
                            if ($result && mysqli_num_rows($result) > 1) { ?>
                                <a href="#" class="buy-now-size btn_3">
                                    buy now
                                </a>
                            <?php } else { ?>
                                <a href="#" data-single-product-id="<?php echo $singleproduct_id; ?>" class="buy-now btn_3">
                                    buy now
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="review-tab" data-toggle="tab" role="tab" aria-controls="review"
                        aria-selected="true">Reviews</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php
                            // Assuming you have already connected to your database

                            $product_id = $_GET['id']; // Get the product ID from the URL

                            // Fetch the total number of reviews and the overall rating
                            $sql_overall = "SELECT AVG(ratingcount) as average_rating, COUNT(*) as total_reviews FROM rating WHERE product_id = ?";
                            $stmt_overall = $conn->prepare($sql_overall);
                            $stmt_overall->bind_param('i', $product_id);
                            $stmt_overall->execute();
                            $result_overall = $stmt_overall->get_result();
                            $row_overall = $result_overall->fetch_assoc();

                            $average_rating = round($row_overall['average_rating'], 1); // Average rating
                            $total_reviews = $row_overall['total_reviews']; // Total reviews

                            // Fetch the count of each star rating (1-5 stars)
                            $star_counts = [];
                            for ($i = 1; $i <= 5; $i++) {
                                $sql_star_count = "SELECT COUNT(*) as count FROM rating WHERE product_id = ? AND ratingcount = ?";
                                $stmt_star_count = $conn->prepare($sql_star_count);
                                $stmt_star_count->bind_param('ii', $product_id, $i);
                                $stmt_star_count->execute();
                                $result_star_count = $stmt_star_count->get_result();
                                $row_star_count = $result_star_count->fetch_assoc();
                                $star_counts[$i] = $row_star_count['count'];
                            }
                            ?>

                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <h4><?php echo number_format($average_rating, 1); ?></h4>
                                        <h6>(<?php echo $total_reviews; ?> Reviews)</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <h3>Based on <?php echo $total_reviews; ?> Reviews</h3>
                                        <ul class="list">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <li>
                                                    <a href="#"><?php echo $i; ?> Star
                                                        <?php for ($j = 1; $j <= 5; $j++): ?>
                                                            <i class="fa fa-star<?php echo ($j <= $i) ? ' filled' : ''; ?>"></i>
                                                        <?php endfor; ?>
                                                        <?php echo $star_counts[$i]; ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="review_list">
                                <?php
                                $product_id = $_GET['id'];
                                $sql = "SELECT r.ratingcount,c.name,p.review_date,p.review FROM rating r JOIN customer c ON r.customer_id=c.customer_id
                                LEFT JOIN product_review p ON p.customer_id=c.customer_id 
                                WHERE p.product_id = '$product_id'";
                                if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
                                    $review = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                                    $rating = $review['ratingcount'];



                                ?>
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="homestyle/img/product/single-product/review-1.png" alt="" />
                                            </div>
                                            <div class="media-body">
                                                <h4><?php echo $review['name']; ?></h4>
                                                <ul class="list">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fa fa-star <?php echo ($i <= $rating) ? 'filled' : ''; ?>"></i>
                                                    <?php endfor; ?>
                                                </ul>

                                            </div>
                                        </div>
                                        <p>
                                            <?php echo $review['review']; ?>
                                        </p>
                                    </div>
                                <?php  } ?>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['userid'])) { ?>
                            <div class="col-lg-6">
                                <?php
                                $customer_id = $_SESSION['userid'];
                                // SQL query to check if any single_product_id related to this product_id exists in orderdetails for the customer
                                $checkOrderSql = "SELECT sp.single_product_id 
                            FROM orderdetails od  
                            JOIN ordermaster om ON od.ordermaster_id = om.ordermaster_id
                            JOIN customer c ON om.customer_id = c.customer_id 
                            JOIN single_product sp ON od.single_product_id = sp.single_product_id 
                            WHERE c.customer_id = $customer_id 
                            AND od.single_product_id IN ($single_id_list_str)";

                                $checkOrderResult = mysqli_query($conn, $checkOrderSql);

                                // Display review section only if a result exists
                                if (mysqli_num_rows($checkOrderResult) > 0) {
                                ?>
                                    <div class="review_box">
                                        <h4>Add a Review</h4>
                                        <p>Your Rating:</p>
                                        <?php
                                        $customer_id = $_SESSION['userid'];
                                        $product_id = $_GET['id'];
                                        $sql = "SELECT ratingcount FROM rating WHERE product_id = '$product_id' AND customer_id='$customer_id'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $ratingcount = $row['ratingcount'];
                                            $ratingcount = $ratingcount ?? 0;
                                            switch ($ratingcount) {
                                                case 1:
                                                    $label = "Poor";
                                                    break;
                                                case 2:
                                                    $label = "Fair";
                                                    break;
                                                case 3:
                                                    $label = "Good";
                                                    break;
                                                case 4:
                                                    $label = "Very Good";
                                                    break;
                                                case 5:
                                                    $label = "Outstanding";
                                                    break;
                                                default:
                                                    $label = "No Rating";
                                            }
                                        ?>
                                            <ul class="list">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <li>
                                                        <a href="#" class="star" data-value="<?php echo $i; ?>" data-product-id="<?php echo $product_id; ?>">
                                                            <i class="fa fa-star <?php echo ($i <= $ratingcount) ? 'filled' : ''; ?>"></i>
                                                        </a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>

                                            <p id="rating-label"><?php echo $label; ?></p>
                                        <?php } else { ?>
                                            <ul class="list">
                                                <li>
                                                    <a href="#" class="star" data-value="1" data-product-id="<?php echo $product_id; ?>">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="star" data-value="2" data-product-id="<?php echo $product_id; ?>">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="star" data-value="3" data-product-id="<?php echo $product_id; ?>">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="star" data-value="4" data-product-id="<?php echo $product_id; ?>">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="star" data-value="5" data-product-id="<?php echo $product_id; ?>">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php } ?>
                                        <form class="row contact_form" action="submit_review.php" method="post" novalidate="novalidate">
                                            <input type="hidden" name="rating" id="rating-input" value="0">
                                            <input type="hidden" name="pro_id" id="pro_id-input" value="<?php echo $product_id; ?>">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="message" rows="5" placeholder="Review" style="height: 200px;" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="submit" value="submit" class="btn_3">
                                                    Submit Now
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php
                                } else {
                                    echo "<p>You need to have purchased this product to leave a review.</p>";
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->


    <?php
    if (isset($_SESSION['userid'])) {
        include("html/cust_footer.html");
    } else {
        include('html/main_footer.html');
    }
    ?>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- jquery plugins here-->
    <script src="mainstyle/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="mainstyle/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="mainstyle/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="mainstyle/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="mainstyle/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="mainstyle/js/mixitup.min.js"></script>
    <!-- particles js -->
    <script src="mainstyle/js/owl.carousel.min.js"></script>
    <script src="mainstyle/js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="mainstyle/js/slick.min.js"></script>
    <script src="mainstyle/js/jquery.counterup.min.js"></script>
    <script src="mainstyle/js/waypoints.min.js"></script>
    <script src="mainstyle/js/contact.js"></script>
    <script src="mainstyle/js/jquery.ajaxchimp.min.js"></script>
    <script src="mainstyle/js/jquery.form.js"></script>
    <script src="mainstyle/js/jquery.validate.min.js"></script>
    <script src="mainstyle/js/mail-script.js"></script>
    <!-- custom js -->
    <script src="mainstyle/js/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <!-- Quantity -->

    <!-- Add to cart -->
    <script>
        $(document).ready(function() {
            var selectedSizeId = null; // Keep track of selected size
            var selectedProductId = null; // Keep track of selected product
            var stock = null;
            var loggedIn = <?php echo isset($_SESSION['userid']) ? json_encode($_SESSION['userid']) : 'null'; ?>;

            // Handle size selection
            $(document).on('click', '.size-option', function() {
                selectedSizeId = $(this).data('size-id');
                selectedProductId = $(this).data('single-product-id');

                // Highlight the selected size
                $('.size-option').removeClass('selected');
                $(this).addClass('selected');



            });

            // Handle the "Add to Cart" button click with size
            $(document).on('click', '.add-to-cart-size', function(event) {
                event.preventDefault();
                var quantity = $('#qty').val();

                // Check if a size is selected
                if (!selectedSizeId) {
                    Toastify({
                        text: "Please select a size before adding to cart.",
                        duration: 3000,
                        backgroundColor: "#FF5F6D",
                        className: "custom-toast",
                    }).showToast();
                    return; // Exit if no size is selected
                }

                // AJAX call to add the product to the cart with size
                $.ajax({
                    url: 'cust_cart.php',
                    type: 'POST',
                    data: {
                        singleproduct_id: selectedProductId,
                        qty: quantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        handleCartResponse(response);
                        $.ajax({
                            url: 'get_cart_count.php', // Separate PHP file to get cart count
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $('#cart-count').text(response.cartCount); // Update cart count element
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Error fetching cart count:', error);
                            }
                        });
                        if (response.status === 'notLoggedIn') {
                            window.location.href = 'login.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", status, error);
                    }
                });
            });

            // Handle the "Add to Cart" button click (no size selection)
            $(document).on('click', '.add-to-cart', function(event) {
                event.preventDefault();

                selectedProductId = $(this).data('single-product-id');
                var quantity = $('#qty').val();

                // AJAX call to add the product to the cart
                $.ajax({
                    url: 'cust_cart.php',
                    type: 'POST',
                    data: {
                        singleproduct_id: selectedProductId,
                        qty: quantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        handleCartResponse(response);
                        $.ajax({
                            url: 'get_cart_count.php', // Separate PHP file to get cart count
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $('#cart-count').text(response.cartCount); // Update cart count element
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Error fetching cart count:', error);
                            }
                        });
                        if (response.status === 'notLoggedIn') {
                            window.location.href = 'login.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", status, error);
                    }
                });
            });

            // Helper function to handle the response
            function handleCartResponse(response) {
                if (response.status === 'success') {
                    Toastify({
                        text: "Product successfully added to cart. <u><a href='cust_viewcart.php' style='color: white;'>Go to Cart</a></u>",
                        duration: 5000,
                        close: true,
                        gravity: "bottom",
                        position: 'right',
                        backgroundColor: "#17191c",
                        stopOnFocus: true,
                        escapeMarkup: false,
                        className: "custom-toast",
                    }).showToast();
                } else if (response.status === 'error') {
                    Toastify({
                        text: "Failed to add product to cart.",
                        duration: 5000,
                        close: true,
                        gravity: "bottom",
                        position: 'right',
                        backgroundColor: "#17191c",
                        stopOnFocus: true,
                        escapeMarkup: false,
                        className: "custom-toast",
                    }).showToast();
                } else if (response.status === 'outOfStock') {
                    Toastify({
                        text: "Product is out of stock.",
                        duration: 5000,
                        close: true,
                        gravity: "bottom",
                        position: 'right',
                        backgroundColor: "#17191c",
                        stopOnFocus: true,
                        escapeMarkup: false,
                        className: "custom-toast",
                    }).showToast();
                }
            }
        });
    </script>

    <!-- Buy now -->
    <script>
        $(document).ready(function() {
            var selectedSizeId = null; // Keep track of selected size
            var selectedProductId = null; // Keep track of selected product
            var stock = null;
            var loggedIn = <?php echo isset($_SESSION['userid']) ? json_encode($_SESSION['userid']) : 'null'; ?>;

            // Handle size selection
            $(document).on('click', '.size-option', function() {
                selectedSizeId = $(this).data('size-id');
                selectedProductId = $(this).data('single-product-id');

                // Highlight the selected size
                $('.size-option').removeClass('selected');
                $(this).addClass('selected');

                // AJAX request to get stock
                $.ajax({
                    url: 'get_stock.php', // PHP file to query stock
                    type: 'POST',
                    data: {
                        single_product_id: selectedProductId
                    },
                    success: function(response) {
                        // Parse response to get the stock value
                        stock = JSON.parse(response).stock;
                        stockElement = document.getElementById("stock");
                        quantityInput = document.getElementById("qty");

                        if (stock > 0 && stock < 10) {
                            stockElement.textContent = 'Only ' + stock + ' items left!!';
                            stockElement.style.color = 'red'; // Optional: Color for limited stock
                        } else if (stock >= 10) {
                            stockElement.textContent = 'In Stock';
                            stockElement.style.color = 'green';
                        } else {
                            stockElement.textContent = 'Out of Stock';
                            stockElement.style.color = 'red';
                        }

                        // Dynamically set the max value of the quantity input
                        if (stock > 0) {
                            quantityInput.max = stock; // Set max to the current stock value
                        } else {
                            quantityInput.max = 1; // Prevent selection of items when out of stock
                            quantityInput.value = 1; // Reset to minimum value if out of stock
                        }

                    },
                    error: function() {
                        // document.getElementById("stock").textContent = 'Error retrieving stock information.';
                    }
                });
            });

            // Handle the "Buy now" button click with size
            $(document).on('click', '.buy-now-size', function(event) {
                event.preventDefault();
                var quantity = $('#qty').val();

                // Check if a size is selected
                if (!selectedSizeId) {
                    Toastify({
                        text: "Please select a size.",
                        duration: 3000,
                        backgroundColor: "#FF5F6D",
                        className: "custom-toast",
                    }).showToast();
                    return; // Exit if no size is selected
                }

                if (loggedIn != null) {
                    // Check stock
                    if (stock == 0) {
                        Toastify({
                            text: "Product is out of stock.",
                            duration: 3000,
                            backgroundColor: "#FF5F6D",
                            className: "custom-toast",
                        }).showToast();
                        return; // Exit if no size is selected
                    } else {
                        // Redirect to cust_buynow.php with the selected product ID
                        var url = 'cust_buynow.php?singleproduct_id=' + selectedProductId + "&qty=" + quantity;
                        window.location.href = url;
                    }
                } else {
                    window.location.href = 'login.php';
                }
            });

            // Handle the "Buy now" button click (no size selection)
            $(document).on('click', '.buy-now', function(event) {
                event.preventDefault();

                selectedProductId = $(this).data('single-product-id');
                var quantity = $('#qty').val();

                // AJAX request to get stock
                $.ajax({
                    url: 'get_stock.php', // PHP file to query stock
                    type: 'POST',
                    data: {
                        single_product_id: selectedProductId
                    },
                    success: function(response) {
                        // Parse response to get the stock value
                        stock = JSON.parse(response).stock;
                        if (loggedIn != null) {
                            // Check stock
                            if (stock == 0) {
                                Toastify({
                                    text: "Product is out of stock.",
                                    duration: 3000,
                                    backgroundColor: "#FF5F6D",
                                    className: "custom-toast",
                                }).showToast();
                                return; // Exit if no size is selected
                            } else {
                                // Redirect to cust_buynow.php with the selected product ID
                                var url = 'cust_buynow.php?singleproduct_id=' + selectedProductId + "&qty=" + quantity;
                                window.location.href = url;
                            }
                        } else {
                            window.location.href = 'login.php';
                        }
                    },
                    error: function() {
                        // document.getElementById("stock").textContent = 'Error retrieving stock information.';
                    }
                });
            });
        });
    </script>

    <!-- Wishlist -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION['userid']) ? 'true' : 'false'; ?>;

        $(document).ready(function() {
            $('.wishlist-btn').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                var productId = button.data('product-id');
                var heartIcon = button.find('i');

                $.ajax({
                    url: 'wishlist.php',
                    type: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        console.log("Raw response:", response); // Log the raw response

                        if (typeof response === 'string') {
                            try {
                                response = JSON.parse(response); // Ensure response is parsed as JSON
                            } catch (e) {
                                console.error("Failed to parse JSON:", e);
                                toastr.error('An unexpected error occurred while processing the response.');
                                return;
                            }
                        }

                        if (response.status === 'success') {
                            if (response.action === 'added') {
                                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                                heartIcon.removeClass('text-muted').addClass('text-danger');
                                toastr.success(response.message);
                            } else if (response.action === 'removed') {
                                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                                heartIcon.removeClass('text-danger').addClass('text-muted');
                                toastr.success(response.message);
                            }

                            // Update the wishlist count in the icon
                            var wishlistCount = parseInt(response.wishlistCount, 10);
                            if (wishlistCount > 0) {
                                $('#wishlist-count').text(wishlistCount).show(); // Update and show cart count element
                            } else {
                                $('#wishlist-count').hide(); // Hide if no items
                            }
                        } else if (response.status === 'error') {
                            toastr.error(response.message); // Show error message
                        }
                    },
                    error: function() {
                        toastr.error('An unexpected error occurred.');
                    }
                });
            });
        });
    </script>

    <!-- Rating -->
    <script>
        $(document).ready(function() {
            $('.star').on('click', function(e) {
                e.preventDefault();

                // Get the rating value
                var ratingValue = $(this).data('value');
                var product_id = $(this).data('product-id');

                // Fill stars up to the clicked one
                $('.star').each(function(index) {
                    if (index < ratingValue) {
                        $(this).find('i').addClass('filled');
                    } else {
                        $(this).find('i').removeClass('filled');
                    }
                });

                // Update the label
                var labelText;
                switch (ratingValue) {
                    case 1:
                        labelText = "Poor";
                        break;
                    case 2:
                        labelText = "Fair";
                        break;
                    case 3:
                        labelText = "Good";
                        break;
                    case 4:
                        labelText = "Very Good";
                        break;
                    case 5:
                        labelText = "Outstanding";
                        break;
                    default:
                        labelText = "No Rating";
                }
                $('#rating-label').text(labelText);

                // Set the rating value in the hidden input
                $('#rating-input').val(ratingValue);
            });
        });
    </script>

</body>

</html>