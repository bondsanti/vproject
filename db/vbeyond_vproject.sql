-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2023 at 08:32 AM
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
  `room_no` varchar(100) DEFAULT NULL,
  `room_price` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `action` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `description`, `created_at`, `updated_at`) VALUES
(1, '1233', 'Logout', NULL, '2023-05-07 09:16:24', '2023-05-07 09:16:24'),
(2, '3526', 'Login', 'By LoginPage', '2023-05-07 09:21:31', '2023-05-07 09:21:31'),
(3, '3526', 'Create', 'เยี่ยมโครงการ, 66001', '2023-05-07 09:22:43', '2023-05-07 09:22:43'),
(4, '3526', 'Logout', NULL, '2023-05-07 09:22:55', '2023-05-07 09:22:55'),
(5, '3510', 'Login', 'By LoginPage', '2023-05-07 09:23:05', '2023-05-07 09:23:05'),
(6, '3510', 'Update Status', 'เยี่ยมโครงการ, 66001, รับงานแล้ว', '2023-05-07 09:23:28', '2023-05-07 09:23:28'),
(7, '3510', 'Logout', NULL, '2023-05-07 09:23:31', '2023-05-07 09:23:31'),
(8, '3526', 'Login', 'By LoginPage', '2023-05-07 09:23:42', '2023-05-07 09:23:42'),
(9, '3526', 'Update Status', 'เยี่ยมโครงการ, 66001, จองสำเร็จ', '2023-05-07 09:23:56', '2023-05-07 09:23:56'),
(10, '3526', 'Logout', NULL, '2023-05-07 09:24:02', '2023-05-07 09:24:02'),
(11, '3510', 'Login', 'By LoginPage', '2023-05-07 09:24:09', '2023-05-07 09:24:09'),
(12, '3510', 'Update Job Succress', 'เยี่ยมโครงการ, 66001', '2023-05-07 09:24:37', '2023-05-07 09:24:37'),
(13, '3510', 'Update Score', 'เยี่ยมโครงการ, 66001', '2023-05-07 09:24:46', '2023-05-07 09:24:46'),
(14, '3510', 'Update Job Succress', 'เยี่ยมโครงการ, 66001', '2023-05-07 09:46:12', '2023-05-07 09:46:12'),
(15, '3510', 'Logout', NULL, '2023-05-07 09:47:26', '2023-05-07 09:47:26'),
(16, '3526', 'Login', 'By LoginPage', '2023-05-07 09:48:45', '2023-05-07 09:48:45'),
(17, '3526', 'Logout', NULL, '2023-05-07 09:49:27', '2023-05-07 09:49:27'),
(18, '3526', 'Login', 'By LoginPage', '2023-05-07 10:22:15', '2023-05-07 10:22:15'),
(19, '3526', 'Create', 'เยี่ยมโครงการ, 66002', '2023-05-07 10:23:20', '2023-05-07 10:23:20'),
(20, '3526', 'Logout', NULL, '2023-05-07 10:23:27', '2023-05-07 10:23:27'),
(21, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-07 11:43:48', '2023-05-07 11:43:48'),
(22, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-07 11:48:29', '2023-05-07 11:48:29'),
(23, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-07 11:49:41', '2023-05-07 11:49:41'),
(24, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-07 12:00:02', '2023-05-07 12:00:02'),
(25, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ Sale ไม่กดคอนเฟิร์มนัด', '2023-05-07 16:42:43', '2023-05-07 16:42:43'),
(26, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ Sale ไม่กดคอนเฟิร์มนัด', '2023-05-07 16:58:03', '2023-05-07 16:58:03'),
(27, '3464', 'Login', 'By LoginPage', '2023-05-07 17:11:20', '2023-05-07 17:11:20'),
(28, '3526', 'Login', 'By LoginPage', '2023-05-08 02:45:11', '2023-05-08 02:45:11'),
(29, '3526', 'Create', 'เยี่ยมโครงการ, 66001', '2023-05-08 02:45:55', '2023-05-08 02:45:55'),
(30, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-08 02:46:02', '2023-05-08 02:46:02'),
(31, '3526', 'Logout', NULL, '2023-05-08 02:48:19', '2023-05-08 02:48:19'),
(32, '3464', 'Login', 'By LoginPage', '2023-05-08 02:48:26', '2023-05-08 02:48:26'),
(33, '3464', 'Delete', 'เยี่ยมโครงการ, 66001', '2023-05-08 02:48:36', '2023-05-08 02:48:36'),
(34, '3464', 'Logout', NULL, '2023-05-08 02:49:20', '2023-05-08 02:49:20'),
(35, '3464', 'Login', 'By LoginPage', '2023-05-08 02:54:13', '2023-05-08 02:54:13'),
(36, '3464', 'Logout', NULL, '2023-05-08 02:54:29', '2023-05-08 02:54:29'),
(37, '3526', 'Login', 'By LoginPage', '2023-05-08 03:05:19', '2023-05-08 03:05:19'),
(38, '3526', 'Login', 'By LoginPage', '2023-05-08 03:05:20', '2023-05-08 03:05:20'),
(39, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-08 03:25:03', '2023-05-08 03:25:03'),
(40, '3526', 'Create', 'เยี่ยมโครงการ, 66001', '2023-05-08 03:30:10', '2023-05-08 03:30:10'),
(41, '1233', 'Login', 'By LoginPage', '2023-05-08 03:35:33', '2023-05-08 03:35:33'),
(42, '3526', 'Create', 'เยี่ยมโครงการ, 66002', '2023-05-08 03:36:31', '2023-05-08 03:36:31'),
(43, '1233', 'Update Status', 'เยี่ยมโครงการ, 66001, รับงานแล้ว', '2023-05-08 03:36:51', '2023-05-08 03:36:51'),
(44, '3526', 'Create', 'เยี่ยมโครงการ, 66003', '2023-05-08 03:37:10', '2023-05-08 03:37:10'),
(45, '3526', 'Create', 'เยี่ยมโครงการ, 66004', '2023-05-08 03:38:19', '2023-05-08 03:38:19'),
(46, '3526', 'Create', 'เยี่ยมโครงการ, 66005', '2023-05-08 03:38:56', '2023-05-08 03:38:56'),
(47, '3464', 'Login', 'By LoginPage', '2023-05-08 03:49:41', '2023-05-08 03:49:41'),
(48, '3464', 'Logout', NULL, '2023-05-08 03:57:49', '2023-05-08 03:57:49'),
(49, '3539', 'Login', 'By LoginPage', '2023-05-08 03:58:00', '2023-05-08 03:58:00'),
(50, '3464', 'Login', 'By LoginPage', '2023-05-08 04:44:57', '2023-05-08 04:44:57'),
(51, 'System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง', '2023-05-08 05:13:16', '2023-05-08 05:13:16'),
(52, '3464', 'Logout', NULL, '2023-05-08 07:19:26', '2023-05-08 07:19:26'),
(53, '3539', 'Login', 'By LoginPage', '2023-05-08 07:51:50', '2023-05-08 07:51:50'),
(54, '3539', 'Logout', NULL, '2023-05-08 07:56:56', '2023-05-08 07:56:56'),
(55, '3526', 'Login', 'By LoginPage', '2023-05-08 07:58:09', '2023-05-08 07:58:09'),
(56, '3526', 'Logout', NULL, '2023-05-08 08:17:51', '2023-05-08 08:17:51'),
(57, '3464', 'Login', 'By LoginPage', '2023-05-08 08:18:19', '2023-05-08 08:18:19'),
(58, '3464', 'Logout', NULL, '2023-05-08 08:19:31', '2023-05-08 08:19:31'),
(59, '3526', 'Login', 'By LoginPage', '2023-05-08 08:19:44', '2023-05-08 08:19:44'),
(60, '3464', 'Login', 'By LoginPage', '2023-05-09 03:55:42', '2023-05-09 03:55:42'),
(61, '3464', 'Create', 'เยี่ยมโครงการ, 66004', '2023-05-09 04:14:07', '2023-05-09 04:14:07'),
(62, '3464', 'Logout', NULL, '2023-05-09 04:15:20', '2023-05-09 04:15:20'),
(63, '1603', 'Login', 'By LoginPage', '2023-05-09 04:19:36', '2023-05-09 04:19:36'),
(64, '1603', 'Logout', NULL, '2023-05-09 04:20:34', '2023-05-09 04:20:34'),
(65, '3526', 'Login', 'By LoginPage', '2023-05-09 04:20:44', '2023-05-09 04:20:44'),
(66, '3526', 'Create', 'เยี่ยมโครงการ, 66005', '2023-05-09 04:21:54', '2023-05-09 04:21:54'),
(67, '3526', 'Create', 'เยี่ยมโครงการ, 66006', '2023-05-09 04:23:21', '2023-05-09 04:23:21'),
(68, '3526', 'Create', 'เยี่ยมโครงการ, 66007', '2023-05-09 04:27:23', '2023-05-09 04:27:23'),
(69, '3526', 'Logout', NULL, '2023-05-09 04:28:09', '2023-05-09 04:28:09'),
(70, '3464', 'Login', 'By LoginPage', '2023-05-09 04:28:23', '2023-05-09 04:28:23'),
(71, '3464', 'Delete', 'เยี่ยมโครงการ, 66007', '2023-05-09 04:28:29', '2023-05-09 04:28:29'),
(72, '3464', 'Logout', NULL, '2023-05-09 04:28:35', '2023-05-09 04:28:35'),
(73, '3526', 'Login', 'By LoginPage', '2023-05-09 04:28:53', '2023-05-09 04:28:53'),
(74, '3526', 'Create', 'เยี่ยมโครงการ, 66007', '2023-05-09 04:31:52', '2023-05-09 04:31:52'),
(75, '3526', 'Create', 'เยี่ยมโครงการ, 66001', '2023-05-09 04:37:29', '2023-05-09 04:37:29'),
(76, '3526', 'Create', 'เยี่ยมโครงการ, 66002', '2023-05-09 04:39:55', '2023-05-09 04:39:55'),
(77, '3526', 'Create', 'เยี่ยมโครงการ, 66003', '2023-05-09 04:43:20', '2023-05-09 04:43:20'),
(78, '3526', 'Update Booking', 'เยี่ยมโครงการ, 66003', '2023-05-09 04:45:06', '2023-05-09 04:45:06'),
(79, '3526', 'Logout', NULL, '2023-05-09 04:45:27', '2023-05-09 04:45:27'),
(80, '1603', 'Login', 'By LoginPage', '2023-05-09 04:45:41', '2023-05-09 04:45:41'),
(81, '1603', 'Delete', 'เยี่ยมโครงการ, 66003', '2023-05-09 04:45:48', '2023-05-09 04:45:48'),
(82, '1603', 'Logout', NULL, '2023-05-09 04:46:01', '2023-05-09 04:46:01'),
(83, '3526', 'Login', 'By LoginPage', '2023-05-09 04:46:18', '2023-05-09 04:46:18'),
(84, '3526', 'Create', 'เยี่ยมโครงการ, 66003', '2023-05-09 04:46:47', '2023-05-09 04:46:47'),
(85, '1603', 'Login', 'By LoginPage', '2023-05-09 04:52:56', '2023-05-09 04:52:56'),
(86, '1603', 'Delete', 'เยี่ยมโครงการ, 66003', '2023-05-09 04:53:02', '2023-05-09 04:53:02'),
(87, '3526', 'Logout', NULL, '2023-05-09 05:04:04', '2023-05-09 05:04:04'),
(88, '1603', 'Logout', NULL, '2023-05-09 05:05:11', '2023-05-09 05:05:11'),
(89, '3526', 'Login', 'By LoginPage', '2023-05-09 05:57:28', '2023-05-09 05:57:28'),
(90, '3526', 'Logout', NULL, '2023-05-09 06:04:54', '2023-05-09 06:04:54');

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
(2, 'โครงการมอนเต้ พระราม 9', 'enable', NULL, NULL),
(3, 'โครงการ Be condo', 'enable', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `id` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
  `role_type` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`id`, `user_id`, `role_type`, `created_at`, `updated_at`) VALUES
(1, 3464, 'SuperAdmin', NULL, NULL),
(23, 1234, 'SuperAdmin', NULL, NULL);

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
  `team_name` varchar(255) NOT NULL,
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
  `code` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `team_id` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `tel` varchar(10) DEFAULT NULL,
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking_period_employee` (`booking_start`,`booking_end`,`teampro_id`);

--
-- Indexes for table `holiday_users`
--
ALTER TABLE `holiday_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_users`
--
ALTER TABLE `holiday_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
