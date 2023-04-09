-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2023 at 08:27 PM
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
  `customer_tel` varchar(20) NOT NULL,
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
(23, '66001', 'สมศักดิ์ ใจดี', '(069) 554-5121', 'ชมห้องตัวอย่าง,พาชมห้องราคา', '', NULL, '', NULL, NULL, NULL, NULL, 'A420', 1200000);

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
  `because_cancel_other` text DEFAULT NULL COMMENT 'เหตุผลยกเลิกการจองอื่น ๆ',
  `job_detailsubmission` text DEFAULT NULL COMMENT 'รายละเอียดรับงาน',
  `job_img` varchar(255) DEFAULT NULL COMMENT 'รูป',
  `job_score` int(11) DEFAULT NULL COMMENT 'คะแนน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_title`, `booking_start`, `booking_end`, `booking_status`, `project_id`, `booking_status_df`, `teampro_id`, `team_id`, `subteam_id`, `user_id`, `user_tel`, `remark`, `because_cancel_remark`, `because_cancel_other`, `job_detailsubmission`, `job_img`, `job_score`, `created_at`, `updated_at`) VALUES
('66001', 'เยี่ยมโครงการ', '2023-04-20 15:00', '2023-04-20 18:00', NULL, 166, 0, 1233, 4, 11, 3526, '(022) 222-2222', NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-09 15:16:03', '2023-04-09 18:26:33');

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
(4, 3526, 'Sale'),
(5, 3510, 'Staff'),
(6, 1603, 'Admin'),
(7, 3511, 'Sale');

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
(2, 'เสืออสังหา', 1, '2023-03-04 19:19:12', '2023-04-09 14:56:33'),
(5, 'Commando', 2, '2023-03-30 16:24:01', '2023-04-09 14:57:03'),
(6, 'คุณต่อ', 3, '2023-04-09 05:16:11', '2023-04-09 14:58:02'),
(7, 'คุณวิรัตน์', 3, '2023-04-09 14:58:44', '2023-04-09 14:58:44'),
(8, 'คุณแจม', 4, '2023-04-09 14:59:31', '2023-04-09 15:00:16'),
(9, 'TMRL', 4, '2023-04-09 15:00:28', '2023-04-09 15:00:28'),
(10, 'ลิซ่า', 4, '2023-04-09 15:01:14', '2023-04-09 15:01:14'),
(11, 'คุณเอ้/คุณปุ๋ย', 4, '2023-04-09 15:01:56', '2023-04-09 15:01:56'),
(12, 'ดร.กุ้ง', 4, '2023-04-09 15:03:19', '2023-04-09 15:03:19'),
(13, 'คุณแอ๊พ', 5, '2023-04-09 15:05:20', '2023-04-09 15:05:20'),
(14, 'OBL', 5, '2023-04-09 15:06:10', '2023-04-09 15:06:10'),
(15, 'BKK1', 6, '2023-04-09 15:07:20', '2023-04-09 15:07:20'),
(16, 'BKK2', 6, '2023-04-09 15:07:42', '2023-04-09 15:07:42');

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
(2, 'VVIP', '2023-03-04 19:16:09', '2023-04-09 14:50:51'),
(3, 'คุณต่อ', '2023-03-30 15:55:51', '2023-04-09 14:51:19'),
(4, 'คุณแจม', '2023-04-09 14:51:56', '2023-04-09 14:51:56'),
(5, 'คุณแอ็พ(ศิระ)', '2023-04-09 14:52:34', '2023-04-09 15:05:44'),
(6, 'คุณเซน', '2023-04-09 14:53:03', '2023-04-09 14:53:03');

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
(1, 'admin', '$2y$10$ZOMlS2LD8VlfjQbeO6YZa.NGrTgk4gItjBfAMstcsJkA7Y5YU2Uni', 'Admin IT', 'admin', '0', 'enable', NULL, '2023-03-04 03:42:36', '2023-03-04 03:42:36');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `holiday_users`
--
ALTER TABLE `holiday_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subteams`
--
ALTER TABLE `subteams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
