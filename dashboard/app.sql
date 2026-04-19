-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 07:46 PM
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
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_username`, `admin_email`, `admin_password`, `created_at`) VALUES
(1, 'admin', 'admin', '$2y$10$2Wh/4TpDdQG5KXOAP/QTYOz8qpr0k9AFzvd9nyrg.We7srRhlWAMW', '2024-09-04 16:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `Customer_Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Balance` decimal(10,2) DEFAULT 0.00,
  `Customer_ID` varchar(8) NOT NULL,
  `referral_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `referred_by` varchar(255) DEFAULT NULL,
  `is_suspended` tinyint(1) DEFAULT 0,
  `Interest_Balance` decimal(10,2) DEFAULT 0.00,
  `total_invest` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `Customer_Name`, `Email`, `Password`, `Balance`, `Customer_ID`, `referral_code`, `created_at`, `referred_by`, `is_suspended`, `Interest_Balance`, `total_invest`) VALUES
(1, 'brownlucky386', 'brownlucky386@mail.com', '$2y$10$2Wh/4TpDdQG5KXOAP/QTYOz8qpr0k9AFzvd9nyrg.We7srRhlWAMW', 522323.00, '04927581', 'K5FkWE3hTm', '2024-08-31 08:21:11', NULL, 0, 299.00, 0.00),
(3, 'brownlucky38', 'brownlucky38@mail.com', '$2y$10$GK3PlymMNDya.hvVFCLBou2R/lLwahIOAtPqSelOkkVl3PDEgaf3O', 0.00, '93726854', 'djCKVoSWkt', '2024-08-31 11:24:38', NULL, 0, 0.00, 0.00),
(14, 'request.wrecircle', 'brownlucky6@mail.com', '$2y$10$1IS2wv0igqFE4eCMjGWlDOvtsmaeQR0fpt3QmcuQmMMrtwdNM/eEC', 0.00, '72150869', '4RZ6eDUWuq', '2024-08-31 11:52:54', '04927581', 0, 0.00, 0.00),
(16, 'ttttt', 'brown@ail.com', '$2y$10$HpPorJox31nItuCcoUZaOOG6Dxjn9BWuFy9Wb/RqEi4o7teD/CBK2', 0.00, '70896315', 'F4nhYk8S5P', '2024-08-31 12:08:53', '72150869', 0, 0.00, 0.00),
(17, 'hr', 'hr@laurenflowers.co.ke', '$2y$10$PKZL46gU7hATa9xx5PJFgOXRbloWoU2eFP4wQkdEYQlNB5kjZQ9kq', 0.00, '08364512', 'RG4UxemtVj', '2024-08-31 17:22:29', '93726854', 0, 0.00, 0.00),
(21, 'hrr', 'hr@lanflors.co.ke', '$2y$10$OlAnZ8p8OO9MQ0jdbqFEN.R0edOgw/IB69fDN2qZTea0ZFhbyw3Ge', 0.00, '53680724', 'zaUPoCEWKu', '2024-09-01 05:05:28', '72150869', 0, 0.00, 0.00),
(22, 'another.one', 'hrrrr@lanflors.co.ke', '$2y$10$B9KdIQ3Y9X08Fk9IgDyX4eDySEClI8ehBCBxn8RL8CEy2t.8e8oVy', 0.00, '27948301', '3Mbat4r2Ch', '2024-09-01 05:18:54', '72150869', 0, 0.00, 0.00),
(23, 'last.one', 'hrrrrr@lanflors.co.ke', '$2y$10$GNjEDA2Mp2opJWjFsFo0suD/ued48tDx7JtK/htcxrlFRwLoNNUFy', 0.00, '81924530', '9ZywriYvm6', '2024-09-01 05:21:16', '04927581', 0, 0.00, 0.00),
(24, 'lev3.one', 'brownlucky386@mail.comff', '$2y$10$wL89F.PD4oMEAW2O7IXzXelyz4RAYMfUFCPjAwkDvWujmoHmsaO7m', 0.00, '61509243', 'EfhkCzrcK8', '2024-09-01 05:22:28', '70896315', 0, 0.00, 0.00),
(25, 'lev3.o', 'brownluy386@mail.comff', '$2y$10$eeB56n565wR7RiQ3xnMzP.QM3TaUDGtaHG7ZsX1vdrvE6WZxvIMn.', 0.00, '03821975', 'mu1yp7bjwx', '2024-09-01 07:10:45', '70896315', 0, 0.00, 0.00),
(26, 'another___iobe', 'hr@laurenflowers.co.keutrfg', '$2y$10$YsNbFlzEnG4jjBD19DLleuDtJ.nyXdM7V3NVYdDuWiHnZZ20m.kjW', 0.00, '56710948', 'YhgKWutBcG', '2024-09-01 07:12:15', '04927581', 0, 0.00, 0.00),
(27, 'another___io', 'hr@laurenflows.co.keutrfg', '$2y$10$ahdiutwMCK0XNpXSJlLhPOgUCupUtvVg2FSoXPy5dmJ2uBtVM4b3K', 0.00, '17204396', 'EbYVQ8iM35', '2024-09-01 07:12:28', '04927581', 0, 0.00, 0.00),
(28, 'another___ioIOllldf', 'hr@lrenflows.co.keutrfg', '$2y$10$fKRhKvdV03g41o./bFqtnePl0h4TOxv1nJq0Uk4Un6wH0UN9y2wrW', 0.00, '04865273', 'BkOM0yxlfs', '2024-09-02 22:34:07', '04927581', 0, 0.00, 0.00),
(29, 'another___iiou89joIOllldf', 'hr@lrenflol;koopws.co.keutrfg', '$2y$10$edqYSheyMCv5tUYoGEq90.IM2uMqQBhwXxJxaef0l1FuQLR2K7O7C', 0.00, '10298436', 'TIMN6oDlFC', '2024-09-02 22:34:24', NULL, 0, 0.00, 0.00),
(30, 'another___ioIOllldfassd', 'hr@lrenflsdsows.co.keutrfg', '$2y$10$wlt6LLF44mltGeAJtnKItufXN5KyHhfhFMGCTBQQEJOi6yRqPkCXS', 0.00, '12870465', 'I6rozctP89', '2024-09-02 22:43:22', '04927581', 0, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `amount`, `currency`, `timestamp`, `status`) VALUES
(8, '04927581', 0.00, 'BTC', '2024-09-03 08:33:35', 'approved'),
(32, '04927581', 0.00, 'BTC', '2024-09-03 09:47:19', 'approved'),
(59, '04927581', 6.00, 'USDT', '2024-09-03 21:25:24', 'pending'),
(60, '04927581', 8.00, 'BTC', '2024-09-04 03:49:29', 'rejected'),
(65, '04927581', 6.00, 'BTC', '2024-09-05 06:11:27', 'approved'),
(67, '04927581', 79.00, 'BTC', '2024-09-05 18:06:11', 'approved'),
(68, '04927581', 8.00, 'BTC', '2024-09-06 02:12:46', 'approved'),
(69, '04927581', 99.00, 'BTC', '2024-09-06 02:45:11', 'approved'),
(70, '04927581', 7.00, 'BTC', '2024-09-06 02:52:29', 'approved'),
(71, '04927581', 6.00, 'BTC', '2024-09-06 03:05:19', 'approved'),
(72, '04927581', 6.00, 'BTC', '2024-09-06 03:29:51', 'pending'),
(73, '04927581', 3.00, 'BTC', '2024-09-06 03:44:25', 'pending'),
(74, '04927581', 8.00, 'BTC', '2024-09-06 05:19:42', 'pending'),
(75, '04927581', 7.00, 'BTC', '2024-09-06 07:36:16', 'pending'),
(76, '04927581', 8.00, 'BTC', '2024-09-06 07:38:48', 'pending'),
(77, '04927581', 8.00, 'USDT', '2024-09-06 07:39:00', 'pending'),
(78, '04927581', 88.00, 'BTC', '2024-09-07 13:20:14', 'pending'),
(79, '04927581', 700.00, 'BTC', '2024-09-08 06:26:40', 'pending'),
(80, '04927581', 777.00, 'BTC', '2024-09-08 09:33:56', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `investment_type` varchar(50) NOT NULL,
  `min_investment` decimal(10,2) NOT NULL,
  `max_investment` decimal(10,2) NOT NULL,
  `total_roi` decimal(5,2) NOT NULL,
  `daily_roi` decimal(5,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `referral_commission` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `investment_type`, `min_investment`, `max_investment`, `total_roi`, `daily_roi`, `duration`, `referral_commission`, `created_at`, `customer_id`) VALUES
(1, 'Basic', 100.00, 1000.00, 10.00, 1.00, 7, 10.00, '2024-09-08 13:24:17', NULL),
(2, 'Standard', 1000.00, 10000.00, 20.00, 1.00, 14, 10.00, '2024-09-08 13:24:17', NULL),
(3, 'Premium', 10000.00, 100000.00, 40.00, 1.00, 40, 10.00, '2024-09-08 13:24:17', NULL),
(4, 'VIP', 50000.00, 500000.00, 60.00, 2.00, 60, 10.00, '2024-09-08 13:24:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `referred_user_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `user_id`, `referred_user_id`, `level`, `created_at`) VALUES
(1, '04927581', '72150869', 1, '2024-08-31 11:52:54'),
(2, '72150869', '70896315', 1, '2024-08-31 12:08:53'),
(4, '93726854', '08364512', 1, '2024-08-31 17:22:29'),
(8, '72150869', '53680724', 1, '2024-09-01 05:05:28'),
(9, '72150869', '27948301', 1, '2024-09-01 05:18:54'),
(10, '04927581', '81924530', 1, '2024-09-01 05:21:16'),
(11, '70896315', '61509243', 1, '2024-09-01 05:22:28'),
(12, '70896315', '03821975', 1, '2024-09-01 07:10:45'),
(13, '04927581', '56710948', 1, '2024-09-01 07:12:15'),
(14, '04927581', '17204396', 1, '2024-09-01 07:12:28'),
(15, '04927581', '04865273', 1, '2024-09-02 22:34:07'),
(16, '04927581', '12870465', 1, '2024-09-02 22:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `currency` enum('BTC','USDT') DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `customer_id`, `amount`, `currency`, `status`, `address`, `created_at`, `updated_at`) VALUES
(1, '04927581', 4.00, 'USDT', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-03 18:45:50', '2024-09-03 18:45:50'),
(2, '04927581', 8.00, 'USDT', 'pending', '8', '2024-09-03 18:46:26', '2024-09-03 18:46:26'),
(4, '04927581', 8.00, 'BTC', 'pending', '8', '2024-09-03 18:54:08', '2024-09-03 18:54:08'),
(15, '04927581', 6.00, 'BTC', 'pending', 'jkigyutfrdtfgbhn', '2024-09-03 22:09:44', '2024-09-03 22:09:44'),
(16, '04927581', 5.00, 'USDT', 'rejected', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-03 22:13:37', '2024-09-05 07:22:49'),
(17, '04927581', 6.00, 'USDT', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-03 22:14:30', '2024-09-03 22:14:30'),
(18, '04927581', 6.00, 'USDT', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-03 22:15:52', '2024-09-03 22:15:52'),
(24, '04927581', 76.00, 'BTC', 'approved', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-05 13:19:12', '2024-09-06 01:09:19'),
(25, '04927581', 700.00, 'BTC', 'rejected', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-05 13:21:35', '2024-09-05 13:21:44'),
(26, '04927581', 50000.00, 'BTC', 'approved', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-06 02:03:25', '2024-09-06 02:03:40'),
(27, '04927581', 8.00, 'BTC', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-06 08:11:23', '2024-09-06 08:11:23'),
(28, '04927581', 4.00, 'BTC', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-06 09:50:57', '2024-09-06 09:50:57'),
(29, '04927581', 5.00, 'BTC', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-06 09:52:03', '2024-09-06 09:52:03'),
(30, '04927581', 500.00, 'USDT', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-06 10:26:59', '2024-09-06 10:26:59'),
(31, '04927581', 7.00, 'BTC', 'pending', 'kjnbgfvcdxszxrdcfvghbjnkmjhgv', '2024-09-06 11:03:00', '2024-09-06 11:03:00'),
(32, '04927581', 899.00, 'USDT', 'pending', 'jkigyutfrdtfgbhn', '2024-09-06 12:55:15', '2024-09-06 12:55:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`),
  ADD UNIQUE KEY `admin_email` (`admin_email`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Customer_Name` (`Customer_Name`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Customer_ID` (`Customer_ID`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `referred_user_id` (`referred_user_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `referrals_ibfk_2` FOREIGN KEY (`referred_user_id`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
