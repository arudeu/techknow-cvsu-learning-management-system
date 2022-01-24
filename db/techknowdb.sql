-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 11:19 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techknowdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `message` tinytext NOT NULL,
  `groupID` tinytext NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coursedept`
--

CREATE TABLE `coursedept` (
  `id` int(11) NOT NULL,
  `type` tinytext NOT NULL,
  `code` varchar(8) NOT NULL,
  `title` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forgotpassword`
--

CREATE TABLE `forgotpassword` (
  `id` int(11) NOT NULL,
  `selector` tinytext NOT NULL,
  `token` longtext NOT NULL,
  `email` tinytext NOT NULL,
  `expires` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `grpID` int(11) NOT NULL,
  `grpcode` tinytext NOT NULL,
  `grptitle` tinytext NOT NULL,
  `grpdesc` tinytext NOT NULL,
  `grpcourse` tinytext NOT NULL,
  `grpauthor` tinytext NOT NULL,
  `grpauthorID` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `color` varchar(255) NOT NULL,
  `status` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `keystring`
--

CREATE TABLE `keystring` (
  `keystringID` int(11) NOT NULL,
  `keystringKey` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `grpmemID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `grpcode` tinytext NOT NULL,
  `grptitle` tinytext NOT NULL,
  `color` varchar(255) NOT NULL,
  `status` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notifid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `notifmsg` tinytext NOT NULL,
  `notifdate` datetime NOT NULL,
  `notifgrp` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` tinytext NOT NULL,
  `grpcode` tinytext NOT NULL,
  `groupID` tinytext NOT NULL,
  `date` datetime NOT NULL,
  `subjectID` tinytext NOT NULL,
  `message` varchar(10000) NOT NULL,
  `imgStatus` int(11) NOT NULL,
  `imagename` tinytext NOT NULL,
  `attachstatus` int(11) NOT NULL,
  `attachname` tinytext NOT NULL,
  `videostatus` int(11) NOT NULL,
  `videoname` varchar(255) NOT NULL,
  `posttype` tinytext NOT NULL,
  `deadlinedate` datetime NOT NULL,
  `hours` int(11) NOT NULL,
  `meetingcode` varchar(8) NOT NULL,
  `status` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profileimg`
--

CREATE TABLE `profileimg` (
  `imgID` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportID` int(11) NOT NULL,
  `reporterID` int(11) NOT NULL,
  `reportedID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `reasonID` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`reportID`, `reporterID`, `reportedID`, `postID`, `reasonID`, `reason`) VALUES
(4, 86, 82, 203, 3, 'Misleading information or links'),
(5, 81, 82, 205, 1, 'Irrelevant to the subject or topic');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `imgStatus` int(11) NOT NULL,
  `imgname` varchar(255) NOT NULL,
  `attachstatus` int(11) NOT NULL,
  `attachname` varchar(255) NOT NULL,
  `videostatus` int(11) NOT NULL,
  `videoname` varchar(255) NOT NULL,
  `posttype` tinytext NOT NULL,
  `datedeadline` date NOT NULL,
  `datepassed` date NOT NULL,
  `late` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `fnameUsers` tinytext NOT NULL,
  `lnameUsers` tinytext NOT NULL,
  `usernameUsers` tinytext NOT NULL,
  `course` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `studentIDUsers` tinytext NOT NULL,
  `departmentUsers` tinytext NOT NULL,
  `employeeIDUsers` tinytext NOT NULL,
  `passUsers` varchar(255) NOT NULL,
  `bdayUsers` date DEFAULT NULL,
  `genderUsers` char(1) NOT NULL,
  `addressUsers` longtext NOT NULL,
  `imageUsers` tinytext NOT NULL,
  `accounttypeUsers` tinytext NOT NULL,
  `statusUsers` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `coursedept`
--
ALTER TABLE `coursedept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgotpassword`
--
ALTER TABLE `forgotpassword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`grpID`);

--
-- Indexes for table `keystring`
--
ALTER TABLE `keystring`
  ADD PRIMARY KEY (`keystringID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`grpmemID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notifid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `profileimg`
--
ALTER TABLE `profileimg`
  ADD PRIMARY KEY (`imgID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportID`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `coursedept`
--
ALTER TABLE `coursedept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `forgotpassword`
--
ALTER TABLE `forgotpassword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `grpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `keystring`
--
ALTER TABLE `keystring`
  MODIFY `keystringID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `grpmemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notifid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `profileimg`
--
ALTER TABLE `profileimg`
  MODIFY `imgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
