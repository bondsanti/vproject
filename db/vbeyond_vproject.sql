-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2023 at 10:49 AM
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
-- Table structure for table `bookingdetails`
--

CREATE TABLE `bookingdetails` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(5) NOT NULL COMMENT 'ref_ตารางจอง',
  `customer_name` varchar(100) NOT NULL,
  `customer_tel` varchar(10) NOT NULL,
  `customer_req` text NOT NULL COMMENT 'ข้อมูลลูกค้าเข้าชม',
  `customer_req_bank` text DEFAULT NULL COMMENT 'เอกสารขอกู้ธนาคาร',
  `customer_doc_personal` text DEFAULT NULL COMMENT 'เอกสารจากลูกค้า',
  `num_home` int(1) DEFAULT NULL COMMENT 'สำเนาทะเบียนบ้าน',
  `num_idcard` int(1) DEFAULT NULL COMMENT 'สำเนาบัตรประชาชน',
  `num_app_statement` int(1) DEFAULT NULL COMMENT 'หนังสือรับรองเงินเดือน',
  `num_statement` int(1) DEFAULT NULL COMMENT 'เอกสาร Statement',
  `room_no` varchar(10) NOT NULL,
  `room_price` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingdetails`
--

INSERT INTO `bookingdetails` (`id`, `booking_id`, `customer_name`, `customer_tel`, `customer_req`, `customer_req_bank`, `customer_doc_personal`, `num_home`, `num_idcard`, `num_app_statement`, `num_statement`, `room_no`, `room_price`) VALUES
(2, '4', 'สันติ ชูประยูร', '0613299642', 'ชมห้องตัวอย่าง,พาชมห้องราคา', 'กสิกร,กรุงไทย,เกียรตินาคิน,ไทยพาณิชย์,ธอส.,ออมสิน,TTB,bitkub', 'สำเนาทะเบียนบ้าน,สำเนาบัตรประชาชน,หนังสือรับรองเงินเดือน,เอกสาร Statement', 1, 1, 1, 1, '99/9', 2000000);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_title` varchar(50) NOT NULL,
  `booking_start` varchar(100) NOT NULL,
  `booking_end` varchar(100) NOT NULL,
  `booking_status` int(1) DEFAULT 0,
  `project_id` int(3) NOT NULL,
  `booking_status_df` int(1) DEFAULT 0 COMMENT 'สถานะ DF',
  `teampro_id` int(3) NOT NULL COMMENT 'ref_เจ้าหน้าโครงการที่รับผิดชอบ',
  `team_id` int(3) NOT NULL COMMENT 'ทีมสายงาน',
  `subteam_id` int(3) NOT NULL COMMENT 'ชื่อสายงาน',
  `user_id` int(3) NOT NULL COMMENT 'ref_ผู้ทำรายงาน',
  `user_tel` varchar(10) NOT NULL,
  `remark` text DEFAULT NULL COMMENT 'หมายเหตุการจอง',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_title`, `booking_start`, `booking_end`, `booking_status`, `project_id`, `booking_status_df`, `teampro_id`, `team_id`, `subteam_id`, `user_id`, `user_tel`, `remark`, `created_at`, `updated_at`) VALUES
(4, 'เยี่ยมโครงการ', '2023-03-16 08:00', '2023-03-16 11:00', 0, 1, 0, 30, 1, 1, 1, '009', 'ทดสอบ', '2023-03-15 06:55:25', '2023-03-15 06:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_requests`
--

CREATE TABLE `holiday_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(3) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `teams_project`
--

CREATE TABLE `teams_project` (
  `id` int(3) NOT NULL,
  `team_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `is_jobs` int(1) DEFAULT 0 COMMENT 'สถานะรับงาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `password`, `fullname`, `role`, `team_id`, `active`, `is_jobs`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$ZOMlS2LD8VlfjQbeO6YZa.NGrTgk4gItjBfAMstcsJkA7Y5YU2Uni', 'admin IT', 'admin', '0', 'enable', 0, '2023-03-04 03:42:36', '2023-03-04 03:42:36'),
(30, 'jib', '$2y$10$iP8oApxYr89gjfs0frRdiOX/DLdxNs7/Ge8K8Os/mpJ18JmqlIAhK', 'จิ๊ป', 'staff', '0', 'enable', 0, '2023-03-13 09:01:42', '2023-03-13 09:01:42'),
(31, 'max', '$2y$10$LUraHvihWFIa/x7CBNe9AeictIrtljFGICs5ZFl8fFq9zMjD8oH4u', 'แม็ค', 'staff', '0', 'disable', 0, '2023-03-13 09:02:04', '2023-03-13 09:02:04'),
(32, 'if', '$2y$10$Ms69PXGE22C66VZGllrW9uHv0EomHPnGFVoa.U06TlFJ.YnPsayUG', 'อีฟ', 'staff', '0', 'enable', 0, '2023-03-13 09:02:33', '2023-03-13 09:02:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingdetails`
--
ALTER TABLE `bookingdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
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
-- AUTO_INCREMENT for table `bookingdetails`
--
ALTER TABLE `bookingdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
