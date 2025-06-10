-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2023 at 03:06 AM
-- Server version: 10.4.19-MariaDB-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sq_luckybet`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(10) NOT NULL,
  `name_at` varchar(100) NOT NULL,
  `detail_at` varchar(5000) NOT NULL,
  `fileupload_at` varchar(200) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `name_comment` varchar(100) NOT NULL,
  `amount_at` varchar(100) NOT NULL,
  `credit_at` varchar(100) NOT NULL,
  `status_at` varchar(100) NOT NULL,
  `date_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `turnover_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `name_at`, `detail_at`, `fileupload_at`, `comment`, `name_comment`, `amount_at`, `credit_at`, `status_at`, `date_at`, `turnover_at`) VALUES
(15, 'แจกฟรีเพียงแค่สมัคร', '<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n', '20220221547023440.jpg', '', '', '1538', '15', 'เปิด', '2022-02-21 11:00:47', '500');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_ad` int(10) NOT NULL,
  `username_ad` varchar(100) NOT NULL,
  `password_ad` varchar(100) NOT NULL,
  `name_ad` varchar(100) NOT NULL,
  `phone_ad` varchar(100) NOT NULL,
  `status_ad` varchar(100) NOT NULL,
  `date_ad` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_ad`, `username_ad`, `password_ad`, `name_ad`, `phone_ad`, `status_ad`, `date_ad`) VALUES
(1, 'admin', 'c5acc43a9641b759a47bf699437e3a2e', '-', '00', 'Administrator', '2021-08-26 03:05:01'),
(6, 'lucky', 'e10adc3949ba59abbe56e057f20f883e', 'A', '001', 'Staff', '2023-03-16 12:07:23');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate`
--

CREATE TABLE `affiliate` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `bankacc` varchar(100) NOT NULL,
  `percent` varchar(100) NOT NULL,
  `dateup` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `money` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affiliate`
--

INSERT INTO `affiliate` (`id`, `name`, `username`, `password`, `code`, `phone`, `bank`, `bankacc`, `percent`, `dateup`, `status`, `money`) VALUES
(1, 'เอกพล กิจควร', 'lllsasorilll', 'Aa0830205528', 'FiOMV', '0899797558', 'ธ.กรุงเทพ', '4647082850', '20', '2022-05-08  10:23:40', 'อนุมัติ', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(10) NOT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `name_bank` varchar(100) NOT NULL,
  `bankacc_bank` varchar(100) NOT NULL,
  `nameacc_bank` varchar(100) NOT NULL,
  `bankfor` varchar(100) NOT NULL,
  `status_bank` varchar(10) NOT NULL,
  `money_bank` varchar(100) DEFAULT NULL,
  `money_bank2` varchar(100) DEFAULT NULL,
  `fileupload_bank` varchar(200) NOT NULL,
  `date_bank` timestamp NOT NULL DEFAULT current_timestamp(),
  `device` varchar(100) DEFAULT NULL,
  `pin_bank` varchar(100) DEFAULT NULL,
  `password_true` varchar(100) DEFAULT NULL,
  `no_true` varchar(100) DEFAULT NULL,
  `otp_true` varchar(100) DEFAULT NULL,
  `id_kbank` varchar(100) DEFAULT NULL,
  `token_kbank` varchar(3000) DEFAULT NULL,
  `user_kbank` varchar(100) DEFAULT NULL,
  `pass_kbank` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `id_bank`, `name_bank`, `bankacc_bank`, `nameacc_bank`, `bankfor`, `status_bank`, `money_bank`, `money_bank2`, `fileupload_bank`, `date_bank`, `device`, `pin_bank`, `password_true`, `no_true`, `otp_true`, `id_kbank`, `token_kbank`, `user_kbank`, `pass_kbank`) VALUES
(1, NULL, 'ธนาคารไทยพาณิชย์', '8842559912', 'อมรพรรณ คนหลัก', 'ฝากและถอน', 'เปิด', NULL, NULL, '202303121528129964.jpg', '2023-03-11 18:39:51', '04de8aeb-1afb-4e23-2f61-e96577683cee', '140366', '', '', '', '', '', '', ''),
(2, NULL, 'ธนาคารกสิกรไทย', '1512755999', 'อมรพรรณ คนหลัก', 'ฝาก', 'เปิด', NULL, NULL, '20230312510074015.png', '2023-03-11 18:40:54', '', '', '', '', '', '', 'kbank.luckybet888live.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `code_update`
--

CREATE TABLE `code_update` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `percent` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `code_update`
--

INSERT INTO `code_update` (`id`, `code`, `percent`) VALUES
(1, 'FiOMV', '20');

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

CREATE TABLE `credit` (
  `id` int(11) NOT NULL,
  `credit_ufa` varchar(100) NOT NULL,
  `credit_scb` varchar(100) NOT NULL,
  `credit_kbank` varchar(100) NOT NULL,
  `credit_true` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credit`
