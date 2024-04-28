-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2024 at 03:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(6) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `name`, `image`, `quantity`, `price`) VALUES
(4, 'Tomato', 'images/tomato.jpg', 1, 12.00),
(5, 'Pumpkin', 'images/pumpkin.jpg', 2, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `quantity` int(6) NOT NULL,
  `color` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `count` int(5) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `subcategory`, `quantity`, `color`, `price`, `count`, `image`) VALUES
(1, 'Potato', 'Root Vegetables', 'Potato', 100, 'Brown', 5.50, 500, 'images/potato.jpg'),
(2, 'Beetroot', 'Root Vegetables', 'Beetroot', 100, 'Red', 8.00, 300, 'images/beetroot.jpg'),
(3, 'Tomato', 'Fruits', 'Tomato', 15, 'Red', 12.00, 300, 'images/tomato.jpg'),
(4, 'Pumpkin', 'Fruits', 'Pumpkin', 30, 'Orange', 10.00, 700, 'images/pumpkin.jpg'),
(5, 'Garlic', 'Allium Vegetables', 'Garlic', 60, 'White', 30.99, 200, 'images/garlic.jpg'),
(6, 'Ginger', 'Allium Vegetables', 'Ginger', 50, 'Beige', 200.00, 400, 'images/ginger.jpg'),
(7, 'Carrot', 'Root Vegetables', 'Carrot', 150, 'Orange', 3.00, 600, 'images/carrots.jpg'),
(8, 'Okra', 'Root Vegetables', 'Okra', 34, 'Green', 35.00, 800, 'images/okra.jpg'),
(9, 'Capsicum', 'Fruits', 'Capsicum', 22, 'Green', 19.99, 900, 'images/capsicum.jpg'),
(10, 'Bell Pepper', 'Fruits', 'Bell Pepper', 22, 'Red', 15.99, 600, 'images/bellpepper.jpg'),
(11, 'Cucumber', 'Fruits', 'Cucumber', 75, 'Green', 4.20, 400, 'images/cucumber.jpg'),
(12, 'Beans', 'Legumes', 'Green Beans', 18, 'Green', 7.99, 1000, 'images/beans.jpg'),
(13, 'Zucchini', 'Fruits', 'Zucchini', 85, 'Green', 4.99, 1200, 'images/zucchini.jpg'),
(14, 'Onion', 'Allium Vegetables', 'Onion', 110, 'Yellow', 3.49, 1100, 'images/onion.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
