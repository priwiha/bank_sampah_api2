-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 08:45 AM
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
(1, 'kategori pertama', '2', 'tester', 'adm', '2024-02-22 03:25:05', '2024-03-01 05:30:32'),
(2, 'test input', '1', 'adm', NULL, '2024-02-22 04:23:56', NULL),
(3, 'kategori 3', '2', 'adm', NULL, '2024-02-22 04:26:59', '2024-02-23 08:21:39'),
(4, 'karegori baru', '1', 'adm', NULL, '2024-02-22 09:05:21', NULL),
(5, 'kat b', '1', 'adm', 'adm', '2024-03-08 09:24:55', '2024-03-08 09:25:09'),
(6, 'kategori pertamaa', '2', 'adm', 'MBD15bb3', '2024-03-14 07:23:43', '0000-00-00 00:00:00'),
(7, 'baru g', '1', 'adm', 'adm', '2024-03-19 09:05:01', '2024-03-19 09:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `mtmember`
--

CREATE TABLE `mtmember` (
  `idmember` int(11) NOT NULL,
  `userid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(29, 'member2', 'MBD2438a8fb00', 'member keduax', NULL, '082132132149999', '', 0, 'Y', 'Register', 'adm', '2024-02-26 07:07:17', '2024-04-17 09:33:56'),
(30, 'member3', 'MBD26755c69d7', 'ketigaaaax', NULL, '02138213210', 'keti@ga.xa', 72595, 'Y', 'Register', 'tester', '2024-02-26 07:07:50', '2024-03-18 01:55:13'),
(31, 'tesmem', 'MBDfab47', 'member testing', NULL, '012372134210', 'mailtes@te.r', 0, 'T', 'Register', NULL, '2024-03-01 09:45:41', NULL),
(32, 'tesss', 'MBD93066', 'member', NULL, '0812312321412', 'mail@11.a', 0, 'Y', 'Register', NULL, '2024-03-08 07:41:48', NULL),
(33, 'testttt', 'MBDdee24', 'member test', NULL, '082132142141', 'mmm@mm.mm', 0, 'Y', 'Register', NULL, '2024-03-08 07:49:45', NULL),
(34, 'testo', 'MBD410b1', 'mmemberr', NULL, '08213213421', 'mmm@m.m', 0, 'Y', 'Register', NULL, '2024-03-08 07:51:31', NULL),
(35, 'abece', 'MBD2ffdf', 'acebede ef ge', NULL, '021392141', 'mail@abc.c', 0, 'Y', 'Register', NULL, '2024-03-08 08:48:11', NULL),
(36, 'mems', 'MBD15bb3', 'memss2', NULL, '092183214', 'mm@masd.as', 3514134, 'Y', 'Register', 'adm', '2024-03-08 08:50:04', '2024-03-21 02:16:04'),
(37, 'cek111', 'MBD2d16f', 'cek', NULL, '0813412412', 'ce@k.kk', 15000, 'Y', 'Register', 'adm', '2024-03-14 07:21:25', '2024-04-18 02:17:22'),
(38, 'cobaappr', 'MBD8dbd7', 'testing approval saja', NULL, '08123214', 'ppp@pp.p', 0, 'T', 'Register', NULL, '2024-03-20 03:23:48', NULL);

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
(1, 1, NULL, 1500.00, 2, '2024-02-23 00:00:00', NULL, 'T', 'tester', NULL, '2024-02-23 07:41:31', '2024-02-29 02:16:45'),
(3, 1, NULL, 5000.00, 2, '2024-02-29 00:00:00', NULL, 'Y', NULL, NULL, '2024-02-29 02:26:34', NULL),
(4, 2, NULL, 2000.00, 1, '2024-03-01 00:00:00', NULL, 'Y', 'adm', NULL, '2024-03-01 05:29:27', NULL),
(5, 3, NULL, 100.00, 2, '2024-03-01 00:00:00', NULL, 'Y', 'adm', NULL, '2024-03-01 05:29:42', NULL),
(6, 4, NULL, 550.00, 1, '2024-03-01 00:00:00', NULL, 'T', 'adm', 'adm', '2024-03-01 05:30:03', '2024-03-08 09:39:29'),
(7, 4, NULL, 1000.00, 1, '2024-03-08 00:00:00', NULL, 'Y', 'adm', NULL, '2024-03-08 09:39:29', NULL),
(8, 6, NULL, 1500.00, 2, '2024-03-14 00:00:00', NULL, 'T', 'adm', 'adm', '2024-03-14 07:24:02', '2024-03-19 09:30:37'),
(9, 6, NULL, 1500.00, 2, '2024-03-19 00:00:00', NULL, 'Y', 'adm', NULL, '2024-03-19 09:30:37', NULL);

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
  `date` date DEFAULT NULL,
  `membercode` varchar(255) NOT NULL,
  `userid` varchar(225) NOT NULL,
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

--
-- Dumping data for table `trgrbres`
--

INSERT INTO `trgrbres` (`idgrb`, `date`, `membercode`, `userid`, `idcategory`, `idprod`, `qty`, `iduom`, `price`, `pricetot`, `inuserid`, `chuserid`, `indate`, `chdate`) VALUES
(30, '2024-03-06', 'MBD26755c69d7', 'member3', 2, NULL, 10, 1, 2000.00, 20000.00, 'adm', NULL, '2024-03-01 07:42:59', NULL),
(31, '2024-03-14', 'MBD15bb3', 'mems', 1, NULL, 500, 2, 5000.00, 2500000.00, 'adm', NULL, '2024-03-12 06:57:33', NULL),
(32, '2024-03-20', 'MBD15bb3', 'mems', 1, NULL, 200, 2, 5000.00, 1000000.00, 'adm', NULL, '2024-03-14 08:36:31', NULL),
(33, '2024-03-14', 'MBD26755c69d7', 'member3', 1, NULL, 5, 1, 10520.00, 52600.00, 'tester', NULL, '2024-03-18 01:55:13', NULL),
(34, '2024-03-19', 'MBD15bb3', 'mems', 1, NULL, 10, 2, 5000.00, 50000.00, 'adm', NULL, '0000-00-00 00:00:00', NULL),
(35, '2024-03-19', 'MBD2d16f', 'cek111', 6, NULL, 10, 2, 1500.00, 15000.00, 'adm', NULL, '2024-03-19 09:44:08', NULL),
(36, '2024-03-19', 'MBD2d16f', 'cek111', 3, NULL, 50, 2, 100.00, 5000.00, 'adm', NULL, '2024-03-19 09:45:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trredeem`
--

CREATE TABLE `trredeem` (
  `idredeem` int(11) NOT NULL,
  `membercode` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `redeemamt` int(11) NOT NULL,
  `redeemdate` date NOT NULL,
  `approveddate` date DEFAULT NULL,
  `approved` varchar(1) DEFAULT NULL COMMENT '0:initial\r\n1:approved\r\n2:rejected',
  `userapproved` varchar(255) DEFAULT NULL,
  `inuserid` varchar(255) DEFAULT NULL,
  `chuserid` varchar(255) DEFAULT NULL,
  `indate` date DEFAULT NULL,
  `chdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trredeem`
--

INSERT INTO `trredeem` (`idredeem`, `membercode`, `userid`, `redeemamt`, `redeemdate`, `approveddate`, `approved`, `userapproved`, `inuserid`, `chuserid`, `indate`, `chdate`) VALUES
(1, 'MBD15bb3', 'mems', 5000, '2024-03-13', '2024-03-13', '1', 'tester', 'tester', NULL, '2024-03-13', NULL),
(2, 'MBD15bb3', 'mems', 5000, '2024-03-14', '2024-03-14', '1', 'adm', 'adm', NULL, '2024-03-14', NULL),
(3, 'MBD15bb3', 'mems', 200, '2024-03-19', '2024-03-20', '1', '', 'tester', '', '2024-03-19', '2024-03-20'),
(4, 'MBD15bb3', 'mems', 1000, '2024-03-19', '2024-03-19', '1', 'mems', 'mems', NULL, '2024-03-19', NULL),
(5, 'MBD15bb3', 'mems', 2500, '2024-03-19', '2024-03-20', '1', 'tester', 'mems', 'tester', '2024-03-19', '2024-03-20'),
(6, 'MBD15bb3', 'mems', 2001, '2024-03-19', '2024-03-21', '1', 'adm', 'tester', 'adm', '2024-03-19', '2024-03-21'),
(7, 'MBD15bb3', 'mems', 1234, '2024-03-19', '2024-03-20', '1', 'adm', 'mems', 'adm', '2024-03-19', '2024-03-20'),
(8, 'MBD2d16f', 'cek111', 5000, '2024-03-20', '2024-03-20', '1', 'adm', 'adm', NULL, '2024-03-20', NULL),
(9, 'MBD15bb3', 'mems', 500, '2024-03-20', '2024-03-21', '1', 'adm', 'mems', 'adm', '2024-03-20', '2024-03-21'),
(10, 'MBD15bb3', 'mems', 125, '2024-03-20', '2024-03-20', '1', 'adm', 'adm', NULL, '2024-03-20', NULL);

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
(59, 'member3', 'ketigaaaa', '0213821321', 'keti@ga.x', NULL, '188db62dd8e05686340792a79462d21d', NULL, '2', 'Y', '2024-02-26 00:07:50', NULL),
(60, 'tesmem', 'member testing', '012372134210', 'mailtes@te.r', NULL, 'd70e547e547ca6930e24a86170f4013b', NULL, '2', 'Y', '2024-03-01 02:45:41', NULL),
(61, 'tesss', 'member', '0812312321412', 'mail@11.a', NULL, '132ef7821278f3258f19520d6c903f2b', NULL, '2', 'Y', '2024-03-08 00:41:48', NULL),
(62, 'testttt', 'member test', '082132142141', 'mmm@mm.mm', NULL, 'df4a54b7162627d233d89d1f9603f18c', NULL, '2', 'Y', '2024-03-08 00:49:45', NULL),
(63, 'testo', 'mmemberr', '08213213421', 'mmm@m.m', NULL, 'cd3390f3070e94d17ef3cf62d8aa8acf', NULL, '2', 'Y', '2024-03-08 00:51:31', NULL),
(64, 'abece', 'acebede ef ge', '021392141', 'mail@abc.c', NULL, 'c386d52d2855292b812cb32ae1b628b6', NULL, '2', 'Y', '2024-03-08 01:48:11', NULL),
(65, 'mems', 'asdasfa', '092183214', 'mm@masd.as', NULL, 'c3af8c3bd5980aeccf9cc334a7a97f02', NULL, '2', 'Y', '2024-03-08 01:50:04', NULL),
(66, 'cek111', 'cek', '0813412412', 'ce@k.kk', NULL, 'c1ef1ef3b15bba28f9e07149036041d3', NULL, '2', 'Y', '2024-03-14 00:21:25', NULL),
(67, 'cobaappr', 'testing approval saja', '08123214', 'ppp@pp.p', NULL, 'f248791bf21894e2754b946c9819b88e', NULL, '2', 'Y', '2024-03-19 20:23:47', NULL);

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
-- Indexes for table `trredeem`
--
ALTER TABLE `trredeem`
  ADD PRIMARY KEY (`idredeem`);

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
  MODIFY `idcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mtmember`
--
ALTER TABLE `mtmember`
  MODIFY `idmember` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `mtprice`
--
ALTER TABLE `mtprice`
  MODIFY `idprice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `trgrbres`
--
ALTER TABLE `trgrbres`
  MODIFY `idgrb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `trredeem`
--
ALTER TABLE `trredeem`
  MODIFY `idredeem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
