-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2026 at 01:51 PM
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
-- Database: `crime_analysis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `crime_records`
--

CREATE TABLE `crime_records` (
  `id` int(11) NOT NULL,
  `crime_type` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `crime_date` date NOT NULL,
  `severity` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crime_records`
--

INSERT INTO `crime_records` (`id`, `crime_type`, `location`, `crime_date`, `severity`, `description`) VALUES
(1, 'Theft', 'Vashi', '2026-08-05', 'Medium', 'Theft reported in a crowded area.'),
(2, 'Robbery', 'Nerul', '2026-08-07', 'High', 'Robbery case reported in the evening.'),
(3, 'Cyber Crime', 'Airoli', '2026-08-08', 'High', 'Online fraud complaint reported.'),
(4, 'Fraud', 'Sanpada', '2026-08-09', 'Medium', 'Financial fraud case reported.'),
(5, 'Vehicle Theft', 'Belapur', '2026-08-10', 'Low', 'Two-wheeler theft reported.'),
(9, 'Robbery', 'Kopar Khairane', '2026-08-13', 'High', 'demo record'),
(10, 'Theft', 'Vashi', '2026-08-13', 'Medium', 'Mobile phone theft reported near market area.'),
(11, 'Cyber Crime', 'Nerul', '2026-08-14', 'High', 'Online banking fraud complaint reported.'),
(12, 'Burglary', 'Airoli', '2026-08-15', 'High', 'House burglary reported in residential area.'),
(13, 'Vehicle Theft', 'Ghansoli', '2026-08-16', 'Medium', 'Motorcycle theft reported from parking area.'),
(14, 'Fraud', 'Belapur', '2026-08-17', 'High', 'UPI payment fraud complaint registered.'),
(15, 'Theft', 'Sanpada', '2026-08-18', 'Low', 'Wallet theft reported at a crowded public place.'),
(16, 'Cyber Crime', 'Vashi', '2026-08-18', 'Medium', 'Suspicious phishing link complaint reported.'),
(17, 'Robbery', 'Nerul', '2026-08-19', 'High', 'Robbery incident reported near railway station.'),
(18, 'Theft', 'Kopar Khairane', '2026-08-20', 'Medium', 'Personal belongings theft reported in public area.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `crime_records`
--
ALTER TABLE `crime_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `crime_records`
--
ALTER TABLE `crime_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
