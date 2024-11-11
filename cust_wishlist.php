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
                        <h2>Wishlist</h2>
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
                <div class="col-md-12">
                    <div class="product_list">
                        <div class="row">
                            <?php
                            $cust_id = $_SESSION['userid'];
                            $sql = "SELECT w.*, p.* FROM wishlist w 
                            JOIN product p ON w.product_id = p.product_id 
                            WHERE w.customer_id = '$cust_id'";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any products in the wishlist
                            if (mysqli_num_rows($result) > 0) {
                                // Display products in the wishlist
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <div class="col-lg-3 col-sm-6 col-md-4 p-b-35">
                                        <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>">
                                            <?php $product_id = $row['product_id']; ?>
                                            <div class="single_product_item product-entry">
                                                <div class="single_product_item_thumb">
                                                    <img src="./uploads/<?php echo $row['image']; ?>" alt="#" class="img-fluid">
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="txt-overflow"><?php echo $row['name']; ?></h4>
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
                                                    <a href="#" style="font-size: 20px;" class="like_us wishlist-btn <?php echo $color_class; ?>" data-product-id="<?php echo $product_id; ?>"> <i class="fa-solid fa-heart"></i> </a>
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
                                <?php
                                }
                            } else {
                                // No products in wishlist
                                ?>
                                <div class="col-md-12 text-center">
                                    <h3>No products were added to wishlist.</h3>
                                    <a href="cust_viewproduct.php" class="btn_3">
                                        Click here to save
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
                        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 10px; right: 10px;"></button>
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
                        handleCartResponse(response);
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

    <!-- Wishlist -->
    <script>
        $(document).ready(function() {
            $('.wishlist-btn').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var productId = button.data('product-id');
                var productCard = button.closest('.product-entry'); // The product card to remove

                $.ajax({
                    url: 'wishlist.php', // This PHP script handles adding/removing items in wishlist
                    type: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        console.log("Raw response:", response); // Log the raw response for debugging

                        if (typeof response === 'string') {
                            try {
                                response = JSON.parse(response); // Ensure the response is parsed as JSON
                            } catch (e) {
                                console.log("Failed to parse JSON:", e);
                                return;
                            }
                        }

                        // Check if the response indicates success
                        if (response.status === 'success') {
                            // Remove the product card from the DOM
                            productCard.fadeOut(400, function() {
                                $(this).remove();

                                // Check if there are no remaining wishlist items
                                if ($('.product-entry').length === 0) {
                                    $('#empty-wishlist-message').show(); // Show "empty wishlist" message
                                }
                            });
                            var wishlistCount = parseInt(response.wishlistCount, 10);
                            if (wishlistCount > 0) {
                                $('#wishlist-count').text(wishlistCount).show(); // Update and show cart count element
                            } else {
                                $('#wishlist-count').hide(); // Hide if no items
                            }
                            // Show a success toast
                            toastr.success('Item removed from wishlist!', 'Success');
                        } else {
                            // Show an error toast if something went wrong
                            toastr.error('Failed to remove item from wishlist.', 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error); // Log any error for debugging
                        toastr.error('An error occurred. Please try again.', 'Error');
                    }
                });
            });

            // Check if wishlist is already empty when page loads
            if ($('.product-entry').length === 0) {
                $('#empty-wishlist-message').show(); // Show "empty wishlist" message if no items
            }
        });
    </script>

</body>

</html>