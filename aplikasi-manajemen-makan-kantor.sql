-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 08:58 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi-manajemen-makan-kantor`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1747552700),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1747552700;', 1747552700);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
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
  `attempts` tinyint(3) UNSIGNED NOT NULL,
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
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `karbohidrat` varchar(255) NOT NULL,
  `protein` varchar(255) NOT NULL,
  `sayur` varchar(255) NOT NULL,
  `buah` varchar(255) NOT NULL,
  `kategori_bahan_utama` varchar(255) NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `harga` int(11) NOT NULL DEFAULT 0,
  `jumlah_vote` int(11) NOT NULL DEFAULT 0,
  `terakhir_dipilih` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `nama_menu`, `karbohidrat`, `protein`, `sayur`, `buah`, `kategori_bahan_utama`, `vendor_id`, `harga`, `jumlah_vote`, `terakhir_dipilih`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nasi Ayam Bakar', 'Nasi', 'Ayam', 'Bayam', 'Jeruk', 'Poultry', 3, 20000, 10, '2025-05-09', 1, '2025-03-08 23:39:55', '2025-05-18 00:21:02'),
(2, 'Nasi tahu tempe orek', 'Nasi', 'Tempe', 'Kangkung', 'Mangga', 'Plant-Based', 1, 15000, 0, '2025-05-05', 1, '2025-03-08 23:40:09', '2025-05-18 00:19:59'),
(3, 'Mie Goreng Sapi', 'Mie', 'Sapi', 'Kol', 'Pisang', 'Meat', 2, 30000, 0, '2025-05-07', 1, '2025-03-14 23:29:52', '2025-05-18 08:07:48'),
(4, 'Nasi kari ikan', 'Nasi', 'Ikan', 'Sawi', 'Pisang', 'Seafood', 1, 35000, 0, '2025-05-01', 1, '2025-03-14 23:30:26', '2025-05-18 01:27:46'),
(5, 'Soto ayam', 'Nasi', 'Ayam', 'Kol', 'Pisang', 'Poultry', 2, 20000, 0, '2025-05-12', 1, '2025-03-14 23:30:57', '2025-05-18 00:20:54'),
(6, 'Gado-gado', 'Lontong', 'Tahu', 'Selada', 'Salak', 'Plant-Based', 3, 20000, 0, '2025-05-08', 1, '2025-03-14 23:31:24', '2025-05-18 00:19:59'),
(7, 'Ayam Geprek', 'Nasi', 'Ayam', 'Kangkung', 'Jeruk', 'Poultry', 2, 25000, 0, '2025-05-02', 1, '2025-03-14 23:31:49', '2025-05-18 09:12:55'),
(8, 'Rendang Sapi', 'Nasi', 'Sapi', 'Sawi', 'Pisang', 'Meat', 1, 35000, 0, '2025-05-06', 1, '2025-03-14 23:33:53', '2025-05-18 09:11:39'),
(9, 'Gado-gado', 'Nasi', 'Tempe', 'Selada', 'Mangga', 'Plant-Based', 3, 20000, 0, NULL, 1, '2025-05-18 01:35:04', '2025-05-18 01:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `menus_deck`
--

CREATE TABLE `menus_deck` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `total_serve` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `tanggal_pelaksanaan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus_deck`
--

INSERT INTO `menus_deck` (`id`, `menu_id`, `total_serve`, `status`, `tanggal_pelaksanaan`, `created_at`, `updated_at`) VALUES
(1, 4, '200', 1, '2025-05-01', '2025-05-18 00:19:04', '2025-05-18 01:27:46'),
(2, 7, '400', 1, '2025-05-02', '2025-05-18 00:19:59', '2025-05-18 09:12:55'),
(3, 2, NULL, 0, '2025-05-05', '2025-05-18 00:19:59', '2025-05-18 00:19:59'),
(4, 8, '200', 0, '2025-05-06', '2025-05-18 00:19:59', '2025-05-18 09:11:39'),
(5, 3, '250', 1, '2025-05-07', '2025-05-18 00:19:59', '2025-05-18 08:07:48'),
(6, 6, NULL, 0, '2025-05-08', '2025-05-18 00:19:59', '2025-05-18 00:19:59'),
(7, 1, '120', 1, '2025-05-09', '2025-05-18 00:19:59', '2025-05-18 00:21:02'),
(8, 5, '200', 1, '2025-05-12', '2025-05-18 00:19:59', '2025-05-18 00:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `menu_deck_expenses`
--

CREATE TABLE `menu_deck_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_deck_id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi_biaya` varchar(255) NOT NULL,
  `jumlah_biaya` decimal(12,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_deck_expenses`
--

