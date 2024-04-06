-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2023 at 02:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `333projectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `question` text NOT NULL,
  `end_by` varchar(200) NOT NULL,
  `end_date` varchar(200) DEFAULT NULL,
  `statues` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poll`
--

INSERT INTO `poll` (`pid`, `uid`, `title`, `question`, `end_by`, `end_date`, `statues`) VALUES
(15, 68, 'Programming ', 'What is your favorite programming language?', 'manually', NULL, 'open'),
(16, 68, 'Game', 'what is your favorite game?', 'date', '2023-08-31', 'open'),
(17, 69, 'Colors', 'what is your favorite color?', 'manually', NULL, 'open'),
(18, 69, 'Food', 'what is your favorite food?', 'manually', NULL, 'close'),
(19, 68, 'Subject', 'what is your favorite Subject?', 'date', '2023-08-22', 'open'),
(20, 70, 'Transportation', 'What is your favorite mode of transportation?', 'manually', NULL, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `polloptions`
--

CREATE TABLE `polloptions` (
  `opid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `option text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polloptions`
--

INSERT INTO `polloptions` (`opid`, `pid`, `option text`) VALUES
(42, 15, 'JAVA'),
(43, 15, 'C++'),
(44, 15, 'C#'),
(45, 15, 'Python'),
(46, 15, 'Ruby'),
(47, 16, 'Chess'),
(48, 16, 'Sudoku'),
(49, 16, 'Minecraft'),
(50, 17, 'Blue'),
(51, 17, 'Green'),
(52, 17, 'Purple'),
(53, 17, 'yellow'),
(54, 17, 'red'),
(55, 18, 'Pasta'),
(56, 18, 'Pizza'),
(57, 18, 'Burger'),
(58, 19, 'Math'),
(59, 19, 'Art'),
(60, 20, 'Car'),
(61, 20, 'Bicycle'),
(62, 20, 'Walking'),
(63, 20, 'Bus');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`) VALUES
(68, 'Zahra', 'zahra@gmail.com', '$2y$10$t8HnhMs1sb34RSGu8j2YZOhX8GnKFpG.woa4XFP29ucWKiETUpiem'),
(69, 'Hawra', 'hawra@gmail.com', '$2y$10$m.0pWCl18mP3qVKGfnXw3er2awgHrX1my9UeRjsSvyIKkgfXiEGsy'),
(70, 'Faisal', 'faisal@gmail.com', '$2y$10$evu1vD.n1FbcTZUlM3UrVOgH6MVNGkhINDFR.2ULZQSoIizOFj4dO');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `vid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `opid` int(11) NOT NULL,
  `date_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`vid`, `uid`, `pid`, `opid`, `date_time`) VALUES
(149, 68, 15, 42, 'Sunday 13 of August 2023 10:17:23 PM'),
(150, 69, 16, 48, 'Sunday 13 of August 2023 10:20:17 PM'),
(151, 69, 17, 50, 'Sunday 13 of August 2023 10:22:10 PM'),
(152, 69, 18, 56, 'Sunday 13 of August 2023 10:23:54 PM'),
(153, 68, 18, 55, 'Sunday 13 of August 2023 10:24:13 PM'),
(154, 68, 16, 47, 'Monday 14 of August 2023 02:30:12 AM'),
(155, 68, 19, 59, 'Monday 14 of August 2023 02:46:45 AM'),
(156, 69, 20, 61, 'Monday 14 of August 2023 03:33:55 AM'),
(157, 68, 20, 62, 'Monday 14 of August 2023 03:34:15 AM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `FK to users` (`uid`);

--
-- Indexes for table `polloptions`
--
ALTER TABLE `polloptions`
  ADD PRIMARY KEY (`opid`),
  ADD KEY `FK to poll` (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`vid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `opid` (`opid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `polloptions`
--
ALTER TABLE `polloptions`
  MODIFY `opid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `polloptions`
--
ALTER TABLE `polloptions`
  ADD CONSTRAINT `FK to poll` FOREIGN KEY (`pid`) REFERENCES `poll` (`pid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
