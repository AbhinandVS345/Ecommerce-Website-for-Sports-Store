<?php
session_start();
include('Connection.php');
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
    <!-- Util CSS -->
    <link rel="stylesheet" href="mainstyle/css/util.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

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

    <!-- breadcrumb part start-->
    <section class="breadcrumb_part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <h2>product list</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb part end-->

    <!-- product list part start-->
    <section class="product_list section_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="product_sidebar">
                        <div class="single_sedebar">
                            <form id="search-form" action="#" onsubmit="return false;">
                                <input id="search-input" placeholder="Search here..." type="text" oninput="filterProducts()">
                                <i class="ti-search" onclick="filterProducts()"></i>
                            </form>
                        </div>

                        <div class="single_sedebar">
                            <div class="select_option">
                                <div class="select_option_list">Category <i class="right fas fa-caret-down" id="close-filter1"></i></div>
                                <div class="select_option_dropdown">
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>All</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" id="category-all" name="categories[]" value="all" onclick="toggleAllCategories(this)">
                                            <label for="category-all"></label>
                                        </div>
                                    </div>
                                    <?php
                                    include('connection.php');
                                    // Fetch categories
                                    $sql = "SELECT category_id, name FROM category";
                                    $result = $conn->query($sql);

                                    while ($row = $result->fetch_assoc()) { ?>
                                        <div class="switch-wrap d-flex justify-content-between">
                                            <p><?php echo htmlspecialchars($row['name']); ?></p>
                                            <div class="primary-checkbox">
                                                <input type="checkbox" class="category-checkbox" id="category-<?php echo $row['category_id']; ?>" name="categories[]" value="<?php echo $row['category_id']; ?>" onclick="filterProducts()">
                                                <label for="category-<?php echo $row['category_id']; ?>"></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="single_sedebar">
                            <div class="select_option">
                                <div class="select_option_list">Sports <i class="right fas fa-caret-down" id="close-filter1"></i></div>
                                <div class="select_option_dropdown">
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>All</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" id="sports-all" name="sports[]" value="all" onclick="toggleAllSports(this)">
                                            <label for="sports-all"></label>
                                        </div>
                                    </div>
                                    <?php
                                    include('connection.php');
                                    // Fetch sports
                                    $sql = "SELECT sports_id, name FROM sports";
                                    $result = $conn->query($sql);

                                    while ($row = $result->fetch_assoc()) { ?>
                                        <div class="switch-wrap d-flex justify-content-between">
                                            <p><?php echo htmlspecialchars($row['name']); ?></p>
                                            <div class="primary-checkbox">
                                                <input type="checkbox" class="sports-checkbox" id="sports-<?php echo $row['sports_id']; ?>" name="sports[]" value="<?php echo $row['sports_id']; ?>" onclick="filterProducts()">
                                                <label for="sports-<?php echo $row['sports_id']; ?>"></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="single_sedebar">
                            <div class="select_option">
                                <div class="select_option_list">Brand <i class="right fas fa-caret-down" id="close-filter1"></i></div>
                                <div class="select_option_dropdown">
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>All</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" id="brand-all" name="brands[]" value="all" onclick="toggleAllBrands(this)">
                                            <label for="brand-all"></label>
                                        </div>
                                    </div>
                                    <?php
                                    include('connection.php');
                                    // Fetch brands
                                    $sql = "SELECT brand_id, name FROM brand";
                                    $result = $conn->query($sql);

                                    while ($row = $result->fetch_assoc()) { ?>
                                        <div class="switch-wrap d-flex justify-content-between">
                                            <p><?php echo htmlspecialchars($row['name']); ?></p>
                                            <div class="primary-checkbox">
                                                <input type="checkbox" class="brand-checkbox" id="brand-<?php echo $row['brand_id']; ?>" name="brands[]" value="<?php echo $row['brand_id']; ?>" onclick="filterProducts()">
                                                <label for="brand-<?php echo $row['brand_id']; ?>"></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="single_sedebar">
                            <div class="select_option">
                                <div class="select_option_list">Price Range <i class="right fas fa-caret-down" id="close-filter4"></i></div>
                                <div class="select_option_dropdown">
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>All</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" class="price-checkbox" id="price-all" name="prices[]" value="all" onclick="toggleAllPrices(this)">
                                            <label for="price-all"></label>
                                        </div>
                                    </div>
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>₹0 - ₹500</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" class="price-checkbox" id="price_0_500" data-min-price="0" data-max-price="500" name="prices[]" onclick="filterProducts()">
                                            <label for="price_0_500"></label>
                                        </div>
                                    </div>
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>₹500 - ₹1000</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" class="price-checkbox" id="price_500_1000" data-min-price="500" data-max-price="1000" name="prices[]" onclick="filterProducts()">
                                            <label for="price_500_1000"></label>
                                        </div>
                                    </div>
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>₹1000 - ₹1500</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" class="price-checkbox" id="price_1000_1500" data-min-price="1000" data-max-price="1500" name="prices[]" onclick="filterProducts()">
                                            <label for="price_1000_1500"></label>
                                        </div>
                                    </div>
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>₹1500 - ₹2000</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" class="price-checkbox" id="price_1500_2000" data-min-price="1500" data-max-price="2000" name="prices[]" onclick="filterProducts()">
                                            <label for="price_1500_2000"></label>
                                        </div>
                                    </div>
                                    <div class="switch-wrap d-flex justify-content-between">
                                        <p>Above ₹2000</p>
                                        <div class="primary-checkbox">
                                            <input type="checkbox" class="price-checkbox" id="price_2000_above" data-min-price="2000" data-max-price="above" name="prices[]" onclick="filterProducts()">
                                            <label for="price_2000_above"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="product_list products">
                        <div class="row" id="product-grid">
                            <?php
                            $sql = "SELECT * FROM product";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product list part end-->


    <!-- Modal -->
    <!-- Modal Structure -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" action="">
                        <!-- <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 10px; right: 10px;"></button> -->
                        <input type="hidden" name="product_id" id="size_prod_id">
                        <input type="hidden" class="selected_size" id="selected_size_id">
                        <input type="hidden" id="selected_single_id">
                        <div id="size-options">
                            <!-- Sizes will be dynamically injected here -->
                        </div>
                    </form>
                    <button type="button" class="add-to-cart-size genric-btn primary-border radius col-md-12 m-t-2" data-bs-dismiss="modal" style="font-size: 15px;">
                        Add to cart
                    </button>

                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION['userid'])) {
        include("html/cust_footer.html");
    } else {
        include("html/main_footer.html");
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

    <!-- Add to cart -->
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

            $(document).on('click', '.size-option', function() {
                var selectedSizeId = $(this).data('size-id');
                var selectedProductId = $(this).data('single-product-id');
                $('.size-option').removeClass('selected');
                $(this).addClass('selected');
                $('#selected_size_id').val(selectedSizeId); // Update hidden input with selected size
                $('#selected_single_id').val(selectedProductId); // Update hidden input with selected product
            });

            // Handle the "Add to Cart" button click with size
            $(document).on('click', '.add-to-cart-size', function(event) {
                event.preventDefault();
                var selectedSizeId = document.querySelector('#selected_size_id').getAttribute('value'); // Get the size ID
                var selectedProductId = document.querySelector('#selected_single_id').getAttribute('value'); // Get the product ID

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
                        singleproduct_id: selectedProductId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'notLoggedIn') {
                            // Redirect to login page
                            window.location.href = 'login.php'; // Change to your login page URL
                        } else {
                            handleCartResponse(response);
                            updateCartCount();
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

                // AJAX call to add the product to the cart
                $.ajax({
                    url: 'cust_cart.php',
                    type: 'POST',
                    data: {
                        singleproduct_id: selectedProductId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'notLoggedIn') {
                            // Redirect to login page
                            window.location.href = 'login.php'; // Change to your login page URL
                        } else {
                            handleCartResponse(response);
                            updateCartCount();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", status, error);
                    }
                });
            });

            function updateCartCount() {
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
            }

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

    <!-- Search and Filters -->
    <script>
        $(document).ready(function() {
            // Click event for the search icon
            $('#search_1').on('click', function() {
                $('#search-icon').focus(); // Set focus to the search input field
            });

            // Event to close the search bar when Enter key is pressed in the search input
            $('#search-icon').on('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent form submission
                    $('#close_search').click(); // Trigger the click event on close button
                    $(this).val(''); // Clear the entered text
                }
            });

            // Handle search icon input change
            $('#search-icon').on('input', function() {
                var searchQuery = $(this).val(); // Get the input value

                // AJAX request to fetch products by search query
                $.ajax({
                    url: 'fetch_products_by_search.php', // Backend script that handles product fetching by search
                    method: 'GET',
                    data: {
                        query: searchQuery
                    },
                    success: function(response) {
                        // Update the product list with the new content
                        $('.products .row').html(response);
                    },
                    error: function() {
                        alert('Error fetching products. Please try again.');
                    }
                });
            });
        });
    </script>


    <script>
        function toggleAllCategories(allCheckbox) {
            const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

            // If "All" is checked, uncheck all other checkboxes
            if (allCheckbox.checked) {
                categoryCheckboxes.forEach(cb => cb.checked = false);
            }
            // Trigger filter
            filterProducts();
        }

        function toggleAllSports(allCheckbox) {
            const sportsCheckboxes = document.querySelectorAll('.sports-checkbox');

            // If "All" is checked, uncheck all other checkboxes
            if (allCheckbox.checked) {
                sportsCheckboxes.forEach(cb => cb.checked = false);
            }
            // Trigger filter
            filterProducts();
        }

        function toggleAllBrands(allCheckbox) {
            const brandCheckboxes = document.querySelectorAll('.brand-checkbox');

            // If "All" is checked, uncheck all other checkboxes
            if (allCheckbox.checked) {
                brandCheckboxes.forEach(cb => cb.checked = false);
            }
            // Trigger filter
            filterProducts();
        }

        function toggleAllPrices(allCheckbox) {
            const priceCheckboxes = document.querySelectorAll('.price-checkbox');

            // If "All" is checked, uncheck all other checkboxes
            if (allCheckbox.checked) {
                priceCheckboxes.forEach(cb => cb.checked = false);
            }
            // Trigger filter
            filterProducts();
        }
    </script>

    <script>
        function filterProducts() {
            const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.value);
            const selectedSports = Array.from(document.querySelectorAll('.sports-checkbox:checked')).map(cb => cb.value);
            const selectedBrands = Array.from(document.querySelectorAll('.brand-checkbox:checked')).map(cb => cb.value);
            const selectedPrices = Array.from(document.querySelectorAll('.price-checkbox:checked'));

            // Handle multiple selected price ranges and set minPrice/maxPrice boundaries
            let minPrice = null;
            let maxPrice = null;

            if (selectedPrices.length > 0) {
                selectedPrices.forEach(checkbox => {
                    const min = parseInt(checkbox.dataset.minPrice);
                    const max = checkbox.dataset.maxPrice === 'above' ? Infinity : parseInt(checkbox.dataset.maxPrice);

                    if (minPrice === null || min < minPrice) {
                        minPrice = min;
                    }

                    if (maxPrice === null || (max !== Infinity && max > maxPrice)) {
                        maxPrice = max;
                    }
                });
            }

            const searchTerm = document.getElementById('search-input')?.value.trim() || "";

            // Handle "All" option as default if no category, sports, or brand is selected
            const categories = selectedCategories.length > 0 ? selectedCategories : ["all"];
            const sports = selectedSports.length > 0 ? selectedSports : ["all"];
            const brands = selectedBrands.length > 0 ? selectedBrands : ["all"];
            const prices = selectedPrices.length > 0 ? selectedPrices.map(cb => cb.value) : ["all"];

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "filter_products.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById("product-grid").innerHTML = this.responseText;
                }
            };

            // Send data with minPrice and maxPrice included
            xhr.send(
                "categories=" + JSON.stringify(categories) +
                "&sports=" + JSON.stringify(sports) +
                "&brands=" + JSON.stringify(brands) +
                "&search=" + encodeURIComponent(searchTerm) +
                "&minPrice=" + encodeURIComponent(minPrice !== null ? minPrice : '') +
                "&maxPrice=" + encodeURIComponent(maxPrice !== null ? maxPrice : '')
            );
        }
    </script>

</body>

</html>