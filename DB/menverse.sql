-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 20, 2023 at 04:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abc_plt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `UId` int(11) NOT NULL,
  `PId` int(20) NOT NULL,
  `cID` int(11) NOT NULL,
  `Quantity` int(255) NOT NULL DEFAULT 1,
  `Total` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`UId`, `PId`, `cID`, `Quantity`, `Total`) VALUES
(13, 44, 117, 1, 0),
(13, 56, 118, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cId` int(20) NOT NULL,
  `cName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cId`, `cName`) VALUES
(1, 'Long Sleeves'),
(2, 'Sport Tshirts'),
(3, 'Polo Tshirts'),
(4, 'CrewNeck Tshirts'),
(5, 'Shorts');

-- --------------------------------------------------------

--
-- Table structure for table `normal_admin`
--

CREATE TABLE `normal_admin` (
  `aId` int(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `number` int(20) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `normal_admin`
--

INSERT INTO `normal_admin` (`aId`, `name`, `email`, `number`, `password`) VALUES
(1, 'Januda', 'desilvabethmin@gmail.com', 777772229, 'd00f5d5217896fb7fd601412cb890830'),
(3, 'Imesha Sewmini', 'imeshasewmini@gmail.com', 777493538, 'd00f5d5217896fb7fd601412cb890830');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oId` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` int(20) NOT NULL,
  `postal` int(20) NOT NULL,
  `addline1` varchar(255) NOT NULL,
  `addline2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `method` varchar(20) NOT NULL,
  `quantity` int(255) NOT NULL,
  `total` int(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Cancelled',
  `uId` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oId`, `name`, `email`, `number`, `postal`, `addline1`, `addline2`, `city`, `method`, `quantity`, `total`, `status`, `uId`, `datetime`) VALUES
(28, 'E. D. Thevindu Kevin Apsara', 'thevindukevin@gmail.com', 777772231, 11300, 'No.111,', 'Sangaraja Mawatha, Hunupitiya, Wattala', 'Wattala', 'Card', 12, 12000, 'Successfull', 12, '2023-12-20 08:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `pId` int(20) NOT NULL,
  `pName` varchar(225) NOT NULL,
  `pPrice` int(255) NOT NULL,
  `pQuantity` int(20) NOT NULL,
  `pDescription` varchar(225) NOT NULL,
  `pImg` varchar(225) NOT NULL,
  `cId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`pId`, `pName`, `pPrice`, `pQuantity`, `pDescription`, `pImg`, `cId`) VALUES
(43, 'Black Long Sleeve TShirt', 1000, 17, 'Material : 65/35 Cotton Heather. Softened. Thickness : 180 GSM Size Range : S – XXL', 'Raven-Black-Mens-Long-Sleeve-T-Shirt .png', 1),
(44, 'Black Sports Tshirt', 1000, 0, ' Material : Dri-Fit – 95% Polyester Microfiber, 5% Spandex Thickness : 150 – 160 GSM Size Range : XS – XXL', 'Jet-Black-Sports-T-Shirt.png', 2),
(45, 'Black Polo Tshirt', 1000, 18, ' Material : 65/35 Cotton. Softened. Thickness : 180 GSM Size Range : S – XL', 'Raven-Black-Mens-Polo-T-Shirt.png', 3),
(46, 'Black Shorts', 1000, 16, 'Material : 65/35 Cotton Pique Knit Thickness : 220 GSM Size Range : XS – XXL', 'Raven-Black-Mens-Casual-Short.png', 5),
(47, 'Blue Long Sleeve Tshirt', 1000, 15, 'Material : 65/35 Cotton Heather. Softened. Thickness : 180 GSM Size Range : S – XXL', 'Navy-Blue-Mens-Long-Sleeve-T-Shirt.png', 1),
(48, 'Blue Sports Tshirt', 1000, 20, 'Material : Dri-Fit – 95% Polyester Microfiber, 5% Spandex Thickness : 150 – 160 GSM Size Range : XS – XXL', 'Navy-Blue-Sports-T-Shirt.png', 2),
(49, 'Blue Polo Tshirt', 1000, 0, ' Material : 65/35 Cotton. Softened. Thickness : 180 GSM Size Range : S – XL', 'Navy-Blue-Mens-Polo-T-Shirt.png', 3),
(50, 'Blue Shorts', 1000, 19, 'Material : 65/35 Cotton Pique Knit Thickness : 220 GSM Size Range : XS – XXL', 'Navy-Blue-Mens-Casual-Short.png', 5),
(51, 'Dark Grey Long Sleeve Tshirt', 1000, 19, 'Material : 65/35 Cotton Heather. Softened. Thickness : 180 GSM Size Range : S – XXL', 'Charcoal-Grey-Mens-Long-Sleeve-T-Shirt.png', 1),
(52, 'Dark Grey Sports Tshirt', 1000, 16, 'Material : Dri-Fit – 95% Polyester Microfiber, 5% Spandex Thickness : 150 – 160 GSM Size Range : XS – XXL', 'Steel-Grey-Sports-T-Shirt.png', 2),
(53, 'Dark Grey Polo Tshirt', 1000, 0, ' Material : 65/35 Cotton. Softened. Thickness : 180 GSM Size Range : S – XL', 'Charcoal-Grey-Mens-Polo-T-Shirt.png', 3),
(54, 'Dark Grey Shorts', 1000, 19, 'Material : 65/35 Cotton Pique Knit Thickness : 220 GSM Size Range : XS – XXL', 'Charcoal-Grey-Mens-Casual-Short.png', 5),
(55, 'Grey Longs Sleeve Tshirt', 1000, 20, 'Material : 65/35 Cotton Heather. Softened. Thickness : 180 GSM Size Range : S – XXL', 'Grey-Marl-Mens-Long-Sleeve-T-Shirt.png', 1),
(56, 'Grey Sports Tshirt', 1000, 16, '  Material : Dri-Fit – 95% Polyester Microfiber, 5% Spandex Thickness : 150 – 160 GSM Size Range : XS – XXL', 'Cloud-Grey-Sports-T-Shirt.png', 2),
(57, 'Grey Polo Tshirt', 1000, 12, 'Material : 65/35 Cotton. Softened. Thickness : 180 GSM Size Range : S – XL', 'Grey-Marl-Mens-Polo-T-Shirt.png', 3),
(58, 'Grey Shorts', 1000, 0, ' Material : 65/35 Cotton Pique Knit Thickness : 220 GSM Size Range : XS – XXL', 'Grey-Marl-Mens-Casual-Short.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `sId` int(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `number` int(20) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`sId`, `name`, `email`, `number`, `password`) VALUES
(1, 'Januda', 'desilvabethmin@gmail.com', 777772229, 'd00f5d5217896fb7fd601412cb890830');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `uId` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `number` int(20) NOT NULL,
  `epassword` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`uId`, `name`, `email`, `number`, `epassword`) VALUES
(1, 'Januda', 'desilvabethmin@gmail.com', 777772229, 'd00f5d5217896fb7fd601412cb890830'),
(12, 'Thevindu Kevin', 'thevindukevin@gmail.com', 777345324, 'd00f5d5217896fb7fd601412cb890830'),
(13, 'Imesha Sewmini', 'imeshasewmini@gmail.com', 777493538, 'd00f5d5217896fb7fd601412cb890830');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `UId` int(11) NOT NULL,
  `PId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`UId`, `PId`) VALUES
(13, 57),
(13, 58);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cId`);

--
-- Indexes for table `normal_admin`
--
ALTER TABLE `normal_admin`
  ADD PRIMARY KEY (`aId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oId`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`pId`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`sId`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`uId`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`UId`,`PId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `normal_admin`
--
ALTER TABLE `normal_admin`
  MODIFY `aId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `pId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `sId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `uId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
