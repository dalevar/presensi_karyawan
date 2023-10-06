-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2023 at 08:52 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int NOT NULL,
  `jabatan` varchar(128) NOT NULL,
  `alokasi_cuti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `jabatan`, `alokasi_cuti`) VALUES
(9, 'Manager', 4),
(36, 'test', 2);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tipe_id` int NOT NULL,
  `jabatan_id` int NOT NULL,
  `tingkat_pendidikan` varchar(128) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `user_id`, `email`, `nama`, `tanggal_masuk`, `tipe_id`, `jabatan_id`, `tingkat_pendidikan`, `catatan`) VALUES
(11, 32, 'decros2324@gmail.com', 'Rudy', '2022-04-22', 30, 9, 'SMK', ''),
(17, 31, 'dummyedale@gmail.com', 'Dale', '2020-02-12', 19, 9, 'SMK', '');

-- --------------------------------------------------------

--
-- Table structure for table `konfig`
--

CREATE TABLE `konfig` (
  `id` int NOT NULL,
  `nama` varchar(128) NOT NULL,
  `nilai` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `konfig`
--

INSERT INTO `konfig` (`id`, `nama`, `nilai`) VALUES
(1, 'jam_masuk', '08:00'),
(2, 'jam_berakhir', '17:00'),
(3, 'wfh', '15 menit');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `created_by` int NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `user_id`, `tanggal`, `created_by`, `created_on`) VALUES
(11, 31, '2023-09-15 08:00:00', 17, '2023-09-15 07:58:00'),
(13, 31, '2023-09-16 08:00:00', 17, '2023-09-16 07:50:00'),
(17, 31, '2023-09-18 08:00:00', 17, '2023-09-18 08:02:00'),
(18, 31, '2023-09-19 08:00:00', 17, '2023-09-19 08:05:00'),
(19, 31, '2023-09-20 08:00:00', 17, '2023-09-20 08:01:57'),
(20, 31, '2023-09-21 08:00:00', 17, '2023-09-21 08:05:00'),
(21, 31, '2023-09-22 08:00:00', 17, '2023-09-22 07:59:03'),
(24, 31, '2023-08-01 08:00:00', 17, '2023-08-01 08:02:00'),
(25, 31, '2023-08-02 08:00:00', 17, '2023-08-02 08:04:30'),
(26, 31, '2022-09-22 08:00:00', 17, '2022-09-22 08:00:00'),
(27, 31, '2022-09-21 08:00:00', 17, '2022-09-21 08:00:00'),
(30, 31, '2023-09-22 08:00:00', 17, '2023-09-22 07:16:58'),
(32, 31, '2023-09-23 08:00:00', 17, '2023-09-23 08:05:00'),
(34, 31, '2023-09-25 08:00:00', 17, '2023-09-25 08:08:32'),
(35, 31, '2023-09-26 08:00:00', 17, '2023-09-26 08:00:00'),
(38, 31, '2023-09-27 08:00:00', 17, '2023-09-27 07:58:07'),
(39, 31, '2023-09-29 08:00:00', 17, '2023-09-29 08:11:31'),
(40, 31, '2023-09-30 08:00:00', 17, '2023-09-30 08:23:10'),
(79, 31, '2023-10-02 08:00:00', 17, '2023-10-02 08:00:00'),
(80, 32, '2023-10-02 08:00:00', 11, '2023-10-02 08:00:00'),
(81, 31, '2023-10-03 08:00:00', 17, '2023-10-03 08:00:00'),
(82, 32, '2023-10-03 08:00:00', 11, '2023-10-03 08:12:00'),
(83, 31, '2023-10-04 08:00:00', 17, '2023-10-04 08:00:00'),
(84, 32, '2023-10-04 08:00:00', 11, '2023-10-04 08:00:00'),
(85, 31, '2023-10-05 08:00:00', 17, '2023-10-05 08:03:00'),
(88, 31, '2023-10-06 08:00:00', 17, '2023-10-06 08:10:45'),
(89, 32, '2023-10-06 08:00:00', 11, '2023-10-06 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `qrcode_presensi`
--

CREATE TABLE `qrcode_presensi` (
  `id` int NOT NULL,
  `code` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `qrcode_presensi`
--

INSERT INTO `qrcode_presensi` (`id`, `code`, `created_on`) VALUES
(2, 'SCRJNG', '2023-09-16 00:00:00'),
(3, 'TXO2B6', '2023-09-18 00:00:00'),
(4, 'TCO29Q', '2023-09-20 00:00:00'),
(8, 'DTAXRL', '2023-09-21 00:00:00'),
(9, '3NIX1V', '2023-09-22 00:00:00'),
(10, 'LSWULM', '2023-09-23 00:00:00'),
(11, '0SN2NP', '2023-09-25 00:00:00'),
(12, '8I1EFU', '2023-09-26 00:00:00'),
(13, 'E58ZNK', '2023-09-27 00:00:00'),
(14, '9SNT4M', '2023-09-29 00:00:00'),
(15, 'O0WIUA', '2023-10-02 00:00:00'),
(16, 'WHGUEZ', '2023-10-03 00:00:00'),
(17, 'TNGUXM', '2023-10-04 00:00:00'),
(18, 'WH27OQ', '2023-10-05 00:00:00'),
(19, '9MD1KG', '2023-10-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tipe`
--

CREATE TABLE `tipe` (
  `id` int NOT NULL,
  `tipe` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipe`
--

INSERT INTO `tipe` (`id`, `tipe`) VALUES
(19, 'baru asd'),
(30, 'asd asdas'),
(37, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login_oauth_uid` varchar(100) DEFAULT NULL,
  `login_access` int DEFAULT NULL COMMENT '1:ADMIN | 0:USER',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login_oauth_uid`, `login_access`, `first_name`, `last_name`, `email_address`, `profile_picture`, `created_at`, `updated_at`) VALUES
(6, '116056833446412691740', 1, 'dale', 'admin', 'dalemaster77@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKiL8RuKg7hDrJJfPwxFjEoUoscNmES8Gab5VqapMRV=s96-c', '2023-09-19 06:54:02', '2023-10-06 16:16:30'),
(31, '100827754095854324927', 0, 'Dummy', 'Dale', 'dummyedale@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocJm_ToIa1VX049Vy7KY3dzhjEoFUFir5W4KoyLrFSf-=s96-c', '2023-09-20 02:27:35', '2023-10-06 16:17:41'),
(32, '108168417186943125594', 0, 'DECROS', 'Ty', 'decros2324@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocLDzJv3XdUV4EIyWhR2XyHk1XLQiPXYA5k9FqhU82Do=s96-c', '2023-09-20 03:09:27', '2023-10-06 15:24:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konfig`
--
ALTER TABLE `konfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qrcode_presensi`
--
ALTER TABLE `qrcode_presensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `created_on` (`created_on`);

--
-- Indexes for table `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `konfig`
--
ALTER TABLE `konfig`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `qrcode_presensi`
--
ALTER TABLE `qrcode_presensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tipe`
--
ALTER TABLE `tipe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
