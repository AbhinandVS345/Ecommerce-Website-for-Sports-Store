<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            position: relative;
            top: -10px;
            left: -5px;
        }
    </style>
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="cust_home.php"> <img src="mainstyle/img/logo.png" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="cust_home.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="about_us.php">about</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cust_viewproduct.php">Products</a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" href="cust_feedback.php">Feedback</a>
                                </li>
                            </ul>
                        </div>
                        <div class="hearer_icon d-flex align-items-center">
                            <?php
                            $current_page = basename($_SERVER['PHP_SELF']);
                            if ($current_page == 'cust_home.php' || $current_page == 'cust_viewproduct.php') : ?>
                                <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <?php endif; ?>

                            <?php
                            $cust_id = $_SESSION['userid'];
                            $sql = "SELECT COUNT(*) AS totalItems FROM wishlist WHERE customer_id = '$cust_id'";
                            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                            $totalWishlistItems = $row['totalItems'] ? $row['totalItems'] : 0; // Default to 0 if no items

                            // Get total cart items
                            $sql = "SELECT SUM(quantity) AS totalItems FROM cart WHERE customer_id ='$cust_id'";
                            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                            $totalCartItems = $row['totalItems'] ? $row['totalItems'] : 0; // Default to 0 if no items
                            ?>
                            <a href="cust_wishlist.php">
                                <i class="fa-solid fa-heart"></i>
                                <?php if ($totalWishlistItems > 0){ ?>
                                    <span class="badge" id="wishlist-count"><?php echo $totalWishlistItems; ?></span>
                                <?php }else{ ?>
                                    <span class="badge" id="wishlist-count"></span>
                                <?php } ?>
                            </a>
                            <a href="cust_viewcart.php">
                                <i class="flaticon-shopping-cart-black-shape"></i>
                                <?php if ($totalCartItems > 0){ ?>
                                    <span class="badge" id="cart-count"><?php echo $totalCartItems; ?></span>
                                <?php }else{ ?>
                                    <span class="badge" id="cart-count"></span>
                                <?php } ?>
                            </a>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-user" title="Login"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="cust_profile_edit.php">Profile</a>
                                <a class="dropdown-item" href="cust_vieworder.php">My Order</a>
                                <a class="dropdown-item" href="cust_viewcart.php">My Cart</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sign_out.php">Logout</a>
                            </div>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container ">
                <form class="d-flex justify-content-between search-inner">
                    <input type="text" class="form-control" id="search-icon" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>
    <!-- Header part end-->

</body>

</html>