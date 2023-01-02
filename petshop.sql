-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2023 at 07:39 PM
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
  `SERVICES_ID` int(11) DEFAULT NULL,
  `USER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`ID`, `SERVICES_SLOTS_ID`, `BOOKING_DATE`, `BOOKING_DATETIME`, `SERVICES_ID`, `USER_ID`) VALUES
(1, 16, '2023-01-05', '0000-00-00 00:00:00', 2, 2),
(9, 39, '2023-01-01', '0000-00-00 00:00:00', 18, 2),
(10, 19, '2023-01-09', '0000-00-00 00:00:00', 3, 2),
(11, 40, '2023-01-03', '0000-00-00 00:00:00', 18, 4),
(12, 1, '2023-01-04', '0000-00-00 00:00:00', 1, 4),
(13, 18, '2023-01-05', '0000-00-00 00:00:00', 3, 4),
(14, 3, '2022-12-29', '0000-00-00 00:00:00', 1, 4),
(15, 2, '2022-12-28', '0000-00-00 00:00:00', 1, 4),
(16, 14, '2022-11-23', '0000-00-00 00:00:00', 2, 4),
(17, 47, '2023-01-01', '0000-00-00 00:00:00', 21, 5),
(18, 47, '2023-01-01', '0000-00-00 00:00:00', 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `ID` int(11) NOT NULL,
  `SERVICE_ID` int(11) NOT NULL,
  `RATING` decimal(10,0) NOT NULL DEFAULT 0,
  `REVIEW` varchar(200) NOT NULL,
  `BOOKING_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`ID`, `SERVICE_ID`, `RATING`, `REVIEW`, `BOOKING_ID`) VALUES
(3, 18, '4', 'sample feedback 1', 9),
(4, 18, '5', 'sample feedback 2', 9),
(5, 18, '1', 'sample feedback 4', 9),
(6, 1, '3', 'amazing', 14),
(7, 21, '5', 'shampoo bath was good', 17),
(8, 21, '1', 'bad', 18);

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
(1, 'Nail Trimming', 5, 0, 'cat_nail.webp', 1),
(2, 'Pet Grooming', 10, 0, 'Pet_Grooming.png', 1),
(3, 'Pet Shower', 5, 0, 'cat_shower.jpg', 1),
(4, 'Pet Ear Cleaning', 5, 0, 'pet_ear_cleaning.png', 1),
(5, 'Pet X-Ray', 15, 3, 'pet_xray.jpg', 1),
(18, 'Dental Scaling', 4, 4.5, 'Dental_scaling.png', 1),
(20, 'Pet Vaccine', 12.5, 0, 'img167263479087690364563b261a609e85.jpg', 1),
(21, 'shampoo bath', 2.5, 0, 'img16726816702757808663b318c6e486d.jpg', 0);

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
(21, 3, '17:00:00', '18:00:00', 1, 0, 0, 1, 1),
(39, 18, '12:30:00', '01:00:00', 1, 1, 1, 1, 0),
(40, 18, '15:00:00', '16:00:00', 1, 1, 1, 1, 0),
(41, 18, '16:30:00', '17:30:00', 1, 0, 1, 1, 0),
(45, 20, '09:45:00', '10:45:00', 0, 1, 0, 1, 0),
(46, 21, '11:00:00', '12:00:00', 1, 1, 0, 1, 0),
(47, 21, '12:30:00', '14:30:00', 1, 1, 1, 1, 0),
(48, 21, '16:00:00', '17:00:00', 1, 1, 0, 0, 0);

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
  `TYPE` varchar(10) NOT NULL DEFAULT 'customer',
  `PROFILE_PIC` varchar(200) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `NAME`, `EMAIL`, `PASSWORD`, `PHONE`, `TYPE`, `PROFILE_PIC`) VALUES
(1, 'Admin', 'admin@petshop.com', 'Admin1', '38888888', 'admin', 'default.jpg'),
(2, 'user one one', 'user11@petshop.com', 'User1111', '33333334', 'customer', 'picpfp21672682350201134506363b31b6eb9fa9.png'),
(3, 'user two', 'user2@petshop.com', 'user2U', '38888888', 'customer', 'default.jpg'),
(4, 'Ahmed', 'joyone1187@vpsrec.com', 'Ahmed1', '34455445', 'customer', 'default.jpg'),
(5, 'tony stark', 'tonystark@avengers.com', 'aaaaaa1Q', '38393233', 'customer', 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `foreignkey_services_slots_bookings` (`SERVICES_SLOTS_ID`),
  ADD KEY `SERVICES_ID` (`SERVICES_ID`),
  ADD KEY `foreignkey_services_booking` (`USER_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `foreignkey_feedback_services` (`SERVICE_ID`),
  ADD KEY `foreignkey_feedback_bookings` (`BOOKING_ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `services_slots`
--
ALTER TABLE `services_slots`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `foreignkey_services_booking` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `foreignkey_services_bookings` FOREIGN KEY (`SERVICES_ID`) REFERENCES `services` (`ID`),
  ADD CONSTRAINT `foreignkey_services_slots_bookings` FOREIGN KEY (`SERVICES_SLOTS_ID`) REFERENCES `services_slots` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `foreignkey_feedback_bookings` FOREIGN KEY (`BOOKING_ID`) REFERENCES `bookings` (`ID`),
  ADD CONSTRAINT `foreignkey_feedback_services` FOREIGN KEY (`SERVICE_ID`) REFERENCES `services` (`ID`);

--
-- Constraints for table `services_slots`
--
ALTER TABLE `services_slots`
  ADD CONSTRAINT `foreignkey_services_services_slots` FOREIGN KEY (`SERVICES_ID`) REFERENCES `services` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
