<?php
//session_start();
include('connection.php');

$name = $phno = $email = $password = $confpassword = "";

if (isset($_POST["submit"])) {

    $customerName = $_POST['name'];
    $contactno = $_POST['phno'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = 'customer';

    $sql = "SELECT * FROM customer WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        echo '<script>alert("User with this email already exists. Please choose a different email.");</script>';
    } else {

        $sql = "INSERT INTO customer(name,email,phno,reg_date) VALUES('$customerName','$email','$contactno', NOW())";
        if (mysqli_query($conn, $sql)) {

            $sql = "INSERT INTO login(email,password,usertype) VALUES ('$email','$password','$user')";
            mysqli_query($conn, $sql);
            //for email
            require 'vendor/autoload.php'; //Create an instance; passing true enables exceptions
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            // Use SMT
            $mail->isSMTP();

            // SMTP settings
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'gentriusprojects@gmail.com';
            $mail->Password = 'lbef xirr qxgq tsix';

            // Set 'from' email address and name
            $mail->setFrom('gentriusprojects@gmail.com', 'Track Sports');

            // Add a recipient email address
            $mail->addAddress($email);

            // Email subject and body
            $mail->Subject = 'Welcome to Track Sports - Your Adventure Begins Here!';
            $mail->Body = "Hello $customerName,\n\n" .
                "Welcome to Track Sports! We're thrilled to have you as part of our community.\n\n" .
                "As a member, you now have access to a wide range of premium sports gear, apparel, and equipment tailored to help you reach your peak performance. Whether you're just starting or an experienced athlete, we’re here to support your journey every step of the way.\n\n" .
                "Here are your registration details:\n\n" .
                "- **Email**: $email\n" .
                "- **Registration Date**: " . date('Y-m-d') . "\n\n" .
                "### What's Next?\n" .
                "Explore our collections, take advantage of our latest offers, and stay updated with exclusive promotions and events curated just for you.\n\n" .
                "If you ever need assistance, our team is ready to help. Simply reply to this email or reach out at support@example.com. Your satisfaction is our top priority.\n\n" .
                "Thank you for choosing Track Sports as your partner in fitness and adventure.\n\n" .
                "Warm regards,\n\n" .
                "The Track Sports Team\n" .
                "Contact Us: +91 9856985674\n";


            // Send email
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                // echo 'Message sent!';
            }
?>
            <script type="text/javascript" src="swal/jquery.min.js"></script>
            <script type="text/javascript" src="swal/bootstrap.min.js"></script>
            <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // SweetAlert initialization code goes here
                    Swal.fire({
                        icon: 'success',
                        text: 'Successfully Registered',
                        didClose: () => {
                            window.location.replace('login.php');
                        }
                    });
                });
            </script>
<?php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
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

    <style>
        .error {
            color: red;
        }
    </style>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <?php include('html/main_header.php'); ?>
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
                            <h3>Welcome ! <br>
                                Create your account</h3>
                            <form class="row contact_form sign-in-form" action="#" method="post" novalidate="novalidate">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Name">
                                    <span id="nameError" class="error"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="email" value="" placeholder="Email">
                                    <span id="emailError" class="error"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="phno" name="phno" value="" placeholder="Phone Number">
                                    <span id="phoneError" class="error"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="confpassword" name="confpassword" value="" placeholder="Confirm Password">
                                    <span id="passwordError" class="error"></span>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" name="submit" class="btn_3">
                                        sign up
                                    </button>
                                    <!-- <a class="lost_pass" href="#">forget password?</a> -->
                                    <p class="new_acc">Already have an account?..
                                    <p>
                                        <a class="new_acc" href="login.php"><b style="color:#4B3049">Sign in</b></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->

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
    <script src="mainstyle/js/validation.js"></script>
</body>

</html>