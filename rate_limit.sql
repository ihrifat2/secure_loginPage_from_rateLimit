-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2017 at 07:07 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rate_limit`
--

-- --------------------------------------------------------

--
-- Table structure for table `usr_info`
--

CREATE TABLE `usr_info` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usr_info`
--

INSERT INTO `usr_info` (`id`, `name`, `address`, `phone`, `email`, `username`, `password`) VALUES
(1, 'bob', 'Las Vegas', '17579980', 'bob@mail.com', 'bob', 'bob12345'),
(2, 'admin', 'Largo Carmona, Brazil', '23456789', 'admin@mail.com', 'admin', 'admin123'),
(3, 'Mark johnson', 'Okland, New Zealand', '97785663242', 'mark@gmail.com', 'mark', 'mark1234'),
(4, 'Peter parker', 'Australia', '4672634724', 'peter@gmail.com', 'peter', 'peter1234'),
(5, 'Alex mart', 'Canada', '77646467576', 'alex@gmail.com', 'alex', 'alex1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `usr_info`
--
ALTER TABLE `usr_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usr_info`
--
ALTER TABLE `usr_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
