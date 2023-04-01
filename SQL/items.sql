-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 01:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isp`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_id` varchar(100) NOT NULL,
  `item` varchar(100) NOT NULL,
  `item_desc` varchar(200) DEFAULT NULL,
  `item_img` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `category` varchar(100) NOT NULL,
  `flag` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_id`, `item`, `item_desc`, `item_img`, `price`, `category`, `flag`) VALUES
(1, 'kiwi', 'Kiwi', 'A fresh and tasty fruit.', 'image1.png', 1.29, 'food', 1),
(2, 'strawberry', 'Strawberry', 'A pound of strawberries.', 'image2.png', 1.49, 'food', 1),
(3, 'banana', 'Banana', 'A yellow tasty fruit.', 'image3.png', 0.5, 'food', 0),
(4, 'shirt', 'Shirt', 'A simple red shirt.', 'image4.png', 19.99, 'clothing', 1),
(5, 'dictionary', 'Dictionary', 'Has all the definitions you could ever need.', 'image5.png', 15, 'books', NULL),
(6, 'playstation4_controller', 'PS4 Controller', 'A controller for the Playstation 4.', 'image6.png', 60, 'electronics', NULL),
(7, 'nintendo_switch', 'Nintendo Switch', 'A gaming console made by Nintendo.', 'image7.png', 299.99, 'electronics', 1),
(8, 'pants', 'Pants', 'A pair of black pants.', 'image8.png', 19.99, 'clothing', NULL),
(9, 'television_32_TCL', 'TV', 'A 32 inch TCL television.', 'image9.png', 169.99, 'electronics', NULL),
(10, 'playstation4', 'Playstation 4', 'A gaming console made by Sony.', 'image10.png', 200, 'electronics', NULL),
(11, 'playstation5', 'Playstation 5', 'A gaming console made by Sony.', 'image11.png', 700, 'electronics', 1),
(12, 'playstation5_controller', 'PS5 Controller', 'A controller made for the Playstation 5.', 'image12.png', 70, 'electronics', NULL),
(13, 'pretzals', 'Pretzals', 'A bag of salty pretzels.', 'image13.png', 3, 'food', NULL),
(14, 'fritos', 'Fritos', 'A bag of regular fritos.', 'image14.png', 4, 'food', NULL),
(15, 'mountain_dew', 'Mountain Dew', 'A 24 pack of Mountain Dew.', 'image15.png', 8, 'food', 0),
(16, 'pepsi', 'Pepsi', 'A can of Pepsi.', 'image16.png', 0.99, 'food', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_id` (`item_id`),
  ADD UNIQUE KEY `item` (`item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
