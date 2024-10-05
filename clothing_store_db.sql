-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothing_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image`) VALUES
(1, 'SOFT GOODS', 'c1.jpg'),
(2, 'HARD GOODS', 'c2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_detail` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stockQty` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `size` varchar(5) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_detail`, `price`, `stockQty`, `category_id`, `size`, `image`, `created_at`) VALUES
(21, '378-2023-WHT', '378-2023 : The THIEVES / White / T-Shirt 500 B.', 50.00, 500, 1, 'Large', 'p1.jpg', '2024-10-05 10:30:37'),
(22, '234-2023-BLK', '234-2023 : Rebel / Black / Hoodie 800 B.', 80.00, 200, 2, 'Mediu', 'p2.jpg', '2024-10-05 10:30:37'),
(23, '567-2023-PNK', '567-2023 : Pink Passion / Pink / T-Shirt 400 B.', 40.00, 250, 1, 'Small', 'p3.jpg', '2024-10-05 10:30:37'),
(24, '345-2023-ORG', '345-2023 : Energy Boost / Orange / Hoodie 950 B.', 95.00, 180, 2, 'XL', 'p4.jpg', '2024-10-05 10:30:37'),
(25, '789-2023-GRN', '789-2023 : Nature Vibes / Green / Polo Shirt 600 B.', 60.00, 120, 1, 'XL', 'p5.jpg', '2024-10-05 10:30:37'),
(26, '901-2023-YLW', '901-2023 : Sunshine / Yellow / T-Shirt 450 B.', 45.00, 450, 1, 'Large', 'p6.jpg', '2024-10-05 10:30:37'),
(27, '321-2023-PUR', '321-2023 : Royal / Purple / Hoodie 850 B.', 85.00, 110, 2, 'Large', 'p7.jpg', '2024-10-05 10:30:37'),
(28, '567-2023-RED', '567-2023 : Flame / Red / T-Shirt 480 B.', 48.00, 280, 1, 'XL', 'p8.jpg', '2024-10-05 10:30:37'),
(29, '432-2023-BLK', '432-2023 : Shadow / Black / Polo Shirt 620 B.', 62.00, 150, 1, 'Mediu', 'p9.jpg', '2024-10-05 10:30:37'),
(30, '109-2023-BRN', '109-2023 : Coffee Lover / Brown / Hoodie 900 B.', 90.00, 140, 2, 'Mediu', 'p10.jpg', '2024-10-05 10:30:37'),
(31, '654-2023-WHT', '654-2023 : Classic / White / T-Shirt 550 B.', 55.00, 400, 1, 'Mediu', 'p11.jpg', '2024-10-05 10:30:37'),
(32, '908-2023-BLU', '908-2023 : Sky High / Blue / Cap 300 B.', 30.00, 320, 2, 'One S', 'p12.jpg', '2024-10-05 10:30:37'),
(33, '567-2023-PNK', '567-2023 : Cherry Blossom / Pink / T-Shirt 520 B.', 52.00, 220, 1, 'Small', 'p13.jpg', '2024-10-05 10:30:37'),
(34, '345-2023-BLK', '345-2023 : Midnight / Black / Hoodie 820 B.', 82.00, 190, 2, 'Large', 'p14.jpg', '2024-10-05 10:30:37'),
(35, '432-2023-RED', '432-2023 : Bold / Red / T-Shirt 490 B.', 49.00, 300, 1, 'Small', 'p15.jpg', '2024-10-05 10:30:37'),
(36, '210-2023-GRY', '210-2023 : Urban Style / Gray / Hoodie 1200 B.', 120.00, 80, 2, 'Mediu', 'p16.jpg', '2024-10-05 10:30:37'),
(37, '109-2023-ORG', '109-2023 : Orange Burst / Orange / Hoodie 780 B.', 78.00, 150, 2, 'XL', 'p17.jpg', '2024-10-05 10:30:37'),
(38, '567-2023-WHT', '567-2023 : Clean Look / White / T-Shirt 530 B.', 53.00, 260, 1, 'Large', 'p18.jpg', '2024-10-05 10:30:37'),
(39, '789-2023-BLU', '789-2023 : Ocean Wave / Blue / Polo Shirt 600 B.', 60.00, 130, 1, 'XL', 'p19.jpg', '2024-10-05 10:30:37'),
(40, '234-2023-YLW', '234-2023 : Sunny Day / Yellow / Hoodie 880 B.', 88.00, 170, 2, 'Mediu', 'p20.jpg', '2024-10-05 10:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `shipping_date` datetime DEFAULT current_timestamp(),
  `tracking_number` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_customers`
--

CREATE TABLE `tb_customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `reg_date` datetime DEFAULT current_timestamp(),
  `user_role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customers`
--

INSERT INTO `tb_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `address`, `city`, `postal_code`, `reg_date`, `user_role`) VALUES
(1, 'รัตติยา', 'น้อยไกรจักร์', 'Chatupon21396@gmail.com', '$2y$10$artd7.CHrAJzculk1iPTZOSZQTB.d7B0Ct3yVxBCi1Io3M1S4HkcO', '123213', 'asdsad', '123213', 'asdsad', '2024-10-01 18:53:31', 'customer'),
(6, 'รัตติยา', 'น้อยไกรจักร์', 'asdsa@gmail.com', '$2y$10$B41gYzByQ2IWOF1.haCLt.qaTRPfy9pttBk7EBGlo897UOV8/Dvcm', '0954699682', 'asdsad', 'asdsad', '12342', '2024-10-02 01:25:11', 'admin'),
(15, 'asdasdsad', 'sdsadasdsa', '12312321@gmail.com', '$2y$10$A0YuvBpFZi56hhh1crAhZOdUlSdHSKZIXPQci9R5icRsORuIzYU/e', '0954699689', 'asdasd', '213asdsad', '48140', '2024-10-02 01:42:08', 'customer'),
(18, 'รัตติยา', 'น้อยไกรจักร์', 'asdasdsadsa@gmail.com', '$2y$10$j7MSwOg0UtqVhvQo.MDfTeqx97x5wOiRdaJD1cXVsqpnn8GiZItyq', '095469968s', '123', 'asd', '1234', '2024-10-04 03:40:18', 'customer'),
(19, 'จตุพล', 'สิงห์กระโจม', '12312322221@gmail.com', '$2y$10$RxkG.bqqFEk1vYWI2hvAHeyyrwADj3Ky9pbEPOQhrmoRFs6LitKx6', '1234', '1234', '1234', '1324', '2024-10-04 03:41:21', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `tb_orders`
--

CREATE TABLE `tb_orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_order_details`
--

CREATE TABLE `tb_order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_payments`
--

CREATE TABLE `tb_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tb_customers`
--
ALTER TABLE `tb_customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `tb_order_details`
--
ALTER TABLE `tb_order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tb_payments`
--
ALTER TABLE `tb_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_customers`
--
ALTER TABLE `tb_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_orders`
--
ALTER TABLE `tb_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_order_details`
--
ALTER TABLE `tb_order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_payments`
--
ALTER TABLE `tb_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tb_orders` (`order_id`);

--
-- Constraints for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD CONSTRAINT `tb_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tb_customers` (`customer_id`);

--
-- Constraints for table `tb_order_details`
--
ALTER TABLE `tb_order_details`
  ADD CONSTRAINT `tb_order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tb_orders` (`order_id`),
  ADD CONSTRAINT `tb_order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `tb_payments`
--
ALTER TABLE `tb_payments`
  ADD CONSTRAINT `tb_payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tb_orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
