-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 07:27 PM
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
-- Database: `busify_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_signup`
--

CREATE TABLE `admin_signup` (
  `id` int(25) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `cpassword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_signup`
--

INSERT INTO `admin_signup` (`id`, `fname`, `lname`, `phone`, `email`, `password`, `cpassword`) VALUES
(0, 'omar', 'khaled', '01002020455', 'omar@gmail.com', '$2y$10$8aZyD9K0HKvmzfImp1/Z4.gEyYLPBUp3OPp3ufOVxm0l5fBDmsj4e', '');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(25) NOT NULL,
  `bus_number` varchar(25) NOT NULL,
  `source` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `time` time(5) NOT NULL,
  `date` date NOT NULL,
  `price` varchar(50) NOT NULL,
  `available_seats` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `bus_number` varchar(20) NOT NULL,
  `bus_model` varchar(50) NOT NULL,
  `bus_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone_number`, `bus_number`, `bus_model`, `bus_capacity`) VALUES
(1, 'omar khaled', '01002020455', '1', '11', 12);

-- --------------------------------------------------------

--
-- Table structure for table `driver_signup`
--

CREATE TABLE `driver_signup` (
  `id` int(25) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `nic` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dstfrom` varchar(50) NOT NULL,
  `dstto` varchar(50) NOT NULL,
  `routeno` varchar(50) NOT NULL,
  `busmodel` varchar(50) NOT NULL,
  `busno` varchar(50) NOT NULL,
  `buscolor` varchar(50) NOT NULL,
  `buscapacity` varchar(50) NOT NULL,
  `servicetype` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_signup`
--

INSERT INTO `driver_signup` (`id`, `fname`, `lname`, `phone`, `nic`, `email`, `dstfrom`, `dstto`, `routeno`, `busmodel`, `busno`, `buscolor`, `buscapacity`, `servicetype`, `password`) VALUES
(2, 'omar', 'khaled', '01002020455', '', '', '', '', '', '1', '1', '', 'suez', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `feedback_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `passenger_id`, `feedback_text`, `created_at`) VALUES
(1, 1, '11', '2025-01-05 18:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_signup`
--

CREATE TABLE `passenger_signup` (
  `id` int(25) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `cpassword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger_signup`
--

INSERT INTO `passenger_signup` (`id`, `fname`, `lname`, `phone`, `email`, `password`, `cpassword`) VALUES
(1, 'mohamed', 'yasser', '01018102203', 'mohamedabdelhammed2001@gmail.com', '$2y$10$/SWy13asH35WtwnxpCu0ReT6NL5EvKwR3CjhPAmeQwwLy5oXu0VL6', '$2y$10$nHlwZh67sXc92YQBYwPWyu/H7Hgu2QS2c.XJUID1eVMQLTWoZl0ly'),
(2, 'omar', 'khaled', '01002020455', 'omarkhaled202080@gmail.com', '$2y$10$k57CUybwhkaAt2I/DWG.7uWCaxYWp75TqJUQFjn86CO9PnB6DioGG', '$2y$10$k57CUybwhkaAt2I/DWG.7uWCaxYWp75TqJUQFjn86CO9PnB6DioGG');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `date`, `time`, `source`, `destination`, `price`, `driver_id`) VALUES
(1, '0000-00-00', '00:00:01', '1', '1', 1.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `bus_number` (`bus_number`);

--
-- Indexes for table `driver_signup`
--
ALTER TABLE `driver_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- Indexes for table `passenger_signup`
--
ALTER TABLE `passenger_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `driver_signup`
--
ALTER TABLE `driver_signup`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `passenger_signup`
--
ALTER TABLE `passenger_signup`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`passenger_id`) REFERENCES `passenger_signup` (`id`);

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
