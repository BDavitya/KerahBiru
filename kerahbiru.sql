-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 03, 2025 at 09:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kerahbiru`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_11_10_042512_create_users_table', 1),
(3, '2025_11_10_042523_create_workers_table', 1),
(4, '2025_11_10_042550_create_worker_schedules_table', 1),
(5, '2025_11_10_042602_create_orders_table', 1),
(6, '2025_11_10_042609_create_vouchers_table', 1),
(7, '2025_11_24_041644_add_aproval_status_to_workers_table', 2),
(8, '2025_11_24_041716_add_is_booked_to_worker_schedules_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance_km` decimal(8,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','accepted','on_the_way','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `photo_before` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_after` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_rating` decimal(3,2) DEFAULT NULL,
  `user_review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `worker_arrived_at` timestamp NULL DEFAULT NULL,
  `work_started_at` timestamp NULL DEFAULT NULL,
  `work_completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `worker_id`, `order_date`, `time_slot`, `distance_km`, `total_price`, `status`, `photo_before`, `photo_after`, `user_rating`, `user_review`, `worker_arrived_at`, `work_started_at`, `work_completed_at`, `created_at`, `updated_at`) VALUES
(1, 3, 3, '2025-11-18', '08:00-10:00', '4.89', '220000.00', 'in_progress', 'orders/before/oWW6FMO2jWjNDp6iFQG5FuLl6ZxrQWlwbfPS0tOi.jpg', NULL, NULL, NULL, NULL, '2025-11-15 22:01:40', NULL, '2025-11-15 22:01:20', '2025-11-15 22:01:40'),
(3, 6, 1, '2025-11-27', '10:00 - 12:00 WIB', '4.81', '150000.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-16 12:44:25', '2025-11-16 12:44:25'),
(4, 6, 1, '2025-11-19', '10:00 - 12:00 WIB', '4.81', '150000.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-16 12:46:07', '2025-11-16 12:46:07'),
(8, 13, 3, '2025-11-26', '03:00 - 05:00 GMT', '4.89', '220000.00', 'completed', 'orders/before/C1yYuGLFou15BLU1mGJGQZjN0dMcRWGP3RHcRgue.jpg', 'orders/after/0OgkYzhVrDKLwCeWGRc4bHKTPWFBHjRXXwWUeKlc.jpg', '4.50', 'keren banget liss recommend', NULL, '2025-11-23 00:17:28', '2025-11-23 00:17:56', '2025-11-23 00:17:01', '2025-11-23 00:18:11'),
(9, 13, 3, '2025-11-26', '08:00 - 10:00 GMT', '4.89', '220000.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-23 00:18:52', '2025-11-23 00:18:52'),
(10, 13, 3, '2025-11-26', '03:00 - 05:00 GMT', '4.89', '220000.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-23 00:19:08', '2025-11-23 00:19:08'),
(11, 12, 4, '2025-11-28', '11:00 - 13:00 WITA', '4.89', '120000.00', 'in_progress', 'orders/before/a3gbmbiTlCURq3tv95LKVmnSjJKZusURrxWzNfkb.jpg', NULL, NULL, NULL, NULL, '2025-11-23 00:39:24', NULL, '2025-11-23 00:38:58', '2025-11-23 00:39:24'),
(12, 15, 4, '2025-11-25', '20:00 - 22:00 EST', '5.20', '120000.00', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-23 15:11:10', '2025-11-24 01:15:13'),
(26, 12, 3, '2025-09-13', '15:00 - 17:00', '3.40', '69613.00', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-12 23:00:00', '2025-09-12 23:00:00'),
(36, 57, 2, '2025-10-06', '08:00 - 10:00', '3.64', '121405.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 23:00:00', '2025-10-05 23:00:00'),
(37, 87, 3, '2025-10-24', '20:00 - 22:00 EST', '6.35', '157587.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 23:00:00', '2025-10-23 23:00:00'),
(40, 58, 1, '2025-09-06', '15:00 - 17:00', '9.69', '101902.00', 'accepted', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-05 23:00:00', '2025-09-05 23:00:00'),
(52, 69, 4, '2025-11-14', '08:00 - 10:00', '10.01', '157331.00', 'accepted', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-13 23:00:00', '2025-11-13 23:00:00'),
(74, 9, 1, '2025-11-12', '10:00 - 12:00 WIB', '11.56', '233303.00', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-11 23:00:00', '2025-11-11 23:00:00'),
(75, 51, 2, '2025-09-02', '10:00 - 12:00 WIB', '8.48', '82570.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-01 23:00:00', '2025-09-01 23:00:00'),
(76, 57, 1, '2025-10-24', '03:00 - 05:00 GMT', '4.83', '84290.00', 'completed', 'orders/before/seed_before_76.jpg', NULL, '4.26', 'sangat ramah dan teliti.', '2025-10-24 14:00:00', '2025-10-24 14:09:00', '2025-10-24 15:09:00', '2025-10-23 23:00:00', '2025-10-23 23:00:00'),
(77, 12, 4, '2025-10-08', '15:00 - 17:00', '11.41', '105944.00', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-07 23:00:00', '2025-11-24 16:29:01'),
(82, 32, 3, '2025-09-02', '13:00 - 15:00', '2.08', '88609.00', 'completed', 'orders/before/seed_before_82.jpg', NULL, '3.50', 'datang telat tapi bagus kerjanya.', '2025-09-02 21:00:00', '2025-09-02 21:46:00', '2025-09-02 22:46:00', '2025-09-01 23:00:00', '2025-09-01 23:00:00'),
(88, 72, 2, '2025-10-28', '08:00 - 10:00', '10.78', '93108.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-27 23:00:00', '2025-10-27 23:00:00'),
(90, 6, 3, '2025-10-17', '10:00 - 12:00 WIB', '6.31', '124400.00', 'completed', 'orders/before/seed_before_90.jpg', 'orders/after/seed_after_90.jpg', '3.59', 'kerja rapih dan cepat.', '2025-10-17 07:00:00', '2025-10-17 07:36:00', '2025-10-17 09:36:00', '2025-10-16 23:00:00', '2025-10-16 23:00:00'),
(110, 16, 4, '2025-10-03', '08:00 - 10:00', '2.95', '98369.00', 'completed', NULL, NULL, '4.75', 'datang telat tapi bagus kerjanya.', '2025-10-03 00:00:00', '2025-10-03 00:53:00', '2025-10-03 02:53:00', '2025-10-02 23:00:00', '2025-10-02 23:00:00'),
(117, 49, 2, '2025-11-09', '08:00 - 10:00', '2.06', '152044.00', 'completed', 'orders/before/seed_before_117.jpg', NULL, '4.39', 'kerja rapih dan cepat.', '2025-11-09 06:00:00', '2025-11-09 06:58:00', '2025-11-09 08:58:00', '2025-11-08 23:00:00', '2025-11-08 23:00:00'),
(126, 60, 4, '2025-09-13', '20:00 - 22:00 EST', '3.99', '91936.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-12 23:00:00', '2025-09-12 23:00:00'),
(132, 40, 1, '2025-09-22', '20:00 - 22:00 EST', '3.85', '109471.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-21 23:00:00', '2025-09-21 23:00:00'),
(144, 94, 3, '2025-09-24', '03:00 - 05:00 GMT', '0.57', '148273.00', 'completed', NULL, 'orders/after/seed_after_144.jpg', '3.87', 'kerja rapih dan cepat.', '2025-09-24 03:00:00', '2025-09-24 03:26:00', '2025-09-24 04:26:00', '2025-09-23 23:00:00', '2025-09-23 23:00:00'),
(147, 53, 1, '2025-09-01', '03:00 - 05:00 GMT', '7.28', '78869.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-31 23:00:00', '2025-08-31 23:00:00'),
(152, 65, 1, '2025-09-19', '15:00 - 17:00', '11.59', '170793.00', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-18 23:00:00', '2025-09-18 23:00:00'),
(157, 74, 4, '2025-11-23', '03:00 - 05:00 GMT', '7.55', '135357.00', 'on_the_way', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-22 23:00:00', '2025-11-22 23:00:00'),
(169, 43, 2, '2025-10-27', '03:00 - 05:00 GMT', '2.86', '77268.00', 'completed', NULL, 'orders/after/seed_after_169.jpg', '4.03', 'kerja rapih dan cepat.', '2025-10-27 15:00:00', '2025-10-27 15:13:00', '2025-10-27 16:13:00', '2025-10-26 23:00:00', '2025-10-26 23:00:00'),
(171, 64, 2, '2025-10-11', '15:00 - 17:00', '3.17', '113120.00', 'completed', 'orders/before/seed_before_171.jpg', NULL, '4.65', 'sangat ramah dan teliti.', '2025-10-11 18:00:00', '2025-10-11 18:11:00', '2025-10-11 19:11:00', '2025-10-10 23:00:00', '2025-10-10 23:00:00'),
(176, 76, 4, '2025-08-31', '13:00 - 15:00', '6.19', '223975.00', 'completed', 'orders/before/seed_before_176.jpg', 'orders/after/seed_after_176.jpg', '4.75', 'recommended banget.', '2025-08-31 09:00:00', '2025-08-31 09:11:00', '2025-08-31 11:11:00', '2025-08-30 23:00:00', '2025-08-30 23:00:00'),
(182, 88, 3, '2025-09-27', '10:00 - 12:00 WIB', '3.93', '151884.00', 'completed', 'orders/before/seed_before_182.jpg', 'orders/after/seed_after_182.jpg', '3.98', 'recommended banget.', '2025-09-27 10:00:00', '2025-09-27 10:45:00', '2025-09-27 11:45:00', '2025-09-26 23:00:00', '2025-09-26 23:00:00'),
(208, 79, 2, '2025-11-03', '08:00 - 10:00', '9.07', '98016.00', 'accepted', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-02 23:00:00', '2025-11-02 23:00:00'),
(211, 16, 1, '2025-11-13', '20:00 - 22:00 EST', '11.57', '161560.00', 'completed', NULL, NULL, '4.12', 'baik dan komunikatif.', '2025-11-13 10:00:00', '2025-11-13 10:28:00', '2025-11-13 11:28:00', '2025-11-12 23:00:00', '2025-11-12 23:00:00'),
(214, 33, 1, '2025-10-03', '08:00 - 10:00', '3.20', '76272.00', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-02 23:00:00', '2025-10-02 23:00:00'),
(216, 3, 1, '2025-08-30', '20:00 - 22:00 EST', '1.65', '114143.00', 'completed', 'orders/before/seed_before_216.jpg', 'orders/after/seed_after_216.jpg', '4.91', 'recommended banget.', '2025-08-30 15:00:00', '2025-08-30 15:05:00', '2025-08-30 16:05:00', '2025-08-29 23:00:00', '2025-08-29 23:00:00'),
(226, 61, 1, '2025-09-28', '08:00 - 10:00', '7.47', '164585.00', 'in_progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 23:00:00', '2025-09-27 23:00:00'),
(233, 96, 2, '2025-11-25', '10:00-12:00', '6.84', '180000.00', 'completed', 'orders/before/r55hJhiGowlx0IyrCMZ6adFV1u8B1sulTExvbKzo.jpg', 'orders/after/FK7uMsLXSO9mseU2UKkaaCxZbhiRg6g4ixzlmyFJ.jpg', '4.50', 'keren bngt plls', NULL, '2025-11-24 01:37:36', '2025-11-24 01:40:48', '2025-11-24 01:36:15', '2025-11-24 01:41:32'),
(235, 97, 32, '2025-12-02', '10:00-12:00', '3.66', '40000.00', 'completed', 'orders/before/d7L66s8zBa0BgDoPoedBe2I1r7aEC6IKK1zKndYu.jpg', 'orders/after/oZFU9yRrY7M7yjkZ5ejqC5RhmNnaJZKX4t9Ue59N.jpg', '4.00', 'sangat terpercayaaa', NULL, '2025-11-30 21:30:46', '2025-11-30 21:32:24', '2025-11-30 21:25:38', '2025-11-30 21:32:52'),
(237, 98, 32, '2025-12-03', '13:00-15:00', '4.74', '40000.00', 'accepted', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-30 23:20:36', '2025-11-30 23:21:03'),
(238, 99, 32, '2025-12-03', '10:00-12:00', '5.04', '40000.00', 'completed', 'orders/before/QtLus3n8YnIG6KqjfGBPaDTADHkjByNQXOVaifO8.jpg', 'orders/after/9D9RgWDpevgEgngSLr8BoStZXCwiwmzMdYHn6k1P.jpg', '4.50', 'bagus pisan', NULL, '2025-12-01 01:49:00', '2025-12-01 01:49:59', '2025-12-01 01:45:29', '2025-12-01 01:51:06'),
(239, 99, 32, '2025-12-03', '08:00-10:00', '5.04', '40000.00', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-01 01:53:09', '2025-12-01 01:53:30'),
(240, 100, 1, '2025-12-04', '13:00-15:00', '4.81', '150000.00', 'completed', 'orders/before/2cpSZw0TzxDgUyYmVmvTpr6wOWAjKbWrxGgq2Yy2.jpg', 'orders/after/qLU4khSNcCQ6C5HOOKNBIeOOJ4VRCwcTzzjHwspY.jpg', '4.50', 'hua kerreeenpiosssnnn', NULL, '2025-12-03 12:56:53', '2025-12-03 12:57:13', '2025-12-03 12:23:18', '2025-12-03 12:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gamification_points` int(11) NOT NULL DEFAULT 0,
  `last_shake_date` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `preferred_currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `preferred_timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Asia/Jakarta',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `photo`, `is_verified`, `verification_token`, `gamification_points`, `last_shake_date`, `latitude`, `longitude`, `preferred_currency`, `preferred_timezone`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'bar', 'bdavitya@gmail.com', '7d23a3d5450bfdbb474176fcbc0fd247ae6ad8e4a01ef88510720d86d603761d', '081313536957', 'jogjah jogjahhh', NULL, 1, NULL, 0, NULL, '-7.76958300', '110.40432270', 'IDR', 'Asia/Jakarta', '2025-11-12 03:56:19', NULL, '2025-11-12 03:56:19', '2025-11-12 04:00:40'),
(3, 'Jessica', 've@gmail.do', 'd1c7c99c6e2e7b311f51dd9d19161a5832625fb21f35131fba6da62513f0c099', '082175768874', 'Perumahan apa ya, ya gitu', 'users/BVIOpFrImnBbuazWy7yg1WMMPGkMuJMzGcI9JujK.jpg', 1, NULL, 12, '2025-11-15 13:59:29', '-7.76961440', '110.40437110', 'EUR', 'Asia/Jayapura', '2025-11-15 13:09:38', NULL, '2025-11-15 13:09:41', '2025-11-15 22:00:31'),
(4, 'hiu', 'hiu@g.i', 'aaa9402664f1a41f40ebbc52c9993eb66aeb366602958fdfaa283b71e64db123', '081354349799', 'jalan jalan ke kota baru cakep', NULL, 1, NULL, 0, NULL, '-7.76962470', '110.40438430', 'IDR', 'Asia/Jakarta', '2025-11-15 22:11:29', NULL, '2025-11-15 22:11:29', '2025-11-15 22:12:29'),
(5, 'bim', 'Bim@mail.co', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-16 12:27:12', '2025-11-16 12:27:34'),
(6, 'oi', 'o@go.i', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '123', 'go', NULL, 1, NULL, 0, NULL, '-7.76961400', '110.40437140', 'SGD', 'America/New_York', NULL, NULL, '2025-11-16 12:41:51', '2025-11-16 12:48:14'),
(11, 'vee', 'v@gmail.co', '7d23a3d5450bfdbb474176fcbc0fd247ae6ad8e4a01ef88510720d86d603761d', '082175768874', 'hdjjsbskhhh', 'users/d1wczRUri0gikCOgBYKqRrlunKm6BiTUx2ghigHh.jpg', 1, NULL, 0, NULL, '-7.76955990', '110.40428040', 'USD', 'Asia/Makassar', NULL, NULL, '2025-11-17 00:42:53', '2025-11-17 00:44:32'),
(12, 'Melody', 'mel@d.y', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '123', 'jalan dki', NULL, 1, NULL, 0, NULL, '-7.76961560', '110.40437990', 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-22 23:09:23', '2025-12-01 00:09:51'),
(13, 'hiuw', 'hiu@hi.u', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '081313536957', 'Jl. Selokan Mataram GriyaHarapan Mulya No.2 3 M, Condongcatur, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', NULL, 1, NULL, 0, NULL, '-7.76956012', '110.40432406', 'MYR', 'Europe/London', NULL, NULL, '2025-11-23 00:14:11', '2025-11-23 00:16:45'),
(14, 'Jessica Vania', 'je@j.e', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '081313536957', 'Jl. Jend. Urip Sumoharjo No.8-A, Klitren, Kecamatan Gondokusuman, Kota Yogyakarta, Daerah Istimewa Yogyakarta', 'users/lt8rAAKvxqlA5xPFZawbAXEsq8UQqBUgZooyAEN8.jpg', 1, NULL, 0, NULL, '-7.78337284', '110.38045607', 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-23 02:20:05', '2025-11-23 02:42:47'),
(15, 'nabilah', 'na@n.a', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '081313536957', 'Seberang Holand Bakery, Caturtunggal, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', NULL, 1, NULL, 0, NULL, '-7.77199416', '110.40919522', 'EUR', 'America/New_York', NULL, NULL, '2025-11-23 15:02:30', '2025-11-23 15:05:05'),
(16, 'Intan Susanto', 'intan.susanto16@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.16, Yogyakarta', NULL, 1, NULL, 377, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-09 23:00:00', NULL),
(17, 'Yoga Pratama', 'yoga.pratama17@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08001338908', 'Jl. Contoh No.17, Yogyakarta', NULL, 1, NULL, 279, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-30 23:00:00', NULL),
(18, 'Hendra Halim', 'hendra.halim18@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08026542351', 'Jl. Contoh No.18, Yogyakarta', NULL, 1, NULL, 433, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-09 23:00:00', NULL),
(19, 'Rizal Saputra', 'rizal.saputra19@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08781618495', 'Jl. Contoh No.19, Yogyakarta', NULL, 1, NULL, 23, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-30 23:00:00', NULL),
(20, 'Hendra Nugroho', 'hendra.nugroho20@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08316475255', 'Jl. Contoh No.20, Yogyakarta', NULL, 1, NULL, 479, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-27 23:00:00', NULL),
(21, 'Intan Pratama', 'intan.pratama21@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08283276483', 'Jl. Contoh No.21, Yogyakarta', NULL, 0, NULL, 397, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-15 23:00:00', NULL),
(22, 'Hendra Wijaya', 'hendra.wijaya22@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08641395376', 'Jl. Contoh No.22, Yogyakarta', 'users/seed_22.jpg', 1, NULL, 73, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-20 23:00:00', NULL),
(23, 'Joko Hartono', 'joko.hartono23@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08849696532', 'Jl. Contoh No.23, Yogyakarta', NULL, 1, NULL, 24, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-04 23:00:00', NULL),
(24, 'Rina Irawan', 'rina.irawan24@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08691669784', 'Jl. Contoh No.24, Yogyakarta', 'users/seed_24.jpg', 0, NULL, 5, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-27 23:00:00', NULL),
(25, 'Eka Susanto', 'eka.susanto25@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08845146270', 'Jl. Contoh No.25, Yogyakarta', 'users/seed_25.jpg', 0, NULL, 134, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-19 23:00:00', NULL),
(27, 'Rizal Haryanto', 'rizal.haryanto27@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08154303911', 'Jl. Contoh No.27, Yogyakarta', 'users/seed_27.jpg', 0, NULL, 500, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-17 23:00:00', NULL),
(28, 'Farid Irawan', 'farid.irawan28@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08782489638', 'Jl. Contoh No.28, Yogyakarta', 'users/seed_28.jpg', 1, NULL, 365, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-14 23:00:00', NULL),
(29, 'Agus Permata', 'agus.permata29@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08871331509', 'Jl. Contoh No.29, Yogyakarta', NULL, 1, NULL, 3, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-13 23:00:00', NULL),
(30, 'Maya Wijaya', 'maya.wijaya30@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08051834738', 'Jl. Contoh No.30, Yogyakarta', NULL, 0, NULL, 292, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-10 23:00:00', NULL),
(31, 'Rahma Hartono', 'rahma.hartono31@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08631165667', 'Jl. Contoh No.31, Yogyakarta', 'users/seed_31.jpg', 1, NULL, 334, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-01 23:00:00', NULL),
(32, 'Rina Wijaya', 'rina.wijaya32@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08513338726', 'Jl. Contoh No.32, Yogyakarta', NULL, 1, NULL, 447, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-07-27 23:00:00', NULL),
(33, 'Siti Halim', 'siti.halim33@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08810801326', 'Jl. Contoh No.33, Yogyakarta', NULL, 1, NULL, 205, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-07-30 23:00:00', NULL),
(34, 'Budi Kusuma', 'budi.kusuma34@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08647468723', 'Jl. Contoh No.34, Yogyakarta', NULL, 0, NULL, 296, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-20 23:00:00', NULL),
(35, 'Farid Wijaya', 'farid.wijaya35@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08009788208', 'Jl. Contoh No.35, Yogyakarta', NULL, 1, NULL, 304, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-14 23:00:00', NULL),
(36, 'Yoga Hartono', 'yoga.hartono36@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08939909169', 'Jl. Contoh No.36, Yogyakarta', NULL, 1, NULL, 133, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-27 23:00:00', NULL),
(37, 'Yoga Haryanto', 'yoga.haryanto37@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08624751079', 'Jl. Contoh No.37, Yogyakarta', 'users/seed_37.jpg', 0, NULL, 37, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-15 23:00:00', NULL),
(38, 'Lina Saputra', 'lina.saputra38@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08513542784', 'Jl. Contoh No.38, Yogyakarta', NULL, 0, NULL, 334, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-16 23:00:00', NULL),
(39, 'Andi Nugroho', 'andi.nugroho39@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08124118244', 'Jl. Contoh No.39, Yogyakarta', NULL, 1, NULL, 104, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-27 23:00:00', NULL),
(40, 'Intan Saputra', 'intan.saputra40@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08401640052', 'Jl. Contoh No.40, Yogyakarta', NULL, 1, NULL, 379, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-27 23:00:00', NULL),
(41, 'Farid Maulana', 'farid.maulana41@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08112805982', 'Jl. Contoh No.41, Yogyakarta', NULL, 1, NULL, 186, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-07-30 23:00:00', NULL),
(42, 'Mega Wijaya', 'mega.wijaya42@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08331586923', 'Jl. Contoh No.42, Yogyakarta', 'users/seed_42.jpg', 0, NULL, 415, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-31 23:00:00', NULL),
(43, 'Wulan Santoso', 'wulan.santoso43@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08563421607', 'Jl. Contoh No.43, Yogyakarta', NULL, 0, NULL, 235, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-09 23:00:00', NULL),
(44, 'Faisal Hartono', 'faisal.hartono44@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08365414586', 'Jl. Contoh No.44, Yogyakarta', NULL, 0, NULL, 169, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-19 23:00:00', NULL),
(45, 'Rina Saputra', 'rina.saputra45@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08401965569', 'Jl. Contoh No.45, Yogyakarta', 'users/seed_45.jpg', 1, NULL, 460, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-10 23:00:00', NULL),
(46, 'Lina Saputra', 'lina.saputra46@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.46, Yogyakarta', NULL, 1, NULL, 412, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-15 23:00:00', NULL),
(47, 'Yoga Wahyudi', 'yoga.wahyudi47@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08159514846', 'Jl. Contoh No.47, Yogyakarta', NULL, 1, NULL, 283, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-06 23:00:00', NULL),
(48, 'Lina Maulana', 'lina.maulana48@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08629946804', 'Jl. Contoh No.48, Yogyakarta', NULL, 1, NULL, 296, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-06 23:00:00', NULL),
(49, 'Intan Haryanto', 'intan.haryanto49@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08738721489', 'Jl. Contoh No.49, Yogyakarta', NULL, 0, NULL, 384, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-23 23:00:00', NULL),
(50, 'Yoga Nugroho', 'yoga.nugroho50@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08320037917', 'Jl. Contoh No.50, Yogyakarta', NULL, 1, NULL, 99, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-23 23:00:00', NULL),
(51, 'Maya Siregar', 'maya.siregar51@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08320163287', 'Jl. Contoh No.51, Yogyakarta', NULL, 1, NULL, 434, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-07 23:00:00', NULL),
(52, 'Yudi Irawan', 'yudi.irawan52@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08889579868', 'Jl. Contoh No.52, Yogyakarta', NULL, 1, NULL, 441, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-23 23:00:00', NULL),
(53, 'Yudi Saputra', 'yudi.saputra53@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08487347143', 'Jl. Contoh No.53, Yogyakarta', NULL, 1, NULL, 276, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-12 23:00:00', NULL),
(54, 'Joko Irawan', 'joko.irawan54@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08231665876', 'Jl. Contoh No.54, Yogyakarta', NULL, 0, NULL, 199, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-07-30 23:00:00', NULL),
(55, 'Tito Santoso', 'tito.santoso55@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08967054668', 'Jl. Contoh No.55, Yogyakarta', 'users/seed_55.jpg', 1, NULL, 308, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-07-31 23:00:00', NULL),
(56, 'Hendra Aditya', 'hendra.aditya56@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08670656272', 'Jl. Contoh No.56, Yogyakarta', 'users/seed_56.jpg', 1, NULL, 464, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-03 23:00:00', NULL),
(57, 'Lia Santoso', 'lia.santoso57@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.57, Yogyakarta', NULL, 0, NULL, 93, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-16 23:00:00', NULL),
(58, 'Rudi Siregar', 'rudi.siregar58@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08755646417', 'Jl. Contoh No.58, Yogyakarta', NULL, 1, NULL, 487, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-09 23:00:00', NULL),
(59, 'Hendra Pratama', 'hendra.pratama59@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08003309232', 'Jl. Contoh No.59, Yogyakarta', NULL, 1, NULL, 485, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-26 23:00:00', NULL),
(60, 'Yudi Saputra', 'yudi.saputra60@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08299124190', 'Jl. Contoh No.60, Yogyakarta', 'users/seed_60.jpg', 1, NULL, 464, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-05 23:00:00', NULL),
(61, 'Agus Wahyudi', 'agus.wahyudi61@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.61, Yogyakarta', NULL, 1, NULL, 52, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-25 23:00:00', NULL),
(62, 'Tito Nugroho', 'tito.nugroho62@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08919058651', 'Jl. Contoh No.62, Yogyakarta', NULL, 1, NULL, 434, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-30 23:00:00', NULL),
(63, 'Rahma Susanto', 'rahma.susanto63@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08572628498', 'Jl. Contoh No.63, Yogyakarta', 'users/seed_63.jpg', 1, NULL, 422, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-21 23:00:00', NULL),
(64, 'Lia Saputra', 'lia.saputra64@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08314737996', 'Jl. Contoh No.64, Yogyakarta', NULL, 1, NULL, 166, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-30 23:00:00', NULL),
(65, 'Rahma Wahyudi', 'rahma.wahyudi65@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08454948083', 'Jl. Contoh No.65, Yogyakarta', NULL, 1, NULL, 250, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-12 23:00:00', NULL),
(66, 'Tito Hartono', 'tito.hartono66@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08770143634', 'Jl. Contoh No.66, Yogyakarta', NULL, 1, NULL, 283, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-16 23:00:00', NULL),
(67, 'Dian Maulana', 'dian.maulana67@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08855744431', 'Jl. Contoh No.67, Yogyakarta', 'users/seed_67.jpg', 1, NULL, 380, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-15 23:00:00', NULL),
(68, 'Tito Kusuma', 'tito.kusuma68@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08749894134', 'Jl. Contoh No.68, Yogyakarta', NULL, 1, NULL, 7, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-24 23:00:00', NULL),
(69, 'Farid Irawan', 'farid.irawan69@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08084271094', 'Jl. Contoh No.69, Yogyakarta', NULL, 1, NULL, 94, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-16 23:00:00', NULL),
(70, 'Rudi Aditya', 'rudi.aditya70@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08167190229', 'Jl. Contoh No.70, Yogyakarta', 'users/seed_70.jpg', 1, NULL, 127, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-07 23:00:00', NULL),
(71, 'Farid Maulana', 'farid.maulana71@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08938677496', 'Jl. Contoh No.71, Yogyakarta', NULL, 1, NULL, 312, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-20 23:00:00', NULL),
(72, 'Rina Wahyudi', 'rina.wahyudi72@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08412328120', 'Jl. Contoh No.72, Yogyakarta', NULL, 1, NULL, 240, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-16 23:00:00', NULL),
(73, 'Budi Hartono', 'budi.hartono73@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08471349361', 'Jl. Contoh No.73, Yogyakarta', NULL, 1, NULL, 465, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-19 23:00:00', NULL),
(74, 'Joko Pratama', 'joko.pratama74@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.74, Yogyakarta', 'users/seed_74.jpg', 1, NULL, 422, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-11 23:00:00', NULL),
(75, 'Faisal Halim', 'faisal.halim75@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08464887719', 'Jl. Contoh No.75, Yogyakarta', NULL, 1, NULL, 165, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-06 23:00:00', NULL),
(76, 'Rudi Santoso', 'rudi.santoso76@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.76, Yogyakarta', 'users/seed_76.jpg', 0, NULL, 294, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-08 23:00:00', NULL),
(77, 'Andi Saputra', 'andi.saputra77@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08278742967', 'Jl. Contoh No.77, Yogyakarta', 'users/seed_77.jpg', 1, NULL, 209, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-11 23:00:00', NULL),
(78, 'Putri Susanto', 'putri.susanto78@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08567468071', 'Jl. Contoh No.78, Yogyakarta', NULL, 1, NULL, 496, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-16 23:00:00', NULL),
(79, 'Agus Santoso', 'agus.santoso79@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08876038597', 'Jl. Contoh No.79, Yogyakarta', NULL, 1, NULL, 104, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-19 23:00:00', NULL),
(80, 'Farid Irawan', 'farid.irawan80@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08771093248', 'Jl. Contoh No.80, Yogyakarta', NULL, 1, NULL, 115, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-07 23:00:00', NULL),
(81, 'Rina Halim', 'rina.halim81@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08274846773', 'Jl. Contoh No.81, Yogyakarta', NULL, 1, NULL, 97, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-07-28 23:00:00', NULL),
(82, 'Rizal Irawan', 'rizal.irawan82@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08465840449', 'Jl. Contoh No.82, Yogyakarta', NULL, 1, NULL, 443, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-03 23:00:00', NULL),
(83, 'Yudi Aditya', 'yudi.aditya83@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08886753396', 'Jl. Contoh No.83, Yogyakarta', NULL, 1, NULL, 22, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-13 23:00:00', NULL),
(85, 'Nina Halim', 'nina.halim85@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.85, Yogyakarta', NULL, 0, NULL, 496, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-03 23:00:00', NULL),
(86, 'Siti Aditya', 'siti.aditya86@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08459615865', 'Jl. Contoh No.86, Yogyakarta', NULL, 0, NULL, 249, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-03 23:00:00', NULL),
(87, 'Farid Wijaya', 'farid.wijaya87@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08343161172', 'Jl. Contoh No.87, Yogyakarta', NULL, 0, NULL, 23, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-12 23:00:00', NULL),
(88, 'Mega Wijaya', 'mega.wijaya88@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08562386922', 'Jl. Contoh No.88, Yogyakarta', NULL, 1, NULL, 195, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-04 23:00:00', NULL),
(90, 'Yudi Permata', 'yudi.permata90@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08464743671', 'Jl. Contoh No.90, Yogyakarta', NULL, 1, NULL, 294, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-10-16 23:00:00', NULL),
(91, 'Maya Nugroho', 'maya.nugroho91@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', NULL, 'Jl. Contoh No.91, Yogyakarta', 'users/seed_91.jpg', 1, NULL, 4, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-11 23:00:00', NULL),
(92, 'Yoga Wijaya', 'yoga.wijaya92@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08743953394', 'Jl. Contoh No.92, Yogyakarta', NULL, 1, NULL, 337, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-27 23:00:00', NULL),
(93, 'Joko Susanto', 'joko.susanto93@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08047095214', 'Jl. Contoh No.93, Yogyakarta', NULL, 1, NULL, 102, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-06 23:00:00', NULL),
(94, 'Mega Permata', 'mega.permata94@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08424745171', 'Jl. Contoh No.94, Yogyakarta', NULL, 0, NULL, 440, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-08-28 23:00:00', NULL),
(95, 'Eka Siregar', 'eka.siregar95@example.test', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', '08851604817', 'Jl. Contoh No.95, Yogyakarta', NULL, 1, NULL, 134, NULL, NULL, NULL, 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-09-09 23:00:00', NULL),
(96, 'Shinta Naomi', 'nao@m.i', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '081346798520', 'Jl. Ringroad utara no. 1c Mancasan kidul, Condongcatur, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', NULL, 1, NULL, 0, NULL, '-7.76138300', '110.41183292', 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-24 00:42:37', '2025-11-24 01:01:15'),
(97, 'Rona Anggraeni dan', 'rona@gmail.com', '7d23a3d5450bfdbb474176fcbc0fd247ae6ad8e4a01ef88510720d86d603761d', '082175768874', 'Jl. Selokan Mataram GriyaHarapan Mulya No.2 3 M, Condongcatur, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', 'users/vAY54bKjPFdfXt98V2mGUpCAB1yQodijqWRPIb7U.jpg', 1, NULL, 0, NULL, '-7.76961440', '110.40436070', 'EUR', 'Europe/London', NULL, NULL, '2025-11-30 21:24:25', '2025-11-30 21:38:56'),
(98, 'Baritaaa Setyiaa', 'set@j.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '0081134664', 'Jl. Padjajaran Jl. Ring Road Utara No.104, Condongcatur, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', 'users/UZqaPhmHE3xM24doz67iy8Li5dVofmRDh5CVGQ0p.jpg', 1, NULL, 0, NULL, '-7.76244758', '110.41156026', 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-11-30 23:17:20', '2025-11-30 23:18:29'),
(99, 'Barita Davitya', 'bdav@mail.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '0813131313', '6CF9+6QQ, Caturtunggal, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', NULL, 1, NULL, 0, NULL, '-7.77675325', '110.41982958', 'EUR', 'America/New_York', NULL, NULL, '2025-12-01 01:40:49', '2025-12-01 01:54:03'),
(100, 'barbar', 'bar@gmail.com', '08a2d3c63bf9fc88276d97a9e8df5f841fd772724ad10f119f7e516f228b74c6', '081313536957', 'Jl. Selokan Mataram GriyaHarapan Mulya No.2 3 M, Condongcatur, Kecamatan Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', 'users/FabHMQdsjb3TJq7tfpBiNM10j5rbsCEKQhPa3qzT.jpg', 1, NULL, 0, NULL, '-7.76960140', '110.40438060', 'IDR', 'Asia/Jakarta', NULL, NULL, '2025-12-03 11:38:41', '2025-12-03 12:22:08');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_orders` int(11) NOT NULL DEFAULT 0,
  `price_per_hour` decimal(10,2) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `approval_status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `name`, `job_title`, `description`, `gender`, `rating`, `total_orders`, `price_per_hour`, `photo`, `latitude`, `longitude`, `phone`, `whatsapp`, `is_available`, `approval_status`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'Tukang Bangunan', 'Berpengalaman 10 tahun dalam konstruksi bangunan, renovasi rumah, dan pekerjaan sipil lainnya.', 'Laki-laki', '4.45', 4, '75000.00', 'workers/btDCxiCO6kLBem100fYIOkQfeRnOE40kOAagrPS0.png', '-7.79560000', '110.36950000', '081234567890', '081234567890', 1, 'approved', '2025-11-12 03:46:14', '2025-12-03 12:57:43'),
(2, 'Rina Putri', 'Asisten Rumah Tangga', 'Berpengalaman dalam membersihkan rumah, mencuci, menyetrika, dan memasak.', 'Perempuan', '4.39', 4, '90000.00', 'workers/KLpVIrtLULS06YPLtSt5NJtUhxSzJMSHnsBHRtBg.png', '-7.80120000', '110.36450000', '081234567891', '081234567891', 1, 'approved', '2025-11-12 03:46:14', '2025-11-24 01:41:32'),
(3, 'Andi Wijaya', 'Tukang Cat', 'Spesialis pengecatan dinding dan barang lainnya dengan tektur apapun tanpa meninggalkan jejak.', 'Laki-laki', '3.89', 5, '110000.00', 'workers/vSfi3Kd7XshMXrE0FISTd213nmM6IaoptdzSKuNr.png', '-7.79890000', '110.37120000', '081234567892', '081234567892', 1, 'approved', '2025-11-12 03:46:14', '2025-11-23 22:14:07'),
(4, 'Siti Aulia', 'Baby Sitter', 'Menyukai anak-anak dan pandai berinteraksi dengan anak-anak.', 'Perempuan', '4.75', 2, '60000.00', 'workers/MBIuQuvutJTAhI1JYhm1ZNgmrj5AzurUnNuwP16o.png', '-7.79450000', '110.36780000', '081234567893', '081234567893', 1, 'approved', '2025-11-12 03:46:14', '2025-12-03 13:02:54'),
(31, 'Nabilah Ratna', 'Guru Matematika', 'Mengajarkan mata pelajarak matematika dasar hingga unggul di semua jenjang pendidikan.', 'Perempuan', '0.00', 0, '40000.00', 'workers/DmJVVXt7CuUwQ9hL2pSCOPGaXktibmOYI5coa1y6.png', '-7.80202423', '110.39244461', '082175768874', '082175768874', 0, 'approved', '2025-11-30 17:36:48', '2025-11-30 21:47:52'),
(32, 'Jung Ho Seok', 'Jasa Titip', 'Melakukan pembelian barang-barang penitipan apabila Anda tidak bisa keluar rumah.', 'Laki-laki', '4.25', 2, '20000.00', 'workers/kl7AkEL2VWN1RlujXewR4V5VSMf9IHzL5B21KHMr.png', '-7.78453192', '110.37475061', '081313536957', '081313536957', 1, 'approved', '2025-11-30 17:47:29', '2025-12-01 01:51:06'),
(33, 'Jessica Veranda', 'Tukang Listrik', 'Tidak takut mati kesetrum listirk.', 'Perempuan', '0.00', 0, '80000.00', 'workers/vpLdEqBR3pVQO66xLXx7epcJPmco1t8Q7GnUZmW0.png', '-7.78617319', '110.40319061', '81313536957', '81313536957', 0, 'approved', '2025-12-03 11:47:46', '2025-12-03 13:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `worker_schedules`
--

CREATE TABLE `worker_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `booked_date` date DEFAULT NULL,
  `is_booked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_schedules`
--

INSERT INTO `worker_schedules` (`id`, `worker_id`, `day`, `time_slot`, `is_available`, `booked_date`, `is_booked`, `created_at`, `updated_at`) VALUES
(1, 1, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(2, 1, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-23 15:35:34'),
(3, 1, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(4, 1, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(5, 1, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(6, 1, 'Selasa', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(7, 1, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(8, 1, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(9, 1, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(10, 1, 'Rabu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(11, 1, 'Rabu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(12, 1, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(13, 1, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(14, 1, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(15, 1, 'Kamis', '13:00-15:00', 1, '2025-12-04', 1, '2025-11-12 03:46:14', '2025-12-03 12:23:18'),
(16, 1, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(17, 1, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(18, 1, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(19, 1, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(20, 1, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(21, 1, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(22, 1, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(23, 1, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(24, 1, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(25, 2, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(26, 2, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(27, 2, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(28, 2, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(29, 2, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(30, 2, 'Selasa', '10:00-12:00', 1, '2025-11-25', 1, '2025-11-12 03:46:14', '2025-11-24 01:36:15'),
(31, 2, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(32, 2, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(33, 2, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(34, 2, 'Rabu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(35, 2, 'Rabu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(36, 2, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(37, 2, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(38, 2, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(39, 2, 'Kamis', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(40, 2, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(41, 2, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(42, 2, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(43, 2, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(44, 2, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(45, 2, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(46, 2, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(47, 2, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(48, 2, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(49, 3, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(50, 3, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(51, 3, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(52, 3, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(53, 3, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(54, 3, 'Selasa', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(55, 3, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(56, 3, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(57, 3, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(58, 3, 'Rabu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(59, 3, 'Rabu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(60, 3, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(61, 3, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(62, 3, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(63, 3, 'Kamis', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(64, 3, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(65, 3, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(66, 3, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(67, 3, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(68, 3, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(69, 3, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(70, 3, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(71, 3, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(72, 3, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(73, 4, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(74, 4, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(75, 4, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(76, 4, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(77, 4, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(78, 4, 'Selasa', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(79, 4, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(80, 4, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(81, 4, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(82, 4, 'Rabu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(83, 4, 'Rabu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(84, 4, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(85, 4, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(86, 4, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(87, 4, 'Kamis', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(88, 4, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(89, 4, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(90, 4, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(91, 4, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(92, 4, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(93, 4, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(94, 4, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(95, 4, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(96, 4, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-11-12 03:46:14', '2025-11-12 03:46:14'),
(721, 31, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(722, 31, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(723, 31, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(724, 31, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(725, 31, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(726, 31, 'Selasa', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(727, 31, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(728, 31, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(729, 31, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(730, 31, 'Rabu', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(731, 31, 'Rabu', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(732, 31, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(733, 31, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(734, 31, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(735, 31, 'Kamis', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(736, 31, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(737, 31, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(738, 31, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(739, 31, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(740, 31, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(741, 31, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(742, 31, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(743, 31, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(744, 31, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(745, 31, 'Minggu', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(746, 31, 'Minggu', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(747, 31, 'Minggu', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(748, 31, 'Minggu', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:36:49', '2025-11-30 17:36:49'),
(749, 32, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(750, 32, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(751, 32, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(752, 32, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(753, 32, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(754, 32, 'Selasa', '10:00-12:00', 1, '2025-12-02', 1, '2025-11-30 17:47:29', '2025-11-30 21:25:38'),
(755, 32, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(756, 32, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(757, 32, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-12-01 01:53:30'),
(758, 32, 'Rabu', '10:00-12:00', 1, '2025-12-03', 1, '2025-11-30 17:47:29', '2025-12-01 01:45:29'),
(759, 32, 'Rabu', '13:00-15:00', 1, '2025-12-03', 1, '2025-11-30 17:47:29', '2025-11-30 23:20:36'),
(760, 32, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(761, 32, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(762, 32, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(763, 32, 'Kamis', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(764, 32, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(765, 32, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(766, 32, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(767, 32, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(768, 32, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(769, 32, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(770, 32, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(771, 32, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(772, 32, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(773, 32, 'Minggu', '08:00-10:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(774, 32, 'Minggu', '10:00-12:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(775, 32, 'Minggu', '13:00-15:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(776, 32, 'Minggu', '15:00-17:00', 1, NULL, 0, '2025-11-30 17:47:29', '2025-11-30 17:47:29'),
(777, 33, 'Senin', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(778, 33, 'Senin', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(779, 33, 'Senin', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(780, 33, 'Senin', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(781, 33, 'Selasa', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(782, 33, 'Selasa', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(783, 33, 'Selasa', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(784, 33, 'Selasa', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(785, 33, 'Rabu', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(786, 33, 'Rabu', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(787, 33, 'Rabu', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(788, 33, 'Rabu', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(789, 33, 'Kamis', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(790, 33, 'Kamis', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(791, 33, 'Kamis', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(792, 33, 'Kamis', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(793, 33, 'Jumat', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(794, 33, 'Jumat', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(795, 33, 'Jumat', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(796, 33, 'Jumat', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(797, 33, 'Sabtu', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(798, 33, 'Sabtu', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(799, 33, 'Sabtu', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(800, 33, 'Sabtu', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(801, 33, 'Minggu', '08:00-10:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(802, 33, 'Minggu', '10:00-12:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(803, 33, 'Minggu', '13:00-15:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46'),
(804, 33, 'Minggu', '15:00-17:00', 1, NULL, 0, '2025-12-03 11:47:46', '2025-12-03 11:47:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_schedules`
--
ALTER TABLE `worker_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_schedules_worker_id_foreign` (`worker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `worker_schedules`
--
ALTER TABLE `worker_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=805;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `worker_schedules`
--
ALTER TABLE `worker_schedules`
  ADD CONSTRAINT `worker_schedules_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
