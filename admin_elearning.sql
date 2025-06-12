-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2025 at 10:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('e_learning_cache_admin@joki-admin.com|127.0.0.1', 'i:1;', 1749636188),
('e_learning_cache_admin@joki-admin.com|127.0.0.1:timer', 'i:1749636188;', 1749636188);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_rooms`
--

CREATE TABLE `class_rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('reguler','bimbel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reguler',
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `schedule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_rooms`
--

INSERT INTO `class_rooms` (`id`, `name`, `subject`, `description`, `type`, `teacher_id`, `schedule`, `price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Matematika Lanjutan', 'Mathematics', 'Advanced mathematics course covering calculus, algebra, and geometry for high school students.', 'bimbel', 1, 'Monday & Wednesday 16:00-18:00', 500000.00, 1, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(2, 'Matematika Umum', 'Mathematics', 'Basic mathematics course for middle school students.', 'reguler', 1, 'Tuesday & Thursday 14:00-16:00', NULL, 1, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(3, 'Dasar-Dasar Fisika', 'Physics', 'Comprehensive physics course covering mechanics, thermodynamics, and electromagnetism.', 'bimbel', 2, 'Tuesday & Thursday 16:00-18:00', 450000.00, 1, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(4, 'Percakapan Bahasa Inggris', 'English', 'Improve your English speaking and listening skills through interactive conversations.', 'bimbel', 3, 'Wednesday & Friday 15:00-17:00', 400000.00, 1, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(5, 'Bahasa Inggris Dasar', 'English', 'Foundation English course for beginners.', 'reguler', 3, 'Monday & Friday 13:00-15:00', NULL, 1, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(6, 'Kimia Organik', 'Chemistry', 'Intensive chemistry course focusing on organic compounds and reactions.', 'bimbel', 4, 'Saturday 09:00-12:00', 550000.00, 1, '2025-06-11 01:30:19', '2025-06-11 01:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `class_student`
--

CREATE TABLE `class_student` (
  `id` bigint UNSIGNED NOT NULL,
  `class_room_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_student`
--

INSERT INTO `class_student` (`id`, `class_room_id`, `student_id`, `enrolled_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-06-11 08:30:19', '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(2, 3, 2, '2025-06-11 08:30:19', '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(3, 6, 4, '2025-06-11 08:30:19', '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(4, 2, 5, '2025-06-11 08:30:19', '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(5, 5, 6, '2025-06-11 08:30:19', '2025-06-11 01:30:19', '2025-06-11 01:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_11_044455_create_teachers_table', 1),
(5, '2025_06_11_044504_create_students_table', 1),
(6, '2025_06_11_044511_create_class_rooms_table', 1),
(7, '2025_06_11_044518_create_payments_table', 1),
(8, '2025_06_11_044542_create_class_student_table', 1),
(9, '2025_06_11_052026_add_payment_fields_to_payments_table', 1),
(10, '2025_06_11_052715_add_teacher_fields_to_teachers_table', 1),
(11, '2025_06_11_052901_add_classroom_fields_to_class_rooms_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `class_room_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `class_room_id`, `amount`, `payment_method`, `transaction_id`, `payment_proof`, `proof_image_path`, `status`, `notes`, `approved_at`, `approved_by`, `rejected_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 500000.00, 'bank_transfer', 'TXN001234567', 'payment_proofs/1749633840_4044930.jpg', NULL, 'approved', 'Payment for Advanced Mathematics course', '2025-06-11 01:30:19', 1, NULL, '2025-06-11 01:30:19', '2025-06-11 02:24:00'),
(2, 2, 3, 450000.00, 'e_wallet', 'TXN001234568', NULL, NULL, 'approved', 'Payment for Physics Fundamentals course', '2025-06-11 01:30:19', 1, NULL, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(3, 3, 4, 400000.00, 'bank_transfer', 'TXN001234569', 'payment_proofs/1749634281_1.jpg', NULL, 'pending', 'Payment for English Conversation course', NULL, NULL, NULL, '2025-06-11 01:30:19', '2025-06-11 02:31:21'),
(4, 4, 6, 550000.00, 'cash', NULL, NULL, NULL, 'approved', 'Cash payment for Organic Chemistry course', '2025-06-11 01:30:19', 1, NULL, '2025-06-11 01:30:19', '2025-06-11 01:30:19'),
(5, 5, 1, 500000.00, 'bank_transfer', 'TXN001234570', 'payment_proofs/1749634262_2er.jpg', NULL, 'pending', 'Lucas wants to upgrade to Advanced Mathematics', NULL, NULL, NULL, '2025-06-11 01:30:19', '2025-06-11 02:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Av9NvcJC13e0FOc8n8DDlwoEBWTIt8zJSSmfrjPQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiREh6YlZHakxYaDhNdGNVT1FqSEIyQ2d2SjVqZUlUb1JEeWlVYUJ4cyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1749636063),
('d9scJnUHSrsB1Bcq62OZlNqZYRuX1OStbmdB8AgD', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmo4S2I4YVdJdDB1VVlpMUlaaDhhakZQWFFaNEsycTRoQkhKUkhNMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749635682),
('dmF2mGnWPOJ3y5fqkCEKEmSuXP26lTAnCdOxPSfg', 1, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidUxkT2g4NlZsUnlvYnZFYXlockNWWWlTdGxsY1FlMVp2SEN0aXY2NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9qb2tpLWFkbWluLnRlc3QvYWRtaW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1749633975),
('hHK2QnLekJdsadYlV8RGTX9XSfzUy80ThBbaatIq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWWRybjZjeEp0RUJjbEVyU3djZE1IM2U3aVJHWWRWcUF4c241NnhVeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1749636333),
('tZbCJCNEJNdItl3DHbH0zkP87gRsnSWi6OxbXkGJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNTdMOVJYczBoVVpuazN4TUVsYlJMZ0I5T0xTaDFIeWtmMHlidWtxOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749635524);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `student_id`, `date_of_birth`, `address`, `created_at`, `updated_at`) VALUES
(1, 6, 'STU001', '2005-05-15', 'Jl. Merdeka No. 123, Jakarta', '2025-06-11 01:30:14', '2025-06-11 01:30:14'),
(2, 7, 'STU002', '2005-08-20', 'Jl. Sudirman No. 456, Jakarta', '2025-06-11 01:30:16', '2025-06-11 01:30:16'),
(3, 8, 'STU003', '2004-12-10', 'Jl. Thamrin No. 789, Jakarta', '2025-06-11 01:30:17', '2025-06-11 01:30:17'),
(4, 9, 'STU004', '2005-03-25', 'Jl. Gatot Subroto No. 101, Jakarta', '2025-06-11 01:30:18', '2025-06-11 01:30:18'),
(5, 10, 'STU005', '2005-07-08', 'Jl. Kuningan No. 202, Jakarta', '2025-06-11 01:30:18', '2025-06-11 01:30:18'),
(6, 11, 'STU006', '2004-11-30', 'Jl. Senayan No. 303, Jakarta', '2025-06-11 01:30:19', '2025-06-11 01:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `employee_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `employee_id`, `subject`, `qualification`, `experience`, `bio`, `created_at`, `updated_at`) VALUES
(1, 2, 'EMP001', 'Mathematics', 'Ph.D in Mathematics', '10 years', NULL, '2025-06-11 01:30:12', '2025-06-11 01:30:12'),
(2, 3, 'EMP002', 'Physics', 'M.Sc in Physics', '8 years', NULL, '2025-06-11 01:30:12', '2025-06-11 01:30:12'),
(3, 4, 'EMP003', 'English', 'M.A in English Literature', '5 years', NULL, '2025-06-11 01:30:12', '2025-06-11 01:30:12'),
(4, 5, 'EMP004', 'Chemistry', 'M.Sc in Chemistry', '7 years', NULL, '2025-06-11 01:30:13', '2025-06-11 01:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','teacher','student') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '081234567890', 'admin', NULL, '$2y$12$EndNKFAM7xUugwd7cVbPlOV07Sk4Dfm95ujKv1GWa9LKlLTMorNFO', NULL, '2025-06-11 01:30:11', '2025-06-11 01:30:11'),
(2, 'Dr. Sarah Johnson', 'sarah.johnson@ -admin.com', '081234567890', 'teacher', '2025-06-11 01:30:12', '$2y$12$GSGCslLbtDfhV.4J/O4i0OdDUjF040B7.odqy/DqoyZmhZSLdjXSS', NULL, '2025-06-11 01:30:12', '2025-06-11 01:30:12'),
(3, 'Prof. Michael Chen', 'michael.chen@ -admin.com', '081234567891', 'teacher', '2025-06-11 01:30:12', '$2y$12$saVTr8XrE.2SN9351acKpeq4JxPhLnqF4Afc2TPglS11B/TePDDsy', NULL, '2025-06-11 01:30:12', '2025-06-11 01:30:12'),
(4, 'Mrs. Lisa Anderson', 'lisa.anderson@ -admin.com', '081234567892', 'teacher', '2025-06-11 01:30:12', '$2y$12$DXpWQ.JUKaGI43GAKlvd8eRH8hFDsEH7CZh6cDPADYtCnXbJA.FMG', NULL, '2025-06-11 01:30:12', '2025-06-11 01:30:12'),
(5, 'Mr. David Rodriguez', 'david.rodriguez@ -admin.com', '081234567893', 'teacher', '2025-06-11 01:30:13', '$2y$12$OkhAimBK05hem1BsT20RseFWFw1fG6xcYvE5EiKwyt1VgullOVI7W', NULL, '2025-06-11 01:30:13', '2025-06-11 01:30:13'),
(6, 'John Smith', 'john.smith@student.com', '082345678901', 'student', '2025-06-11 01:30:14', '$2y$12$yTBUh43BILw8cBZ/QUguP.gsDTTPQE/csf2nC.5306x44CkI7x5pi', NULL, '2025-06-11 01:30:14', '2025-06-11 01:30:14'),
(7, 'Emily Davis', 'emily.davis@student.com', '082345678902', 'student', '2025-06-11 01:30:16', '$2y$12$0mo4SBSVZGdQfjLkRBwnUuLJni3jSC1b7FBWl8VTMEvi4IxyMZGiG', NULL, '2025-06-11 01:30:16', '2025-06-11 01:30:16'),
(8, 'Ryan Wilson', 'ryan.wilson@student.com', '082345678903', 'student', '2025-06-11 01:30:17', '$2y$12$sVZ7g/XUcfw/z56Y1NSHLOmoP3DR97vQnwTAjMP.AG6kF7BfDQXZi', NULL, '2025-06-11 01:30:17', '2025-06-11 01:30:17'),
(9, 'Sophia Brown', 'sophia.brown@student.com', '082345678904', 'student', '2025-06-11 01:30:18', '$2y$12$.l8OrjI8kYk.YUqakHQ4bOoMGCtBjWnw4b6XaoY/uK8sXE0qHJVG.', NULL, '2025-06-11 01:30:18', '2025-06-11 01:30:18'),
(10, 'Lucas Miller', 'lucas.miller@student.com', '082345678905', 'student', '2025-06-11 01:30:18', '$2y$12$ZspoqTgbAhL8g2FCHdoI3e.xc5hUVmJFgRLDEvbgv0ecM.dPGZA5u', NULL, '2025-06-11 01:30:18', '2025-06-11 01:30:18'),
(11, 'Olivia Garcia', 'olivia.garcia@student.com', '082345678906', 'student', '2025-06-11 01:30:19', '$2y$12$6K5fiIEHSFWxcMfBVZMr/.h5x98wtWGyUQ5GNo4pn0FxnDcyJg8uG', NULL, '2025-06-11 01:30:19', '2025-06-11 01:30:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `class_rooms`
--
ALTER TABLE `class_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_rooms_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `class_student`
--
ALTER TABLE `class_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_student_class_room_id_student_id_unique` (`class_room_id`,`student_id`),
  ADD KEY `class_student_student_id_foreign` (`student_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_student_id_foreign` (`student_id`),
  ADD KEY `payments_class_room_id_foreign` (`class_room_id`),
  ADD KEY `payments_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD KEY `students_user_id_foreign` (`user_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_employee_id_unique` (`employee_id`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_rooms`
--
ALTER TABLE `class_rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `class_student`
--
ALTER TABLE `class_student`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_rooms`
--
ALTER TABLE `class_rooms`
  ADD CONSTRAINT `class_rooms_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `class_student`
--
ALTER TABLE `class_student`
  ADD CONSTRAINT `class_student_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
