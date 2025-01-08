
CREATE DATABASE busify_db;
USE busify_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Table structure for table `admin_signup`
--

CREATE TABLE `admin_signup` (
  `id` int(10) NOT NULL,
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
(1, 'mohamed', 'yasser', '01018102203', 'mohamed@gmail.com', '$2y$10$fw6lpzOOhAaox4eisf6DyOIQSfIXH2.iAFBqpycDv5ehBUNl/TVni', '$2y$10$dKyBQ2B2Iw17mWahQ2M9uOM4XuMKMCkWw0ZGT7NwfL5wJREmaN80y'),
(2, 'Omar', 'Khaled', '101844453', 'omar@gmail.com', '$2y$10$NdUBgeuonevidq6xA4gOduOY8O/akl6j5YPE4O0GZ1tJv4HuW2G4m', '$2y$10$65hVhJ7w/k0gS6x5i59ZheCXvrt5Zp4x6PkVfBvIyarifvujatCJO');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(25) NOT NULL,
  `bus_number` varchar(25) NOT NULL,
  `bus_model` varchar(50) NOT NULL,
  `bus_color` varchar(50) NOT NULL,
  `bus_capacity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_number`, `bus_model`, `bus_color`, `bus_capacity`) VALUES
(1, '500', 'mercedes', 'black', '30'),
(2, '590', 'Volvo', 'black', '13'),
(3, '90', 'MCV', 'white', '50');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `bus_number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `fname`, `lname`, `phone_number`, `bus_number`, `email`, `address`) VALUES
(1, 'mohamed', 'yasser', '01018102203', '500', 'mohamed2001@gmail.com', 'fifth settlement'),
(2, 'Omar', 'khaled', '01019027', '590', 'omarkhaled@gmail.com', 'suez'),
(3, 'philo', 'herz', '01019027', '90', 'filo@gmail.com', 'ramses');

-- --------------------------------------------------------

--
-- Table structure for table `driver_signup`
--

CREATE TABLE `driver_signup` (
  `id` int(25) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `bus_number` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_signup`
--

INSERT INTO `driver_signup` (`id`, `fname`, `lname`, `email`, `bus_number`, `password`, `cpassword`) VALUES
(1, 'mohamed', 'yasser', 'mohamed2001@gmail.com', '500', '$2y$10$AawfzvlFeq5aenFgQy2keOoDd36o2GzJHWW6d619UIR', '$2y$10$hhB/SAdgUeXwMo6SQSscZ.JAX2iTBUsC9EgFwHeJuwWnzQzpu//oe'),
(2, 'Omar', 'khaled', 'omarkhaled@gmail.com', '590', '$2y$10$UKLN8N0QCZ/0RVn8PobbZOPtmrQUUfiwSyWM8LB9DxR', '$2y$10$p7lo/5eNEWfKWtm5XOq38eNY57idiV36gfOqdIERkJT4AEZjg/vwe'),
(3, 'philo', 'herz', 'filo@gmail.com', '90', '$2y$10$ffQUkMgBpOE1Hd8gWU0CcOeCN6YsUonm9wyULhaKU1/', '$2y$10$i2dqjOSpMXtm/P//zCGUkOdwRSjSXK/0Y5j0zIHMz6mmGvozHr0Cq');

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
(1, 1, '11', '2025-01-05 18:11:32'),
(4, 1, 'ghvhgvhgfhg', '2025-01-05 20:16:01');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_signup`
--

CREATE TABLE `passenger_signup` (
  `passenger_id` int(25) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger_signup`
--

INSERT INTO `passenger_signup` (`passenger_id`, `fname`, `lname`, `phone`, `email`, `password`, `cpassword`) VALUES
(1, 'mohamed', 'yasser', '01018102203', 'mohamedabdelhammed2001@gmail.com', '$2y$10$8IFMHxxAtTA8MfLR3suOee25rwOmLuyh1f34l3j9E9Ngjzo0zy2Yi', '$2y$10$fGHeDz1krblAMChZKe2GveihsOk0mlJ6rKjAV4LEWnyV1JoJkD9U2'),
(2, 'Omar', 'Khaled', '101844453', 'omar7@gmail.com', '$2y$10$WuOGv0Sytass9gNi.wr.LuRGuSAI83sWe3xJDGtrGOFzyzF5v1AlC', '$2y$10$HNXVo5o48dlj2GdkpfhjBeFhCOyC/.p5MUqD309NTmiK2A4hWLLYG');

-- --------------------------------------------------------

--
-- Table structure for table `reserved`
--

CREATE TABLE `reserved` (
  `id` int(10) NOT NULL,
  `trip_id` int(10) NOT NULL,
  `passenger_id` int(10) NOT NULL,
  `bus_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserved`
--

INSERT INTO `reserved` (`id`, `trip_id`, `passenger_id`, `bus_number`) VALUES
(2, 7, 1, 590),
(4, 6, 2, 500);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `trip_id` int(10) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `bus_number` int(11) NOT NULL,
  `available_seats` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`trip_id`, `date`, `time`, `source`, `destination`, `price`, `bus_number`, `available_seats`) VALUES
(6, '2025-01-10', '05:42:00', 'cairo', 'sharm', 500.00, 500, 29),
(7, '2025-01-15', '03:43:00', 'cairo', 'suez', 150.00, 590, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_signup`
--
ALTER TABLE `admin_signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`passenger_id`);

--
-- Indexes for table `reserved`
--
ALTER TABLE `reserved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`trip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_signup`
--
ALTER TABLE `admin_signup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_signup`
--
ALTER TABLE `driver_signup`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passenger_signup`
--
ALTER TABLE `passenger_signup`
  MODIFY `passenger_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reserved`
--
ALTER TABLE `reserved`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `trip_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`bus_number`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;
COMMIT;
ALTER TABLE `trips`
ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`bus_number`) REFERENCES `buses` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
