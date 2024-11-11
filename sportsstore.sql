-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 01:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `name`, `image`) VALUES
(2, 'Adidas', 'adidas.png'),
(3, 'Puma', 'puma.jpg'),
(4, 'Nivia', 'nivia.png'),
(8, 'Kipsta', 'kipsta.jpeg'),
(10, 'Yonex', 'yonex.jpg'),
(14, 'FLX', 'images.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `single_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `single_product_id`, `quantity`) VALUES
(172, 21, 28, 1),
(173, 21, 15, 1),
(174, 21, 27, 3),
(175, 21, 21, 2),
(176, 21, 24, 2),
(179, 21, 30, 1),
(180, 23, 27, 1),
(182, 23, 21, 1),
(183, 23, 15, 2),
(245, 34, 15, 1),
(250, 35, 15, 3),
(253, 35, 31, 2),
(254, 28, 15, 2),
(255, 28, 30, 1),
(256, 28, 31, 1),
(263, 33, 16, 1),
(264, 33, 31, 1),
(265, 33, 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `image`) VALUES
(1, 'Shoes', 'shoes.jpg'),
(5, 'Equipments', 'equipments.jpeg'),
(8, 'Accessories', 'gear.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phno` bigint(20) NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `email`, `phno`, `reg_date`) VALUES
(20, 'Luffy', 'luffy7@gmail.com', 8495731602, '2024-10-24'),
(21, 'Rahul', 'rahul11@gmail.com', 8495731602, '2024-10-24'),
(22, 'Sanju', 'sanju12@gmail.com', 7845967510, '2024-10-24'),
(23, 'Sooraj ', 'sooraj25@gmail.com', 9878796879, '2024-10-24'),
(24, 'Abhinand', 'abhinand123@gmail.com', 8495731602, '2024-10-25'),
(28, 'Abhinand V S', 'okda01234@gmail.com', 7510436345, '2024-10-27'),
(30, 'Achu Aji', 'achuaji205@gmail.com', 9947540539, '2024-10-27'),
(31, 'V Ajay Krishnan', 'krishnanajay26@gmail.com', 9496722757, '2024-10-28'),
(33, 'Arjun T S', 'abhinandabhis101@gmail.com', 7510436348, '2024-10-29'),
(34, 'Abhinand V S', 'abhinandvs345@gmail.com', 9846617779, '2024-11-01'),
(35, 'Anakha', 'anakha.talrop@gmail.com', 9846617779, '2024-11-06'),
(36, 'Lalitha P K', 'lalithapkrishnan@gmail.com', 9497051509, '2024-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `deliveryaddress`
--

CREATE TABLE `deliveryaddress` (
  `deliveryaddress_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `house_num` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `city` varchar(30) NOT NULL,
  `pincode` int(11) NOT NULL,
  `district` varchar(20) NOT NULL,
  `phno` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveryaddress`
--

INSERT INTO `deliveryaddress` (`deliveryaddress_id`, `customer_id`, `name`, `house_num`, `location`, `city`, `pincode`, `district`, `phno`) VALUES
(48, 28, 'Abhinand V S', '312', 'Chempu', 'Vaikom', 686608, 'Kottayam', 7845129670),
(49, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(50, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(51, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(52, 28, 'Abhinand V S', '312', 'Chempu', 'Vaikom', 686608, 'Kottayam', 7845129670),
(53, 31, 'V Ajay Krishnan', '319', 'Anari Road', 'Vaikom', 686141, 'Kottayam', 9496722757),
(54, 31, 'V Ajay Krishnan', '319', 'Anari Road', 'Vaikom', 686141, 'Kottayam', 9496722757),
(56, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(62, 28, 'Abhinand V S', '312', 'Chempu', 'Vaikom', 686608, 'Kottayam', 7845129670),
(63, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(64, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(65, 34, 'Abhinand V S', '319,Vadassery Illam', 'Chempu', 'Vaikom', 686608, 'Kottayam', 9846617779),
(68, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(69, 28, 'Abhinand V S', '312', 'Chempu', 'Vaikom', 686608, 'Kottayam', 7845129670),
(70, 28, 'Abhinand V S', '312', 'Chempu', 'Vaikom', 686608, 'Kottayam', 7845129670),
(71, 28, 'Abhinand', '308', 'Kanakkari', 'Ettumanoor', 686684, 'Kottayam', 7894615230),
(72, 33, 'Arjun', '317, Thakidiyil', 'Koprakkalam', 'Pomkunnam', 686684, 'Kottayam', 9947540539),
(73, 33, 'Arjun', '317, Thakidiyil', 'Koprakkalam', 'Pomkunnam', 686684, 'Kottayam', 9947540539),
(74, 35, 'Arjun', 'Souparnika', 'T V Puram', 'Vaikom', 686608, 'Kottayam', 9846617779),
(75, 35, 'Gayathri', '301', 'Koprakalam', 'Pala', 675423, 'Kottayam', 8078757787),
(76, 36, 'Lalitha P K', '310, Parakkal', 'Vazhakkulam', 'Aluva', 686508, 'Ernakulam', 9497051509),
(77, 36, 'Lalitha P K', '310, Parakkal', 'Vazhakkulam', 'Aluva', 686508, 'Ernakulam', 9497051509),
(78, 33, 'Arjun', '317, Thakidiyil', 'Koprakkalam', 'Pomkunnam', 686684, 'Kottayam', 9947540539);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` varchar(300) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `date`, `comment`, `customer_id`) VALUES
(18, '2024-07-27', 'Thanks', 21),
(20, '2024-08-07', 'Thank you', 23),
(21, '2024-11-03', 'I have enjoyed purchase from this webpage.', 28);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `gender`) VALUES
(1, 'male'),
(2, 'female'),
(3, 'Neutral');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(20) NOT NULL,
  `usertype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `email`, `password`, `usertype`) VALUES
(19, 'luffy7@gmail.com', 'asdfg', 'customer'),
(20, 'rahul11@gmail.com', 'abcd', 'customer'),
(21, 'admin@gmail.com', 'admin', 'admin'),
(22, 'sanju12@gmail.com', 'asdf', 'customer'),
(23, 'sooraj25@gmail.com', 'zxcv', 'customer'),
(24, 'abhinand123@gmail.com', 'qwerty', 'customer'),
(26, 'okda01234@gmal.com', 'qwerty', 'customer'),
(27, 'okda01234@gmail.com', 'zxsa', 'customer'),
(28, 'okda01234@gmail.com', 'zxsa', 'customer'),
(30, 'achuaji205@gmail.com', '12345', 'customer'),
(31, 'krishnanajay26@gmail.com', 'ajay26', 'customer'),
(33, 'abhinandabhis101@gmail.com', 'asdf', 'customer'),
(34, 'abhinandvs345@gmail.com', 'asdf', 'customer'),
(35, 'anakha.talrop@gmail.com', 'zxcvb', 'customer'),
(36, 'lalithapkrishnan@gmail.com', 'lalitha123', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetails_id` int(11) NOT NULL,
  `ordermaster_id` int(11) NOT NULL,
  `single_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderdetails_id`, `ordermaster_id`, `single_product_id`, `quantity`, `total_price`) VALUES
(85, 43, 15, 1, 599),
(86, 44, 15, 1, 599),
(87, 45, 15, 1, 599),
(88, 46, 32, 1, 599),
(89, 47, 31, 1, 699),
(90, 48, 29, 1, 455),
(91, 49, 15, 1, 599),
(93, 51, 15, 1, 599),
(100, 57, 21, 1, 599),
(101, 58, 21, 1, 599),
(102, 58, 31, 1, 699),
(103, 58, 27, 1, 490),
(104, 58, 24, 1, 1200),
(105, 59, 15, 1, 599),
(106, 59, 31, 1, 699),
(107, 59, 28, 1, 490),
(108, 59, 16, 2, 1000),
(109, 59, 27, 1, 490),
(113, 63, 15, 1, 599),
(114, 64, 21, 1, 599),
(115, 65, 24, 3, 3600),
(116, 66, 24, 1, 1200),
(117, 67, 15, 3, 1797),
(118, 68, 29, 2, 910),
(119, 68, 15, 1, 599),
(120, 68, 31, 3, 2097),
(121, 69, 15, 1, 599),
(122, 70, 15, 3, 1797),
(123, 71, 33, 1, 799),
(124, 71, 40, 1, 100),
(125, 72, 35, 1, 699),
(126, 72, 25, 2, 1000),
(127, 73, 38, 1, 899);

-- --------------------------------------------------------

--
-- Table structure for table `ordermaster`
--

CREATE TABLE `ordermaster` (
  `ordermaster_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `totalamount` float NOT NULL,
  `status` varchar(20) NOT NULL,
  `deliveryaddress_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordermaster`
--

INSERT INTO `ordermaster` (`ordermaster_id`, `customer_id`, `order_date`, `totalamount`, `status`, `deliveryaddress_id`) VALUES
(43, 28, '2024-11-02', 649, 'Delivered', 48),
(44, 28, '2024-11-02', 649, 'Cancelled', 49),
(45, 28, '2024-11-02', 649, 'Delivered', 50),
(46, 28, '2024-11-02', 649, 'Cancelled', 51),
(47, 28, '2024-11-02', 749, 'Delivered', 52),
(48, 31, '2024-11-02', 505, 'Delivered', 53),
(49, 31, '2024-11-02', 649, 'Delivered', 54),
(51, 28, '2024-11-02', 649, 'Cancelled', 56),
(57, 28, '2024-11-03', 649, 'Delivered', 62),
(58, 28, '2024-11-03', 3038, 'Successful', 63),
(59, 28, '2024-11-06', 3328, 'Successful', 64),
(60, 34, '2024-11-06', 649, 'Successful', 65),
(63, 28, '2024-11-06', 649, 'Successful', 68),
(64, 28, '2024-11-06', 649, 'Successful', 69),
(65, 28, '2024-11-06', 3650, 'Successful', 70),
(66, 28, '2024-11-06', 1250, 'Successful', 71),
(67, 33, '2024-11-06', 1847, 'Successful', 72),
(68, 33, '2024-11-06', 3656, 'Successful', 73),
(69, 35, '2024-11-06', 649, 'Cancelled', 74),
(70, 35, '2024-11-06', 1847, 'Successful', 75),
(71, 36, '2024-11-07', 949, 'Successful', 76),
(72, 36, '2024-11-07', 1749, 'Successful', 77),
(73, 33, '2024-11-07', 949, 'Successful', 78);

-- --------------------------------------------------------

--
-- Table structure for table `otp_table`
--

CREATE TABLE `otp_table` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` enum('unused','used') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_table`
--

INSERT INTO `otp_table` (`id`, `email`, `otp`, `timestamp`, `status`) VALUES
(1, 'okda01234@gmail.com', '696949', '2024-10-25 15:18:11', 'used'),
(2, 'okda01234@gmail.com', '972357', '2024-10-31 17:55:01', 'used'),
(3, 'okda01234@gmail.com', '798852', '2024-10-31 17:55:06', 'unused'),
(4, 'okda01234@gmail.com', '845393', '2024-11-01 00:38:34', 'unused'),
(5, 'okda01234@gmail.com', '857456', '2024-11-01 00:46:03', 'used'),
(6, 'okda01234@gmail.com', '163944', '2024-11-01 00:46:08', 'unused'),
(7, 'okda01234@gmail.com', '952060', '2024-11-01 00:46:13', 'unused'),
(8, 'okda01234@gmail.com', '858122', '2024-11-01 00:46:23', 'unused'),
(9, 'okda01234@gmail.com', '833573', '2024-11-01 00:48:18', 'unused'),
(10, 'okda01234@gmail.com', '296972', '2024-11-01 00:50:13', 'unused'),
(11, 'okda01234@gmail.com', '258728', '2024-11-01 00:50:18', 'unused'),
(12, 'okda01234@gmail.com', '165084', '2024-11-01 00:50:28', 'used'),
(13, 'okda01234@gmail.com', '976299', '2024-11-01 20:32:23', 'used'),
(14, 'okda01234@gmail.com', '896372', '2024-11-01 20:32:28', 'used'),
(15, 'okda01234@gmail.com', '690554', '2024-11-01 20:35:09', 'unused'),
(16, 'okda01234@gmail.com', '199384', '2024-11-01 20:35:14', 'unused'),
(17, 'anakha.talrop@gmail.com', '348258', '2024-11-06 19:02:48', 'unused'),
(18, 'anakha.talrop@gmail.com', '126520', '2024-11-06 19:02:52', 'used'),
(19, 'okda01234@gmail.com', '142210', '2024-11-07 12:02:59', 'used');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `ordermaster_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `ordermaster_id`, `payment_method`, `payment_date`, `payment_status`) VALUES
(31, 43, 'Cash on Delivery', '2024-11-02', 'Completed'),
(32, 44, 'UPI Payment', '2024-11-02', 'Completed'),
(33, 45, 'Cash on Delivery', '2024-11-02', 'Completed'),
(34, 46, 'UPI Payment', '2024-11-02', 'Completed'),
(35, 47, 'Cash on Delivery', '2024-11-02', 'Completed'),
(36, 48, 'UPI Payment', '2024-11-02', 'Completed'),
(37, 49, 'Cash on Delivery', '2024-11-02', 'Completed'),
(39, 51, 'Cash on Delivery', '2024-11-02', 'Pending'),
(45, 57, 'UPI Payment', '2024-11-03', 'Completed'),
(46, 58, 'Cash on Delivery', '2024-11-03', 'Completed'),
(47, 59, 'Cash on Delivery', '2024-11-06', 'Completed'),
(49, 63, 'Cash on Delivery', '2024-11-06', 'Pending'),
(50, 64, 'UPI Payment', '2024-11-06', 'Completed'),
(51, 65, 'Cash on Delivery', '2024-11-06', 'Pending'),
(52, 66, 'Cash on Delivery', '2024-11-06', 'Pending'),
(53, 67, 'Cash on Delivery', '2024-11-06', 'Pending'),
(54, 68, 'Cash on Delivery', '2024-11-06', 'Completed'),
(55, 69, 'Cash on Delivery', '2024-11-06', 'Pending'),
(56, 70, 'UPI Payment', '2024-11-06', 'Completed'),
(57, 71, 'Cash on Delivery', '2024-11-07', 'Completed'),
(58, 72, 'UPI Payment', '2024-11-07', 'Completed'),
(59, 73, 'Credit/Debit Card', '2024-11-07', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sports_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `image`, `price`, `description`, `category_id`, `sports_id`, `brand_id`, `gender_id`) VALUES
(1, 'KIPSTA', 'prod1.avif', 599, 'Football Club Ball Size 5 FIFA Basic F500 White Yellow', 5, 1, 8, 1),
(7, 'Volleyball-KIPSTA', 'prod2.avif', 490, 'Volleyball Indoor Ball V500 White Blue', 5, 2, 8, 1),
(9, 'Basketball', '61H3K5VEx+L._AC_UF894,1000_QL80_.jpg', 455, 'KIPSTA TARMAK 100 Adult Orange', 5, 4, 4, 1),
(11, 'Running Shoes', 'run-active-lightweight-cushioned-men-running-shoes-upto-10-km-wk-black-orange.avif', 500, 'RUN ACTIVE Lightweight Cushioned Men Running Shoes UPTO 10 km/wk - Black Orange', 1, 1, 2, 1),
(15, 'Football Gloves', 'kids-football-goalkeeper-gloves-f100-black-yellow.avif', 599, 'Kids Football Goalkeeper Gloves F100 - Black/Yellow', 8, 1, 4, 1),
(16, 'Badminton Racket', 'adult-badminton-racket-br-100-blue.avif', 1200, 'Adult Badminton Racket BR 190', 5, 8, 10, 1),
(17, 'Shoes', 'p2155509.avif', 599, 'JOGFLOW 100 Superior Grip Cushioned Men Running Shoes max 10km/wk- White/Orange', 1, 9, 3, 1),
(19, 'Beach Volleyball', 'p2637121.avif', 699, 'Beach Volleyball BV100 Classic - Turquoise', 5, 2, 8, 1),
(20, 'FLX Bat', 'p2410168.avif', 799, 'T 500 LITE KIDS POPLAR WOOD BAT BLUE', 5, 6, 14, 3),
(21, 'Turf Boots', 'p1273543.avif', 699, 'Mens Football Shoes Agility 100 Turf Black', 1, 1, 8, 1),
(22, 'Casual Shoes', 'p1419921.avif', 899, 'Men Walking Shoes PW 100 - Grey', 1, 9, 3, 1),
(23, 'Badminton Shuttlecock', 'download.jpeg', 100, 'Yonex Mavis 10 Blue Cap Shuttlecock', 5, 8, 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_date` date NOT NULL,
  `review` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`review_id`, `customer_id`, `product_id`, `review_date`, `review`) VALUES
(1, 23, 7, '2024-10-04', 'Nice product'),
(2, 23, 1, '2024-10-25', 'good');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ratingcount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `product_id`, `customer_id`, `ratingcount`) VALUES
(1, 7, 23, 4),
(2, 1, 23, 4),
(3, 1, 22, 3);

-- --------------------------------------------------------

--
-- Table structure for table `single_product`
--

CREATE TABLE `single_product` (
  `single_product_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `single_product`
--

INSERT INTO `single_product` (`single_product_id`, `product_id`, `size_id`, `stock`) VALUES
(15, 1, 3, 22),
(16, 11, 6, 93),
(21, 17, 5, 149),
(24, 16, 9, 41),
(25, 11, 5, 28),
(26, 1, 1, 0),
(27, 7, 3, 27),
(28, 7, 2, 7),
(29, 9, 2, 7),
(30, 9, 3, 48),
(31, 19, 2, 8),
(32, 15, 3, 0),
(33, 20, 9, 24),
(34, 21, 5, 20),
(35, 21, 6, 14),
(36, 21, 4, 15),
(37, 22, 5, 20),
(38, 22, 6, 39),
(39, 22, 7, 30),
(40, 23, 9, 99);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `size_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`size_id`, `size`) VALUES
(1, '3'),
(2, '4'),
(3, '5'),
(4, '6'),
(5, '7'),
(6, '8'),
(7, '9'),
(8, '10'),
(9, 'pp');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `sports_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`sports_id`, `name`) VALUES
(1, 'Football'),
(2, 'Volleyball'),
(4, 'Basketball'),
(6, 'Cricket'),
(8, 'Badminton'),
(9, 'Casual');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `product_id`, `customer_id`) VALUES
(9, 15, 23),
(11, 11, 23),
(17, 19, 23),
(28, 9, 21),
(30, 17, 21),
(32, 9, 23),
(58, 17, 28),
(65, 9, 28),
(67, 1, 35),
(69, 1, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cust_id` (`customer_id`),
  ADD KEY `single_product_id` (`single_product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `deliveryaddress`
--
ALTER TABLE `deliveryaddress`
  ADD PRIMARY KEY (`deliveryaddress_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `cust_id` (`customer_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetails_id`),
  ADD KEY `order_master_id` (`ordermaster_id`),
  ADD KEY `single_product_id` (`single_product_id`);

--
-- Indexes for table `ordermaster`
--
ALTER TABLE `ordermaster`
  ADD PRIMARY KEY (`ordermaster_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `delivery_address_id` (`deliveryaddress_id`);

--
-- Indexes for table `otp_table`
--
ALTER TABLE `otp_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`otp`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `ordermaster_id` (`ordermaster_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `game_id` (`sports_id`),
  ADD KEY `product_ibfk_1` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `gender_id` (`gender_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `single_product`
--
ALTER TABLE `single_product`
  ADD PRIMARY KEY (`single_product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`sports_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `deliveryaddress`
--
ALTER TABLE `deliveryaddress`
  MODIFY `deliveryaddress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetails_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `ordermaster`
--
ALTER TABLE `ordermaster`
  MODIFY `ordermaster_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `otp_table`
--
ALTER TABLE `otp_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `single_product`
--
ALTER TABLE `single_product`
  MODIFY `single_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `sports_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`single_product_id`) REFERENCES `single_product` (`single_product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deliveryaddress`
--
ALTER TABLE `deliveryaddress`
  ADD CONSTRAINT `deliveryaddress_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`ordermaster_id`) REFERENCES `ordermaster` (`ordermaster_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`single_product_id`) REFERENCES `single_product` (`single_product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordermaster`
--
ALTER TABLE `ordermaster`
  ADD CONSTRAINT `ordermaster_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordermaster_ibfk_2` FOREIGN KEY (`deliveryaddress_id`) REFERENCES `deliveryaddress` (`deliveryaddress_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`ordermaster_id`) REFERENCES `ordermaster` (`ordermaster_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`sports_id`) REFERENCES `sports` (`sports_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`gender_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `single_product`
--
ALTER TABLE `single_product`
  ADD CONSTRAINT `single_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `single_product_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
