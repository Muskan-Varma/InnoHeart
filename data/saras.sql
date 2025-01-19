-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 05:33 PM
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
-- Database: `saras`
--

-- --------------------------------------------------------

--
-- Table structure for table `craft`
--
-- Creation: Dec 28, 2024 at 04:31 PM
-- Last update: Dec 29, 2024 at 04:09 PM
--

CREATE TABLE `craft` (
  `cid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `pdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `craft`:
--   `uid`
--       `users` -> `uid`
--

--
-- Dumping data for table `craft`
--

INSERT INTO `craft` (`cid`, `title`, `description`, `category`, `subcategory`, `price`, `quantity`, `pdate`, `uid`) VALUES
(1, 'sample', 'demo craft', 'Paper Crafts', '0', 445647.00, 2, '2024-09-21 11:03:23', 1),
(4, 'sample 3', 'plz plz\r\nplz\r\nplz\r\nplz\r\nplz', 'Drawing and Painting', 'Acrylic Painting', 45.00, 2, '2024-12-28 17:03:43', 4);

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--
-- Creation: Sep 21, 2024 at 11:00 AM
-- Last update: Dec 29, 2024 at 03:26 PM
--

CREATE TABLE `favourites` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `favourites`:
--   `username`
--       `users` -> `username`
--   `cid`
--       `craft` -> `cid`
--

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `username`, `cid`) VALUES
(1, 'admin', 1),
(2, 'muskan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--
-- Creation: Sep 21, 2024 at 11:00 AM
-- Last update: Dec 29, 2024 at 04:09 PM
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `image_description` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `images`:
--   `cid`
--       `craft` -> `cid`
--

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `cid`, `image_description`, `upload_date`) VALUES
(1, 1, 'ganesha1.jfif', '2024-09-21 11:03:23'),
(2, 1, 'ganesha2.jfif', '2024-09-21 11:03:23'),
(8, 4, 'csi logo.png', '2024-12-28 17:03:43'),
(9, 4, 'csi_logo.png', '2024-12-28 17:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `session_logs`
--
-- Creation: Sep 21, 2024 at 11:00 AM
-- Last update: Dec 29, 2024 at 04:10 PM
--

CREATE TABLE `session_logs` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `session_logs`:
--

--
-- Dumping data for table `session_logs`
--

INSERT INTO `session_logs` (`id`, `session_id`, `username`, `action`, `timestamp`) VALUES
(1, '80ee5ta9re0ckvmocodd8ibipq', 'admin', 'login', '2024-09-21 11:02:14'),
(2, '80ee5ta9re0ckvmocodd8ibipq', 'admin', 'logout', '2024-09-21 11:05:16'),
(3, 'qev6m5vmm3pga2oneogj1dglcu', 'admin', 'login', '2024-11-24 12:59:48'),
(4, 't7nlaakcder1ltmn8pokhrrfun', 'admin', 'login', '2024-11-24 13:00:03'),
(5, '057k2dg5csdu5igshcn6e756ia', 'admin', 'login', '2024-11-24 13:38:43'),
(6, 'qev6m5vmm3pga2oneogj1dglcu', 'admin', 'login', '2024-11-24 13:41:32'),
(7, 'rl9f4b3msv9blsm5jrf5dqs69d', 'admin', 'login', '2024-11-24 14:57:29'),
(8, 'ojg7cfo64svaejg9t5u86mf3o0', 'admin', 'login', '2024-11-24 14:59:19'),
(9, '890t5bo9nrhlnfd9eul74oebfn', 'admin', 'login', '2024-11-24 14:59:53'),
(10, 's1b4ihjuv1pcbl9siimegd94le', 'admin', 'login', '2024-11-24 15:02:04'),
(11, '890t5bo9nrhlnfd9eul74oebfn', 'admin', 'login', '2024-11-24 15:34:43'),
(12, '890t5bo9nrhlnfd9eul74oebfn', 'admin', 'logout', '2024-11-24 17:29:42'),
(13, '94i0r6498r34id9tatcudcsd0t', 'admin', 'login', '2024-12-22 15:29:36'),
(14, '94i0r6498r34id9tatcudcsd0t', 'admin', 'login', '2024-12-22 15:30:11'),
(15, '96s4j1anpnkcfjnknr8mkbkejf', 'admin', 'login', '2024-12-22 15:34:07'),
(16, '96s4j1anpnkcfjnknr8mkbkejf', 'admin', 'logout', '2024-12-22 15:36:33'),
(17, '94i0r6498r34id9tatcudcsd0t', 'admin', 'logout', '2024-12-22 15:36:48'),
(18, '96s4j1anpnkcfjnknr8mkbkejf', 'admin', 'login', '2024-12-22 16:11:02'),
(19, '96s4j1anpnkcfjnknr8mkbkejf', 'admin', 'logout', '2024-12-22 16:11:29'),
(20, 'tqdj83lvic6029jc5vmuuf66ce', 'admin', 'login', '2024-12-22 16:52:55'),
(21, '96s4j1anpnkcfjnknr8mkbkejf', 'admin', 'login', '2024-12-22 16:56:21'),
(22, '96s4j1anpnkcfjnknr8mkbkejf', 'admin', 'logout', '2024-12-22 16:56:28'),
(23, 'plgqnbv66t786qg8ubngm9r7fv', 'admin', 'login', '2024-12-22 16:56:50'),
(24, 'tqdj83lvic6029jc5vmuuf66ce', 'admin', 'logout', '2024-12-22 16:59:59'),
(25, 'hl2lvhaop07u38qtil4irbvvj1', 'admin', 'login', '2024-12-23 13:47:16'),
(26, 'kkn965qq4dpfgk4bsk36mte6cf', 'admin', 'login', '2024-12-23 13:47:54'),
(27, 'hl2lvhaop07u38qtil4irbvvj1', 'admin', 'logout', '2024-12-24 16:17:02'),
(28, 'hl2lvhaop07u38qtil4irbvvj1', 'admin', 'login', '2024-12-24 16:17:11'),
(29, 'hl2lvhaop07u38qtil4irbvvj1', 'admin', 'login', '2024-12-24 16:17:52'),
(30, '9s3p6opn7q3ag8df35d7pgut3d', 'admin', 'login', '2024-12-25 07:39:09'),
(31, 'hvacunklvc9r2trhmdniq480sm', 'admin', 'login', '2024-12-25 15:12:51'),
(32, 'hvacunklvc9r2trhmdniq480sm', 'admin', 'logout', '2024-12-25 15:20:40'),
(33, 'hvacunklvc9r2trhmdniq480sm', 'admin', 'login', '2024-12-25 15:20:47'),
(34, 'hvacunklvc9r2trhmdniq480sm', 'admin', 'login', '2024-12-25 15:44:43'),
(35, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'login', '2024-12-25 15:54:16'),
(36, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'logout', '2024-12-25 16:11:18'),
(37, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'login', '2024-12-25 16:11:23'),
(38, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'login', '2024-12-25 17:07:12'),
(39, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'logout', '2024-12-25 17:16:04'),
(40, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'login', '2024-12-25 17:16:14'),
(41, 'uvku4t9qk32ols2c8av6552lp8', 'admin', 'login', '2024-12-25 17:17:52'),
(42, 'vt7dkctiiosebedqbr1anai946', 'admin', 'login', '2024-12-25 17:45:25'),
(43, '96deg9envp12lv7m55jcs2tf9s', 'admin', 'login', '2024-12-26 13:18:31'),
(44, 'rvookoafqf208v6c1kqhfa1rkh', 'admin', 'login', '2024-12-26 13:24:45'),
(45, '6ncgf32f25uoqhlv8809v58k7s', 'admin', 'login', '2024-12-26 13:27:59'),
(46, '6ncgf32f25uoqhlv8809v58k7s', 'admin', 'logout', '2024-12-26 18:11:20'),
(47, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'login', '2024-12-28 15:41:32'),
(48, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'login', '2024-12-28 16:06:22'),
(49, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'login', '2024-12-28 16:07:33'),
(50, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'logout', '2024-12-29 15:49:56'),
(51, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'login', '2024-12-29 15:50:03'),
(52, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'logout', '2024-12-29 15:57:02'),
(53, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'login', '2024-12-29 15:57:07'),
(54, 'gb30spotmkhcgsqd3agff1kt2c', 'muskan', 'logout', '2024-12-29 16:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Sep 21, 2024 at 11:00 AM
-- Last update: Dec 29, 2024 at 04:02 PM
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `rdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `firstName`, `lastName`, `phone`, `email`, `dob`, `gender`, `username`, `pass`, `rdate`) VALUES
(1, 'admin', 'admin', '45657765747', 'admin@gmail.com', '2024-09-20', '', 'admin', '$2y$10$.o3JhMRDMo.hiH0UaAJ5oOJO6VQGAq5GJmgd7GBmMj4UgEN.iTEP6', '2024-09-21 11:02:00'),
(4, 'Muskan', 'Sharma', '7249856966', 'muskanvarma0304@gmail.com', '2003-12-12', 'Female', 'muskan', '$2y$10$UxJeCjmicf7i29c5VqG3jO7zV2EZE35JpymeSDdOWJbLd0.EbsvTq', '2024-12-28 16:07:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `craft`
--
ALTER TABLE `craft`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `craft`
--
ALTER TABLE `craft`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `session_logs`
--
ALTER TABLE `session_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `craft`
--
ALTER TABLE `craft`
  ADD CONSTRAINT `craft_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `craft` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `craft` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
