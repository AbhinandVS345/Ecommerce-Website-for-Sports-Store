<?php
session_start();
include('Connection.php');
$customer_id = $_SESSION['userid'];
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
</head>

<body>

    <?php include("html/cust_header.php"); ?>

    <!-- breadcrumb part start-->
    <section class="breadcrumb_part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <h2>orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb part end-->

    <!--================Cart Area =================-->
    <section class="cart_area section_padding">
        <div class="container">
            <div class="cart_inner">
                <?php $sql = "SELECT * FROM ordermaster om 
                            JOIN customer c ON om.customer_id=c.customer_id WHERE om.customer_id=$customer_id ORDER BY om.ordermaster_id DESC";
                $result = mysqli_query($conn, $sql);
                $count = 0;
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sl.No.</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $count += 1;
                            ?>
                                <tr>
                                    <td><?php echo $count ?> </td>
                                    <td><?php echo $row['ordermaster_id']; ?> </td>
                                    <td><?php echo '₹' . number_format($row['totalamount'], 2); ?> </td>
                                    <td><?php echo $row['order_date']; ?> </td>
                                    <td><?php echo $row['status']; ?> </td>
                                    <td><a class="genric-btn primary circle" href="cust_orderdetails.php?ordermaster_id=<?php echo $row['ordermaster_id']; ?>">View more</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <div class="col-md-12 text-center">
                        <h3>No orders were placed yet.</h3>
                        <a href="cust_viewproduct.php" class="btn_3">
                            Continue Shopping
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->


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