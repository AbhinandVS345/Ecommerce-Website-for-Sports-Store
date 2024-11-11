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
  <link rel="icon" href="mainstyle/img/track.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="mainstyle/css/bootstrap.min.css">
  <!-- animate CSS -->
  <link rel="stylesheet" href="mainstyle/css/animate.css">
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="mainstyle/css/owl.carousel.min.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="mainstyle/css/all.css">
  <!-- icon CSS -->
  <link rel="stylesheet" href="mainstyle/css/flaticon.css">
  <link rel="stylesheet" href="mainstyle/css/themify-icons.css">
  <!-- magnific popup CSS -->
  <link rel="stylesheet" href="mainstyle/css/magnific-popup.css">
  <link rel="stylesheet" href="mainstyle/css/nice-select.css">
  <!-- style CSS -->
  <link rel="stylesheet" href="mainstyle/css/style.css">
  <link rel="stylesheet" href="mainstyle/css/util.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</head>

<body>

  <?php include('html/cust_header.php'); ?>

  <!-- breadcrumb part start-->
  <section class="breadcrumb_part">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb_iner">
            <h2>cart list</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb part end-->

  <!--================Cart Area =================-->
  <section class="cart_area section_padding mb-5">
    <div class="container">
      <div class="cart_inner">
        <?php
        $sql = "SELECT c.*, sp.*, p.*, s.size as size, cust.customer_id  FROM cart c 
        JOIN single_product sp ON c.single_product_id = sp.single_product_id 
        JOIN product p ON sp.product_id = p.product_id 
        JOIN size s ON sp.size_id = s.size_id 
        JOIN customer cust ON c.customer_id = cust.customer_id 
        WHERE cust.customer_id = '$customer_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        ?>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">Image</th>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
                <th scope="col" style="width: 150px;">Remove</th>
              </tr>
            </thead>
            <tbody id="cartItems">
              <?php

              $subtotal = 0;
              while ($product = mysqli_fetch_array($result)) {
                $total_price = $product['price'] * $product['quantity'];
                $subtotal += $total_price;
                $product_id = $product['product_id'];

                $sql2 = "SELECT sp.stock as stock, sp.single_product_id as single_id, s.size as size FROM single_product sp
                  JOIN product p ON sp.product_id = p.product_id 
                  JOIN size s ON sp.size_id = s.size_id 
                  WHERE p.product_id = '$product_id'";
                $single_result = mysqli_query($conn, $sql2);
                $single_product = mysqli_fetch_array($single_result);
                $size = $product['size'];
              ?>
                <tr id="cartItem_<?php echo $product['single_product_id']; ?>">
                  <td style="width: 150px; padding: 0;">
                    <!-- <div class="media">
                        <div class="d-flex"> -->
                    <a href="cust_singleproduct.php?id=<?php echo $product['product_id']; ?>">
                      <img style="width:150px;height:150px;" src="./uploads/<?php echo $product['image']; ?>" alt="" />
                    </a>
                  </td>
                  <!-- </div> -->
                  <!-- <div class="media-body"> -->
                  <td>
                    <h5><?php echo $product['name'];
                        if ($size != 'pp') {
                          echo ' (Size: ' . $size . ')';
                        }
                        ?></h5>
                    <!--    </div>
                    </div> -->
                  </td>
                  <td>
                    <h5><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo number_format($product['price'], 2); ?></h5>
                  </td>
                  <td>
                    <div class="product_count">
                      <span class="input-number-decrement"> <i class="ti-minus"></i></span>
                      <input class="input-number" type="text" value="<?php echo $product['quantity']; ?>" min="1" max="<?php echo $single_product['stock']; ?>" data-price="<?php echo $product['price']; ?>" data-id="<?php echo $product['cart_id']; ?>">
                      <span class="input-number-increment"> <i class="ti-plus"></i></span>
                    </div>
                  </td>
                  <td>
                    <h5><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo number_format($total_price, 2); ?></h5>
                  </td>
                  <td>
                    <button onclick="deleteCartItem(<?php echo $product['single_product_id']; ?>)" style="border:none; background-color:transparent;">
                      <i class="fa-regular fa-trash-can fa-lg" style="color: #575156;"></i>
                    </button>
                  </td>

                </tr>
              <?php } ?>
              <tr class="subtotal">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <h5>Subtotal</h5>
                </td>
                <td>
                  <h5 id="subtotal"><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo number_format($subtotal, 2); ?></h5>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="checkout_btn_inner float-right">
            <a class="btn_1 checkout_btn_1" href="cust_checkout.php">Proceed to checkout</a>
          </div>
        <?php
        } else {
        ?>
          <div class="col-md-12 text-center">
            <h3>No products were added to cart.</h3>
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

  <script>
    function deleteCartItem(singleProductId) {
      $.ajax({
        url: 'delete_from_cart.php', // Updated to handle deletion through AJAX
        type: 'POST',
        data: {
          single_product_id: singleProductId
        }, // Sending single_product_id to backend
        success: function(response) {
          response = JSON.parse(response); // Parse JSON response from server
          if (response.success) {
            $('#cartItem_' + singleProductId).remove(); // Remove item row from table
            document.getElementById("subtotal").innerHTML = `<i class="fa-solid fa-indian-rupee-sign"></i> ${Number(response.subtotal).toFixed(2)}`;
            updateCartCount();
            $_SESSION['status'] = response.message; // Show success message
          } else {
            alert('Product deletion from cart failed!'); // Show failure message
          }
        },
        error: function(xhr, status, error) {
          console.error("An error occurred:", status, error);
        }
      });
    }

    function updateCartCount() {
      $.ajax({
        url: 'get_cart_count.php', // Separate PHP file to get cart count
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            var cartCount = parseInt(response.cartCount, 10);
            if (cartCount > 0) {
              $('#cart-count').text(cartCount).show(); // Update and show cart count element
            } else {
              $('#cart-count').hide(); // Hide if no items
            }
          }
        },
        error: function(xhr, status, error) {
          console.log('Error fetching cart count:', error);
        }
      });
    }
  </script>


</body>

</html>