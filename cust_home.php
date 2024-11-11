<?php
include('Connection.php');
session_start();
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
    <!-- Slider CSS -->
    <link rel="stylesheet" href="mainstyle/css/slider.css">
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

    <?php include('html/cust_header.php'); ?>

    <!-- Slider Start -->
    <div class="slider-container" id="slider">
        <div class="slider-wrapper">
            <div class="slide">
                <section class="banner_part">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Gear Up for Victory</h1>
                                        <p>Equip yourself with the latest sports gear to elevate your game. From high-performance apparel to top-quality equipment, we've got everything you need to succeed.</p>
                                        <a href="cust_viewproduct.php" class="btn_1">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="banner_img">
                        <img src="mainstyle/img/slide1.png" alt="#" class="img-fluid">
                    </div>
                </section>
            </div>
            <div class="slide">
                <section class="banner_part">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Unleash Your Potential</h1>
                                        <p>Find the perfect gear to boost your performance. Whether you’re training or competing, we have what it takes to help you reach new heights.</p>
                                        <a href="cust_viewproduct.php" class="btn_1">Explore Collection</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="banner_img">
                        <img src="mainstyle/img/slide2.png" alt="#" class="img-fluid">
                    </div>
                </section>
            </div>
            <div class="slide">
                <section class="banner_part">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>Play Hard, Play Smart</h1>
                                        <p>Discover sports essentials designed for champions. Find quality products that keep you at the top of your game.</p>
                                        <a href="cust_viewproduct.php" class="btn_1">Shop the Gear</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="banner_img">
                        <img src="mainstyle/img/slide3.png" alt="#" class="img-fluid">
                    </div>
                </section>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <a class="prev" onclick="moveSlide(-1)">&#10094;</a>
        <a class="next" onclick="moveSlide(1)">&#10095;</a>
    </div>
    <!-- Slider End -->


    <!-- trending item start-->
    <section class="trending_items section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        <h2>Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product_list products">
                        <div class="row">
                            <?php
                            $sql = "SELECT * FROM product";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <div class="col-lg-3 col-sm-6 col-md-4 p-b-35">
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
                        <div class="load_more_btn text-center">
                            <a href="cust_viewproduct.php" class="btn_3">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- trending item end-->


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


    <?php include('html/cust_footer.html'); ?>

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
    <!-- slider js -->
    <script src="mainstyle/js/slider.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


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
                        handleCartResponse(response);
                        updateCartCount();
                    },
                    error: function(xhr, status, error) {
                        showErrorToast();
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
                        handleCartResponse(response);
                        updateCartCount();
                    },
                    error: function(xhr, status, error) {
                        showErrorToast();
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

            // Helper function to show error toast
            function showErrorToast() {
                Toastify({
                    text: "An error occurred. Please try again later.",
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


    <script>
        $(document).ready(function() {
            // Initially show the slider
            document.getElementById("slider").style.display = "block";

            // Click event for the search icon
            $('#search_1').on('click', function() {
                $('#slider').hide(); // Hide the slider by setting display to none
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
                    url: 'cust_home_search.php', // Backend script that handles product fetching by search
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

</body>

</html>