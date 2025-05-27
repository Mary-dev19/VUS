-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 08:55 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vanguard`
--

-- --------------------------------------------------------

--
-- Table structure for table `allocation`
--

CREATE TABLE `allocation` (
  `AlloID` int(10) NOT NULL,
  `IncID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `ConID` int(10) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'In progress',
  `Payment` varchar(50) NOT NULL DEFAULT 'Not Paid'
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `conr`
--

CREATE TABLE `conr` (
  `RepID` int(10) NOT NULL,
  `IncID` varchar(50) NOT NULL,
  `Hours` int(10) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `FixingDate` int(30) NOT NULL,
  `Date Created` int(30) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Comment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `contractor`
--

CREATE TABLE `contractor` (
  `ConID` int(20) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Confirm` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `DOB` int(20) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Price` int(20) NOT NULL,
  `Contacts` int(20) NOT NULL,
  `Service` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'Applied'
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `con_request`
--

CREATE TABLE `con_request` (
  `id` int(11) NOT NULL,
  `ConID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Reason` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_accounts`
--

CREATE TABLE `deleted_accounts` (
  `DELID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `IncID` int(50) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `incidentImage` varchar(30) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'New',
  `Modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `qat`
--

CREATE TABLE `qat` (
  `QAID` int(10) NOT NULL,
  `Ratings` int(10) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Decision` varchar(10) NOT NULL,
  `Comments` varchar(50) NOT NULL,
  `AlloID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Reason` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(20) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Confirm` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Contacts` int(20) NOT NULL,
  `DOB` int(30) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Usertype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Name`, `Surname`, `Username`, `Password`, `Confirm`, `Email`, `Gender`, `Contacts`, `DOB`, `Address`, `Usertype`) VALUES
(5, 'Mary', 'Hlehlethe', 'pretty', '2003A', '2003A', 'mahlape.hlehlethe@bothouniversity.com', 'Female', 59441836, 1975, 'Hafoso', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allocation`
--
ALTER TABLE `allocation`
  ADD PRIMARY KEY (`AlloID`);

--
-- Indexes for table `conr`
--
ALTER TABLE `conr`
  ADD PRIMARY KEY (`RepID`);

--
-- Indexes for table `contractor`
--
ALTER TABLE `contractor`
  ADD PRIMARY KEY (`ConID`);

--
-- Indexes for table `con_request`
--
ALTER TABLE `con_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_accounts`
--
ALTER TABLE `deleted_accounts`
  ADD PRIMARY KEY (`DELID`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`IncID`);

--
-- Indexes for table `qat`
--
ALTER TABLE `qat`
  ADD PRIMARY KEY (`QAID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allocation`
--
ALTER TABLE `allocation`
  MODIFY `AlloID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `conr`
--
ALTER TABLE `conr`
  MODIFY `RepID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `contractor`
--
ALTER TABLE `contractor`
  MODIFY `ConID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `con_request`
--
ALTER TABLE `con_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `deleted_accounts`
--
ALTER TABLE `deleted_accounts`
  MODIFY `DELID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `IncID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `qat`
--
ALTER TABLE `qat`
  MODIFY `QAID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
