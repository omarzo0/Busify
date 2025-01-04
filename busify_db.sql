-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 07:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
CREATE DATABASE busify_db;
USE busify_db;

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

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_number`, `source`, `destination`, `time`, `date`, `price`, `available_seats`) VALUES
(1, '500', 'cairo', 'alexandria', '05:00:00.00000', '0000-00-00', '100', '29');

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

-- Table structure for table `admin_signup`
--

CREATE TABLE `admin_signup` (
    `id` INT(25) NOT NULL AUTO_INCREMENT,
    `fname` VARCHAR(50) NOT NULL,
    `lname` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL UNIQUE,
    `password` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Create the drivers table

-- Create the trips table
CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    time TIME NOT NULL,
    source VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    driver_id INT NOT NULL,
    FOREIGN KEY (driver_id) REFERENCES drivers(id) ON DELETE CASCADE
);
INSERT INTO `passenger_signup` (`id`, `fname`, `lname`, `phone`, `email`, `password`, `cpassword`) VALUES
(1, 'mohamed', 'yasser', '01018102203', 'mohamedabdelhammed2001@gmail.com', '$2y$10$/SWy13asH35WtwnxpCu0ReT6NL5EvKwR3CjhPAmeQwwLy5oXu0VL6', '$2y$10$nHlwZh67sXc92YQBYwPWyu/H7Hgu2QS2c.XJUID1eVMQLTWoZl0ly');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_signup`
--
ALTER TABLE `driver_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger_signup`
--
ALTER TABLE `passenger_signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `driver_signup`
--
ALTER TABLE `driver_signup`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passenger_signup`
--
ALTER TABLE `passenger_signup`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
