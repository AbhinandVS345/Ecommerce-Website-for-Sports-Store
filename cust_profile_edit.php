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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<style>
    .nav-pills .nav-link {
        font-size: 18px; /* Increased font size */
        padding: 15px; /* Increased padding */
        border-radius: 8px; /* Rounded corners */
        text-align: center;
        transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition */
        color: #000;
    }

    .nav-pills .nav-link.active {
        background-color: #B08EAD; /* Active tab background */
        color: #fff; /* Active tab text color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for active tab */
    }

   
    .nav-pills {
        margin-top: 30px; /* Add some top margin */
    }
    .btn-profile{
        background-color: #B08EAD;
        color: #fff;
    }
    .btn-profile:hover{
        background-color: #B08EAD;
        color: #fff;
    }
</style>
</head>

<body>

    <?php
    if (isset($_SESSION['userid'])) {
        // User is logged in, include the logged-in header
        include("html/cust_header.php");
    } else {
        // User is not logged in, include the default header
        include('html/main_header.php');
    }
    ?>

    <!-- breadcrumb part start-->
    <section class="breadcrumb_part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <h2>Account Settings</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb part end-->

    <section class="account-settings section_padding">
    <div class="container">
        <div class="row">
            <!-- Sidebar for Profile Editing and Change Password -->
            <div class="col-md-3">
                <ul class="nav flex-column nav-pills" id="settingsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-bs-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile Editing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="password-tab" data-bs-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">Change Password</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content for Profile and Password -->
            <div class="col-md-9">
                <div class="tab-content" id="settingsTabContent">
                    <!-- Profile Editing Content -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h4>Edit Profile</h4>
                        <form id="edit-profile-form" action="" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['CustomerName']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-profile">Update Profile</button>
                        </form>
                    </div>

                    <!-- Change Password Content -->
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <h4>Change Password</h4>
                        <form id="change-password-form" action="" method="post">
                            <div class="mb-3">
                                <label for="current-password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current-password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new-password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-profile">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <?php include('html/cust_footer.html'); ?>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
   $(document).ready(function () {
    $('#edit-profile-form').on('submit', function (e) {
        e.preventDefault(); // Prevent form from submitting normally

        $.ajax({
            type: 'POST',
            url: 'update_profile.php', // Update URL to your PHP file
            data: $(this).serialize(), // Serialize form data
            success: function (response) {
                try {
                    // Parse the response to JSON if it's not already an object
                    const jsonResponse = (typeof response === 'string') ? JSON.parse(response) : response;

                    if (jsonResponse.status === 'success') {
                        // Display success toast notification
                        toastr.success('Profile updated successfully!');

                        // Update the form values immediately after a successful update
                        $('#username').val(jsonResponse.updated_name);
                        $('#phone').val(jsonResponse.updated_phone);
                    } else {
                        toastr.error('Error updating profile.');
                    }
                } catch (error) {
                    toastr.error('Invalid response from server.');
                }
            },
            error: function () {
                toastr.error('Something went wrong!');
            }
        });
    });

    $('#change-password-form').on('submit', function (e) {
        e.preventDefault(); // Prevent form from submitting normally

        $.ajax({
            type: 'POST',
            url: 'change_password.php', // The PHP file to handle the password change
            data: $(this).serialize(), // Serialize form data
            success: function (response) {
                try {
                    // Parse the response to JSON
                    const jsonResponse = (typeof response === 'string') ? JSON.parse(response) : response;

                    if (jsonResponse.status === 'success') {
                        // Display success toast notification
                        toastr.success(jsonResponse.message);

                        // Redirect to login page after a short delay
                        setTimeout(function () {
                            window.location.href = 'login.php'; // Redirect to the login page
                        }, 2000); // Redirect after 2 seconds
                    } else {
                        // Display error message
                        toastr.error(jsonResponse.message);
                    }
                } catch (error) {
                    toastr.error('Invalid response from server.');
                }
            },
            error: function () {
                toastr.error('Something went wrong!');
            }
        });
    });
});

</script>
</body>

</html>