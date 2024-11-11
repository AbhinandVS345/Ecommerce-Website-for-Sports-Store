<?php
session_start();
include("connection.php");


if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Verify the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            if ($row["usertype"] == "admin") {
                $_SESSION['username'] = $email;
                $_SESSION['name'] = 'Admin';
                echo '<script>window.location.href="admin_home.php";</script>';
                exit();
            } elseif ($row["usertype"] == "customer") {
                $_SESSION['username'] = $email;
                $sql = "SELECT * FROM customer WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['CustomerName'] = $row["name"];
                    $_SESSION['email'] = $row["email"];
                    $_SESSION['phone'] = $row["phno"];
                    $_SESSION['userid'] = $row["customer_id"];
                }
                echo '<script>window.location.href="cust_home.php";</script>';
                exit();
            } else {
                $_SESSION['loginMessage'] = "Invalid username or password";
?>
                <script type="text/javascript" src="swal/jquery.min.js"></script>
                <script type="text/javascript" src="swal/bootstrap.min.js"></script>
                <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // SweetAlert initialization code goes here
                        Swal.fire({
                            icon: 'error',
                            text: 'Incorrect EmailID or Password.',
                            didClose: () => {
                                window.location.replace('login.php');
                            }
                        });
                    });
                </script>
            <?php
                exit();
            }
        } else {
            $_SESSION['loginMessage'] = "Invalid username or password";
            ?>
            <script type="text/javascript" src="swal/jquery.min.js"></script>
            <script type="text/javascript" src="swal/bootstrap.min.js"></script>
            <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // SweetAlert initialization code goes here
                    Swal.fire({
                        icon: 'error',
                        text: 'Incorrect EmailID or Password.',
                        didClose: () => {
                            window.location.replace('login.php');
                        }
                    });
                });
            </script>
<?php
            exit();
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
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
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <style>
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            /* Dark overlay */
            animation: fadeIn 0.3s;
            /* Fade in effect */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            /* Responsive max width */
            transition: transform 0.3s ease;
            /* Animation effect */
            transform: translateY(-50px);
            /* Start slightly above */
        }

        .modal-content.show {
            transform: translateY(0);
            /* Slide down into view */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        p {
            margin: 0 0 15px;
            font-size: 16px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            /* Darker on hover */
        }
    </style>
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
      <?php include('html/main_header.php');?>
    </header>
    <!-- Header part end-->


    <!--================login_part Area =================-->
    <section class="login_part section_padding ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <img src="mainstyle/img/newlogin.jpg">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Welcome Back ! <br>
                                Sign in to your account</h3>
                            <form class="row contact_form sign-in-form" action="#" method="post" novalidate="novalidate">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="email" value=""
                                        placeholder="Email">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" value=""
                                        placeholder="Password">
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="creat_account d-flex align-items-center">
                                        <a href="#" class="forgot-password-link" id="forgotPasswordLink">Forgot Password?</a>
                                    </div>
                                    <button type="submit" value="submit" name="submit" class="btn_3">
                                        log in
                                    </button>
                                    <!-- <a class="lost_pass" href="#">forget password?</a> -->
                                    <p class="new_acc">Don't have an account?..
                                    <p>
                                        <a class="new_acc" href="cust_reg.php"><b style="color:#4B3049">Create One!</b></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->

    <!--===== Modal form =====-->
    <div id="forgotPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h1>Find your password</h1>
            <p>Step 1: Enter your email address:</p>
            <form id="emailForm">
                <input type="email" name="email1" placeholder="Enter your email" required>
                <input type="hidden" name="usertype" value="user"> <!-- Adjust this value based on your needs -->
                <input type="button" value="Next" id="sendOtpButton">
            </form>
        </div>
    </div>

    <div id="otpModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeOtpModal">&times;</span>
             <h1>Find your password</h1>
            <p>Step 2: Enter OTP</p>
            <form id="otpForm">
                <input type="text" name="otp" placeholder="Enter the OTP" required>
                <input type="submit" value="Verify OTP">
            </form>
        </div>
    </div>

    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeChangePasswordModal">&times;</span>
             <h1>Find your password</h1>
            <p>Step 3: New Credentials</p>
            <form id="changePasswordForm" method="POST" action="set_password.php">
                <label for="newpwd">New Password:</label>
                <input type="password" name="newpwd" required>
                <label for="confirmpwd">Confirm Password:</label>
                <input type="password" name="confirmpwd" required>
                <input type="submit" name="save" value="Change Password">
            </form>
        </div>
    </div>
    <!--===== End Modal form =====-->

    <?php include('html/main_footer.html'); ?>

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

    <!-- Forgot Password -->
    <script>
        document.getElementById('forgotPasswordLink').onclick = function() {
            document.getElementById('forgotPasswordModal').style.display = 'block';
        }

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('forgotPasswordModal').style.display = 'none';
        }

        document.getElementById('closeOtpModal').onclick = function() {
            document.getElementById('otpModal').style.display = 'none';
        }

        // Handle sending the OTP
        document.getElementById('sendOtpButton').onclick = function() {
            const email = document.querySelector('input[name="email1"]').value;
            const usertype = document.querySelector('input[name="usertype"]').value;

            // AJAX request to send the OTP
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_otp.php', true); // Adjust this to your PHP script
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    if (response.includes('Message has been sent.')) {
                        // Close email modal and open OTP modal
                        document.getElementById('forgotPasswordModal').style.display = 'none';
                        document.getElementById('otpModal').style.display = 'block';
                        document.getElementById('otpEmail').value = email; // Pass the email to OTP modal
                    } else {
                        alert(response); // Display error message
                    }
                }
            };
            xhr.send('email=' + encodeURIComponent(email) + '&usertype=' + encodeURIComponent(usertype));
        }

        document.getElementById('otpForm').onsubmit = function(event) {
            event.preventDefault();
            const otp = document.querySelector('input[name="otp"]').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'verify_otp.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    // Close OTP modal and open Change Password modal
                    document.getElementById('otpModal').style.display = 'none';
                    document.getElementById('changePasswordModal').style.display = 'block';
                } else {
                    alert(response.message); // Show error message
                }
            };
            xhr.send('otp=' + encodeURIComponent(otp));
        }
    </script>
</body>

</html>