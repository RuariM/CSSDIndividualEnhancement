-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2021 at 11:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cssd`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `need` text NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `firstname`, `lastname`, `email`, `need`, `message`) VALUES
(4, 'Some', 'Body', 'somebody@something.com', 'General Enquiry', 'A test message to show it works!'),
(5, 'john', 'smith', 'john@smith.com', 'Request copy of an invoice', 'I would like an invoice.');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `name`, `price`) VALUES
(0, 'Smart Energy meter', 50),
(1, 'Gas meter', 30),
(2, 'Gas regulator', 10),
(3, 'Basic energy meter', 20),
(4, 'Solar meter', 75);

-- --------------------------------------------------------

--
-- Table structure for table `orderlines`
--

CREATE TABLE `orderlines` (
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `lineID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderlines`
--

INSERT INTO `orderlines` (`orderID`, `itemID`, `quantity`, `lineID`) VALUES
(152, 1, 2, 314),
(152, 2, 2, 315),
(153, 0, 1, 316),
(153, 1, 1, 317),
(153, 2, 1, 318),
(153, 3, 2, 319),
(153, 4, 4, 320),
(154, 0, 2, 321),
(154, 3, 1, 322);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `address` text NOT NULL,
  `status` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userID`, `date`, `address`, `status`, `total`, `location`) VALUES
(152, 1, '2021-03-15 19:37:49', 'qqq', 0, 80, 'Bedfordshire'),
(153, 1, '2021-03-15 19:37:55', 'qqqq', 0, 430, 'Durham'),
(154, 1, '2021-03-15 21:58:18', '1 test road', 0, 120, 'Berkshire');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `residents` int(11) NOT NULL,
  `location` text NOT NULL,
  `notes` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `price` double NOT NULL,
  `status` int(1) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT 0,
  `utilityType` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `userID`, `rooms`, `residents`, `location`, `notes`, `date`, `price`, `status`, `complete`, `utilityType`) VALUES
(76, 1, 3, 5, 'Berkshire', 'My house is well insulated', '2021-03-12 16:14:58', 70.3555, 1, 0, 'Gas'),
(94, 1, 50, 20, 'Berkshire', 'My house is well insulated', '2021-03-13 18:03:34', 0, 0, 0, 'Gas'),
(97, 1, 50, 20, 'Berkshire', 'My house is well insulated', '2021-03-13 18:55:25', 0, 0, 0, 'Gas'),
(98, 1, 1, 1, 'Berkshire', 'My house is well insulated', '2021-03-13 18:58:21', 8.89, 1, 0, 'Gas'),
(99, 1, 14, 7, 'East Riding of Yorkshire', '', '2021-03-15 22:04:37', 0, 0, 0, 'Energy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `quotes` text NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `quotes`, `isAdmin`) VALUES
(1, '123', '202cb962ac59075b964b07152d234b70', 'Testing McTest', '', 0),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `orderlines`
--
ALTER TABLE `orderlines`
  ADD PRIMARY KEY (`lineID`),
  ADD KEY `orderLineLink` (`orderID`),
  ADD KEY `itemLineLink` (`itemID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orderlines`
--
ALTER TABLE `orderlines`
  MODIFY `lineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderlines`
--
ALTER TABLE `orderlines`
  ADD CONSTRAINT `itemLineLink` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderLineLink` FOREIGN KEY (`orderID`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
