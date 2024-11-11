<?php
include('Connection.php');
session_start();
$ordermaster_id = $_SESSION['master_id'];

$sql = "SELECT om.*, d.*, p.* FROM ordermaster om  
    JOIN deliveryaddress d ON om.deliveryaddress_id = d.deliveryaddress_id 
    JOIN payment p ON om.ordermaster_id = p.ordermaster_id 
    WHERE om.ordermaster_id = $ordermaster_id";
$order = mysqli_fetch_array(mysqli_query($conn, $sql));
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
    <!-- Util CSS -->
    <link rel="stylesheet" href="mainstyle/css/util.css">
    <style>
        .order-success-section {
            padding: 20px 0;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            /* Green color */
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .download-link {
            color: #007bff;
            text-decoration: none;
            font-size: 18px;
        }

        .download-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php include("html/cust_header.php"); ?>

    <!--================Checkout Area =================-->
    <section class="order-success-section">
        <div class="container text-center">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Order Placed Successfully</h1>
            <h4>Download invoice?<a href="order_invoice.php" class="download-link">Click here</a></h4>
            <p><a href="cust_home.php" class="download-link">Home</a></p>
        </div>
    </section>

    <!--================End Checkout Area =================-->

    <!--================ confirmation part start =================-->
    <section class="confirmation_part section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="confirmation_tittle">
                        <h3>Thank you. Your order details.</h3>
                    </div>
                </div>
                <div class="col-lg-6 col-lx-4">
                    <div class="single_confirmation_details">
                        <h4>order info</h4>
                        <ul>
                            <li>
                                <p>order number</p><span>: <?php echo $ordermaster_id; ?></span>
                            </li>
                            <li>
                                <p>date</p><span>: <?php echo $order['order_date']; ?></span>
                            </li>
                            <li>
                                <p>total</p><span>: ₹ <?php echo $order['totalamount']; ?></span>
                            </li>
                            <li>
                                <p>payment methord</p><span>: <?php echo $order['payment_method']; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-lx-4">
                    <div class="single_confirmation_details">
                        <h4>Billing Address</h4>
                        <ul>
                            <li>
                                <p>Name</p><span>: <?php echo $order['name']; ?></span>
                            </li>
                            <li>
                                <p>House</p><span>: <?php echo $order['house_num']; ?></span>
                            </li>
                            <li>
                                <p>Location</p><span>: <?php echo $order['location']; ?></span>
                            </li>
                            <li>
                                <p>City</p><span>: <?php echo $order['city']; ?></span>
                            </li>
                            <li>
                                <p>District</p><span>: <?php echo $order['district']; ?></span>
                            </li>
                            <li>
                                <p>Pincode</p><span>: <?php echo $order['pincode']; ?></span>
                            </li>
                            <li>
                                <p>Contact No.</p><span>: <?php echo $order['phno']; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="order_details_iner">
                        <h3>Order Details</h3>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $detail = "SELECT om.*, od.*, sp.*, p.*  FROM ordermaster om
                                JOIN orderdetails od ON om.ordermaster_id = od.ordermaster_id 
                                JOIN single_product sp ON od.single_product_id = sp.single_product_id 
                                JOIN product p ON sp.product_id = p.product_id 
                                WHERE om.ordermaster_id = $ordermaster_id";
                                $result = mysqli_query($conn, $detail);
                                $subtotal = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $subtotal += $row['total_price'];
                                ?>
                                    <tr>
                                        <th colspan="2"><span><?php echo $row['name']; ?></span></th>
                                        <th>X<?php echo $row['quantity']; ?></th>
                                        <th> <span><?php echo '₹' . number_format($row['total_price'], 2); ?></span></th>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="3">Subtotal</th>
                                    <th> <span><?php echo '₹' . number_format($subtotal, 2); ?> </span></th>
                                </tr>
                                <tr>
                                    <th colspan="3">shipping</th>
                                    <th><span>flat rate: ₹ 50.00</span></th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" colspan="3">Grand Total</th>
                                    <th scope="col"> <span><?php echo '₹' . number_format($subtotal + 50, 2); ?> </span></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ confirmation part end =================-->


    <?php include('html/cust_footer.html'); ?>

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
</body>

</html>