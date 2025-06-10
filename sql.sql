-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 22, 2022 at 09:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `werewolf_888`
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
(15, 'แจกฟรีเพียงแค่สมัคร', '<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n\r\n<p>&quot;</p>\r\n', '20220221547023440.jpg', '', '', '3000', '50', 'ปิด', '2022-02-21 11:00:47', '500');

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
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Koh', '00', 'Administrator', '2021-08-26 03:05:01');

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
  `id_bank` int(11) NOT NULL,
  `name_bank` varchar(100) NOT NULL,
  `bankacc_bank` varchar(100) NOT NULL,
  `nameacc_bank` varchar(100) NOT NULL,
  `bankfor` varchar(100) NOT NULL,
  `status_bank` varchar(10) NOT NULL,
  `money_bank` varchar(100) NOT NULL,
  `money_bank2` varchar(100) NOT NULL,
  `fileupload_bank` varchar(200) NOT NULL,
  `date_bank` timestamp NOT NULL DEFAULT current_timestamp(),
  `device` varchar(100) NOT NULL,
  `pin_bank` varchar(100) NOT NULL,
  `password_true` varchar(100) NOT NULL,
  `no_true` varchar(100) NOT NULL,
  `otp_true` varchar(100) NOT NULL,
  `id_kbank` varchar(100) NOT NULL,
  `token_kbank` varchar(3000) NOT NULL,
  `user_kbank` varchar(100) NOT NULL,
  `pass_kbank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `id_bank`, `name_bank`, `bankacc_bank`, `nameacc_bank`, `bankfor`, `status_bank`, `money_bank`, `money_bank2`, `fileupload_bank`, `date_bank`, `device`, `pin_bank`, `password_true`, `no_true`, `otp_true`, `id_kbank`, `token_kbank`, `user_kbank`, `pass_kbank`) VALUES
(70, 1, 'ธนาคารกสิกรไทย', '111111', 'ยุทธชาติ ศรีพรมรี', 'ฝากและถอน', 'เปิด', '', '', 'กสิกร.png', '2022-08-18 06:13:29', '', '', '', '', '', '', '99', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `changepoint`
--

CREATE TABLE `changepoint` (
  `id` int(10) NOT NULL,
  `id_change` int(11) NOT NULL,
  `confirm_change` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date_change` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `changepoint`
--

INSERT INTO `changepoint` (`id`, `id_change`, `confirm_change`, `username`, `amount`, `date_change`) VALUES
(1, 88, 'อนุมัติ', 'GH5tE', '1', '2022-09-13 14:42:14'),
(2, 88, 'อนุมัติ', 'GH5tE', '1', '2022-09-14 10:20:23'),
(3, 100, 'อนุมัติ', 'mNflj', '1', '2022-09-20 13:13:37'),
(4, 99, 'อนุมัติ', 'I20P8', '5', '2022-09-21 13:12:00');

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
(1, 'G2Dmb', '20');

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
(1, '26,438', '', '8,586.62', '14.00');

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
  `fileupload` varchar(200) NOT NULL,
  `promotion_dp` varchar(100) NOT NULL,
  `bankin_dp` varchar(100) NOT NULL,
  `turnover` varchar(100) NOT NULL,
  `game_dp` varchar(100) NOT NULL,
  `note_dp` varchar(100) NOT NULL,
  `aff_dp` varchar(100) NOT NULL,
  `ip_dp` varchar(100) NOT NULL,
  `date_check` date NOT NULL,
  `time_check` time NOT NULL,
  `fromAccount` varchar(100) NOT NULL,
  `fromTrue` varchar(100) NOT NULL,
  `date_dp` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_check_true` varchar(100) NOT NULL,
  `date_check_kbank` varchar(100) NOT NULL,
  `add_dp` varchar(100) NOT NULL,
  `edit_dp` varchar(100) NOT NULL,
  `becoz` varchar(100) NOT NULL,
  `creditbefore` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deposit`
--


-- --------------------------------------------------------

--
-- Table structure for table `history_spin`
--

