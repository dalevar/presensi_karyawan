-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2023 at 12:13 AM
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
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int NOT NULL,
  `holiday_date` date NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `is_national_holiday` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `holiday_date`, `holiday_name`, `is_national_holiday`) VALUES
(1, '2023-12-25', 'Hari Raya Natal', 1),
(2, '2023-09-28', 'Maulid Nabi Muhammad SAW', 1),
(3, '2023-08-17', 'Hari Proklamasi Kemerdekaan RI', 1),
(4, '2023-07-19', 'Tahun Baru Islam 1445 Hijriyah', 1),
(5, '2023-06-29', 'Hari Raya Idul Adha 1444 Hijriyah', 1),
(6, '2023-06-04', 'Hari Raya Waisak 2567', 1),
(7, '2023-06-01', 'Hari Lahirnya Pancasila', 1),
(8, '2023-05-18', 'Kenaikan Isa Al Masih', 1),
(9, '2023-05-01', 'Hari Buruh Internasional', 1),
(10, '2023-04-23', 'Hari Raya Idul Fitri 1444 Hijriyah', 1),
(11, '2023-04-22', 'Hari Raya Idul Fitri 1444 Hijriyah', 1),
(12, '2023-04-07', 'Wafat Isa Al Masih', 1),
(13, '2023-03-22', 'Hari Raya Nyepi', 1),
(14, '2023-02-18', 'Isra Mikraj Nabi Muhammad SAW', 1),
(15, '2023-01-22', 'Tahun Baru Imlek 2574 Kongzili', 1),
(16, '2023-01-01', 'Tahun Baru Masehi', 1);

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
(11, 32, 'decros2324@gmail.com', 'Rudy', '2023-09-15', 19, 9, 'SMK', ''),
(17, 31, 'dummyedale@gmail.com', 'Dale', '2023-09-15', 19, 9, 'SMK', '');

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
(3, 'wfh', '60'),
(5, 'sakit', '7'),
(6, 'cuti_kurang', '1');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `created_by` int NOT NULL,
  `is_wfh` int NOT NULL,
  `is_sakit` int NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `user_id`, `tanggal`, `created_by`, `is_wfh`, `is_sakit`, `created_on`) VALUES
