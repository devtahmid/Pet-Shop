-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2023 at 04:26 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `ID` int(11) NOT NULL,
  `SERVICES_SLOTS_ID` int(11) NOT NULL,
  `BOOKING_DATE` date NOT NULL,
  `BOOKING_DATETIME` datetime NOT NULL,
  `SERVICES_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`ID`, `SERVICES_SLOTS_ID`, `BOOKING_DATE`, `BOOKING_DATETIME`, `SERVICES_ID`) VALUES
(1, 16, '2023-01-05', '0000-00-00 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(259) NOT NULL,
  `PRICE` double NOT NULL,
  `RATING` double NOT NULL,
  `PICTURE` varchar(250) NOT NULL,
  `SERVICE_ACTIVE` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ID`, `NAME`, `PRICE`, `RATING`, `PICTURE`, `SERVICE_ACTIVE`) VALUES
(1, 'nail trimming', 5, 0, 'cat_food.png', 1),
(2, 'grooming', 10, 0, 'product_01.png', 1),
(3, 'body wash', 5, 0, 'product_02.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services_slots`
--

CREATE TABLE `services_slots` (
  `ID` int(11) NOT NULL,
  `SERVICES_ID` int(11) NOT NULL,
  `TIME_SLOT_START` time NOT NULL,
  `TIME_SLOT_END` time NOT NULL,
  `SUNDAY` tinyint(1) NOT NULL,
  `MONDAY` tinyint(1) NOT NULL,
  `TUESDAY` tinyint(1) NOT NULL,
  `WEDNESDAY` tinyint(1) NOT NULL,
  `THURSDAY` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_slots`
--

INSERT INTO `services_slots` (`ID`, `SERVICES_ID`, `TIME_SLOT_START`, `TIME_SLOT_END`, `SUNDAY`, `MONDAY`, `TUESDAY`, `WEDNESDAY`, `THURSDAY`) VALUES
(1, 1, '08:00:00', '09:00:00', 1, 1, 1, 1, 1),
(2, 1, '09:00:00', '10:00:00', 1, 1, 1, 0, 1),
(3, 1, '12:00:00', '13:00:00', 1, 1, 0, 1, 1),
(4, 1, '13:00:00', '14:00:00', 1, 0, 0, 0, 0),
(11, 2, '09:00:00', '10:00:00', 1, 1, 0, 0, 0),
(12, 2, '10:00:00', '11:00:00', 1, 0, 1, 0, 1),
(13, 2, '12:00:00', '13:00:00', 0, 0, 1, 1, 1),
(14, 2, '13:00:00', '14:00:00', 0, 0, 0, 1, 1),
(15, 2, '14:00:00', '15:00:00', 1, 1, 0, 0, 1),
(16, 2, '17:00:00', '18:00:00', 0, 0, 0, 0, 1),
(17, 3, '13:00:00', '14:00:00', 1, 1, 1, 1, 1),
(18, 3, '14:00:00', '15:00:00', 1, 1, 1, 1, 1),
(19, 3, '15:00:00', '16:00:00', 1, 1, 1, 0, 0),
(20, 3, '16:00:00', '17:00:00', 1, 1, 0, 0, 0),
(21, 3, '17:00:00', '18:00:00', 1, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `EMAIL` varchar(60) NOT NULL,
  `PASSWORD` varchar(60) NOT NULL,
  `PHONE` varchar(11) NOT NULL,
  `TYPE` varchar(10) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `NAME`, `EMAIL`, `PASSWORD`, `PHONE`, `TYPE`) VALUES
(1, 'Admin', 'admin@petshop.com', 'Admin1', '38888888', 'admin'),
(2, 'User1', 'user1@petshop.com', 'User1111', '33333333', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `foreignkey_services_slots_bookings` (`SERVICES_SLOTS_ID`),
  ADD KEY `SERVICES_ID` (`SERVICES_ID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `services_slots`
--
ALTER TABLE `services_slots`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `foreignkey_services_services_slots` (`SERVICES_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services_slots`
--
ALTER TABLE `services_slots`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `foreignkey_services_bookings` FOREIGN KEY (`SERVICES_ID`) REFERENCES `services` (`ID`),
  ADD CONSTRAINT `foreignkey_services_slots_bookings` FOREIGN KEY (`SERVICES_SLOTS_ID`) REFERENCES `services_slots` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `services_slots`
--
ALTER TABLE `services_slots`
  ADD CONSTRAINT `foreignkey_services_services_slots` FOREIGN KEY (`SERVICES_ID`) REFERENCES `services` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