CREATE TABLE `history_spin` (
  `id` int(11) NOT NULL,
  `reward` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ไม่ได้รับรางวัล',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history_spin`
--



-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_mb` int(10) NOT NULL,
  `username_mb` varchar(100) NOT NULL,
  `password_mb` varchar(100) NOT NULL,
  `phone_mb` varchar(100) NOT NULL,
  `phone_true` varchar(100) NOT NULL,
  `bank_mb` varchar(100) NOT NULL,
  `bankacc_mb` varchar(100) NOT NULL,
  `name_mb` varchar(100) NOT NULL,
  `status_mb` varchar(100) NOT NULL,
  `confirm_mb` varchar(100) NOT NULL,
  `aff` varchar(100) NOT NULL,
  `date_mb` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `password_ufa` varchar(100) NOT NULL,
  `add_mb` varchar(100) NOT NULL,
  `edit_mb` varchar(100) NOT NULL,
  `turnover` varchar(100) NOT NULL,
  `yesterday_turn` varchar(100) NOT NULL,
  `today_turn` varchar(100) NOT NULL,
  `creditspin` varchar(100) NOT NULL,
  `point` varchar(100) NOT NULL,
  `name_eng` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--


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
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_pro` varchar(100) NOT NULL,
  `showpic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `time_check` varchar(100) NOT NULL,
  `bank_acc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportscb`
--



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

--
-- Dumping data for table `reporttrue`
--


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
  `status_auto2` varchar(100) NOT NULL,
  `reward1` varchar(50) NOT NULL,
  `reward2` varchar(50) NOT NULL,
  `reward3` varchar(50) NOT NULL,
  `reward4` varchar(50) NOT NULL,
  `reward5` varchar(50) NOT NULL,
  `reward6` varchar(50) NOT NULL,
  `reward7` varchar(50) NOT NULL,
  `reward8` varchar(50) NOT NULL,
  `Change1` varchar(50) NOT NULL,
  `Change2` varchar(50) NOT NULL,
  `Change3` varchar(50) NOT NULL,
  `Change4` varchar(50) NOT NULL,
  `Change5` varchar(50) NOT NULL,
  `Change6` varchar(50) NOT NULL,
  `Change7` varchar(50) NOT NULL,
  `Change8` varchar(50) NOT NULL,
  `Image1` varchar(50) NOT NULL,
  `Image2` varchar(50) NOT NULL,
  `Image3` varchar(50) NOT NULL,
  `Image4` varchar(50) NOT NULL,
  `Image5` varchar(50) NOT NULL,
  `Image6` varchar(50) NOT NULL,
  `Image7` varchar(50) NOT NULL,
  `Image8` varchar(50) NOT NULL,
  `ImageCenter` varchar(50) NOT NULL,
  `dp_creditspin` varchar(100) NOT NULL,
  `change_point` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name_web`, `link_web`, `link_aff`, `agent`, `pass_agent`, `agent_link`, `logo_web`, `pic_web`, `pic_user`, `slide_1`, `slide_2`, `lineoa`, `lineregister`, `linedeposit`, `linewithdraw`, `cashback`, `affcashback`, `set_dp`, `set_wd`, `rules`, `txtTotal`, `status_auto`, `max_autowd`, `status_auto2`, `reward1`, `reward2`, `reward3`, `reward4`, `reward5`, `reward6`, `reward7`, `reward8`, `Change1`, `Change2`, `Change3`, `Change4`, `Change5`, `Change6`, `Change7`, `Change8`, `Image1`, `Image2`, `Image3`, `Image4`, `Image5`, `Image6`, `Image7`, `Image8`, `ImageCenter`, `dp_creditspin`, `change_point`) VALUES
(1, 'WEREWOLF888', 'werewolf888.com', 'werewolf888.com/login.php', '', '', '', 'https://werewolf888.com/img/werewolf888.png', 'https://ufacup369.com/img/logo.png', 'https://ufacup369.com/img/logo.png', '', '', '', '', '', '', '5', '0.5', '1', '1', '', '', 'เปิด', '300', 'เปิด', '1', '2', '3', '4', '5', '6', 'IPhone', 'IPad', '90', '5', '2', '1', '1', '1', '0', '0', 'spinner/images/1.png', 'spinner/images/2.png', 'spinner/images/3.png', 'spinner/images/4.png', 'spinner/images/5.png', 'spinner/images/6.png', 'spinner/images/iphone.png', 'spinner/images/ipad.png', 'https://werewolf888.com/img/werewolf888.png', '150', '5');

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
  `confirm_wd` varchar(100) NOT NULL,
  `amount_wd` varchar(100) NOT NULL,
  `amount_cashback` varchar(100) NOT NULL,
  `phone_wd` varchar(100) NOT NULL,
  `bank_wd` varchar(100) NOT NULL,
  `bankacc_wd` varchar(100) NOT NULL,
  `name_wd` varchar(100) NOT NULL,
  `date_wd` timestamp NOT NULL DEFAULT current_timestamp(),
  `note_wd` varchar(100) NOT NULL,
  `bankout_wd` varchar(100) NOT NULL,
  `game_wd` varchar(100) NOT NULL,
  `pin_wd` varchar(100) NOT NULL,
  `lastpro` varchar(100) NOT NULL,
  `add_wd` varchar(100) NOT NULL,
  `edit_wd` varchar(100) NOT NULL,
  `aff_wd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `withdraw`
--


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
  `bankout_aff` varchar(100) NOT NULL,
  `timetime` varchar(100) NOT NULL
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
-- Indexes for table `changepoint`
--
ALTER TABLE `changepoint`
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
-- Indexes for table `history_spin`
--
ALTER TABLE `history_spin`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_ad` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `affiliate`
--
ALTER TABLE `affiliate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `changepoint`
--
ALTER TABLE `changepoint`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `history_spin`
--
ALTER TABLE `history_spin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_mb` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `reportkbank`
--
ALTER TABLE `reportkbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `reportscb`
--
ALTER TABLE `reportscb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reporttrue`
--
ALTER TABLE `reporttrue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `withdrawaff`
--
ALTER TABLE `withdrawaff`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawaffiliate`
--
ALTER TABLE `withdrawaffiliate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawvip`
--
ALTER TABLE `withdrawvip`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
