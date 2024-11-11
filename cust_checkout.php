<?php
session_start();
include('Connection.php');
$customer_id = $_SESSION['userid'];

// Fetch existing delivery addresses for the logged-in customer
$addressQuery = "SELECT MIN(deliveryaddress_id) AS deliveryaddress_id, name, house_num, location, city, pincode, district, phno
FROM deliveryaddress
WHERE customer_id = '$customer_id'
GROUP BY name, house_num, location, city, pincode, district, phno";
$addressResult = mysqli_query($conn, $addressQuery);

if (!$addressResult) {
  die("Error fetching addresses: " . mysqli_error($conn));
}
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
  <!-- Util CSS -->
  <link rel="stylesheet" href="mainstyle/css/util.css">
  <!-- font awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <style>
    .error {
      color: red;
    }
  </style>
  <style>
    .card-details {
      background-color: #f9f9f9;
      /* Light background color for the card details section */
      border-radius: 15px;
      /* Rounded corners for the entire section */
      padding: 20px;
      /* Space inside the box */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Light shadow for a 3D effect */
      max-width: 400px;
      /* Limit the width for better readability */
      margin: 0 auto;
      /* Center the box */
    }

    .card-details p {
      font-size: 18px;
      /* Font size for the paragraph */
      color: #333;
      /* Darker text color */
      margin-bottom: 15px;
      /* Space below the paragraph */
    }

    .card-details label {
      display: block;
      /* Each label on a new line */
      margin-bottom: 5px;
      /* Space below each label */
      font-weight: bold;
      /* Bold labels for emphasis */
    }

    .input-field {
      width: 100%;
      /* Full width of the input fields */
      padding: 10px;
      /* Space inside the input fields */
      border-radius: 10px;
      /* Rounded corners for input fields */
      border: 1px solid #ccc;
      /* Light gray border */
      margin-bottom: 15px;
      /* Space below each input field */
      box-sizing: border-box;
      /* Include padding and border in element's total width/height */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      /* Light shadow inside input fields */
      font-size: 16px;
      /* Input text size */
    }

    .order-detail {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .detail {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            <h2>checkout</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb part end-->

  <!--================Checkout Area =================-->
  <section class="checkout_area section_padding">
    <div class="container">
      <div class="row">
        <form class="row address-form" action="order_processing.php" method="post" novalidate="novalidate">
          <div class="col-lg-8">
            <div class="billing_details order-detail" id="billing-address">
              <h3>Existing Delivery/Billing Address</h3>
              <div class="detail m-b-10">
                <!-- Existing Address Options -->
                <?php if (mysqli_num_rows($addressResult) > 0) { ?>
                  <div class="list-group">
                    <?php foreach ($addressResult as $address) { ?>
                      <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                          <p><?php echo htmlspecialchars($address['name']) . ', ' . htmlspecialchars($address['house_num']) . ', ' . htmlspecialchars($address['location']) . ', ' . htmlspecialchars($address['city']) ?>, <?php echo htmlspecialchars($address['district']); ?> - <?php echo htmlspecialchars($address['pincode']) . ', Phone: ' . htmlspecialchars($address['phno']); ?></p>
                        </div>
                        <div>
                          <input type="radio" class="confirm-radio" name="address" value="<?php echo $address['deliveryaddress_id']; ?>">
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                <?php } else { ?>
                  <p>No addresses found. Please add a new address.</p>
                <?php } ?>
              </div>

              <div class="detail">
                <div class="col-md-12 m-t-5">
                  <h3>Billing Details</h3>
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name" required />
                  <span id="nameError" class="error"></span>
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="house_num" name="house_num" placeholder="House Number/Name" required />
                </div>
                <div class="col-md-12 form-group">
                  <input type="text" class="form-control" id="location" name="location" placeholder="Roadname/Area" required />
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="city" name="city" placeholder="Town/City" required />
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="district" name="district" placeholder="District" required />
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="phno" name="phno" placeholder="Phone Number" required />
                  <span id="phoneError" class="error"></span>
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" required />
                  <span id="pinError" class="error"></span>
                </div>
                <p id="fillContent" style="color: red; display: none;">Please fill out all required fields correctly.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="order-detail">
              <div class="order_box">
                <?php
                // Calculate total amount from the cart
                $cartItemsQuery = "SELECT SUM(p.price * cart.quantity) as totalAmount FROM cart 
                  JOIN single_product sp ON cart.single_product_id = sp.single_product_id 
                  JOIN product p ON sp.product_id = p.product_id 
                  WHERE cart.customer_id = '$customer_id'";
                $cartItemsResult = mysqli_query($conn, $cartItemsQuery);
                if (!$cartItemsResult) {
                  die("Error fetching cart items: " . mysqli_error($conn));
                }

                $row = mysqli_fetch_assoc($cartItemsResult);
                $totalAmount = $row['totalAmount'];
                ?>
                <h2>Order Summary</h2>
                <ul class="list list_2">
                  <li>
                    <a href="#">Amount
                      <span><?php echo '₹' . $totalAmount; ?></span>
                    </a>
                  </li>
                  <li>
                    <a href="#">Shipping
                      <span>Flat rate: ₹50.00</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">Total
                      <span><?php echo '₹' . $totalAmount + 50; ?></span>
                    </a>
                  </li>
                </ul>
                <div class="payment_item">
                  <div class="radion_btn">
                    <input type="radio" id="f-option5" name="payment_method" value="Cash on Delivery" />
                    <label for="f-option5">Cash on Delivery</label>
                    <div class="check"></div>
                  </div>
                </div>
                <div class="payment_item active">
                  <div class="radion_btn">
                    <input type="radio" id="f-option6" name="payment_method" value="UPI Payment" />
                    <label for="f-option6">UPI Payment </label>
                    <div class="check"></div>
                  </div>
                </div>
                <div class="payment_item">
                  <div class="radion_btn">
                    <input type="radio" id="f-option7" name="payment_method" value="Credit/Debit Card" />
                    <label for="f-option7">Credit/Debit Card</label>
                    <div class="check"></div>
                  </div>
                </div>
                <!-- Sections for payment details -->
                <div id="codpayment" style="display: none;">
                  <!-- Content for Cash on Delivery -->
                  <p>Cash on Delivery selected. Please keep the amount ready.</p>
                </div>

                <div id="upiPayment" style="display: none;">
                  <!-- Content for UPI Payment -->
                  <p>Scan the QR code to pay via UPI:</p>
                  <?php $amountqr = "₹" . number_format($totalAmount, 2);
                  $qrcodeURL = "https://api.qrserver.com/v1/create-qr-code/?size=150X150&data=" . urlencode($amountqr); ?>
                  <img src="<?php echo $qrcodeURL; ?>" alt="UPI QR Code" />
                </div>

                <div id="cardpaymentsection" style="display: none;">
                  <!-- Content for Card Payment -->
                  <div class="card-details">
                    <p>Enter your card details:</p>
                    <label for="cardNumber">Card Number:</label>
                    <input type="text" id="cardNumber" name="cardNumber" class="input-field" />
                    <label for="expiryDate">Expiry Date:</label>
                    <input type="text" id="expiryDate" name="expiryDate" class="input-field" />
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" class="input-field" />
                  </div>
                </div>
                <div class="creat_account">
                  <input type="checkbox" id="f-option4" name="selector" />
                  <label for="f-option4">I’ve read and accept the </label>
                  <a href="#">terms & conditions*</a>
                </div>
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button type="submit" name="submit" class="btn_3 col-md-12 " id="proceedButton">Place Order</button>
                <p id="warningMessage" style="color: red; display: none;">Please accept the terms and conditions to proceed.</p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!--================End Checkout Area =================-->

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
  <script src="mainstyle/js/address_validation.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const codRadio = document.getElementById('f-option5');
      const upiRadio = document.getElementById('f-option6');
      const cardRadio = document.getElementById('f-option7');

      const codSection = document.getElementById('codpayment');
      const upiSection = document.getElementById('upiPayment');
      const cardSection = document.getElementById('cardpaymentsection');

      codRadio.addEventListener('change', function() {
        if (this.checked) {
          codSection.style.display = 'block';
          upiSection.style.display = 'none';
          cardSection.style.display = 'none';
        }
      });

      upiRadio.addEventListener('change', function() {
        if (this.checked) {
          upiSection.style.display = 'block';
          codSection.style.display = 'none';
          cardSection.style.display = 'none';
        }
      });

      cardRadio.addEventListener('change', function() {
        if (this.checked) {
          cardSection.style.display = 'block';
          codSection.style.display = 'none';
          upiSection.style.display = 'none';
        }
      });

      const checkbox = document.getElementById('f-option4');
      const proceedButton = document.getElementById('proceedButton');
      const warningMessage = document.getElementById('warningMessage');
      const orderForm = document.getElementById('orderForm');

      proceedButton.addEventListener('click', function(event) {
        if (!checkbox.checked) {
          event.preventDefault(); // Prevent form submission
          warningMessage.style.display = 'block'; // Show warning message
        } else {
          warningMessage.style.display = 'none'; // Hide warning message
          // Form will submit naturally, PHP will handle order processing
        }
      });
    });
  </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const differentAddressRadio = document.getElementById('different_address');
      const billingAddressDiv = document.getElementById('billing-address');
      const form = document.querySelector('form');
      const requiredFields = billingAddressDiv.querySelectorAll('[required]');

      // Hide the billing address by default
      if (!differentAddressRadio.checked) {
        billingAddressDiv.style.display = 'none';
      }

      // Show billing address fields only if "Ship to a different address" is selected
      differentAddressRadio.addEventListener('change', function() {
        if (this.checked) {
          billingAddressDiv.style.display = 'block';
          // Add required attributes back when visible
          requiredFields.forEach(field => field.setAttribute('required', ''));
        }
      });

      form.addEventListener('submit', function(event) {
        if (!differentAddressRadio.checked) {
          // Hide the billing address and remove required attributes if not selected
          billingAddressDiv.style.display = 'none';
          requiredFields.forEach(field => field.removeAttribute('required'));
        }
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get all radio buttons for existing addresses
      const addressRadios = document.querySelectorAll('input[name="address"]');

      addressRadios.forEach(radio => {
        radio.addEventListener('change', function() {
          if (this.checked) {
            // Get the ID of the selected address
            const selectedAddressId = this.value;

            // Make an AJAX request to get the address details
            fetch('get_address_details.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                  'address_id': selectedAddressId
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.error) {
                  alert(data.error);
                } else {
                  // Populate the fields with the selected address details
                  document.getElementById('name').value = data.name || '';
                  document.getElementById('house_num').value = data.house_num || '';
                  document.getElementById('location').value = data.location || '';
                  document.getElementById('district').value = data.district || '';
                  document.getElementById('city').value = data.city || '';
                  document.getElementById('pincode').value = data.pincode || '';
                  document.getElementById('phno').value = data.phno || '';
                }
              })
              .catch(error => console.error('Error:', error));
          }
        });
      });
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get form fields and error elements
      const nameField = document.getElementById("name");
      const addressField = document.getElementById("address");
      const locationField = document.getElementById("location");
      const cityField = document.getElementById("city");
      const districtField = document.getElementById("district");
      const phoneField = document.getElementById("phno");
      const pincodeField = document.getElementById("pincode");

      const nameError = document.getElementById("nameError");
      const phoneError = document.getElementById("phoneError");
      const pinError = document.getElementById("pinError");
      const validateMessage = document.getElementById('fillContent');

      // Validate each field
      function validateField() {
        let valid = true;

        // Check if name is filled
        const namePattern = /^[a-zA-Z-' ]*$/;
        if (!namePattern.test(nameField.value.trim())) {
          nameError.innerText = "Only letters and white space allowed";
          valid = false;
        } else {
          nameError.innerText = "";
        }

        // Validate phone number
        const phonePattern = /^\d{10}$/;
        if (!phonePattern.test(phoneField.value.trim())) {
          phoneError.innerText = "Phone number must be 10 digits";
          valid = false;
        } else {
          phoneError.innerText = "";
        }

        // Validate pincode
        const pinPattern = /^\d{6}$/;
        if (!pinPattern.test(pincodeField.value.trim())) {
          pinError.innerText = "Pincode must be 6 digits";
          valid = false;
        } else {
          pinError.innerText = "";
        }

        // Check if other required fields are filled
        const requiredFields = [addressField, locationField, cityField, districtField];
        requiredFields.forEach(field => {
          if (field.value.trim() === "") {
            valid = false;
          } else if (field.nextElementSibling) {
            field.nextElementSibling.innerText = "";
          }
        });

        return valid;
      }

      // Attach validation to the "Proceed" button
      const proceedButton = document.getElementById('proceedButton');
      proceedButton.addEventListener('click', function(event) {
        if (!validateField()) {
          event.preventDefault(); // Prevent form submission
          validateMessage.style.display = 'block'; // Show warning message
          validateMessage.innerText = 'Please fill out all required fields correctly.';
        } else {
          validateMessage.style.display = 'none'; // Hide warning message
        }
      });
    });
  </script>
</body>

</html>