-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 01:49 PM
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
-- Database: `bank_sampah`
--

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtcategory`
--

CREATE TABLE `mtcategory` (
  `idcategory` int(11) NOT NULL,
  `namecategory` varchar(255) DEFAULT NULL,
  `iduom` varchar(255) NOT NULL,
  `inuserid` varchar(255) DEFAULT NULL,
  `chuserid` varchar(255) DEFAULT NULL,
  `indate` datetime DEFAULT NULL,
  `chdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mtcategory`
--

INSERT INTO `mtcategory` (`idcategory`, `namecategory`, `iduom`, `inuserid`, `chuserid`, `indate`, `chdate`) VALUES
(1, 'kategori1', '2', 'tester', NULL, '2024-02-22 03:25:05', '2024-02-23 08:56:36'),
(2, 'test input', '1', 'adm', NULL, '2024-02-22 04:23:56', NULL),
(3, 'kategori 3', '2', 'adm', NULL, '2024-02-22 04:26:59', '2024-02-23 08:21:39'),
(4, 'karegori baru', '1', 'adm', NULL, '2024-02-22 09:05:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtmember`
--

CREATE TABLE `mtmember` (
  `idmember` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `membercode` varchar(225) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `notelp` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `totalamt` double DEFAULT NULL,
  `aktif` varchar(1) NOT NULL,
  `inuserid` varchar(255) DEFAULT NULL,
  `chuserid` varchar(255) DEFAULT NULL,
  `indate` datetime DEFAULT NULL,
  `chdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mtmember`
--

INSERT INTO `mtmember` (`idmember`, `userid`, `membercode`, `name`, `address`, `notelp`, `mail`, `totalamt`, `aktif`, `inuserid`, `chuserid`, `indate`, `chdate`) VALUES
(27, 'mem', 'MBDed4762f7789f4ea', 'mem', NULL, '0821321321', 'me@mm.m', 0, 'Y', 'Register', NULL, '2024-02-26 03:13:10', NULL),
(28, 'member1', 'MBD2385e62824', 'member pertama', NULL, '0812321321', 'pert@ma.a', 0, 'Y', 'Register', NULL, '2024-02-26 07:06:52', NULL),
(29, 'member2', 'MBD2438a8fb00', 'member keduax', NULL, '082132132149999', '', 0, 'Y', 'Register', 'pengubah', '2024-02-26 07:07:17', '2024-02-27 06:54:44'),
(30, 'member3', 'MBD26755c69d7', 'ketigaaaax', NULL, '02138213210', 'keti@ga.xa', 0, 'Y', 'Register', 'adm', '2024-02-26 07:07:50', '2024-02-27 06:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `mtprice`
--

CREATE TABLE `mtprice` (
  `idprice` int(11) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `idprod` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `iduom` int(11) DEFAULT NULL,
  `begdate` datetime NOT NULL,
  `enddate` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL,
  `inuserid` varchar(255) DEFAULT NULL,
  `chuserid` varchar(255) DEFAULT NULL,
  `indate` datetime DEFAULT NULL,
  `chdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mtprice`
--

INSERT INTO `mtprice` (`idprice`, `idcategory`, `idprod`, `price`, `iduom`, `begdate`, `enddate`, `status`, `inuserid`, `chuserid`, `indate`, `chdate`) VALUES
(1, 1, NULL, 1500.00, 2, '2024-02-23 00:00:00', NULL, 'Y', 'tester', 'adm', '2024-02-23 07:41:31', '2024-02-23 08:59:39'),
(2, 1, NULL, 10520.00, 0, '2024-02-23 00:00:00', NULL, 'Y', 'tester', 'tester', '2024-02-23 08:47:45', '2024-02-23 08:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `mtprod`
--

CREATE TABLE `mtprod` (
  `idprod` int(11) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `nameprod` varchar(255) DEFAULT NULL,
  `iduom` int(11) DEFAULT NULL,
  `inuserid` varchar(255) DEFAULT NULL,
  `chuserid` varchar(255) DEFAULT NULL,
  `indate` datetime DEFAULT NULL,
  `chdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mtrole`
--

CREATE TABLE `mtrole` (
  `idrole` int(11) NOT NULL,
  `rolename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mtrole`
--

INSERT INTO `mtrole` (`idrole`, `rolename`) VALUES
(1, 'role web/master'),
(2, 'role transactional'),
(3, 'role view/customer');

-- --------------------------------------------------------

--
-- Table structure for table `mtuom`
--

CREATE TABLE `mtuom` (
  `iduom` int(11) NOT NULL,
  `uomname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mtuom`
--

INSERT INTO `mtuom` (`iduom`, `uomname`) VALUES
(1, 'Gr'),
(2, 'Kg');

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
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'RandomKeyPassportAuth', 'ff85e9207902dda233113640a4e4245cf62598c9a8454bd9a791157044c4956d', '[\"*\"]', NULL, NULL, '2024-02-12 19:49:43', '2024-02-12 19:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `trgrbres`
--

CREATE TABLE `trgrbres` (
  `idgrb` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `idprod` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `iduom` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `pricetot` decimal(10,2) DEFAULT NULL,
  `inuserid` varchar(255) DEFAULT NULL,
  `chuserid` varchar(255) DEFAULT NULL,
  `indate` datetime DEFAULT NULL,
  `chdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` varchar(225) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(225) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(1) NOT NULL COMMENT '1=Admin;2=Member',
  `status` varchar(1) NOT NULL COMMENT 'Y=Aktif;T=Nonaktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `name`, `phone`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `status`, `created_at`, `updated_at`) VALUES
(46, 'adm', 'admin brohh', '0000000000', 'ad@admin.min', NULL, 'c690a84c214c4ab198abe83fbadd072e', NULL, '1', 'Y', '2024-02-21 19:26:27', NULL),
(56, 'mem', 'mem', '0821321321', 'me@mm.m', NULL, '7b4e8e39c5eca49200b6cca2e16b6124', NULL, '2', 'Y', '2024-02-25 20:13:10', NULL),
(57, 'member1', 'member pertama', '0812321321', 'pert@ma.a', NULL, '207e6376972859824f2808a7680e1f6f', NULL, '2', 'Y', '2024-02-26 00:06:52', NULL),
(58, 'member2', 'member keduax', '08213213214', 'member@2.com', NULL, '31662782bafc3ee41a5f219d03fbea8a', NULL, '2', 'Y', '2024-02-26 00:07:17', NULL),
(59, 'member3', 'ketigaaaa', '0213821321', 'keti@ga.x', NULL, '188db62dd8e05686340792a79462d21d', NULL, '2', 'Y', '2024-02-26 00:07:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtcategory`
--
ALTER TABLE `mtcategory`
  ADD PRIMARY KEY (`idcategory`);

--
-- Indexes for table `mtmember`
--
ALTER TABLE `mtmember`
  ADD PRIMARY KEY (`idmember`);

--
-- Indexes for table `mtprice`
--
ALTER TABLE `mtprice`
  ADD PRIMARY KEY (`idprice`);

--
-- Indexes for table `mtprod`
--
ALTER TABLE `mtprod`
  ADD PRIMARY KEY (`idprod`);

--
-- Indexes for table `mtrole`
--
ALTER TABLE `mtrole`
  ADD PRIMARY KEY (`idrole`);

--
-- Indexes for table `mtuom`
--
ALTER TABLE `mtuom`
  ADD PRIMARY KEY (`iduom`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `trgrbres`
--
ALTER TABLE `trgrbres`
  ADD PRIMARY KEY (`idgrb`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mtcategory`
--
ALTER TABLE `mtcategory`
  MODIFY `idcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mtmember`
--
ALTER TABLE `mtmember`
  MODIFY `idmember` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `mtprice`
--
ALTER TABLE `mtprice`
  MODIFY `idprice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mtprod`
--
ALTER TABLE `mtprod`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mtrole`
--
ALTER TABLE `mtrole`
  MODIFY `idrole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mtuom`
--
ALTER TABLE `mtuom`
  MODIFY `iduom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
