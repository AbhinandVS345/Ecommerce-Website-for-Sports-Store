<?php
session_start();
include('Connection.php');
$customer_id = $_SESSION['userid'];
$customerName = $_SESSION['CustomerName'];
$email = $_SESSION['email'];
if (isset($_GET['ordermaster_id'])) {
    $ordermaster_id = $_GET['ordermaster_id'];
    $_SESSION['master_id'] = $ordermaster_id;

    $sql = "SELECT om.*, d.*, p.* FROM ordermaster om  
    JOIN deliveryaddress d ON om.deliveryaddress_id = d.deliveryaddress_id 
    JOIN payment p ON om.ordermaster_id = p.ordermaster_id 
    WHERE om.ordermaster_id = $ordermaster_id";
    $order = mysqli_fetch_array(mysqli_query($conn, $sql));
}

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

    <style>
        .order-detail {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-detail h2 {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        #cod-mail {
            display: none;
        }

        #return-mail {
            display: none;
        }
    </style>
</head>

<body>

    <?php include("html/cust_header.php"); ?>

    <!-- breadcrumb part start-->
    <section class="breadcrumb_part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <h2>order details</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb part end-->

    <!--================Order Area =================-->
    <section class="cart_area section_padding">
        <div class="container">
            <div class="row">
                <!-- Products and Payment Section -->
                <div class="col-lg-12">
                    <!-- Products -->
                    <div class="order-detail mb-5">
                        <h2 class="mb-4">Products</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Sl.No.</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT om.*, od.*, sp.*, p.*  FROM ordermaster om
                                JOIN orderdetails od ON om.ordermaster_id = od.ordermaster_id 
                                JOIN single_product sp ON od.single_product_id = sp.single_product_id 
                                JOIN product p ON sp.product_id = p.product_id 
                                WHERE om.ordermaster_id = $ordermaster_id";
                                $result = mysqli_query($conn, $sql);
                                $count = 0;
                                $subtotal = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $count += 1;
                                    $subtotal += $row['total_price'];
                                ?>
                                    <tr>
                                        <td><?php echo $count ?> </td>
                                        <td><img style="width:100px;" src="./uploads/<?php echo $row['image']; ?>" alt="" /> </td>
                                        <td><?php echo $row['name']; ?> </td>
                                        <td><?php echo '₹' . number_format($row['price'], 2); ?> </td>
                                        <td><?php echo $row['quantity']; ?> </td>
                                        <td><?php echo '₹' . number_format($row['total_price'], 2); ?> </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                    <td><?php echo '₹' . number_format($subtotal, 2); ?> </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Shipping:</strong></td>
                                    <td>₹50.00</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Order Total:</strong></td>
                                    <td><?php echo '₹' . number_format(($subtotal + 50), 2); ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Shipping and Payment -->
                    <div class="order-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="payment-address">
                                    <h2 class="mb-4">Shipping Address</h2>
                                    <p>
                                        <strong>Name: </strong> <?php echo $order['name']; ?><br>
                                        <strong>House: </strong> <?php echo $order['house_num']; ?><br>
                                        <strong>Location: </strong> <?php echo $order['location']; ?><br>
                                        <strong>City: </strong> <?php echo $order['city']; ?><br>
                                        <strong>District: </strong> <?php echo $order['district']; ?><br>
                                        <strong>Pincode: </strong> <?php echo $order['pincode']; ?><br>
                                        <strong>Contact No. :</strong> <?php echo $order['phno']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-address">
                                    <h2 class="mb-4">Payment Method</h2>
                                    <p>
                                        <strong>Payment Method:</strong> <?php echo $order['payment_method']; ?><br>
                                        <strong>Status:</strong> <?php echo $order['payment_status']; ?><br>
                                    </p>
                                    <!-- PDF Icon for generating invoice -->
                                    <div class="d-flex align-items-center mb-4">
                                        <h5 class="mb-0 mr-3">Download Invoice</h5>
                                        <a href="order_invoice.php" class="btn" title="Download Invoice">
                                            <i class="fas fa-file-pdf" style="color: red; font-size: 24px;"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <h5 class="mb-0 mr-3">Order Status:</h5>
                                        <strong id="shipping-status"><?php echo $order['status']; ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($order['status'] !== 'Delivered' && $order['status'] !== 'Cancelled'): ?>
                    <!-- <form action="" method="post" class="d-inline text-center mt-4"> -->
                    <!-- <input type="hidden" name="order_id" value="<?php echo $order['ordermaster_id']; ?>"> -->
                    <div class="d-inline text-center mt-4">
                        <button id="cancel-order-btn" onclick="cancelOrder(<?php echo $order['ordermaster_id']; ?>)" class="btn btn-danger">
                            Cancel Order
                        </button>

                    </div>
                    <!-- </form> -->
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--================End Order Area =================-->

    <!-- =====Email===== -->


    <!-- =====End Email -->


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

    <!-- Cancel Order -->
    <script>
        function cancelOrder(ordermasterId) {
            $.ajax({
                url: 'cancel_order.php',
                type: 'POST',
                data: {
                    ordermaster_id: ordermasterId
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        document.getElementById("shipping-status").textContent = response.message;
                        document.getElementById("cancel-order-btn").style.display = "none";

                        var payment_method = response.payment_method;
                        var emailData = {
                            ordermaster_id: ordermasterId,
                            payment_method: payment_method
                        };

                        if (payment_method == "Cash on Delivery" || payment_method == "UPI Payment" || payment_method == "Credit/Debit Card") {
                            $.ajax({
                                url: 'send_email.php',
                                type: 'POST',
                                data: emailData,
                                success: function(emailResponse) {
                                    emailResponse = JSON.parse(emailResponse);
                                    if (!emailResponse.success) {
                                        console.error("Email Error:", emailResponse.error);
                                    }
                                }
                            });
                        }
                    } else {
                        alert('Order cancellation failed!');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred:", status, error);
                }
            });
        }
    </script>

</body>

</html>