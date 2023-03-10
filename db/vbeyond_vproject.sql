-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2023 at 02:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vbeyond_vproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_title` varchar(50) NOT NULL,
  `booking_start` varchar(100) NOT NULL,
  `booking_end` varchar(100) NOT NULL,
  `booking_status` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_title`, `booking_start`, `booking_end`, `booking_status`) VALUES
(1, 'นัดเยี่ยมโครงการ', '2023-03-09 11:00', '2023-03-09 13:00', 0),
(2, 'ทดสอบ 2', '2023-03-10 10:00', '2023-03-10 13:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `is_active` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'โครงการ Altitude  Unicorn', 'enable', NULL, NULL),
(2, 'โครงการมอนเต้ พระราม 9', 'disable', NULL, NULL),
(3, 'โครงการ Be condo', 'enable', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subteams`
--

CREATE TABLE `subteams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subteam_name` varchar(255) NOT NULL,
  `team_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subteams`
--

INSERT INTO `subteams` (`id`, `subteam_name`, `team_id`, `created_at`, `updated_at`) VALUES
(1, 'สายงาน bigbull', 1, '2023-03-04 19:19:12', '2023-03-04 19:19:12'),
(2, 'สายงาน BKK', 2, '2023-03-04 19:19:12', '2023-03-04 19:19:12'),
(3, 'สายงาน VIP', 1, '2023-03-04 19:24:42', '2023-03-04 19:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_name`, `created_at`, `updated_at`) VALUES
(1, 'VIP', '2023-03-04 19:16:09', '2023-03-04 19:16:09'),
(2, 'คุณเซน', '2023-03-04 19:16:09', '2023-03-04 19:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `team_id` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `password`, `fullname`, `role`, `team_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$ZOMlS2LD8VlfjQbeO6YZa.NGrTgk4gItjBfAMstcsJkA7Y5YU2Uni', 'admin IT', 'admin', '0', 'enable', '2023-03-04 03:42:36', '2023-03-04 03:42:36'),
(3, 'ee', '$2y$10$zR9/vQ5yL4llRBCEz001C.lPxSg74.6ESiPZic5r5/zhKvThjTbFC', 'e', 'staff', '0', 'enable', '2023-03-04 05:20:41', '2023-03-04 05:20:41'),
(5, 'aa', '$2y$10$3JYx3/l8B.yYYWOMoU.4fOPSVq.q2YwucHu/2C.rd/19y56LMLL..', 'aa', 'staff', '3', 'enable', '2023-03-04 05:22:41', '2023-03-04 17:57:38'),
(8, 'rrrrrrrr', '$2y$10$9DLbnQelp8.uUsoP2WQAPOP8fcAbWUCSWucQzIPD98ysBwVvmggq6', 'rrrrrrr', 'staff', '2', 'enable', '2023-03-04 06:53:55', '2023-03-04 06:53:55'),
(9, 'yyy', '$2y$10$/7C2T6ZRcAjlRHkVWXtwIuWWOsiNIn3F8vyHDEbTCrVv3RnoU5F2i', 'yyy', 'staff', '0', 'enable', '2023-03-04 07:06:59', '2023-03-04 07:06:59'),
(10, 'qwe', '$2y$10$2Ju0wH6Q3JmBz8Lt5HiTautDAF1FqS58AINlUnFpQFhUDPoan98tS', 'qwe', 'user', '0', 'disable', '2023-03-04 08:12:53', '2023-03-04 08:12:53'),
(19, 'afsasf', '$2y$10$pV7bd7uLBvr.GSFY7XXMZuan8kgtsjtk/cNHWCSomdwEfZnJBJsj.', 'afasf', 'user', '1', 'disable', '2023-03-04 08:59:53', '2023-03-04 17:51:47'),
(22, 'test', '$2y$10$ppKOlgu3aMlzD2/1vHZF9.ZmX48TEnRLuq9eGFA0CJwmjXYt6GukW', 'test', 'staff', '2', 'enable', '2023-03-04 09:05:32', '2023-03-04 17:54:21'),
(24, '5678', '$2y$10$MYqtCSvyZhi9NXmVEq5PaevJ7ewFOy7WFsLOm8S7B2wI12woR76.u', 'asdasd', 'staff', '0', 'enable', '2023-03-04 10:43:30', '2023-03-04 10:43:30'),
(25, 'tyt', '$2y$10$bsJgGol2LOVSn.4FhJYx4uSfFTduk1QPf5xM0a7Y/LroSttfZ22e.', 'tyt', 'user', '0', 'enable', '2023-03-04 10:47:06', '2023-03-04 10:47:06'),
(28, 'aaa', '$2y$10$lO7BfnLPrpqngnt00ct1TOgYlNBs0ThYsIAisu5dNjwbLhSVui.Im', 'rrrrrrrrrrrrrrr', 'staff', '3', 'disable', '2023-03-04 14:33:23', '2023-03-04 18:23:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subteams`
--
ALTER TABLE `subteams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subteams`
--
ALTER TABLE `subteams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
