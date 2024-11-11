<?php
session_start();

include('connection.php');

$customer_id = $date = $comment = "";

if (isset($_POST['submit'])) {
  if (isset($_SESSION['userid'])) {
    $customer_id = $_SESSION['userid'];
    $date = date('Y-m-d'); // Use 'Y' for the full year format
    $comment = $_POST['comment'];
    $sql = "INSERT INTO feedback(date, comment, customer_id) VALUES('$date', '$comment', '$customer_id')";
    if (mysqli_query($conn, $sql)) {
      header("Location: cust_feedback.php");
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  } else {
    echo "User ID is not set in the session.";
    // Optionally, redirect to the login page or show an error message
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
</head>

<body>

  <?php include('html/cust_header.php'); ?>

  <!-- breadcrumb part start-->
  <section class="breadcrumb_part">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb_iner">
            <h2>feedback</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb part end-->

  <!-- ================ contact section start ================= -->
  <section class="contact-section section_padding">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="contact-title">Get in Touch</h2>
        </div>
        <div class="col-lg-8">
          <form class="form-contact contact_form" action="" method="post" novalidate="novalidate">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"
                    placeholder='Enter Message'></textarea>
                </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <button type="submit" name="submit" class="btn_3 button-contactForm">Send Message</button>
            </div>
          </form>
        </div>
        <div class="col-lg-4">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3>Vaikom, Kottayam.</h3>
              <p>Rosemead, CA 91770</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
            <div class="media-body">
              <h3>+91 9848150825</h3>
              <p>Mon to Fri 9am to 7pm</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3>support@colorlib.com</h3>
              <p>Send us your query anytime!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ contact section end ================= -->

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