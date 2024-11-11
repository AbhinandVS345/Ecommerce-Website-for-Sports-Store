<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php"> <img src="mainstyle/img/logo.png" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="about_us.php">about</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cust_viewproduct.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cust_reg.php">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="login.php">Login</a>
                                </li>
                            </ul>
                        </div>
                        <div class="hearer_icon d-flex align-items-center ml-auto">
                            <?php
                            $current_page = basename($_SERVER['PHP_SELF']);
                            if ($current_page == 'index.php' || $current_page == 'cust_viewproduct.php') : ?>
                                <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <?php endif; ?>
                            <a href="login.php">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                            <a href="login.php">
                                <i class="flaticon-shopping-cart-black-shape"></i>
                            </a>
                            <a href="login.php">
                                <i class="fa-solid fa-user" title="Login"></i>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        if ($current_page == 'index.php' || $current_page == 'cust_viewproduct.php') : ?>
            <div class="search_input" id="search_input_box">
                <div class="container ">
                    <form class="d-flex justify-content-between search-inner">
                        <input type="text" class="form-control" id="search-icon" placeholder="Search Here">
                        <button type="submit" class="btn"></button>
                        <span class="ti-close" id="close_search" title="Close Search"></span>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </header>
    <!-- Header part end-->
</body>

</html>