-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 04, 2026 at 04:52 PM
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
-- Database: `c2c_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Clothing'),
(3, 'Furniture'),
(4, 'Vehicles');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_item_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 2, 1),
(8, 8, 14, 1),
(9, 9, 2, 1),
(10, 10, 13, 1),
(11, 11, 10, 1),
(12, 12, 11, 1),
(13, 13, 5, 1),
(14, 14, 2, 1),
(15, 15, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `buyer_id`, `order_date`, `order_status`) VALUES
(1, 4, '2026-04-29 22:00:00', 'Pending'),
(2, 9, '2026-04-30 22:00:00', 'Pending'),
(3, 9, '2026-04-30 22:00:00', 'Pending'),
(4, 9, '2026-04-30 22:00:00', 'Pending'),
(5, 9, '2026-04-30 22:00:00', 'Pending'),
(6, 10, '2026-05-03 22:00:00', 'Pending'),
(7, 14, '2026-05-13 22:00:00', 'Pending'),
(8, 4, '2026-05-15 22:00:00', 'Pending'),
(9, 4, '2026-05-15 22:00:00', 'Pending'),
(10, 4, '2026-05-15 22:00:00', 'Pending'),
(11, 4, '2026-05-15 22:00:00', 'Pending'),
(12, 4, '2026-05-15 22:00:00', 'Pending'),
(13, 4, '2026-05-15 22:00:00', 'Pending'),
(14, 18, '2026-06-01 22:00:00', 'Pending'),
(15, 19, '2026-06-01 22:00:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `category_id`, `title`, `description`, `price`, `image`, `location`, `created_at`) VALUES
(1, 7, 2, 'shoes', 'makes you run fast', 200.00, '1778173909_shoe.png', 'South Africa', '2026-04-30 14:36:59'),
(2, 7, 2, 'cap', 'nice cap to wear on a sunny day', 200.00, '1778173415_cap.png', 'South Africa', '2026-05-01 09:42:01'),
(3, 7, 2, 'Cotten Shirt', 'soft very nice to wear', 300.00, '1778174107_cotten shirt.png', 'South Africa', '2026-05-07 17:15:07'),
(4, 7, 2, 'Blue Jeans', 'nice semi formal jeans', 400.00, '1778174330_jeans.png', 'South Africa', '2026-05-07 17:18:50'),
(5, 7, 2, 'Jacket', 'stay nice and warm', 500.00, '1778175880_jacket.png', 'South Africa', '2026-05-07 17:44:40'),
(6, 13, 2, 'Socks', 'keep your feet warm', 80.00, '1778176561_socks.png', 'South Africa', '2026-05-07 17:56:01'),
(7, 13, 4, 'Blue Honda Accord ', 'Its a hybrid car', 200000.00, '1778224140_car1.png', 'South Africa', '2026-05-08 07:09:00'),
(8, 13, 4, 'Maruti Suzuki Dzire', 'Nice blue car', 150000.00, '1778224498_car2.png', 'South Africa', '2026-05-08 07:14:58'),
(9, 13, 4, 'Red Toyota', 'nice red car', 100000.00, '1778224658_car3.png', 'South Africa', '2026-05-08 07:17:38'),
(10, 13, 3, 'Wooden Table', 'nice wood table', 1000.00, '1778225252_table.png', 'South Africa', '2026-05-08 07:27:32'),
(11, 13, 3, 'Grey couch', 'nice modern couch', 5000.00, '1778225520_couch1.png', 'South Africa', '2026-05-08 07:32:00'),
(12, 13, 3, 'Mirror', 'you can see yourself now', 150.00, '1778225918_mirror.png', 'South Africa', '2026-05-08 07:38:38'),
(13, 13, 1, 'Samsung Charger', 'compatible with all Samsung phones', 20.00, '1778226205_charger.png', 'South Africa', '2026-05-08 07:43:25'),
(14, 4, 2, 'Blue Sports Shoe', 'good for long distance running', 1000.00, '1778942262_shoe2.png', 'South Africa', '2026-05-16 14:37:42'),
(15, 17, 2, 'Brown Leather Jacket', 'good for the winter', 1000.00, '1778951412_jacket2.png', 'South Africa', '2026-05-16 17:10:12'),
(18, 18, 2, 'Red short', 'Very good condition, has only been worn once', 500.00, '1780404087_1780401641_redshirt.png', 'South Africa', '2026-06-02 12:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `user_password`, `role`, `phone`, `created_at`) VALUES
(1, 'luke', 'luke1@gmail.com', '$2y$10$vRdb8.dlLQF11aMXTB5L6.8ROnIyFpTo6.gyGKj0HbCuFcBSoReoW', 'Buyer', '0661233256', '2026-04-28 13:29:07'),
(4, 'luke2', 'luke2@gmail.com', '$2y$10$RhyDDxKxyHF/WfgYOnnck.CK.f48OUkiudo7rtGYERgyGtn0z2meq', 'Seller', 'Redbat12', '2026-04-29 09:17:51'),
(6, 'luke3', 'luke3@gmail.com', '$2y$10$7mjagljLMBZ6.GFc4ZDV1OlawifW7yyp9IxGd8..UvT9br3iAIfEG', 'Admin', '12345678', '2026-04-29 09:31:05'),
(7, 'luke4', 'luke4@gmail.com', '$2y$10$nAerMYrfpwl9TKGKvCyhY.pW2wTy8nK4Wp3aSup08Vq2PsgGe.QT.', 'Seller', '4444444444', '2026-04-30 13:07:34'),
(9, 'luke5', 'luke5@gmail.com', '$2y$10$g59SdVE1GtD5W3PHMt2pFu9g/CWJ/FQwbYrInDlbpMjs4w77AucUC', 'Seller', 'Redbat15', '2026-05-01 09:07:11'),
(10, 'luke6', 'luke6@gmail.com', '$2y$10$P/rrcK2VYLdO7n2cfMu3mO2WJcmGXj577HGl4Su8fby6NoveemMdi', 'Seller', 'Redbat16', '2026-05-01 09:12:27'),
(11, 'luke7', 'luke7@gmail.com', '$2y$10$FrkVnLuJcIg.nOn51QZWZegXUzGu11f1EnkAkLCJfUfMlm.rvKlwS', 'Seller', '1092876321', '2026-05-07 17:46:50'),
(13, 'luke8', 'luke8@gmail.com', '$2y$10$GYgUKumVqp7HQxhm3ta5muRs6YEEfUBksoT3UbcsiYG0.eWO3Hyjq', 'Seller', '345678901', '2026-05-07 17:52:38'),
(14, 'luke9', 'luke9@gmail.com', '$2y$10$5WlpEoWhlDosnfZWJcTk4uMBrPH9LQ8O5lOagDKhabr2Y/scJnAjO', 'Buyer', '127452521', '2026-05-14 07:33:02'),
(15, 'luke10', 'luke10@gmail.com', '$2y$10$H3gDvOeXE7SFunoOjFC8lubWIl79vRysh2is8Qik48SZveMHNOTHm', 'Buyer', '0771271819', '2026-05-16 10:45:43'),
(16, 'luke11', 'luke11@gmail.com', '$2y$10$IC.9AtMu8AWyeyT8xFFROe35ln1AFf3w3TdJOr12aSvEMPoQNZ8Au', 'Seller', '0771271817', '2026-05-16 10:48:01'),
(17, 'luke12', 'luke12@gmail.com', '$2y$10$G8ThyxDZZ8i/nWgM7hsM2eT8Q4FiXDKUzk6keDpxxagfYFBGF/7YC', 'Seller', '0661281819', '2026-05-16 17:05:14'),
(18, 'luke13', 'luke13@gmail.com', '$2y$10$ZbEpgVoVg99b6e9d1utnp.HpmrOD3Lsa0uYEvZUx7d86GmCwaO3dS', 'Seller', '0661271919', '2026-06-02 11:33:58'),
(19, 'luke14', 'luke14@gmail.com', '$2y$10$HpP4s7PkFEfc3sBlUsfBOuSZfAT9yyJBNxUOjt.EwM7VaGgNTX0S2', 'Seller', '0881891918', '2026-06-02 12:44:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