INSERT INTO `menu_deck_expenses` (`id`, `menu_deck_id`, `deskripsi_biaya`, `jumlah_biaya`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 8, 'Biaya Pokok', '4000000.00', 1, '2025-05-18 00:20:54', '2025-05-18 00:20:54'),
(2, 7, 'Biaya Pokok', '2400000.00', 1, '2025-05-18 00:21:02', '2025-05-18 00:21:02'),
(3, 1, 'Biaya Pokok', '7000000.00', 1, '2025-05-18 01:27:46', '2025-05-18 01:27:46'),
(4, 5, 'Biaya Pokok', '7500000.00', 1, '2025-05-18 08:07:48', '2025-05-18 08:07:48'),
(5, 5, 'Biaya Pokok', '7500000.00', 1, '2025-05-18 08:07:48', '2025-05-18 08:07:48'),
(6, 4, 'Biaya Pokok', '7000000.00', 1, '2025-05-18 09:11:39', '2025-05-18 09:11:39'),
(7, 2, 'Biaya Pokok', '10000000.00', 1, '2025-05-18 09:12:55', '2025-05-18 09:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `menu_deck_payments`
--

CREATE TABLE `menu_deck_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_deck_id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi_pembayaran` varchar(255) NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_deck_payments`
--

INSERT INTO `menu_deck_payments` (`id`, `menu_deck_id`, `deskripsi_pembayaran`, `jumlah_bayar`, `tanggal_bayar`, `metode_pembayaran`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 8, 'Pelunasan', '4000000.00', '2025-05-18', 'Cash', NULL, '2025-05-18 00:21:46', '2025-05-18 00:21:46');

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
(57, '0001_01_01_000000_create_users_table', 1),
(58, '0001_01_01_000001_create_cache_table', 1),
(59, '0001_01_01_000002_create_jobs_table', 1),
(60, '2025_01_01_000001_create_vendors_table', 1),
(61, '2025_01_01_000002_create_menus_table', 1),
(62, '2025_01_01_000003_create_menus_deck_table', 1),
(63, '2025_01_01_000004_create_menu_deck_expenses_table', 1),
(64, '2025_01_01_000005_create_menu_deck_payments_table', 1);

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
('9igx5r4bOqvJyJGAlFXnG4a8UhVv0a8mPkrXtzAQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWElXQUFoSFF6andHbjdRU0tFM0JaUzE5MWRBV2NjdFF3WXBXTHp2RiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1747587984),
('fdVt4bhnut6MP47iTn9ene4q2z6JIVIrIS1SEWs2', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQmlNQWwyeVdPbHJubUhESEtjWWdkWlFSNGNmV3VZNmE0NG91OWFSMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1747589587),
('HmrpXuGHhr2Z7x8cc77CUOhKmfriv7raqQgKYVPX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT2lZMDFERnFKQ1VURGpkdGluZlVHNElDalFVVWQzNDJ6N1NEVWVoVCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbWVudXMtZGVjay84L2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1747559618);

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mark', 'markus.nugraha14.petra@gmail.com', '2025-05-18 00:17:20', '$2y$12$d8a8zsFxfrE2GEBpJfuDjO.cRlJQKFbqyTGLBLhQsYjNxx.zwiM5q', NULL, '2025-05-18 00:17:04', '2025-05-18 00:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kontak` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `penilaian` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `nama`, `kontak`, `alamat`, `email`, `penilaian`, `keterangan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Vendor 1', '08123456789', 'Alamat Vendor 1', 'vendor1@gmail.com', '3.5', NULL, 1, '2025-03-08 23:39:35', '2025-03-08 23:39:35'),
(2, 'Vendor 2', '12345666', 'Alamat Vendor 2', 'vendor2@gmail.com', '4', NULL, 1, '2025-03-15 02:42:20', '2025-03-15 02:42:48'),
(3, 'Vendor 3', '123459990', 'Alamat Vendor 3', 'vendor3@gmail.com', '4', NULL, 1, '2025-03-15 02:42:21', '2025-03-15 02:43:13');

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
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `menus_deck`
--
ALTER TABLE `menus_deck`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_deck_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `menu_deck_expenses`
--
ALTER TABLE `menu_deck_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_deck_expenses_menu_deck_id_foreign` (`menu_deck_id`);

--
-- Indexes for table `menu_deck_payments`
--
ALTER TABLE `menu_deck_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_deck_payments_menu_deck_id_foreign` (`menu_deck_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menus_deck`
--
ALTER TABLE `menus_deck`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu_deck_expenses`
--
ALTER TABLE `menu_deck_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu_deck_payments`
--
ALTER TABLE `menu_deck_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus_deck`
--
ALTER TABLE `menus_deck`
  ADD CONSTRAINT `menus_deck_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_deck_expenses`
--
ALTER TABLE `menu_deck_expenses`
  ADD CONSTRAINT `menu_deck_expenses_menu_deck_id_foreign` FOREIGN KEY (`menu_deck_id`) REFERENCES `menus_deck` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_deck_payments`
--
ALTER TABLE `menu_deck_payments`
  ADD CONSTRAINT `menu_deck_payments_menu_deck_id_foreign` FOREIGN KEY (`menu_deck_id`) REFERENCES `menus_deck` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