--

INSERT INTO `credit` (`id`, `credit_ufa`, `credit_scb`, `credit_kbank`, `credit_true`) VALUES
(1, '960', '757.14', '362.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(10) NOT NULL,
  `id_dp` int(11) NOT NULL,
  `confirm_dp` varchar(100) NOT NULL,
  `username_dp` varchar(100) NOT NULL,
  `amount_dp` varchar(100) NOT NULL,
  `bonus_dp` varchar(100) NOT NULL,
  `phone_dp` varchar(100) NOT NULL,
  `bank_dp` varchar(100) NOT NULL,
  `bankacc_dp` varchar(100) NOT NULL,
  `name_dp` varchar(100) NOT NULL,
  `fileupload` varchar(200) NOT NULL DEFAULT '',
  `promotion_dp` varchar(100) NOT NULL,
  `bankin_dp` varchar(100) NOT NULL,
  `turnover` varchar(100) NOT NULL,
  `game_dp` varchar(100) NOT NULL DEFAULT '',
  `note_dp` varchar(100) NOT NULL,
  `aff_dp` varchar(100) NOT NULL,
  `ip_dp` varchar(100) NOT NULL DEFAULT '',
  `date_check` date NOT NULL DEFAULT current_timestamp(),
  `time_check` time NOT NULL DEFAULT current_timestamp(),
  `fromAccount` varchar(100) NOT NULL,
  `fromTrue` varchar(100) NOT NULL,
  `date_dp` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_check_true` varchar(100) NOT NULL DEFAULT '',
  `date_check_kbank` varchar(100) NOT NULL DEFAULT '',
  `add_dp` varchar(100) NOT NULL DEFAULT '',
  `edit_dp` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `id_dp`, `confirm_dp`, `username_dp`, `amount_dp`, `bonus_dp`, `phone_dp`, `bank_dp`, `bankacc_dp`, `name_dp`, `fileupload`, `promotion_dp`, `bankin_dp`, `turnover`, `game_dp`, `note_dp`, `aff_dp`, `ip_dp`, `date_check`, `time_check`, `fromAccount`, `fromTrue`, `date_dp`, `date_check_true`, `date_check_kbank`, `add_dp`, `edit_dp`) VALUES
(1364, 5, 'อนุมัติ', 'esCOX', '10', '0', '0620587939', 'ธ.กสิกรไทย', '454968', 'ณัฐภัทร รื่นชู', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-14', '16:39:18', '454968', '', '2023-03-14 12:54:34', '', '', '', ''),
(1365, 5, 'อนุมัติ', 'esCOX', '1', '0', '0620587939', 'ธ.กสิกรไทย', '454968', 'ณัฐภัทร รื่นชู', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-14', '16:27:16', '454968', '', '2023-03-14 12:54:34', '', '', '', ''),
(1366, 3, 'อนุมัติ', 'TXVMU', '200', '0', '0653492129', 'ธ.ไทยพาณิชย์', '2493', 'สุมาลี พละการ', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-14', '20:18:11', '2493', '', '2023-03-14 13:19:03', '', '', '', ''),
(1367, 2, 'อนุมัติ', 'pOHR9', '55', '0', '0960675215', 'ธ.กรุงไทย', '8341', 'lailapasa', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '110', '', '', '', '', '2023-03-15', '03:39:44', '8341', '', '2023-03-14 20:39:44', '', '001_20230312_006C7FD118AA646D581,A,CR,N', '', ''),
(1368, 3, 'อนุมัติ', 'TXVMU', '60', '0', '0653492129', 'ธ.ไทยพาณิชย์', '5249', 'สุมาลี พละการ', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '120', '', '', '', '', '2023-03-15', '03:39:48', '5249', '', '2023-03-14 20:39:48', '', '001_20230312_0144516DC9E9E38FEBD,A,CR,N', '', ''),
(1369, 3, 'อนุมัติ', 'TXVMU', '2', '0', '0653492129', 'ธ.ไทยพาณิชย์', '5249', 'สุมาลี พละการ', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '4', '', '', '', '', '2023-03-15', '03:40:32', '5249', '', '2023-03-14 20:40:32', '', '001_20230312_014841750E4FA104FDA,A,CR,N', '', ''),
(1370, 1, 'อนุมัติ', 'n7Lef', '3', '0', '0961658189', 'ธ.กสิกรไทย', '715396', 'วิชากานต์ รัตนสมบูรณ์', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-16', '03:54:32', '715396', '', '2023-03-15 21:20:03', '', '', '', ''),
(1371, 1, 'อนุมัติ', 'n7Lef', '5', '0', '0961658189', 'ธ.กสิกรไทย', '715396', 'วิชากานต์ รัตนสมบูรณ์', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-16', '03:35:20', '715396', '', '2023-03-15 21:20:48', '', '', '', ''),
(1372, 1, 'อนุมัติ', 'n7Lef', '2', '0', '0961658189', 'ธ.กสิกรไทย', '715396', 'วิชากานต์ รัตนสมบูรณ์', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-16', '04:30:37', '715396', '', '2023-03-15 21:32:04', '', '', '', ''),
(1374, 2, 'อนุมัติ', 'su1lj', '5', '0', '0823632388', 'ธ.กสิกรไทย', '5496', 'ณัฐภัทร รื่นชู', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '10', '', '', '', '', '2023-03-15', '22:01:30', '5496', '', '2023-03-15 22:01:30', '', '509_20230316_8620a8f4dec546d1b739ebb4c27aebd4,,CR,Y', '', ''),
(1375, 2, 'อนุมัติ', 'su1lj', '10', '0', '0823632388', 'ธ.กสิกรไทย', '5496', 'ณัฐภัทร รื่นชู', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '20', '', '', '', '', '2023-03-15', '22:01:31', '5496', '', '2023-03-15 22:01:31', '', '509_20230316_73af71105f3f4b09a9b0ce02367f902c,,CR,Y', '', ''),
(1376, 2, 'อนุมัติ', 'su1lj', '5', '0', '0823632388', 'ธ.กสิกรไทย', '5496', 'ณัฐภัทร รื่นชู', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '10', '', '', '', '', '2023-03-15', '22:06:45', '5496', '', '2023-03-15 22:06:45', '', '509_20230316_bbf98b7e59424b968897609fe8fe6adf,,CR,Y', '', ''),
(1377, 3, 'อนุมัติ', '3hGfy', '50', '0', '0960675215', 'ธ.กรุงไทย', '183412', 'lailapasa', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-16', '05:39:07', '183412', '', '2023-03-15 22:40:03', '', '', '', ''),
(1379, 3, 'อนุมัติ', '3hGfy', '20', '0', '0960675215', 'ธ.กรุงไทย', '8341', 'lailapasa', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '40', '', '', '', '', '2023-03-15', '22:50:02', '8341', '', '2023-03-16 05:03:02', '', '001_20230316_006987944AD984598D2,A,CR,N', '', ''),
(1380, 1, 'อนุมัติ', 'n7Lef', '5', '0', '0961658189', 'ธ.กสิกรไทย', '1539', 'วิชากานต์ รัตนสมบูรณ์', '', 'ไม่รับโบนัส', 'ธนาคารกสิกรไทย', '10', '', '', '', '', '2023-03-15', '22:56:01', '1539', '', '2023-03-16 05:56:01', '', '509_20230316_b688aae221d542118f75f42e20507bb8,,CR,Y', '', ''),
(1381, 3, 'อนุมัติ', '3hGfy', '20', '0', '0960675215', 'ธ.กรุงไทย', '183412', 'lailapasa', '', 'ไม่รับโบนัส', 'ธนาคารไทยพาณิชย์', '0', '', '', '', '', '2023-03-16', '19:35:12', '183412', '', '2023-03-16 12:38:03', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_mb` int(10) NOT NULL,
  `username_mb` varchar(100) NOT NULL,
  `password_mb` varchar(100) DEFAULT NULL,
  `phone_mb` varchar(100) DEFAULT NULL,
  `phone_true` varchar(100) DEFAULT NULL,
  `bank_mb` varchar(100) DEFAULT NULL,
  `bankacc_mb` varchar(100) DEFAULT NULL,
  `name_mb` varchar(100) DEFAULT NULL,
  `status_mb` varchar(100) DEFAULT NULL,
  `confirm_mb` varchar(100) DEFAULT NULL,
  `aff` varchar(100) DEFAULT NULL,
  `date_mb` timestamp NULL DEFAULT current_timestamp(),
  `status` varchar(100) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `password_ufa` varchar(100) NOT NULL,
  `add_mb` varchar(100) DEFAULT NULL,
  `edit_mb` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_mb`, `username_mb`, `password_mb`, `phone_mb`, `phone_true`, `bank_mb`, `bankacc_mb`, `name_mb`, `status_mb`, `confirm_mb`, `aff`, `date_mb`, `status`, `ip`, `password_ufa`, `add_mb`, `edit_mb`) VALUES
(1, 'n7Lef', 'A123123123a', '0961658189', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2', '1', '', '2023-03-16 05:18:09', '1', '49.49.236.47', 'aa123456', 'MEMBER', NULL),
(2, 'su1lj', 'Kamon060164$', '0823632388', '0823632388', 'ธ.กสิกรไทย', '1343454968', 'ณัฐภัทร รื่นชู', '2', '1', '', '2023-03-16 05:24:33', '1', '1.46.140.29', 'aa123456', 'MEMBER', NULL),
(3, '3hGfy', 'lailapasa12', '0960675215', '0960675215', 'ธ.กรุงไทย', '5103183412', 'lailapasa', '2', '1', '', '2023-03-16 06:37:37', '1', '183.89.117.161', 'aa123456', 'MEMBER', NULL),
(4, '356qI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:11:01', '2', NULL, 'aa123456', NULL, NULL),
(5, 'joCJy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:12:01', '2', NULL, 'aa123456', NULL, NULL),
(6, 'PVEWG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:13:01', '2', NULL, 'aa123456', NULL, NULL),
(7, 'OvUWq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:14:01', '2', NULL, 'aa123456', NULL, NULL),
(8, 'b04YJ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:15:01', '2', NULL, 'aa123456', NULL, NULL),
(9, 'epzhw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:16:01', '2', NULL, 'aa123456', NULL, NULL),
(10, 'KLuDt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:17:01', '2', NULL, 'aa123456', NULL, NULL),
(11, '1JUNm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:18:01', '2', NULL, 'aa123456', NULL, NULL),
(12, 'wHmrg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:19:01', '2', NULL, 'aa123456', NULL, NULL),
(13, 'mlnQG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:20:01', '2', NULL, 'aa123456', NULL, NULL),
(14, 'orl2a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:21:01', '2', NULL, 'aa123456', NULL, NULL),
(15, 'TBeMk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:22:01', '2', NULL, 'aa123456', NULL, NULL),
(16, 'QyVaH', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:23:01', '2', NULL, 'aa123456', NULL, NULL),
(17, '82QeN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:24:02', '2', NULL, 'aa123456', NULL, NULL),
(18, 'F97i5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:25:02', '2', NULL, 'aa123456', NULL, NULL),
(19, 'hYTgL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:26:01', '2', NULL, 'aa123456', NULL, NULL),
(20, 'CrPcn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:27:01', '2', NULL, 'aa123456', NULL, NULL),
(21, 'hzaNY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:28:01', '2', NULL, 'aa123456', NULL, NULL),
(22, 'edMYR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:29:01', '2', NULL, 'aa123456', NULL, NULL),
(23, 'qdBRy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:30:01', '2', NULL, 'aa123456', NULL, NULL),
(24, 'Iw1uP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:31:01', '2', NULL, 'aa123456', NULL, NULL),
(25, 'DFtXz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:32:01', '2', NULL, 'aa123456', NULL, NULL),
(26, 'amxUj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:33:01', '2', NULL, 'aa123456', NULL, NULL),
(27, 'viCZS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:34:01', '2', NULL, 'aa123456', NULL, NULL),
(28, 'K8Bgy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:35:01', '2', NULL, 'aa123456', NULL, NULL),
(29, 'zeYA8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:36:01', '2', NULL, 'aa123456', NULL, NULL),
(30, 'sW0q7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:37:01', '2', NULL, 'aa123456', NULL, NULL),
(31, 'jFdva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:38:01', '2', NULL, 'aa123456', NULL, NULL),
(32, 'DAR5r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 21:39:01', '2', NULL, 'aa123456', NULL, NULL),
(33, 'Bj2wY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-15 22:38:01', '2', NULL, 'aa123456', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `id` int(11) NOT NULL,
  `name_pro` varchar(200) NOT NULL,
  `time_pro` varchar(100) NOT NULL,
  `fileupload_pro` varchar(200) NOT NULL,
  `dp_pro` varchar(100) NOT NULL,
  `bonus_pro` varchar(100) NOT NULL,
  `bonusper_pro` varchar(100) NOT NULL,
  `games_pro` varchar(100) NOT NULL,
  `turn_pro` varchar(100) NOT NULL,
  `rules_pro` varchar(1000) NOT NULL,
  `wd_pro` varchar(100) NOT NULL,
  `max_pro` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`id`, `name_pro`, `time_pro`, `fileupload_pro`, `dp_pro`, `bonus_pro`, `bonusper_pro`, `games_pro`, `turn_pro`, `rules_pro`, `wd_pro`, `max_pro`, `date`) VALUES
(40, 'สมาชิกไหม่', 'สมาชิกใหม่', '202303122105177245.jpg', '100', '0', '100', 'casino', '5', '', '10000', '1000', '2023-03-11 17:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `reportkbank`
--

CREATE TABLE `reportkbank` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `fromacc` varchar(100) NOT NULL,
  `toacc` varchar(100) NOT NULL,
  `frombank` varchar(100) NOT NULL,
  `tobank` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `fromname` varchar(100) NOT NULL,
  `toname` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportkbank`
--

INSERT INTO `reportkbank` (`id`, `code`, `amount`, `fromacc`, `toacc`, `frombank`, `tobank`, `type`, `fromname`, `toname`, `date`) VALUES
(1350, '001_20230312_014841750E4FA104FDA,A,CR,N', '2', 'xxx-x-x5249-x', '', 'ธ.ไทยพาณิชย์', '', 'รับโอนเงิน', 'นางสาว สุมาลี พ', '', '2023-03-14 20:24:32'),
(1351, '001_20230312_0144516DC9E9E38FEBD,A,CR,N', '60', 'xxx-x-x5249-x', '', 'ธ.ไทยพาณิชย์', '', 'รับโอนเงิน', 'นางสาว สุมาลี พ', '', '2023-03-14 20:24:32'),
(1352, '001_20230312_006C7FD118AA646D581,A,CR,N', '55', 'xxx-x-x8341-x', '', 'ธ.กรุงไทย', '', 'รับโอนเงิน', 'MISSLAILA P', '', '2023-03-14 20:24:32'),
(1353, '509_20230316_bbf98b7e59424b968897609fe8fe6adf,,CR,Y', '5', 'xxx-x-x5496-x', '', 'ธ.กสิกรไทย', '', 'รับโอนเงิน', 'นาย ณัฐภัทร ร', '', '2023-03-15 21:42:09'),
(1354, '509_20230316_73af71105f3f4b09a9b0ce02367f902c,,CR,Y', '10', 'xxx-x-x5496-x', '', 'ธ.กสิกรไทย', '', 'รับโอนเงิน', 'นาย ณัฐภัทร ร', '', '2023-03-15 21:42:09'),
(1356, '509_20230316_8620a8f4dec546d1b739ebb4c27aebd4,,CR,Y', '5', 'xxx-x-x5496-x', '', 'ธ.กสิกรไทย', '', 'รับโอนเงิน', 'นาย ณัฐภัทร ร', '', '2023-03-15 21:53:15'),
(1359, '001_20230316_006987944AD984598D2,A,CR,N', '20', 'xxx-x-x8341-x', '', 'ธ.กรุงไทย', '', 'รับโอนเงิน', 'MISSLAILA P', '', '2023-03-16 05:03:01'),
(1361, '509_20230316_b688aae221d542118f75f42e20507bb8,,CR,Y', '5', 'xxx-x-x1539-x', '', 'ธ.กสิกรไทย', '', 'รับโอนเงิน', 'นาย วิชากานต์ ร', '', '2023-03-16 05:55:01');

-- --------------------------------------------------------

--
-- Table structure for table `reportscb`
--

CREATE TABLE `reportscb` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `details` varchar(100) NOT NULL,
  `date_check` varchar(100) NOT NULL,
  `time_check` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportscb`
--

INSERT INTO `reportscb` (`id`, `type`, `amount`, `details`, `date_check`, `time_check`) VALUES
(98, 'ฝากเงิน', '0.14', 'รับโอนจาก SCB x6773 นางสาว อมรพรรณ คนหลั', '2023-03-14', '12:04:49.000'),
(99, 'ฝากเงิน', '1', 'กสิกรไทย (KBANK) /X454968', '2023-03-14', '16:27:16.000'),
(100, 'ฝากเงิน', '10', 'กสิกรไทย (KBANK) /X454968', '2023-03-14', '16:39:18.000'),
(101, 'ฝากเงิน', '200', 'รับโอนจาก SCB x2493 นางสาว สุมาลี พละการ', '2023-03-14', '20:18:11.000'),
(102, 'ถอนเงิน', '1', 'Transfer to KBANK x4968 Mr. Nattapat Rer', '2023-03-15', '01:13:52.000'),
(103, 'ฝากเงิน', '5', 'กสิกรไทย (KBANK) /X715396', '2023-03-16', '03:35:20.000'),
(104, 'ฝากเงิน', '3', 'กสิกรไทย (KBANK) /X715396', '2023-03-16', '03:54:32.000'),
(105, 'ฝากเงิน', '2', 'กสิกรไทย (KBANK) /X715396', '2023-03-16', '04:30:37.000'),
(106, 'ถอนเงิน', '1', 'Transfer to KBANK x5396 MR. WICHAKAN RAT', '2023-03-16', '05:08:40.000'),
(107, 'ฝากเงิน', '50', 'กรุงไทย (KTB) /X183412', '2023-03-16', '05:39:07.000'),
(108, 'ถอนเงิน', '7', 'Transfer to KBANK x5396 MR. WICHAKAN RAT', '2023-03-16', '06:00:51.000'),
(109, 'ถอนเงิน', '60', 'Transfer to KTB x3412 MISSLAILA PASA', '2023-03-16', '19:13:48.000'),
(110, 'ถอนเงิน', '60', 'Transfer to KTB x3412 MISSLAILA PASA', '2023-03-16', '19:13:45.000'),
(111, 'ฝากเงิน', '20', 'กรุงไทย (KTB) /X183412', '2023-03-16', '19:35:12.000'),
(112, 'ถอนเงิน', '5', 'Transfer to KBANK x5396 MR. WICHAKAN RAT', '2023-03-17', '01:30:20.000');

-- --------------------------------------------------------

--
-- Table structure for table `reporttrue`
--

CREATE TABLE `reporttrue` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `trueacc` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `datetrue` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `name_comment` varchar(100) NOT NULL,
  `date_review` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(10) NOT NULL,
  `name_web` varchar(100) NOT NULL,
  `link_web` varchar(100) NOT NULL,
  `link_aff` varchar(200) NOT NULL,
  `agent` varchar(100) NOT NULL,
  `pass_agent` varchar(100) NOT NULL,
  `agent_link` varchar(100) NOT NULL,
  `logo_web` varchar(200) NOT NULL,
  `pic_web` varchar(200) NOT NULL,
  `pic_user` varchar(200) NOT NULL,
  `slide_1` varchar(1000) NOT NULL,
  `slide_2` varchar(1000) NOT NULL,
  `lineoa` varchar(200) NOT NULL,
  `lineregister` varchar(200) NOT NULL,
  `linedeposit` varchar(200) NOT NULL,
  `linewithdraw` varchar(200) NOT NULL,
  `cashback` varchar(100) NOT NULL,
  `affcashback` varchar(100) NOT NULL,
  `set_dp` varchar(100) NOT NULL,
  `set_wd` varchar(100) NOT NULL,
  `rules` varchar(5000) NOT NULL,
  `txtTotal` text NOT NULL,
  `status_auto` varchar(100) NOT NULL,
  `max_autowd` varchar(100) NOT NULL,
  `status_auto2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name_web`, `link_web`, `link_aff`, `agent`, `pass_agent`, `agent_link`, `logo_web`, `pic_web`, `pic_user`, `slide_1`, `slide_2`, `lineoa`, `lineregister`, `linedeposit`, `linewithdraw`, `cashback`, `affcashback`, `set_dp`, `set_wd`, `rules`, `txtTotal`, `status_auto`, `max_autowd`, `status_auto2`) VALUES
(1, 'luckybet888live', 'luckybet888live.com', 'luckybet888live.com/login.php', 'bdacmlb88', 'uCM0qxiJ5QWgLPGf', '', 'https://sv1.picz.in.th/images/2023/03/12/elxgpJ.png', 'https://sv1.picz.in.th/images/2023/03/12/elxgpJ.png', '-', 'LUCKYBET888LIVE.COM บริการครบวงจร ระบบออโต้ ตลอด 24 ชม.', '-', 'https://lin.ee/tyU9msd', '2PYsGE8oJT3OlvjVo20yvUkVDFahc23ATDpvbpJJAMX', '2PYsGE8oJT3OlvjVo20yvUkVDFahc23ATDpvbpJJAMX', '2PYsGE8oJT3OlvjVo20yvUkVDFahc23ATDpvbpJJAMX', '10', '5', '1', '1', '<p>&nbsp;</p>\r\n\r\n<p>**หากรับโปรโมชั่น ต้องทำเทิร์นให้ครบก่อนแจ้งถอน<br />\r\n**ห้ามมีการเล่นที่ผิดปกติ หรือ เก็บฟรีสปินไว้<br />\r\n**คาสิโนสด ห้ามเทหน้าตัก ห้ามแทงสวน ห้ามแทงทบ</p>\r\n', '54b0c0f438c7c81f337b045a2f068ff4', 'เปิด', '10', 'เปิด');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(200) NOT NULL,
  `s_time` varchar(200) NOT NULL,
  `s_date` varchar(200) NOT NULL,
  `balance` varchar(200) NOT NULL,
  `s_status` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`s_id`, `s_name`, `s_time`, `s_date`, `balance`, `s_status`) VALUES
(1, 'SCB', '11:25:03', '04/09/2020', '2.22', '1'),
(2, 'ufa_agent', '', '', '109715.2', '1'),
(3, 'ktb_balanace', '', '', '', '0'),
(4, 'true', '', '', '641', '1');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(10) NOT NULL,
  `id_wd` int(11) NOT NULL,
  `username_wd` varchar(100) NOT NULL,
  `confirm_wd` varchar(100) NOT NULL DEFAULT '',
  `amount_wd` varchar(100) NOT NULL DEFAULT '0',
  `amount_cashback` varchar(100) NOT NULL DEFAULT '',
  `phone_wd` varchar(100) NOT NULL,
  `bank_wd` varchar(100) NOT NULL,
  `bankacc_wd` varchar(100) NOT NULL,
  `name_wd` varchar(100) NOT NULL,
  `date_wd` timestamp NOT NULL DEFAULT current_timestamp(),
  `note_wd` varchar(100) NOT NULL DEFAULT '',
  `bankout_wd` varchar(100) NOT NULL DEFAULT '',
  `game_wd` varchar(100) NOT NULL DEFAULT '',
  `pin_wd` varchar(100) NOT NULL DEFAULT '',
  `lastpro` varchar(100) NOT NULL DEFAULT '',
  `add_wd` varchar(100) NOT NULL DEFAULT '',
  `edit_wd` varchar(100) NOT NULL DEFAULT '',
  `aff_wd` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`id`, `id_wd`, `username_wd`, `confirm_wd`, `amount_wd`, `amount_cashback`, `phone_wd`, `bank_wd`, `bankacc_wd`, `name_wd`, `date_wd`, `note_wd`, `bankout_wd`, `game_wd`, `pin_wd`, `lastpro`, `add_wd`, `edit_wd`, `aff_wd`) VALUES
(1, 5, 'esCOX', 'อนุมัติ', '1', '', '0620587939', 'ธ.กสิกรไทย', '1343454968', 'ณัฐภัทร รื่นชู', '2023-03-14 14:14:34', '', 'ธนาคารไทยพาณิชย์ 8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(2, 5, 'esCOX', 'อนุมัติ', '1', '', '0620587939', 'ธ.กสิกรไทย', '1343454968', 'ณัฐภัทร รื่นชู', '2023-03-14 18:12:43', '', 'ธนาคารไทยพาณิชย์ 8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(3, 5, 'esCOX', 'อนุมัติ', '1', '', '0620587939', 'ธ.กสิกรไทย', '1343454968', 'ณัฐภัทร รื่นชู', '2023-03-14 18:13:35', '202303155MzKxIpaiO6PQX5l2', 'ธนาคารไทยพาณิชย์ 8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(4, 5, 'esCOX', 'อนุมัติ', '1', '', '0620587939', 'ธ.กสิกรไทย', '1343454968', 'ณัฐภัทร รื่นชู', '2023-03-14 18:17:10', '', 'ธนาคารไทยพาณิชย์ 8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(5, 1, 'n7Lef', 'อนุมัติ', '5', '', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2023-03-15 22:04:17', '202303165NzF91UJaijsWDpCL', 'ธนาคารไทยพาณิชย์-8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(6, 1, 'n7Lef', 'อนุมัติ', '7', '', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2023-03-16 05:59:49', '202303168u2pg3ICoxBbYVtbu', 'ธนาคารไทยพาณิชย์ 8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(8, 1, 'n7Lef', 'อนุมัติ', '0', '0.5', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2023-03-15 23:10:51', '', 'คืนยอดเสีย', '', '', '', '', '', ''),
(9, 1, 'n7Lef', 'อนุมัติ', '0', '0.5', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2023-03-15 23:11:04', '', 'คืนยอดเสีย', '', '', '', '', '', ''),
(10, 3, '3hGfy', 'อนุมัติ', '60', '', '0960675215', 'ธ.กรุงไทย', '5103183412', 'lailapasa', '2023-03-16 06:47:38', '202303163fWOuKZfUmx6FXa45', 'ธนาคารไทยพาณิชย์-8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(11, 3, '3hGfy', 'รอดำเนินการ', '20', '', '0960675215', 'ธ.กรุงไทย', '5103183412', 'lailapasa', '2023-03-16 07:40:19', '', '', '', '', 'ไม่รับโบนัส', '', '', ''),
(12, 1, 'n7Lef', 'อนุมัติ', '5', '', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2023-03-17 01:22:50', '202303172w8zKQxp8NGcC8BIg', 'ธนาคารไทยพาณิชย์-8842559912', '', '', 'ไม่รับโบนัส', '', '', ''),
(13, 1, 'n7Lef', 'ปฏิเสธ', '3', '', '0961658189', 'ธ.กสิกรไทย', '0882715396', 'วิชากานต์ รัตนสมบูรณ์', '2023-03-17 01:32:26', '', 'เงินคืน', '', '', 'ไม่รับโบนัส', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawaff`
--

CREATE TABLE `withdrawaff` (
  `id` int(10) NOT NULL,
  `id_aff` int(11) NOT NULL,
  `username_aff` varchar(100) NOT NULL,
  `confirm_aff` varchar(100) NOT NULL,
  `amount_aff` varchar(100) NOT NULL,
  `phone_aff` varchar(100) NOT NULL,
  `bank_aff` varchar(100) NOT NULL,
  `bankacc_aff` varchar(100) NOT NULL,
  `name_aff` varchar(100) NOT NULL,
  `date_aff` timestamp NOT NULL DEFAULT current_timestamp(),
  `note_aff` varchar(100) NOT NULL,
  `bankout_aff` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawaffiliate`
--

CREATE TABLE `withdrawaffiliate` (
  `id` int(10) NOT NULL,
  `id_aff` int(11) NOT NULL,
  `amount_wd_aff` varchar(100) NOT NULL,
  `status_wd_aff` varchar(100) NOT NULL,
  `dateup_wd_aff` timestamp NOT NULL DEFAULT current_timestamp(),
  `name_wd_aff` varchar(100) NOT NULL,
  `phone_wd_aff` varchar(100) NOT NULL,
  `bank_wd_aff` varchar(100) NOT NULL,
  `bankacc_wd_aff` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `withdrawaffiliate`
--

INSERT INTO `withdrawaffiliate` (`id`, `id_aff`, `amount_wd_aff`, `status_wd_aff`, `dateup_wd_aff`, `name_wd_aff`, `phone_wd_aff`, `bank_wd_aff`, `bankacc_wd_aff`) VALUES
(4, 1, '500', 'รอดำเนินการ', '2022-05-16 15:06:22', 'เอกพล กิจควร', '0899797558', 'ธ.กรุงเทพ', '4647082850');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawvip`
--

CREATE TABLE `withdrawvip` (
  `id` int(10) NOT NULL,
  `id_vip` int(11) NOT NULL,
  `username_vip` varchar(100) NOT NULL,
  `confirm_vip` varchar(100) NOT NULL,
  `amount_vip` varchar(100) NOT NULL,
  `phone_vip` varchar(100) NOT NULL,
  `bank_vip` varchar(100) NOT NULL,
  `bankacc_vip` varchar(100) NOT NULL,
  `name_vip` varchar(100) NOT NULL,
  `date_vip` timestamp NOT NULL DEFAULT current_timestamp(),
  `note_vip` varchar(100) NOT NULL,
  `game_vip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `withdrawvip`
--

INSERT INTO `withdrawvip` (`id`, `id_vip`, `username_vip`, `confirm_vip`, `amount_vip`, `phone_vip`, `bank_vip`, `bankacc_vip`, `name_vip`, `date_vip`, `note_vip`, `game_vip`) VALUES
(1, 663, 'hvejS', 'อนุมัติ', '10', '0829317453', 'ธ.ทหารไทยธนชาติ', '3057043584', 'พงษ์สิทธิ์ ยนทสาท', '2022-06-08 05:50:11', 'VIP 1', ''),
(2, 664, 'WELh4', 'อนุมัติ', '10', '0961284576', 'ธ.ออมสิน', '020334944673', 'เอกรินทร์ เพิงกุณา', '2022-06-08 07:41:02', 'VIP 1', ''),
(3, 663, 'hvejS', 'อนุมัติ', '100', '0829317453', 'ธ.ทหารไทยธนชาติ', '3057043584', 'พงษ์สิทธิ์ ยนทสาท', '2022-06-11 14:46:45', 'VIP 2', ''),
(4, 665, 'hb8MJ', 'อนุมัติ', '100', '0619828070', 'ธ.กสิกรไทย', '1001207772', 'วันชนะ สิงชัย', '2022-06-12 20:28:02', 'VIP 2', ''),
(5, 665, 'hb8MJ', 'อนุมัติ', '10', '0619828070', 'ธ.กสิกรไทย', '1001207772', 'วันชนะ สิงชัย', '2022-06-12 23:02:52', 'VIP 1', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_ad`);

--
-- Indexes for table `affiliate`
--
ALTER TABLE `affiliate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code_update`
--
ALTER TABLE `code_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_mb`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reportkbank`
--
ALTER TABLE `reportkbank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reportscb`
--
ALTER TABLE `reportscb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporttrue`
--
ALTER TABLE `reporttrue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawaff`
--
ALTER TABLE `withdrawaff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawaffiliate`
--
ALTER TABLE `withdrawaffiliate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawvip`
--
ALTER TABLE `withdrawvip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_ad` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `affiliate`
--
ALTER TABLE `affiliate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `code_update`
--
ALTER TABLE `code_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1382;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_mb` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reportkbank`
--
ALTER TABLE `reportkbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1362;

--
-- AUTO_INCREMENT for table `reportscb`
--
ALTER TABLE `reportscb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `reporttrue`
--
ALTER TABLE `reporttrue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `withdrawaff`
--
ALTER TABLE `withdrawaff`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawaffiliate`
--
ALTER TABLE `withdrawaffiliate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `withdrawvip`
--
ALTER TABLE `withdrawvip`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
