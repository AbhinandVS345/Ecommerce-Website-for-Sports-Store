<?php
// Clear all session variables
$_SESSION = array();
include('Connection.php');
?>

<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Track Sports</title>
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
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <?php include('html/main_header.php'); ?>
    </header>
    <!-- Header part end-->


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


    <!--::footer_part start::-->
    <?php include('html/main_footer.html'); ?>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
    <script src="mainstyle/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="mainstyle/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="mainstyle/js/bootstrap.min.js"></script>
    <!-- magnific popup js -->
    <script src="mainstyle/js/jquery.magnific-popup.js"></script>
    <!-- carousel js -->
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
                    url: 'index_search_products.php', // Backend script that handles product fetching by search
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