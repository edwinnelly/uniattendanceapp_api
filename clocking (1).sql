-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 11, 2026 at 11:57 AM
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
-- Database: `clocking`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `timetable_id` bigint(20) UNSIGNED NOT NULL,
  `clock_in_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `clock_out_time` timestamp NULL DEFAULT NULL,
  `clock_in_latitude` decimal(10,8) NOT NULL,
  `clock_in_longitude` decimal(11,8) NOT NULL,
  `clock_in_accuracy` decimal(5,2) DEFAULT NULL,
  `distance_meters` decimal(10,2) DEFAULT NULL,
  `status` enum('present','late','absent','excused') NOT NULL DEFAULT 'present',
  `source` enum('mobile','web','manual','qr_code') NOT NULL DEFAULT 'mobile',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-edwineke25@gmail.com|127.0.0.1', 'i:1;', 1789049913),
('laravel-cache-edwineke25@gmail.com|127.0.0.1:timer', 'i:1789049913;', 1789049913);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `credit_hours` int(11) NOT NULL DEFAULT 3,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department_id`, `level_id`, `code`, `title`, `description`, `credit_hours`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'VEL A CULPA ANIM ODI', 'Voluptatum corrupti omnis architecto r', 'Voluptate et distinc', 6, 1, '2026-09-07 13:47:59', '2026-09-07 13:47:59'),
(2, 2, 4, 'FACILIS FUGIAT SIT C', 'Omnis et aut consectetur magnam consequuntur', 'Delectus repudianda', 2, 1, '2026-09-07 13:48:02', '2026-09-07 13:48:02'),
(3, 1, 2, 'ENIM FUGIAT SEQUI SI', 'Est praesentium nostrud qui aut unde i', 'In in aliquam conseq', 3, 0, '2026-09-07 13:48:07', '2026-09-07 13:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `head_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `head_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cyrus Norris', 'NON EXERCITATIONEM A', 'Qui assumenda ab aut', NULL, 1, '2026-09-07 13:47:04', '2026-09-07 13:47:04'),
(2, 'Callie Warren', 'BLANDITIIS SED NIHIL', 'Veniam beatae elige', NULL, 1, '2026-09-07 13:47:10', '2026-09-07 13:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_locations`
--

CREATE TABLE `lecture_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(50) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `radius_meters` int(11) NOT NULL DEFAULT 50,
  `building` varchar(100) DEFAULT NULL,
  `floor` varchar(20) DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecture_locations`
--

INSERT INTO `lecture_locations` (`id`, `name`, `code`, `latitude`, `longitude`, `radius_meters`, `building`, `floor`, `room_number`, `capacity`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 'Brennan Hamilton', 'IPSUM SIT DESERUNT DUCIMUS SUNT DOLOR FUGIAT N', 34.00000000, 1.00000000, 1024, 'Perspiciatis eu qui', 'Sint unde qui natus', '171', 9330, 1, '2026-09-07 20:58:27', '2026-09-07 20:58:27'),
(11, 'Wesley Franklin', 'MOLLITIA EST INCIDUNT EVENIET VENIAM VELIT LABO', 65.00000000, 85.00000000, 26, 'Enim modi velit quae', 'Eligendi deserunt fu', '430', 6110, 1, '2026-09-10 20:33:46', '2026-09-10 20:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `level_order` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `program_id`, `name`, `code`, `level_order`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Karen Hutchinson', 'IPSA SINT REM QUIA', 69, 'Id praesentium aliqu', '2026-09-07 13:47:35', '2026-09-07 13:47:35'),
(2, 1, 'Elliott Mcneil', 'DUCIMUS POSSIMUS C', 15, 'Commodo dolor nulla', '2026-09-07 13:47:38', '2026-09-07 13:47:38'),
(3, 1, 'Hope Austin', 'SED AB SED OFFICIA N', 54, 'Aperiam consectetur', '2026-09-07 13:47:40', '2026-09-07 13:47:40'),
(4, 1, 'Cynthia Raymond', 'ANIM FACERE PERFEREN', 20, 'Esse ipsum velit s', '2026-09-07 13:47:43', '2026-09-07 13:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_27_110954_create_personal_access_tokens_table', 1),
(5, '2026_09_03_201519_create_departments_table', 1),
(6, '2026_09_03_201520_create_programs_table', 1),
(7, '2026_09_03_201521_create_levels_table', 1),
(8, '2026_09_03_201522_create_courses_table', 1),
(9, '2026_09_03_201523_create_lecture_locations_table', 1),
(10, '2026_09_03_201524_create_timetables_table', 1),
(11, '2026_09_03_201525_create_attendances_table', 1),
(12, '2026_09_03_201526_create_notifications_table', 1),
(13, '2026_09_07_133545_create_sparents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `type` enum('reminder','attendance','announcement','alert') NOT NULL DEFAULT 'attendance',
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(20) NOT NULL,
  `duration_years` int(11) NOT NULL DEFAULT 4,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `department_id`, `name`, `code`, `duration_years`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lana Stevenson', 'CULPA ERROR DEBITIS', 2, 'Ea Nam exercitatione', 1, '2026-09-07 13:47:20', '2026-09-07 13:47:20'),
(2, 2, 'Jacob Langley', 'EU SUNT EST NON AS', 1, 'Nisi hic rerum illum', 1, '2026-09-07 13:47:24', '2026-09-07 13:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AFPJ7w7sCtegdq47voPO2FEIeY36d7b5m9vh7z5T', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.132.1 Chrome/148.0.7778.280 Electron/42.7.1 Safari/537.36', 'eyJfdG9rZW4iOiIyTVV4NzdFN3ZiUklndHdPSTRyMUY1Y3FpWmhycnhxRHFqOG9wb2ZMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1789068991),
('OAToRlF2xTjKfymNBdsDhPr8wZl1rWq7Zjv4Yl2U', 8, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJFMFVoMTF2UlR2a0IzVkdQRThDZWhuR2F2WVVtUHVSOVF6WEprdzlCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdHRlbmRhbmNlXC9jcmVhdGUiLCJyb3V0ZSI6ImF0dGVuZGFuY2UuY3JlYXRlIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjh9', 1789078543);

-- --------------------------------------------------------

--
-- Table structure for table `sparents`
--

CREATE TABLE `sparents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `student_id1` varchar(30) DEFAULT NULL,
  `student_id2` varchar(30) DEFAULT NULL,
  `student_id3` varchar(30) DEFAULT NULL,
  `student_id4` varchar(30) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `alternate_phone` varchar(20) DEFAULT NULL,
  `occupation` varchar(150) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `emergency_contact_name` varchar(150) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `relationship_type` varchar(50) DEFAULT NULL,
  `relationship_to_student` varchar(50) DEFAULT NULL,
  `is_primary_contact` tinyint(1) NOT NULL DEFAULT 0,
  `receives_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sparents`
--

INSERT INTO `sparents` (`id`, `created_at`, `updated_at`, `student_id1`, `student_id2`, `student_id3`, `student_id4`, `title`, `first_name`, `last_name`, `email`, `phone`, `alternate_phone`, `occupation`, `home_address`, `city`, `state`, `country`, `postal_code`, `emergency_contact_name`, `emergency_contact_phone`, `relationship_type`, `relationship_to_student`, `is_primary_contact`, `receives_notifications`, `is_active`) VALUES
(2, '2026-09-07 13:52:17', '2026-09-07 13:52:43', '958', NULL, NULL, NULL, 'Mrs', 'Paul', 'Prince', 'zehido@mailinator.com', '+1 (486) 404-7541', '+1 (433) 765-9261', 'Esse minus sit numq', 'Eos est unde cum ve', 'Aperiam odit excepte', 'Consequat Officia e', 'Quidem veniam conse', NULL, 'Whilemina Reeves', '+1 (146) 279-7556', 'Mother', NULL, 0, 0, 1),
(3, '2026-09-07 18:56:53', '2026-09-07 18:56:53', NULL, NULL, NULL, NULL, 'Prof', 'Paula', 'Baxter', 'fuwa@mailinator.com', '+1 (399) 443-7091', '+1 (806) 954-4349', 'Ipsum possimus qui', 'Deserunt explicabo', 'Tenetur adipisci in', 'Voluptatem dolores m', 'Eligendi quaerat vol', NULL, 'Dawn Hensley', '+1 (596) 849-6385', 'Father', NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `lecturer_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `attendance_window_minutes` int(11) NOT NULL DEFAULT 15,
  `status` enum('scheduled','ongoing','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `cancel_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `course_id`, `lecturer_id`, `location_id`, `level_id`, `date`, `start_time`, `end_time`, `attendance_window_minutes`, `status`, `cancel_reason`, `created_at`, `updated_at`) VALUES
(2, 3, 3, 11, 2, '2026-09-10', '02:22:00', '04:25:00', 15, 'scheduled', NULL, '2026-09-10 20:19:13', '2026-09-10 20:34:17'),
(3, 2, 2, 10, 3, '2026-09-10', '01:33:00', '22:38:00', 16, 'scheduled', NULL, '2026-09-10 20:33:24', '2026-09-10 20:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','lecturer','admin','parent') NOT NULL DEFAULT 'student',
  `phone` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `relationship_to_student` varchar(50) DEFAULT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `enrollment_year` year(4) DEFAULT NULL,
  `employee_number` varchar(50) DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `phone`, `profile_photo`, `parent_id`, `relationship_to_student`, `student_number`, `program_id`, `level_id`, `enrollment_year`, `employee_number`, `department_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Joshua Harmon', 'lewohun@mailinator.com', NULL, '$2y$12$HEG8OTcEaZKdsoBg6VXvee0mj7VUfNUGPiv9aIMeYH.o.FaRAtQ3q', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-09-07 13:45:49', '2026-09-07 13:45:49'),
(2, 'Daquan Whitney', 'lizoh@mailinator.com', NULL, '$2y$12$XYFA1JY28xiMJ66dB2q3tOBcKUL9myQQh21Xfmc94zwP0nhMurkoi', 'lecturer', '+1 (882) 526-6433', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '190', 1, 1, NULL, '2026-09-07 13:48:25', '2026-09-07 13:48:25'),
(3, 'Scarlett Maddox', 'bazi@mailinator.com', NULL, '$2y$12$.MQN3s1Yun23e0ZpVYxc0OKXxiMyBKJs.tZjicuanuiWhsW8CZ7g2', 'lecturer', '+1 (468) 671-7879', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '828', 2, 1, NULL, '2026-09-07 13:48:31', '2026-09-07 13:48:31'),
(4, 'Teegan George', 'husydywis@mailinator.com', NULL, '$2y$12$IR230/2C75i6oHe1PeFZI.MgHbMZAKtatDcQypVb7BsZYEymfHWx6', 'student', '+1 (237) 751-4999', NULL, NULL, NULL, '958', 1, 2, '2004', NULL, 1, 1, NULL, '2026-09-07 13:48:45', '2026-09-07 13:48:45'),
(5, 'Lacy Hart', 'zuxodupyf@mailinator.com', NULL, '$2y$12$aJQgyFiruXafLk9NXIUZPO/9d79V0MgbVj6RKTo5IrD4OXmo9yV7O', 'student', '+1 (631) 616-9329', NULL, NULL, NULL, '201', 1, 3, '2000', NULL, 1, 1, NULL, '2026-09-07 13:48:51', '2026-09-07 13:48:51'),
(6, 'Marcia Bird', 'tuvuq@mailinator.com', NULL, '$2y$12$8F3P1AbRjAvdCsdU8axUHOkubGLnzW1laplDn0M9Ck8Q1s8hhSieO', 'student', '+1 (388) 678-8414', NULL, NULL, NULL, '443', 1, 3, '2009', NULL, 1, 1, NULL, '2026-09-07 13:48:59', '2026-09-07 13:48:59'),
(7, 'Gillian Osborn', 'mabez@mailinator.com', NULL, '$2y$12$Sw53Qv7xZRj5ZP.TrQHkI.b7vJB/Zt/CNLHUad.VfYZu./v44sBie', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-09-07 21:13:41', '2026-09-07 21:13:41'),
(8, 'Rooney Henderson', 'relejyjumy@mailinator.com', NULL, '$2y$12$12GbQPFxlLxLsfB162s4f.OtBsxNylK0wCZaObOP.DaSx3X1QuCpe', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-09-10 13:17:45', '2026-09-10 13:17:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`student_id`,`timetable_id`),
  ADD KEY `attendance_student_id_index` (`student_id`),
  ADD KEY `attendance_timetable_id_index` (`timetable_id`),
  ADD KEY `attendance_clock_in_time_index` (`clock_in_time`),
  ADD KEY `attendance_status_index` (`status`),
  ADD KEY `attendance_student_id_clock_in_time_index` (`student_id`,`clock_in_time`),
  ADD KEY `attendance_timetable_id_status_index` (`timetable_id`,`status`),
  ADD KEY `attendance_source_index` (`source`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_code_unique` (`code`),
  ADD KEY `courses_department_id_index` (`department_id`),
  ADD KEY `courses_level_id_index` (`level_id`),
  ADD KEY `courses_code_index` (`code`),
  ADD KEY `courses_is_active_index` (`is_active`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_code_index` (`code`),
  ADD KEY `departments_is_active_index` (`is_active`),
  ADD KEY `departments_head_id_index` (`head_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_locations`
--
ALTER TABLE `lecture_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lecture_locations_code_unique` (`code`),
  ADD KEY `lecture_locations_code_index` (`code`),
  ADD KEY `lecture_locations_latitude_longitude_index` (`latitude`,`longitude`),
  ADD KEY `lecture_locations_is_active_index` (`is_active`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `levels_program_id_name_unique` (`program_id`,`name`),
  ADD UNIQUE KEY `levels_program_id_code_unique` (`program_id`,`code`),
  ADD KEY `levels_program_id_index` (`program_id`),
  ADD KEY `levels_level_order_index` (`level_order`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_index` (`user_id`),
  ADD KEY `notifications_user_id_read_at_index` (`user_id`,`read_at`),
  ADD KEY `notifications_type_index` (`type`),
  ADD KEY `notifications_created_at_index` (`created_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programs_code_unique` (`code`),
  ADD KEY `programs_department_id_index` (`department_id`),
  ADD KEY `programs_code_index` (`code`),
  ADD KEY `programs_is_active_index` (`is_active`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sparents`
--
ALTER TABLE `sparents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sparents_email_unique` (`email`),
  ADD KEY `sparents_email_index` (`email`),
  ADD KEY `sparents_phone_index` (`phone`),
  ADD KEY `sparents_is_active_index` (`is_active`),
  ADD KEY `sparents_relationship_type_index` (`relationship_type`),
  ADD KEY `sparents_student_id1_index` (`student_id1`),
  ADD KEY `sparents_student_id2_index` (`student_id2`),
  ADD KEY `sparents_student_id3_index` (`student_id3`),
  ADD KEY `sparents_student_id4_index` (`student_id4`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetables_course_id_index` (`course_id`),
  ADD KEY `timetables_lecturer_id_index` (`lecturer_id`),
  ADD KEY `timetables_location_id_index` (`location_id`),
  ADD KEY `timetables_level_id_index` (`level_id`),
  ADD KEY `timetables_date_index` (`date`),
  ADD KEY `timetables_lecturer_id_date_index` (`lecturer_id`,`date`),
  ADD KEY `timetables_location_id_date_index` (`location_id`,`date`),
  ADD KEY `timetables_course_id_date_index` (`course_id`,`date`),
  ADD KEY `timetables_status_index` (`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_student_number_unique` (`student_number`),
  ADD UNIQUE KEY `users_employee_number_unique` (`employee_number`),
  ADD KEY `users_user_type_index` (`user_type`),
  ADD KEY `users_program_id_index` (`program_id`),
  ADD KEY `users_level_id_index` (`level_id`),
  ADD KEY `users_department_id_index` (`department_id`),
  ADD KEY `users_student_number_index` (`student_number`),
  ADD KEY `users_employee_number_index` (`employee_number`),
  ADD KEY `users_is_active_index` (`is_active`),
  ADD KEY `users_parent_id_index` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture_locations`
--
ALTER TABLE `lecture_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sparents`
--
ALTER TABLE `sparents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_head_id_foreign` FOREIGN KEY (`head_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
