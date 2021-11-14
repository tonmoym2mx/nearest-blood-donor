-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2021 at 07:03 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nearest_blood_donor`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `distance_between` (`lat1` DOUBLE, `lon1` DOUBLE, `lat2` DOUBLE, `lon2` DOUBLE) RETURNS DOUBLE RETURN  ( 6371 * acos( cos( radians(lat2) ) * cos( radians( lat1 ) ) 
    * cos( radians( lon1 ) - radians(lon2) ) + sin( radians(lat2) ) * sin(radians(lat1)) ) )$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `donor_id` int(11) NOT NULL,
  `donor_name` varchar(50) NOT NULL,
  `donor_number` varchar(55) NOT NULL,
  `donor_blood_group` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`donor_id`, `donor_name`, `donor_number`, `donor_blood_group`) VALUES
(1, 'Alshorif Hossain', '01736155059', 'A+'),
(2, 'Sarwar Zahan', '01780882316', 'O+'),
(3, 'Tonmoy', '01771000962', 'A-'),
(4, 'Ramisa', '01780882316', 'O+'),
(5, 'Koishik', '01736155059', 'B+'),
(10, 'Dalim', '01780882316', 'A-');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `donor_id`, `latitude`, `longitude`) VALUES
(1, 1, 35.6543, 139.7447),
(2, 2, 21.4225, 39.8261),
(3, 3, 23.75183, 90.380413),
(4, 4, 21.4225, 39.8261),
(5, 5, 35.6544, 39.8261),
(10, 10, 23.817238, 90.353976);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
