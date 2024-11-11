<?php
include('Connection.php');
if (isset($_GET['ordermaster_id'])) {
    $ordermaster_id = $_GET['ordermaster_id'];
}

$sql = "SELECT d.* FROM ordermaster om 
            JOIN deliveryaddress d ON om.deliveryaddress_id=d.deliveryaddress_id
            WHERE ordermaster_id=$ordermaster_id";
$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_array($result);

?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="adminstyle/css/util.css">
    <link rel="stylesheet" href="adminstyle/css/tailwind.output.css" />
    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
        defer></script>
    <script src="adminstyle/js/init-alpine.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <style>
        .order {
            color: rgb(103, 116, 142);
        }

        .detail {
            color: rgb(52, 71, 103);
        }
    </style>
</head>

<body>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Order Details
    </h2>
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Billing Details -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-2xl text-gray-800 dark:text-gray-300">
                Billing Details
            </h4>
            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">Name:</span>
                    <span class="detail"><?php echo $order['name']; ?></span>
                </div>
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">House No:</span>
                    <span class="detail"><?php echo $order['house_num']; ?></span>
                </div>
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">Location:</span>
                    <span class="detail"><?php echo $order['location']; ?></span>
                </div>
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">City:</span>
                    <span class="detail"><?php echo $order['city']; ?></span>
                </div>
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">Pincode:</span>
                    <span class="detail"><?php echo $order['pincode']; ?></span>
                </div>
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">District:</span>
                    <span class="detail"><?php echo $order['district']; ?></span>
                </div>
                <div class="order p-b-5 text-lg text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">Phone No:</span>
                    <span class="detail"><?php echo $order['phno']; ?></span>
                </div>
            </div>
        </div>
        <!-- Products -->
        <div
            class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-2xl text-gray-800 dark:text-gray-300">
                Products
            </h4>
            <div class="mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <ul>
                    <?php
                    $sql = "SELECT od.*, p.* FROM orderdetails od 
                    JOIN single_product sp ON od.single_product_id=sp.single_product_id 
                    JOIN product p ON sp.product_id=p.product_id 
                    WHERE ordermaster_id=$ordermaster_id";


                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $cartsubtotal = 0;
                        $count = 0;
                        while ($product = mysqli_fetch_array($result)) {
                            $total = $product['price'] * $product['quantity'];
                            $cartsubtotal += $total;
                            $count++;
                    ?>
                            <li>
                                <ul>
                                    <li>
                                        <div style="display: flex; align-items: center;">
                                            <span class="text-gray-800 dark:text-gray-300" style="margin-right: 20px;"><?php echo $count; ?></span>
                                            <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 80px; height: 80px; object-fit: cover; margin-right: 20px;">
                                            <div style="flex-grow: 1;">
                                                <span class="text-gray-800 dark:text-gray-300" style="display: block; font-weight: bold;"><?php echo $product['name']; ?></span>
                                                <span class="text-gray-800 dark:text-gray-300"><?php echo $product['quantity']; ?> x ₹<?php echo number_format($product['price'], 2); ?></span>
                                            </div>
                                            <span class="text-gray-800 dark:text-gray-300" style="margin-left: 50px;"><?php echo '₹' . number_format($total, 2); ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                    <?php
                        }
                    }
                    ?>
                    <li><span class="text-gray-800 dark:text-gray-300">Subtotal</span> <span class="text-gray-800 dark:text-gray-300"><?php echo '₹' . number_format($cartsubtotal, 2); ?></span></li>
                    <li><span class="text-gray-800 dark:text-gray-300">Shipping</span> <span class="text-gray-800 dark:text-gray-300">₹50.00</span></li>
                    <li><span class="text-gray-800 dark:text-gray-300">Order Total</span> <span class="text-gray-800 dark:text-gray-300"><?php echo '₹' . number_format(($cartsubtotal + 50), 2); ?></span></li>
                </ul>
            </div>
            <!-- Payment Method -->
            <div class="col-md-12">
                <div class="cart-detail p-2">
                    <h3 class="mb-4 text-gray-800 dark:text-gray-300">Payment Method</h3>
                    <?php
                    $sql = "SELECT * FROM payment WHERE ordermaster_id = $ordermaster_id";
                    $result = mysqli_query($conn, $sql);
                    $payment = mysqli_fetch_array($result);
                    ?>
                    <div class="form-group p-1">
                        <div class="col-md-12">
                            <div class="radio">
                                <label class="mb-4 text-gray-800 dark:text-gray-300">
                                    <?php echo $payment['payment_method']; ?> :
                                    <span id="payment-status-display" style="color: green;"><?php echo $payment['payment_status']; ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign to Staff and Update Status -->
            <div class="col-md-12 text-center">
                <form id="orderForm">
                    <input type="hidden" name="order_master_id" value="<?php echo $ordermaster_id; ?>">
                    <div class="form-group statusdiv">

                        <?php
                        $sql = "SELECT status FROM ordermaster WHERE ordermaster_id = '$ordermaster_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        $order_status = $row['status'];
                        if ($order_status != 'Delivered' && $order_status != 'Cancelled') { ?>
                            <label for="order-status-select" class="mb-4 text-gray-800 dark:text-gray-300">Order Status:</label>
                            <select class="w-half mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                name="order_status" id="order-status-select">
                                <option value="" selected disabled>Select Status</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                            <button type="submit"
                                class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                                name="update_status" value="Update Status" style="margin-top: 20px;">
                                Update Status
                            </button>
                        <?php } else { ?>
                            <p>Order Status: <strong><?php echo ucfirst($order_status); ?></strong></p>
                            <input type="hidden" name="order_status" value="<?php echo htmlspecialchars($order_status); ?>">
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('.statusdiv').html('<p>Order Status: <strong>' + response.updated_status.charAt(0).toUpperCase() + response.updated_status.slice(1) + '</strong></p>');
                            $('#payment-status-display').text('Completed');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the status.');
                    }
                });
            });
        });
    </script>

</body>

</html>