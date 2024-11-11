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
    <?php
    if (isset($_SESSION['userid'])) {
        // User is logged in, include the logged-in header
        include("html/cust_header.php");
    } else {
        // User is not logged in, include the default header
        include("html/main_header.php");
    }
    ?>
    <!-- Header part end-->

    <section class="breadcrumb_part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <h2>About Us</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb part end-->

    <!-- about section start -->
    <section class="about_us padding_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="about_us_content">
                        <h5>Our Mission</h5>
                        <h3>Empowering Athletes Everywhere</h3>
                        <p>At Track Sports, our mission is to provide top-quality sports gear and accessories that enhance performance, inspire confidence, and promote a healthy lifestyle. We aim to support athletes of all levels by offering products that match their ambitions, whether for leisure, fitness, or competitive sports.</p>
                        <div class="about_us_video">
                            <img src="mainstyle/img/sportsimg.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about section end -->

    <!-- feature part start -->
    <section class="feature_part section_padding">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="feature_part_tittle">
                        <h3>Why Choose Us?</h3>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="feature_part_content">
                        <p>We bring you a curated selection of the best brands and innovative products to support your athletic journey, with features that make shopping convenient and rewarding.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_feature_part">
                        <img src="mainstyle/img/icon/feature_icon_1.svg" alt="Credit Card Support">
                        <h4>Secure Payment Options</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_feature_part">
                        <img src="mainstyle/img/icon/feature_icon_2.svg" alt="Online Order">
                        <h4>Easy Online Shopping</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_feature_part">
                        <img src="mainstyle/img/icon/feature_icon_3.svg" alt="Free Delivery">
                        <h4>Fast & Free Delivery</h4>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-sm-6">
                    <div class="single_feature_part">
                        <img src="mainstyle/img/icon/feature_icon_4.svg" alt="Product with Gift">
                        <h4>Exciting Offers & Gifts</h4>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!-- feature part end -->

    <!-- client review part start -->
    <section class="client_review">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="client_review_slider owl-carousel">
                        <div class="single_client_review">
                            <div class="client_img">
                                <img src="mainstyle/img/client.png" alt="Client Review">
                            </div>
                            <p>"Shopping with Track Sports has transformed my training. Their gear is top-notch, and the support is always reliable."</p>
                            <h5>- John Doe</h5>
                        </div>
                        <div class="single_client_review">
                            <div class="client_img">
                                <img src="mainstyle/img/client_1.png" alt="Client Review">
                            </div>
                            <p>"Quick delivery and great quality products. I found everything I needed in one place!"</p>
                            <h5>- Jane Smith</h5>
                        </div>
                        <div class="single_client_review">
                            <div class="client_img">
                                <img src="mainstyle/img/client_2.png" alt="Client Review">
                            </div>
                            <p>"Their products are amazing, and I love the discounts they offer. Highly recommended!"</p>
                            <h5>- Alex Johnson</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- client review part end -->


    <!--::footer_part start::-->
    <?php
    if (isset($_SESSION['userid'])) {
        include("html/cust_footer.html");
    } else {
        include("html/main_footer.html");
    }
    ?>
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

</body>

</html>