(11, 31, '2023-09-15 08:00:00', 17, 0, 0, '2023-09-15 07:58:00'),
(13, 31, '2023-09-16 08:00:00', 17, 1, 0, '2023-09-16 07:50:00'),
(17, 31, '2023-09-18 08:00:00', 17, 0, 0, '2023-09-18 08:02:00'),
(18, 31, '2023-09-19 08:00:00', 17, 0, 0, '2023-09-19 08:05:00'),
(19, 31, '2023-09-20 08:00:00', 17, 0, 0, '2023-09-20 08:01:57'),
(20, 31, '2023-09-21 08:00:00', 17, 0, 0, '2023-09-21 08:05:00'),
(21, 31, '2023-09-22 08:00:00', 17, 0, 0, '2023-09-22 07:59:03'),
(26, 31, '2022-09-22 08:00:00', 17, 0, 0, '2022-09-22 08:00:00'),
(27, 31, '2022-09-21 08:00:00', 17, 0, 0, '2022-09-21 08:00:00'),
(32, 31, '2023-09-23 08:00:00', 17, 0, 0, '2023-09-23 08:05:00'),
(34, 31, '2023-09-25 08:00:00', 17, 0, 0, '2023-09-25 08:08:32'),
(35, 31, '2023-09-26 08:00:00', 17, 0, 0, '2023-09-26 08:00:00'),
(38, 31, '2023-09-27 08:00:00', 17, 0, 0, '2023-09-27 07:58:07'),
(39, 31, '2023-09-29 08:00:00', 17, 0, 0, '2023-09-29 08:11:31'),
(40, 31, '2023-09-30 08:00:00', 17, 0, 0, '2023-09-30 08:23:10'),
(80, 32, '2023-10-02 08:00:00', 11, 1, 0, '2023-10-02 08:00:00'),
(82, 32, '2023-10-03 08:00:00', 11, 0, 0, '2023-10-03 08:12:00'),
(84, 32, '2023-10-04 08:00:00', 11, 0, 0, '2023-10-04 08:00:00'),
(89, 32, '2023-10-06 08:00:00', 11, 0, 0, '2023-10-06 08:00:00'),
(91, 31, '2023-10-04 08:00:00', 17, 1, 0, '2023-10-04 08:00:00'),
(95, 31, '2023-10-06 08:00:00', 17, 1, 0, '2023-10-06 08:00:00'),
(96, 31, '2023-10-07 08:00:00', 17, 1, 0, '2023-10-07 08:06:36'),
(97, 31, '2023-10-05 08:00:00', 17, 1, 0, '2023-10-05 08:00:00'),
(98, 32, '2023-10-07 08:00:00', 11, 0, 0, '2023-10-07 08:03:06'),
(99, 32, '2023-10-05 08:00:00', 11, 0, 0, '2023-10-05 16:00:00'),
(100, 31, '2023-10-09 08:00:00', 17, 0, 0, '2023-10-09 08:13:28'),
(103, 31, '2023-10-10 08:00:00', 17, 1, 0, '2023-10-10 08:12:35'),
(104, 32, '2023-10-10 08:00:00', 11, 0, 0, '2023-10-10 08:07:30'),
(115, 31, '2023-10-12 08:00:00', 17, 0, 0, '2023-10-12 08:00:32'),
(116, 32, '2023-10-12 08:00:00', 11, 0, 0, '2023-10-12 07:00:19'),
(125, 31, '2023-10-13 08:00:00', 17, 1, 0, '2023-10-13 08:06:45'),
(126, 32, '2023-10-13 08:00:00', 11, 1, 0, '2023-10-13 08:06:21'),
(129, 31, '2023-10-14 08:00:00', 17, 0, 0, '2023-10-14 08:54:08'),
(130, 32, '2023-10-14 08:00:00', 11, 1, 0, '2023-10-14 08:12:15'),
(134, 32, '2023-10-16 08:00:00', 11, 1, 0, '2023-10-16 08:00:00'),
(218, 31, '2023-10-16 08:00:00', 17, 0, 0, '2023-10-16 07:53:44'),
(220, 31, '2023-10-17 08:00:00', 17, 0, 0, '2023-10-17 08:02:32'),
(221, 31, '2023-10-18 08:00:00', 17, 0, 0, '2023-10-18 08:00:00'),
(2287, 31, '2023-10-19 00:00:00', 17, 0, 1, '2023-10-19 00:00:00'),
(2288, 31, '2023-10-20 00:00:00', 17, 0, 1, '2023-10-20 00:00:00'),
(2289, 31, '2023-10-21 08:00:00', 17, 0, 0, '2023-10-21 07:53:25'),
(2297, 31, '2023-10-23 08:00:00', 17, 0, 0, '2023-10-23 09:11:55'),
(2298, 31, '2023-10-24 08:00:00', 17, 0, 0, '2023-10-24 08:16:02'),
(18769, 32, '2023-10-25 08:00:00', 11, 0, 0, '2023-10-25 08:14:07'),
(18770, 32, '2023-10-25 00:00:00', 11, 0, 1, '2023-10-25 00:00:00'),
(18771, 32, '2023-10-24 00:00:00', 11, 0, 1, '2023-10-24 00:00:00'),
(18772, 32, '2023-10-23 00:00:00', 11, 0, 1, '2023-10-23 00:00:00'),
(18773, 32, '2023-10-22 00:00:00', 11, 0, 1, '2023-10-22 00:00:00'),
(18774, 32, '2023-10-21 00:00:00', 11, 0, 1, '2023-10-21 00:00:00'),
(18775, 32, '2023-10-20 00:00:00', 11, 0, 1, '2023-10-20 00:00:00'),
(18776, 32, '2023-10-19 00:00:00', 11, 0, 0, '2023-10-19 00:00:00'),
(18777, 32, '2023-10-18 00:00:00', 11, 0, 0, '2023-10-18 00:00:00'),
(18778, 32, '2023-10-17 00:00:00', 11, 0, 0, '2023-10-17 00:00:00'),
(18779, 31, '2023-10-25 08:00:00', 17, 0, 0, '2023-10-25 07:48:14'),
(18780, 32, '2023-10-26 08:00:00', 11, 0, 0, '2023-10-26 08:08:40');

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
(19, '9MD1KG', '2023-10-06 00:00:00'),
(20, 'AFNHQI', '2023-10-07 00:00:00'),
(21, 'EDOUU4', '2023-10-09 00:00:00'),
(22, '5RFJHL', '2023-10-10 00:00:00'),
(23, 'VDUJ7T', '2023-10-11 00:00:00'),
(24, 'AE6S5S', '2023-10-12 00:00:00'),
(25, '4ABXIM', '2023-10-13 00:00:00'),
(26, 'NCXWAU', '2023-10-14 00:00:00'),
(27, 'HSGAFN', '2023-10-16 00:00:00'),
(28, 'LFRKXX', '2023-10-17 00:00:00'),
(29, 'EZ6VJG', '2023-10-18 00:00:00'),
(30, 'B76CYA', '2023-10-19 00:00:00'),
(31, 'MXBLX0', '2023-10-20 00:00:00'),
(32, 'REOSK7', '2023-10-21 00:00:00'),
(33, 'RIDMJS', '2023-10-23 00:00:00'),
(34, 'BVMRUA', '2023-10-24 00:00:00'),
(35, 'QM0NE8', '2023-10-25 00:00:00'),
(36, 'QLP0MX', '2023-10-26 00:00:00');

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
(6, '116056833446412691740', 1, 'dale', 'admin', 'dalemaster77@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKiL8RuKg7hDrJJfPwxFjEoUoscNmES8Gab5VqapMRV=s96-c', '2023-09-19 06:54:02', '2023-10-25 16:52:57'),
(31, '100827754095854324927', 0, 'Dummy', 'Dale', 'dummyedale@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocJm_ToIa1VX049Vy7KY3dzhjEoFUFir5W4KoyLrFSf-=s96-c', '2023-09-20 02:27:35', '2023-10-25 16:48:13'),
(32, '108168417186943125594', 0, 'DECROS', 'Ty', 'decros2324@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocLDzJv3XdUV4EIyWhR2XyHk1XLQiPXYA5k9FqhU82Do=s96-c', '2023-09-20 03:09:27', '2023-10-26 08:11:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18781;

--
-- AUTO_INCREMENT for table `qrcode_presensi`
--
ALTER TABLE `qrcode_presensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
