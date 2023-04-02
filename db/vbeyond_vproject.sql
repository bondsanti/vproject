-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 08:31 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

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
  `booking_id` varchar(10) NOT NULL COMMENT 'ref_ตารางจอง',
  `customer_name` varchar(100) NOT NULL,
  `customer_tel` varchar(10) NOT NULL,
  `customer_req` text NOT NULL COMMENT 'ข้อมูลลูกค้าเข้าชม',
  `customer_req_bank` text DEFAULT NULL COMMENT 'เอกสารขอกู้ธนาคาร',
  `customer_req_bank_other` text DEFAULT NULL,
  `customer_doc_personal` text DEFAULT NULL COMMENT 'เอกสารจากลูกค้า',
  `num_home` int(1) DEFAULT NULL COMMENT 'สำเนาทะเบียนบ้าน',
  `num_idcard` int(1) DEFAULT NULL COMMENT 'สำเนาบัตรประชาชน',
  `num_app_statement` int(1) DEFAULT NULL COMMENT 'หนังสือรับรองเงินเดือน',
  `num_statement` int(1) DEFAULT NULL COMMENT 'เอกสาร Statement',
  `room_no` varchar(10) DEFAULT NULL,
  `room_price` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookingdetails`
--

INSERT INTO `bookingdetails` (`id`, `booking_id`, `customer_name`, `customer_tel`, `customer_req`, `customer_req_bank`, `customer_req_bank_other`, `customer_doc_personal`, `num_home`, `num_idcard`, `num_app_statement`, `num_statement`, `room_no`, `room_price`) VALUES
(1, '66001', 'สมศักดิ์ ใจดี', '0999999999', 'ชมห้องตัวอย่าง,พาชมห้องราคา', '', NULL, '', NULL, NULL, NULL, NULL, '99/4', 2000000);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` varchar(11) NOT NULL,
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
  `user_tel` varchar(20) NOT NULL,
  `remark` text DEFAULT NULL COMMENT 'หมายเหตุการจอง',
  `because_cancel_remark` text DEFAULT NULL COMMENT 'เหตุผลยกเลิกการจอง',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_title`, `booking_start`, `booking_end`, `booking_status`, `project_id`, `booking_status_df`, `teampro_id`, `team_id`, `subteam_id`, `user_id`, `user_tel`, `remark`, `because_cancel_remark`, `created_at`, `updated_at`) VALUES
('66001', 'เยี่ยมโครงการ', '2023-04-13 08:00', '2023-04-13 11:00', 0, 2, 0, 3539, 3, 5, 3464, '(099) 999-9999', 'ทดสอบ', NULL, '2023-04-02 17:42:17', '2023-04-02 17:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_users`
--

CREATE TABLE `holiday_users` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `remark` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday_users`
--

INSERT INTO `holiday_users` (`id`, `user_id`, `start_date`, `end_date`, `remark`, `status`) VALUES
(11, 3510, '2023-04-20', '2023-04-21', 'หยุดงาน', 1),
(17, 1233, '2023-04-13', '2023-04-13', 'หยุดงาน', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'โครงการ Altitude  Unicorn', 'enable', NULL, NULL),
(2, 'โครงการมอนเต้ พระราม 9', 'enable', NULL, NULL),
(3, 'โครงการ Be condo', 'enable', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `id` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
  `role_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`id`, `user_id`, `role_type`) VALUES
(1, 3464, 'SuperAdmin'),
(2, 3539, 'Staff'),
(3, 1233, 'Staff'),
(4, 3526, 'Sell'),
(5, 3510, 'Staff'),
(6, 1603, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `subteams`
--

CREATE TABLE `subteams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subteam_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(5, 'สาย บันเทิง', 3, '2023-03-30 16:24:01', '2023-03-30 16:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_name`, `created_at`, `updated_at`) VALUES
(1, 'VIP', '2023-03-04 19:16:09', '2023-03-04 19:16:09'),
(2, 'คุณเซน', '2023-03-04 19:16:09', '2023-03-04 19:16:09'),
(3, 'คุณบอนด์', '2023-03-30 15:55:51', '2023-03-30 15:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `password`, `fullname`, `role`, `team_id`, `active`, `tel`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$ZOMlS2LD8VlfjQbeO6YZa.NGrTgk4gItjBfAMstcsJkA7Y5YU2Uni', 'Admin IT', 'admin', '0', 'enable', NULL, '2023-03-04 03:42:36', '2023-03-04 03:42:36'),
(30, 'jib', '$2y$10$iP8oApxYr89gjfs0frRdiOX/DLdxNs7/Ge8K8Os/mpJ18JmqlIAhK', 'จิ๊ป', 'staff', '0', 'enable', NULL, '2023-03-13 09:01:42', '2023-03-13 09:01:42'),
(31, 'max', '$2y$10$LUraHvihWFIa/x7CBNe9AeictIrtljFGICs5ZFl8fFq9zMjD8oH4u', 'แม็ค', 'staff', '0', 'disable', NULL, '2023-03-13 09:02:04', '2023-03-13 09:02:04'),
(32, 'if', '$2y$10$Ms69PXGE22C66VZGllrW9uHv0EomHPnGFVoa.U06TlFJ.YnPsayUG', 'อีฟ', 'staff', '0', 'enable', NULL, '2023-03-13 09:02:33', '2023-03-13 09:02:33');

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
-- Indexes for table `holiday_users`
--
ALTER TABLE `holiday_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holiday_users`
--
ALTER TABLE `holiday_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subteams`
--
ALTER TABLE `subteams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
