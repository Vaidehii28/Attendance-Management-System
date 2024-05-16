-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 12:04 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendancefinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '32250170a0dca92d53ec9624f336ca24');

-- --------------------------------------------------------

--
-- Table structure for table `tblattendance`
--

CREATE TABLE `tblattendance` (
  `Id` int(10) NOT NULL,
  `enrollmentNo` varchar(255) NOT NULL,
  `courseId` varchar(10) NOT NULL,
  `sessionTermId` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `dateTimeTaken` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`Id`, `enrollmentNo`, `courseId`, `sessionTermId`, `status`, `dateTimeTaken`) VALUES
(1, 'BT20CSE170', '423', '1', '1', '2023-11-27'),
(2, 'BT20CSE008', '423', '1', '1', '2023-11-27'),
(3, 'BT20CSE038', '423', '1', '1', '2023-11-27'),
(4, 'BT20CSE044', '423', '1', '1', '2023-11-27'),
(5, 'BT20CSE170', '423', '1', '1', '2023-12-05'),
(6, 'BT20CSE008', '423', '1', '1', '2023-12-05'),
(7, 'BT20CSE038', '423', '1', '1', '2023-12-05'),
(8, 'BT20CSE044', '423', '1', '1', '2023-12-05'),
(9, 'BT20CSE086', '423', '1', '1', '2023-12-05'),
(10, 'BT20CSE098', '423', '1', '0', '2023-12-05'),
(11, 'BT20CSE170', '423', '1', '1', '2023-12-06'),
(12, 'BT20CSE008', '423', '1', '1', '2023-12-06'),
(13, 'BT20CSE038', '423', '1', '1', '2023-12-06'),
(14, 'BT20CSE044', '423', '1', '1', '2023-12-06'),
(15, 'BT20CSE086', '423', '1', '1', '2023-12-06'),
(16, 'BT20CSE098', '423', '1', '1', '2023-12-06'),
(17, 'BT20CSE170', '423', '1', '1', '2023-12-07'),
(18, 'BT20CSE008', '423', '1', '1', '2023-12-07'),
(19, 'BT20CSE038', '423', '1', '0', '2023-12-07'),
(20, 'BT20CSE044', '423', '1', '1', '2023-12-07'),
(21, 'BT20CSE086', '423', '1', '0', '2023-12-07'),
(22, 'BT20CSE098', '423', '1', '0', '2023-12-07'),
(23, 'BT20CSE018', '423', '1', '1', '2023-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassteacher`
--

CREATE TABLE `tblclassteacher` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` varchar(50) NOT NULL,
  `courseId` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblclassteacher`
--

INSERT INTO `tblclassteacher` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`, `phoneNo`, `courseId`, `dateCreated`) VALUES
(5, 'Nilesh', 'Pikle', 'nileshpikle@gmail.com', '32250170a0dca92d53ec9624f336ca24', '07410708977', '423', '2023-12-06'),
(2, 'Dr Amol', 'Bhopale', 'amolbhopale@gmail.com', '32250170a0dca92d53ec9624f336ca24', '7014560000', '433', '2023-9-07'),
(3, 'Dr Prerna', 'Mishra', 'prernamishra@gmail.com', '32250170a0dca92d53ec9624f336ca24', '0100000030', '443', '2023-19-07'),
(4, 'Dr Nileshchandra', 'Pikle', 'nileshpikle@gmail.com', '32250170a0dca92d53ec9624f336ca24', '1234567899', '121', '2023-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `tblcourse`
--

CREATE TABLE `tblcourse` (
  `courseId` int(10) NOT NULL,
  `courseName` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcourse`
--

INSERT INTO `tblcourse` (`courseId`, `courseName`) VALUES
(423, 'IPC'),
(433, 'NLP'),
(443, 'HCI'),
(453, 'NNDL'),
(121, 'CP');

-- --------------------------------------------------------

--
-- Table structure for table `tblsessionterm`
--

CREATE TABLE `tblsessionterm` (
  `Id` int(10) NOT NULL,
  `sessionName` varchar(50) NOT NULL,
  `termId` varchar(50) NOT NULL,
  `isActive` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsessionterm`
--

INSERT INTO `tblsessionterm` (`Id`, `sessionName`, `termId`, `isActive`, `dateCreated`) VALUES
(1, '2022/2023', '1', '1', '2023-9-31'),
(3, '2022/2023', '2', '0', '2023-9-31');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `enrollmentNo` varchar(255) NOT NULL,
  `courseId` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`Id`, `firstName`, `lastName`, `enrollmentNo`, `courseId`, `dateCreated`) VALUES
(1, 'Snehal', 'Kale', 'BT20CSE170', '423', '2023-9-31'),
(2, 'Vaidehi', 'Mahyavanshi', 'BT20CSE008', '423', '2023-9-31'),
(3, 'Sunny', 'Dubey', 'BT20CSE038', '423', '2023-9-31'),
(4, 'Ritesh', 'Meshram', 'BT20CSE044', '423', '2023-9-31'),
(5, 'Avantika', 'Kodape', 'BT20CSE086', '423', ''),
(6, 'Anushree', 'Wankhede', 'BT20CSE098', '423', ''),
(7, 'Yash', 'Bhure', 'BT20CSE018', '423', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblterm`
--

CREATE TABLE `tblterm` (
  `Id` int(10) NOT NULL,
  `termName` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblterm`
--

INSERT INTO `tblterm` (`Id`, `termName`) VALUES
(1, 'First'),
(2, 'Second'),
(3, 'Third');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblcourse`
--
ALTER TABLE `tblcourse`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblterm`
--
ALTER TABLE `tblterm`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblterm`
--
ALTER TABLE `tblterm`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
