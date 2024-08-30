-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-08-30 20:53:00
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `parking`
--
CREATE DATABASE IF NOT EXISTS `parking` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `parking`;

-- --------------------------------------------------------

--
-- 資料表結構 `parking`
--

CREATE TABLE `parking` (
  `ID` int(11) NOT NULL COMMENT '聯單編號',
  `LicensePlateNumber` text NOT NULL COMMENT '車牌',
  `Milage` int(11) NOT NULL COMMENT '里程數',
  `Name` text NOT NULL COMMENT '駕駛人姓名',
  `Emigrantiot` text NOT NULL COMMENT '出境航廈',
  `EmigrantiotPeople` text NOT NULL COMMENT '出境人數',
  `Immigration` text NOT NULL COMMENT '入境航廈',
  `ImmigrationPeople` text NOT NULL COMMENT '入境人數',
  `Phone` text NOT NULL COMMENT '連絡電話',
  `BigPackage` text NOT NULL COMMENT '大行李',
  `SmallPackage` text NOT NULL COMMENT '小行李',
  `BallTool` text NOT NULL COMMENT '球具',
  `SkiBoard` text NOT NULL COMMENT '滑雪(衝浪)板',
  `OtherObject` text NOT NULL COMMENT '其他物件',
  `BackDay` datetime NOT NULL COMMENT '回國時間',
  `ParkingNumber` text NOT NULL COMMENT '停車位',
  `ParkingDay` datetime NOT NULL COMMENT '進場時間',
  `Remasks` text NOT NULL COMMENT '備註',
  `Backup` int(11) NOT NULL COMMENT '是否停備用車位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `parking`
--

INSERT INTO `parking` (`ID`, `LicensePlateNumber`, `Milage`, `Name`, `Emigrantiot`, `EmigrantiotPeople`, `Immigration`, `ImmigrationPeople`, `Phone`, `BigPackage`, `SmallPackage`, `BallTool`, `SkiBoard`, `OtherObject`, `BackDay`, `ParkingNumber`, `ParkingDay`, `Remasks`, `Backup`) VALUES
(5569, '1323-Q9', 0, '黃S', '第一航廈', '2', '第一航廈', '2', '0963-145-547', '2', '', '', '', '', '2024-09-02 11:00:00', '126', '2024-08-18 19:02:00', '戶外11:00若16天9折$2800,回國可能4件行李', 0),
(6499, 'ABJ-9637', 0, '張R', '第二航廈', '4', '第二航廈', '2', '0911-215-781', '3', '3', '', '', '', '2024-08-30 23:20:00', '60', '2024-08-17 20:00:00', '停滿10天總額-200,優惠2小行李不收費', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `parking_history`
--

CREATE TABLE `parking_history` (
  `ID` int(11) NOT NULL COMMENT '聯單編號',
  `LicensePlateNumber` text NOT NULL COMMENT '車牌',
  `Milage` int(11) NOT NULL COMMENT '里程數',
  `Name` text NOT NULL COMMENT '駕駛人姓名',
  `Emigrantiot` text NOT NULL COMMENT '出境航廈',
  `EmigrantiotPeople` text NOT NULL COMMENT '出境人數',
  `Immigration` text NOT NULL COMMENT '入境航廈',
  `ImmigrationPeople` text NOT NULL COMMENT '入境人數',
  `Phone` text NOT NULL COMMENT '連絡電話',
  `BigPackage` text NOT NULL COMMENT '大行李',
  `SmallPackage` text NOT NULL COMMENT '小行李',
  `BallTool` text NOT NULL COMMENT '球具',
  `SkiBoard` text NOT NULL COMMENT '滑雪(衝浪)板',
  `OtherObject` text NOT NULL COMMENT '其他物件',
  `BackDay` datetime NOT NULL COMMENT '回國時間',
  `ParkingNumber` text NOT NULL COMMENT '停車位',
  `ParkingDay` datetime NOT NULL COMMENT '進場時間',
  `Cost` int(11) NOT NULL COMMENT '金額',
  `Remasks` text NOT NULL COMMENT '備註',
  `Backup` int(11) NOT NULL COMMENT '是否停備用車位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `parking_history`
--

INSERT INTO `parking_history` (`ID`, `LicensePlateNumber`, `Milage`, `Name`, `Emigrantiot`, `EmigrantiotPeople`, `Immigration`, `ImmigrationPeople`, `Phone`, `BigPackage`, `SmallPackage`, `BallTool`, `SkiBoard`, `OtherObject`, `BackDay`, `ParkingNumber`, `ParkingDay`, `Cost`, `Remasks`, `Backup`) VALUES
(401, 'BLX-5035', 0, '廖S', '', '', '', '', '0914-086-127', '', '', '', '', '', '2024-08-23 10:25:52', 'C11', '2024-08-18 13:30:00', 5, '', 0),
(402, 'AYG-7878', 0, '李R', '', '', '', '', '0981-520-189', '', '', '', '', '', '2024-08-27 10:34:09', 'C01', '2024-08-18 17:51:00', 9, '車棚T1/T1 18:00', 0),
(403, 'AFR-3751', 0, '張智凱', '', '', '', '', '0988-615-313', '', '', '', '', '', '2024-08-27 10:41:00', 'C06', '2024-08-19 10:58:00', 8, '車棚', 0),
(3923, 'AJQ-7203', 0, '楊R', '', '', '', '', '0925-990-779', '', '', '', '', '', '2024-08-19 11:17:52', '64', '2024-08-17 14:45:00', 2, '', 0),
(5552, 'AYK-5791', 0, '徐S', '', '', '', '', '0912-547-306', '', '', '', '', '', '2024-08-23 10:28:59', '140', '2024-08-18 12:01:00', 5, '', 0),
(5553, 'AFY-9696', 0, '李少甫', '', '', '', '', '0989-071-556', '', '', '', '', '', '2024-08-27 10:30:54', '218', '2024-08-18 10:37:00', 9, '', 0),
(5554, 'AYF-6153', 0, '鄭霆曜', '', '', '', '', '0937-553-731', '', '', '', '', '', '2024-08-27 10:31:56', '137', '2024-08-18 10:31:00', 10, '去程行李多2件$200', 0),
(5555, 'BRB-5176', 0, '呂育宏', '', '', '', '', '0912-657-007', '', '', '', '', '', '2024-08-23 10:39:58', '82', '2024-08-18 08:57:00', 6, '', 0),
(5556, '3900-G2', 0, '黃R', '', '', '', '', '0921-345-962', '', '', '', '', '', '2024-08-21 14:39:59', '18', '2024-08-18 13:43:00', 4, '', 0),
(5557, 'BSN-9193', 0, '歐R', '', '', '', '', '0939-074-684', '', '', '', '', '', '2024-08-23 10:41:53', '70', '2024-08-18 08:55:00', 6, '', 0),
(5558, 'BPZ-0926', 0, '蔡政安', '', '', '', '', '0986-322-727', '', '', '', '', '', '2024-08-27 10:46:38', '79', '2024-08-18 13:46:00', 9, '', 0),
(5559, 'ALU-0169', 0, '陳宜昌', '', '', '', '', '0920-710-008', '', '', '', '', '', '2024-08-27 10:42:44', '36', '2024-08-18 08:37:00', 10, '', 0),
(5560, 'ALT-5239', 0, '高S', '', '', '', '', '0921-334-611', '', '', '', '', '', '2024-08-27 10:47:07', '16', '2024-08-18 13:34:00', 9, '', 0),
(5562, '1767-Q3', 0, '魏海洋', '', '', '', '', '0925-389-718', '', '', '', '', '', '2024-08-23 10:30:28', '63', '2024-08-18 13:01:00', 5, '', 0),
(5563, 'BKM-3555', 0, '俞松廷', '', '', '', '', '0989-682-463', '', '', '', '', '', '2024-08-23 10:56:01', '15', '2024-08-18 13:00:00', 5, '', 0),
(5564, '7325-MV', 0, '陳雅萍', '', '', '', '', '0902-337-637', '', '', '', '', '', '2024-08-23 10:29:50', '14', '2024-08-18 13:09:00', 5, '', 0),
(5565, 'AJK-1559', 0, '呂欣儒', '', '', '', '', '0963-767-980', '', '', '', '', '', '2024-08-27 10:41:51', '11', '2024-08-18 13:20:00', 9, '', 0),
(5566, 'BTL-3609', 0, '范書維', '', '', '', '', '0985-499-438', '', '', '', '', '', '2024-08-27 10:32:39', '10', '2024-08-18 13:23:00', 9, '與NO.5568一起2車共7人', 0),
(5567, 'BUB-8697', 0, '謝亦靚', '', '', '', '', '0989-648-243', '', '', '', '', '', '2024-08-27 10:32:14', '124', '2024-08-18 13:10:00', 9, '', 0),
(5568, 'BAX-3111', 0, '黃君豪', '', '', '', '', '0983-760-603', '', '', '', '', '', '2024-08-27 10:33:06', '7', '2024-08-18 13:26:00', 9, '與NO.5566一起2車共7人', 0),
(5571, '3090-A8', 0, '謝R', '', '', '', '', '0936-120-303', '', '', '', '', '', '2024-08-23 10:39:02', 'A14', '2024-08-18 19:22:00', 5, '室內', 0),
(5572, '5978-P6', 0, '柯R', '', '', '', '', '0931-480-483', '', '', '', '', '', '2024-08-23 10:24:34', '64', '2024-08-19 02:25:00', 5, 'T2/T2(10:30)', 0),
(5573, 'AYZ-1796', 0, '賴琮為', '', '', '', '', '0906-125-848', '', '', '', '', '', '2024-08-23 16:02:25', '72', '2024-08-19 03:00:00', 5, '戶外', 0),
(5574, 'BTT-8055', 0, '方裕欽', '', '', '', '', '0982-858-585', '', '', '', '', '', '2024-08-23 10:23:30', '69', '2024-08-19 02:45:00', 5, '8/19-8/22 共2車 與5575一起', 0),
(5575, 'BFQ-8055', 0, '徐浩淳', '', '', '', '', '0981-968-890', '', '', '', '', '', '2024-08-23 10:22:37', '22', '2024-08-19 02:45:00', 5, '8/19-8/22 共2車 與5574一起', 0),
(5576, 'AKY-7372', 0, '王R', '', '', '', '', '0927-650-385', '', '', '', '', '', '2024-08-27 10:44:05', '19', '2024-08-19 11:20:00', 8, '', 0),
(5577, 'BDR-7633', 0, '王炳勝', '', '', '', '', '0921-208-031', '', '', '', '', '', '2024-08-27 10:45:46', '21', '2024-08-19 21:06:00', 8, '', 0),
(5578, '7971-B6', 0, '王S', '', '', '', '', '0923-229-775', '', '', '', '', '', '2024-08-27 10:37:14', '68', '2024-08-19 21:08:00', 8, '', 0),
(5579, 'BBF-2252', 0, '張S', '', '', '', '', '0982-059-878', '', '', '', '', '', '2024-08-23 15:51:23', '55', '2024-08-19 21:16:00', 4, '', 0),
(5580, 'BQJ-2257', 0, '洪R', '', '', '', '', '0976-678-250', '', '', '', '', '', '2024-08-30 10:01:24', '54', '2024-08-19 21:26:00', 11, '', 0),
(5581, 'ATR-2797', 0, '林R', '', '', '', '', '0960-614-795', '', '', '', '', '', '2024-08-27 10:40:40', '88', '2024-08-19 21:14:00', 8, '', 0),
(5583, 'BSR-9687', 0, '黃R', '', '', '', '', '0923-659-867', '', '', '', '', '', '2024-08-27 10:44:26', '87', '2024-08-19 21:01:00', 8, '', 0),
(5584, 'BCB-1310', 0, '徐R', '', '', '', '', '0981-232-667', '', '', '', '', '', '2024-08-27 10:47:37', '32', '2024-08-19 21:23:00', 8, '', 0),
(5585, 'APA-0796', 0, '許R', '', '', '', '', '0963-363-321', '', '', '', '', '', '2024-08-27 10:44:51', '28', '2024-08-19 20:57:00', 8, '月村科技180元/天', 0),
(5586, 'BMF-1835', 0, '許R', '', '', '', '', '0928-236-343', '', '', '', '', '', '2024-08-27 10:43:39', '81', '2024-08-19 21:20:00', 8, '', 0),
(5921, 'BHQ-9818', 0, '吳S', '', '', '', '', '0906-552-848', '', '', '', '', '', '2024-08-27 10:45:15', 'J26', '2024-08-17 15:15:00', 10, '', 0),
(5922, 'BTH-8616', 0, '洪偉哲', '', '', '', '', '0989-743-373', '', '', '', '', '', '2024-08-23 15:52:20', 'A05', '2024-08-18 12:08:00', 6, '', 0),
(5924, 'BPB-7156', 0, '柳R', '', '', '', '', '0906-620-363', '', '', '', '', '', '2024-08-23 10:40:37', 'J67', '2024-08-17 14:18:00', 6, '', 0),
(5925, 'AZP-0505', 0, '陳姜蓉', '', '', '', '', '0985-512-219', '', '', '', '', '', '2024-08-23 15:59:31', 'J27', '2024-08-17 14:10:00', 7, '', 0),
(5926, 'BTN-9312', 0, '張榮斌', '', '', '', '', '0922-037-189', '', '', '', '', '', '2024-08-23 15:50:34', 'A08', '2024-08-18 11:56:00', 6, '', 0),
(5927, 'BQA-1133', 0, '謝昱琳', '', '', '', '', '0903-685-210', '', '', '', '', '', '2024-08-23 15:51:45', 'A50', '2024-08-18 12:11:00', 6, '室內,預約消防栓A50, 留鑰匙,$300/日', 0),
(5928, 'BNU-0560', 0, '林欣蓓', '', '', '', '', '0928-082-870', '', '', '', '', '', '2024-08-23 10:41:03', 'J25', '2024-08-18 09:01:00', 6, '', 0),
(5929, 'BVD-1931', 0, '江宜宸', '', '', '', '', '0931-390-193', '', '', '', '', '', '2024-08-23 10:41:27', 'J61', '2024-08-18 08:59:00', 6, '', 0),
(5931, 'ELQ-3110', 0, '李R', '', '', '', '', '0926-040-116', '', '', '', '', '', '2024-08-23 10:54:19', 'J16', '2024-08-18 14:18:00', 5, '', 0),
(5932, 'BHK-3950', 0, '游勝凱', '', '', '', '', '0910-807-750', '', '', '', '', '', '2024-08-27 10:49:29', 'J09', '2024-08-18 15:03:00', 9, '', 0),
(5933, 'BSN-6255', 0, '曾S', '', '', '', '', '0932-603-132', '', '', '', '', '', '2024-08-23 16:22:37', 'A09', '2024-08-19 21:19:00', 4, '室內', 0),
(5934, 'BSU-5098', 0, '陳勝國', '', '', '', '', '0932-678-876', '', '', '', '', '', '2024-08-27 10:48:19', 'J12', '2024-08-18 14:29:00', 9, '', 0),
(5935, 'BHS-5231', 0, '王S', '', '', '', '', '0921-772-776', '', '', '', '', '', '2024-08-27 10:38:53', 'A03', '2024-08-19 21:17:00', 8, '室內', 0),
(5936, 'BFR-1393', 0, '謝S', '', '', '', '', '0961-331-014', '', '', '', '', '', '2024-08-27 10:42:16', 'A61', '2024-08-19 21:15:00', 8, '室內', 0),
(5937, 'BFN-1278', 0, '李R', '', '', '', '', '0935-297-569', '', '', '', '', '', '2024-08-27 10:46:08', 'J15', '2024-08-19 11:19:00', 8, '室內 8/19-8/24', 0),
(5938, '0139-F3', 0, '陳S', '', '', '', '', '0988-069-924', '', '', '', '', '', '2024-08-23 10:55:21', 'J53', '2024-08-19 06:40:00', 5, '室內 8/19-8/21 共2車 與5939一起', 0),
(5939, 'BHZ-2329', 0, '張呈毅', '', '', '', '', '0912-702-505', '', '', '', '', '', '2024-08-23 10:54:53', 'J21', '2024-08-19 06:40:00', 5, '室內 8/19-8/21 共2車 與5938一起', 0),
(5941, 'AUY-9850', 0, '楊R', '', '', '', '', '0912-001-115', '', '', '', '', '', '2024-08-27 10:43:11', 'J59', '2024-08-19 20:52:00', 8, '室內 8/19-8/24', 0),
(5942, 'REB-9207', 0, '李R', '', '', '', '', '0960-011-408', '', '', '', '', '', '2024-08-27 10:41:25', 'J20', '2024-08-19 11:01:00', 8, '室內 8/19-8/23', 0),
(6492, 'AQA-3776', 0, '許R', '', '', '', '', '0961-006-179', '', '', '', '', '', '2024-08-27 10:30:23', '172', '2024-08-17 14:24:00', 10, '與NO.6492一起共8P', 0),
(6493, '1769-U6', 0, '彭S', '', '', '', '', '0903-209-624', '', '', '', '', '', '2024-08-23 10:42:23', '9', '2024-08-17 14:12:00', 6, '', 0),
(6495, 'ACR-1303', 0, '許R', '', '', '', '', '0926-236-463', '', '', '', '', '', '2024-08-27 10:29:39', '163', '2024-08-17 14:22:00', 10, '與NO.6495一起共8P', 0),
(6497, 'AAL-3322', 0, '郭R', '', '', '', '', '0928-048-688', '', '', '', '', '', '2024-08-23 10:24:02', '150', '2024-08-17 13:40:00', 6, '', 0),
(6498, 'BTX-3260', 0, '吳彥逸', '', '', '', '', '0905-271-566', '', '', '', '', '', '2024-08-23 10:25:20', '143', '2024-08-17 17:40:00', 6, '戶外T1/T1 11:10', 0),
(6500, 'AMJ-0259', 0, '陳S', '', '', '', '', '0935-428-843', '', '', '', '', '', '2024-08-27 10:33:31', '92', '2024-08-18 12:03:00', 9, '', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `parking_number`
--

CREATE TABLE `parking_number` (
  `number` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `parking_number`
--

INSERT INTO `parking_number` (`number`, `description`, `created_at`) VALUES
('10', '戶外', '2024-07-24 06:45:15'),
('11', '戶外', '2024-07-24 06:45:15'),
('112', '戶外', '2024-07-24 06:45:15'),
('113', '戶外', '2024-07-24 06:45:15'),
('114', '戶外', '2024-07-24 06:45:15'),
('115', '戶外', '2024-07-24 06:45:15'),
('116', '戶外', '2024-07-24 06:45:15'),
('117', '戶外', '2024-07-24 06:45:15'),
('118', '戶外', '2024-07-24 06:45:15'),
('119', '戶外', '2024-07-24 06:45:15'),
('12', '戶外', '2024-07-24 06:45:15'),
('120', '戶外', '2024-07-24 06:45:15'),
('121', '戶外', '2024-07-24 06:45:15'),
('122', '戶外', '2024-07-24 06:45:15'),
('124', '戶外', '2024-07-24 06:45:15'),
('125', '戶外', '2024-07-24 06:45:15'),
('126', '戶外', '2024-07-24 06:45:15'),
('127', '戶外', '2024-07-24 06:45:15'),
('128', '戶外', '2024-07-24 06:45:15'),
('129', '戶外', '2024-07-24 06:45:15'),
('13', '戶外', '2024-07-24 06:45:15'),
('130', '戶外', '2024-07-24 06:45:15'),
('131', '戶外', '2024-07-24 06:45:15'),
('132', '戶外', '2024-07-24 06:45:15'),
('133', '戶外', '2024-07-24 06:45:15'),
('134', '戶外', '2024-07-24 06:45:15'),
('135', '戶外', '2024-07-24 06:45:15'),
('136', '戶外', '2024-07-24 06:45:15'),
('137', '戶外', '2024-07-24 06:45:15'),
('138', '戶外', '2024-07-24 06:45:15'),
('139', '戶外', '2024-07-24 06:45:15'),
('14', '戶外', '2024-07-24 06:45:15'),
('140', '戶外', '2024-07-24 06:45:15'),
('141', '戶外', '2024-07-24 06:45:15'),
('142', '戶外', '2024-07-24 06:45:15'),
('143', '戶外', '2024-07-24 06:45:15'),
('144', '戶外', '2024-07-24 06:45:15'),
('145', '戶外', '2024-07-24 06:45:15'),
('146', '戶外', '2024-07-24 06:45:15'),
('147', '戶外', '2024-07-24 06:45:15'),
('148', '戶外', '2024-07-24 06:45:15'),
('149', '戶外', '2024-07-24 06:45:15'),
('15', '戶外', '2024-07-24 06:45:15'),
('150', '戶外', '2024-07-24 06:45:15'),
('151', '戶外', '2024-07-24 06:45:15'),
('152', '戶外', '2024-07-24 06:45:15'),
('153', '戶外', '2024-07-24 06:45:15'),
('154', '戶外', '2024-07-24 06:45:15'),
('155', '戶外', '2024-07-24 06:45:15'),
('156', '戶外', '2024-07-24 06:45:15'),
('157', '戶外', '2024-07-24 06:45:15'),
('159', '戶外', '2024-07-24 06:45:15'),
('16', '戶外', '2024-07-24 06:45:15'),
('160', '戶外', '2024-07-24 06:45:15'),
('161', '戶外', '2024-07-24 06:45:15'),
('162', '戶外', '2024-07-24 06:45:15'),
('163', '戶外', '2024-07-24 06:45:15'),
('164', '戶外', '2024-07-24 06:45:15'),
('165', '戶外', '2024-07-24 06:45:15'),
('166', '戶外', '2024-07-24 06:45:15'),
('167', '戶外', '2024-07-24 06:45:15'),
('168', '戶外', '2024-07-24 06:45:15'),
('169', '戶外', '2024-07-24 06:45:15'),
('17', '戶外', '2024-07-24 06:45:15'),
('170', '戶外', '2024-07-24 06:45:15'),
('171', '戶外', '2024-07-24 06:45:15'),
('172', '戶外', '2024-07-24 06:45:15'),
('173', '戶外', '2024-07-24 06:45:15'),
('174', '戶外', '2024-07-24 06:45:15'),
('175', '戶外', '2024-07-24 06:45:15'),
('176', '戶外', '2024-07-24 06:45:15'),
('177', '戶外', '2024-07-24 06:45:15'),
('178', '戶外', '2024-07-24 06:45:15'),
('179', '戶外', '2024-07-24 06:45:15'),
('18', '戶外', '2024-07-24 06:45:15'),
('180', '戶外', '2024-07-24 06:45:15'),
('181', '戶外', '2024-07-24 06:45:15'),
('182', '戶外', '2024-07-24 06:45:15'),
('183', '戶外', '2024-07-24 06:45:15'),
('184', '戶外', '2024-07-24 06:45:15'),
('19', '戶外', '2024-07-24 06:45:15'),
('20', '戶外', '2024-07-24 06:45:15'),
('208', '戶外', '2024-07-24 06:45:15'),
('209', '戶外', '2024-07-24 06:45:15'),
('21', '戶外', '2024-07-24 06:45:15'),
('210', '戶外', '2024-07-24 06:45:15'),
('211', '戶外', '2024-07-24 06:45:15'),
('214', '戶外', '2024-07-24 06:45:15'),
('215', '戶外', '2024-07-24 06:45:15'),
('216', '戶外', '2024-07-24 06:45:15'),
('217', '戶外', '2024-07-24 06:45:15'),
('218', '戶外', '2024-07-24 06:45:15'),
('219', '戶外', '2024-07-24 06:45:15'),
('22', '戶外', '2024-07-24 06:45:15'),
('220', '戶外', '2024-07-24 06:45:15'),
('221', '戶外', '2024-07-24 06:45:15'),
('222', '戶外', '2024-07-24 06:45:15'),
('23', '戶外', '2024-07-24 06:45:15'),
('24', '戶外', '2024-07-24 06:45:15'),
('25', '戶外', '2024-07-24 06:45:15'),
('26', '戶外', '2024-07-24 06:45:15'),
('27', '戶外', '2024-07-24 06:45:15'),
('28', '戶外', '2024-07-24 06:45:15'),
('29', '戶外', '2024-07-24 06:45:15'),
('30', '戶外', '2024-07-24 06:45:15'),
('31', '戶外', '2024-07-24 06:45:15'),
('32', '戶外', '2024-07-24 06:45:15'),
('33', '戶外', '2024-07-24 06:45:15'),
('34', '戶外', '2024-07-24 06:45:15'),
('35', '戶外', '2024-07-24 06:45:15'),
('36', '戶外', '2024-07-24 06:45:15'),
('54', '戶外', '2024-07-24 06:45:15'),
('55', '戶外', '2024-07-24 06:45:15'),
('56', '戶外', '2024-07-24 06:45:15'),
('57', '戶外', '2024-07-24 06:45:15'),
('58', '戶外', '2024-07-24 06:45:15'),
('59', '戶外', '2024-07-24 06:45:15'),
('6', '戶外', '2024-07-24 06:45:15'),
('60', '戶外', '2024-07-24 06:45:15'),
('61', '戶外', '2024-07-24 06:45:15'),
('62', '戶外', '2024-07-24 06:45:15'),
('63', '戶外', '2024-07-24 06:45:15'),
('64', '戶外', '2024-07-24 06:45:15'),
('65', '戶外', '2024-07-24 06:45:15'),
('66', '戶外', '2024-07-24 06:45:15'),
('67', '戶外', '2024-07-24 06:45:15'),
('68', '戶外', '2024-07-24 06:45:15'),
('69', '戶外', '2024-07-24 06:45:15'),
('7', '戶外', '2024-07-24 06:45:15'),
('70', '戶外', '2024-07-24 06:45:15'),
('71', '戶外', '2024-07-24 06:45:15'),
('72', '戶外', '2024-07-24 06:45:15'),
('73', '戶外', '2024-07-24 06:45:15'),
('74', '戶外', '2024-07-24 06:45:15'),
('75', '戶外', '2024-07-24 06:45:15'),
('76', '戶外', '2024-07-24 06:45:15'),
('77', '戶外', '2024-07-24 06:45:15'),
('78', '戶外', '2024-07-24 06:45:15'),
('79', '戶外', '2024-07-24 06:45:15'),
('8', '戶外', '2024-07-24 06:45:15'),
('80', '戶外', '2024-07-24 06:45:15'),
('81', '戶外', '2024-07-24 06:45:15'),
('82', '戶外', '2024-07-24 06:45:15'),
('83', '戶外', '2024-07-24 06:45:15'),
('84', '戶外', '2024-07-24 06:45:15'),
('85', '戶外', '2024-07-24 06:45:15'),
('86', '戶外', '2024-07-24 06:45:15'),
('87', '戶外', '2024-07-24 06:45:15'),
('88', '戶外', '2024-07-24 06:45:15'),
('89', '戶外', '2024-07-24 06:45:15'),
('9', '戶外', '2024-07-24 06:45:15'),
('90', '戶外', '2024-07-24 06:45:15'),
('91', '戶外', '2024-07-24 06:45:15'),
('92', '戶外', '2024-07-24 06:45:15'),
('93', '戶外', '2024-07-24 06:45:15'),
('94', '戶外', '2024-07-24 06:45:15'),
('95', '戶外', '2024-07-24 06:45:15'),
('96', '戶外', '2024-07-24 06:45:15'),
('97', '戶外', '2024-07-24 06:45:15'),
('A01', '室內', '2024-07-24 06:45:15'),
('A02', '室內', '2024-07-24 06:45:15'),
('A03', '室內', '2024-07-24 06:45:15'),
('A04', '室內', '2024-07-24 06:45:15'),
('A05', '室內', '2024-07-24 06:45:15'),
('A06', '室內', '2024-07-24 06:45:15'),
('A07', '室內', '2024-07-24 06:45:15'),
('A08', '室內', '2024-07-24 06:45:15'),
('A09', '室內', '2024-07-24 06:45:15'),
('A10', '室內', '2024-07-24 06:45:15'),
('A11', '室內', '2024-07-24 06:45:15'),
('A12', '室內', '2024-07-24 06:45:15'),
('A13', '室內', '2024-07-24 06:45:15'),
('A14', '室內', '2024-07-24 06:45:15'),
('A15', '室內', '2024-07-24 06:45:15'),
('A16', '室內', '2024-07-24 06:45:15'),
('A17', '室內', '2024-07-24 06:45:15'),
('A18', '室內', '2024-07-24 06:45:15'),
('A19', '室內', '2024-07-24 06:45:15'),
('A20', '室內', '2024-07-24 06:45:15'),
('A21', '室內', '2024-07-24 06:45:15'),
('A22', '室內', '2024-07-24 06:45:15'),
('A23', '室內', '2024-07-24 06:45:15'),
('A24', '室內', '2024-07-24 06:45:15'),
('A25', '室內', '2024-07-24 06:45:15'),
('A26', '室內', '2024-07-24 06:45:15'),
('A27', '室內', '2024-07-24 06:45:15'),
('A28', '室內', '2024-07-24 06:45:15'),
('A29', '室內', '2024-07-24 06:45:15'),
('A30', '室內', '2024-07-24 06:45:15'),
('A31', '室內', '2024-07-24 06:45:15'),
('A32', '室內', '2024-07-24 06:45:15'),
('A33', '室內', '2024-07-24 06:45:15'),
('A34', '室內', '2024-07-24 06:45:15'),
('A35', '室內', '2024-07-24 06:45:15'),
('A36', '室內', '2024-07-24 06:45:15'),
('A37', '室內', '2024-07-24 06:45:15'),
('A38', '室內', '2024-07-24 06:45:15'),
('A39', '室內', '2024-07-24 06:45:15'),
('A40', '室內', '2024-07-24 06:45:15'),
('A41', '室內', '2024-07-24 06:45:15'),
('A42', '室內', '2024-07-24 06:45:15'),
('A43', '室內', '2024-07-24 06:45:15'),
('A44', '室內', '2024-07-24 06:45:15'),
('A45', '室內', '2024-07-24 06:45:15'),
('A46', '室內', '2024-07-24 06:45:15'),
('A47', '室內', '2024-07-24 06:45:15'),
('A48', '室內', '2024-07-24 06:45:15'),
('A49', '室內', '2024-07-24 06:45:15'),
('A50', '室內', '2024-07-24 06:45:15'),
('A51', '室內', '2024-07-24 06:45:15'),
('A52', '室內', '2024-07-24 06:45:15'),
('A53', '室內', '2024-07-24 06:45:15'),
('A54', '室內', '2024-07-24 06:45:15'),
('A55', '室內', '2024-07-24 06:45:15'),
('A56', '室內', '2024-07-24 06:45:15'),
('A57', '室內', '2024-07-24 06:45:15'),
('A58', '室內', '2024-07-24 06:45:15'),
('A59', '室內', '2024-07-24 06:45:15'),
('A60', '室內', '2024-07-24 06:45:15'),
('A61', '室內', '2024-07-24 06:45:15'),
('A62', '室內', '2024-07-24 06:45:15'),
('A63', '室內', '2024-07-24 06:45:15'),
('A64', '室內', '2024-07-24 06:45:15'),
('A65', '室內', '2024-07-24 06:45:15'),
('B01', '戶外', '2024-07-24 06:45:15'),
('B02', '戶外', '2024-07-24 06:45:15'),
('B03', '戶外', '2024-07-24 06:45:15'),
('B04', '戶外', '2024-07-24 06:45:15'),
('B05', '戶外', '2024-07-24 06:45:15'),
('B06', '戶外', '2024-07-24 06:45:15'),
('B07', '戶外', '2024-07-24 06:45:15'),
('B08', '戶外', '2024-07-24 06:45:15'),
('B09', '戶外', '2024-07-24 06:45:15'),
('B10', '戶外', '2024-07-24 06:45:15'),
('B11', '戶外', '2024-07-24 06:45:15'),
('B12', '戶外', '2024-07-24 06:45:15'),
('B13', '戶外', '2024-07-24 06:45:15'),
('B14', '戶外', '2024-07-24 06:45:15'),
('B15', '戶外', '2024-07-24 06:45:15'),
('B16', '戶外', '2024-07-24 06:45:15'),
('B17', '戶外', '2024-07-24 06:45:15'),
('B18', '戶外', '2024-07-24 06:45:15'),
('B19', '戶外', '2024-07-24 06:45:15'),
('B20', '戶外', '2024-07-24 06:45:15'),
('B21', '戶外', '2024-07-24 06:45:15'),
('B22', '戶外', '2024-07-24 06:45:15'),
('B23', '戶外', '2024-07-24 06:45:15'),
('B24', '戶外', '2024-07-24 06:45:15'),
('B25', '戶外', '2024-07-24 06:45:15'),
('C01', '車棚', '2024-08-15 08:06:19'),
('C02', '車棚', '2024-07-24 06:45:15'),
('C03', '車棚', '2024-07-24 06:45:15'),
('C04', '車棚', '2024-07-24 06:45:15'),
('C05', '車棚', '2024-07-24 06:45:15'),
('C06', '車棚', '2024-07-24 06:45:15'),
('C07', '車棚', '2024-07-24 06:45:15'),
('C08', '車棚', '2024-07-24 06:45:15'),
('C09', '車棚', '2024-07-24 06:45:15'),
('C10', '車棚', '2024-07-24 06:45:15'),
('C11', '車棚', '2024-07-24 06:45:15'),
('C12', '車棚', '2024-07-24 06:45:15'),
('C13', '車棚', '2024-07-24 06:45:15'),
('C14', '車棚', '2024-07-24 06:45:15'),
('C15', '車棚', '2024-07-24 06:45:15'),
('C16', '車棚', '2024-07-24 06:45:15'),
('C17', '車棚', '2024-07-24 06:45:15'),
('C18', '車棚', '2024-07-24 06:45:15'),
('C19', '車棚', '2024-07-24 06:45:15'),
('C20', '車棚', '2024-07-24 06:45:15'),
('C21', '車棚', '2024-07-24 06:45:15'),
('C22', '車棚', '2024-07-24 06:45:15'),
('C23', '車棚', '2024-07-24 06:45:15'),
('C24', '車棚', '2024-07-24 06:45:15'),
('C25', '車棚', '2024-07-24 06:45:15'),
('C26', '車棚', '2024-07-24 06:45:15'),
('J01', '室內', '2024-07-24 06:45:15'),
('J02', '室內', '2024-07-24 06:45:15'),
('J03', '室內', '2024-07-24 06:45:15'),
('J04', '室內', '2024-07-24 06:45:15'),
('J05', '室內', '2024-07-24 06:45:15'),
('J06', '室內', '2024-07-24 06:45:15'),
('J07', '室內', '2024-07-24 06:45:15'),
('J08', '室內', '2024-07-24 06:45:15'),
('J09', '室內', '2024-07-24 06:45:15'),
('J10', '室內', '2024-07-24 06:45:15'),
('J11', '室內', '2024-07-24 06:45:15'),
('J12', '室內', '2024-07-24 06:45:15'),
('J13', '室內', '2024-07-24 06:45:15'),
('J14', '室內', '2024-07-24 06:45:15'),
('J15', '室內', '2024-07-24 06:45:15'),
('J16', '室內', '2024-07-24 06:45:15'),
('J17', '室內', '2024-07-24 06:45:15'),
('J18', '室內', '2024-07-24 06:45:15'),
('J19', '室內', '2024-07-24 06:45:15'),
('J20', '室內', '2024-07-24 06:45:15'),
('J21', '室內', '2024-07-24 06:45:15'),
('J22', '室內', '2024-07-24 06:45:15'),
('J23', '室內', '2024-07-24 06:45:15'),
('J24', '室內', '2024-07-24 06:45:15'),
('J25', '室內', '2024-07-24 06:45:15'),
('J26', '室內', '2024-07-24 06:45:15'),
('J27', '室內', '2024-07-24 06:45:15'),
('J28', '室內', '2024-07-24 06:45:15'),
('J29', '室內', '2024-07-24 06:45:15'),
('J30', '室內', '2024-07-24 06:45:15'),
('J31', '室內', '2024-07-24 06:45:15'),
('J32', '室內', '2024-07-24 06:45:15'),
('J33', '室內', '2024-07-24 06:45:15'),
('J34', '室內', '2024-07-24 06:45:15'),
('J35', '室內', '2024-07-24 06:45:15'),
('J36', '室內', '2024-07-24 06:45:15'),
('J37', '室內', '2024-07-24 06:45:15'),
('J38', '室內', '2024-07-24 06:45:15'),
('J39', '室內', '2024-07-24 06:45:15'),
('J40', '室內', '2024-07-24 06:45:15'),
('J41', '室內', '2024-07-24 06:45:15'),
('J42', '室內', '2024-07-24 06:45:15'),
('J43', '室內', '2024-07-24 06:45:15'),
('J44', '室內', '2024-07-24 06:45:15'),
('J45', '室內', '2024-07-24 06:45:15'),
('J46', '室內', '2024-07-24 06:45:15'),
('J47', '室內', '2024-07-24 06:45:15'),
('J48', '室內', '2024-07-24 06:45:15'),
('J49', '室內', '2024-07-24 06:45:15'),
('J50', '室內', '2024-07-24 06:45:15'),
('J51', '室內', '2024-07-24 06:45:15'),
('J52', '室內', '2024-07-24 06:45:15'),
('J53', '室內', '2024-07-24 06:45:15'),
('J54', '室內', '2024-07-24 06:45:15'),
('J55', '室內', '2024-07-24 06:45:15'),
('J56', '室內', '2024-07-24 06:45:15'),
('J57', '室內', '2024-07-24 06:45:15'),
('J58', '室內', '2024-07-24 06:45:15'),
('J59', '室內', '2024-07-24 06:45:15'),
('J60', '室內', '2024-07-24 06:45:15'),
('J61', '室內', '2024-07-24 06:45:15'),
('J62', '室內', '2024-07-24 06:45:15'),
('J63', '室內', '2024-07-24 06:45:15'),
('J64', '室內', '2024-07-24 06:45:15'),
('J65', '室內', '2024-07-24 06:45:15'),
('J66', '室內', '2024-07-24 06:45:15'),
('J67', '室內', '2024-07-24 06:45:15'),
('J68', '室內', '2024-07-24 06:45:15'),
('J69', '室內', '2024-07-24 06:45:15'),
('J70', '室內', '2024-07-24 06:45:15'),
('J71', '室內', '2024-07-24 06:45:15'),
('J72', '室內', '2024-07-24 06:45:15'),
('VVIP', 'VVIP', '2024-07-24 06:45:15');

-- --------------------------------------------------------

--
-- 資料表結構 `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `hourly_rate` int(10) NOT NULL,
  `daily_rate` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `price`
--

INSERT INTO `price` (`id`, `vehicle_type`, `hourly_rate`, `daily_rate`, `created_at`) VALUES
(1, '', 100, 1, '2024-07-16 14:10:09');

-- --------------------------------------------------------

--
-- 資料表結構 `reservation`
--

CREATE TABLE `reservation` (
  `LicensePlateNumber` text NOT NULL COMMENT '車牌號碼',
  `Name` text NOT NULL COMMENT '駕駛人姓名',
  `Phone` text NOT NULL COMMENT '電話',
  `Milage` int(11) NOT NULL COMMENT '里程數',
  `ReservationDayIn` date NOT NULL COMMENT '預約進場日',
  `ReservationDayOut` date NOT NULL COMMENT '預約出場日',
  `People` int(11) NOT NULL COMMENT '人數',
  `Remasks` text NOT NULL COMMENT '備註',
  `Number` int(11) NOT NULL COMMENT '流水號',
  `Backup` int(11) NOT NULL COMMENT '是否停備用車位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `parking_history`
--
ALTER TABLE `parking_history`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `parking_number`
--
ALTER TABLE `parking_number`
  ADD PRIMARY KEY (`number`);

--
-- 資料表索引 `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Number`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Number` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=119;
--
-- 資料庫： `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- 資料表結構 `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- 傾印資料表的資料 `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"parking\",\"table\":\"parking\"},{\"db\":\"parking\",\"table\":\"reservation\"},{\"db\":\"parking\",\"table\":\"price\"},{\"db\":\"parking\",\"table\":\"parking_number\"},{\"db\":\"parking\",\"table\":\"parking_history\"}]');

-- --------------------------------------------------------

--
-- 資料表結構 `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- 傾印資料表的資料 `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'parking', 'reservation', '{\"CREATE_TIME\":\"2024-06-17 20:42:12\",\"col_order\":[0,1,2,3,4,5,6,8,7,9],\"col_visib\":[1,1,1,1,1,1,1,1,1,1]}', '2024-06-25 13:15:05');

-- --------------------------------------------------------

--
-- 資料表結構 `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- 傾印資料表的資料 `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-08-30 12:45:21', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"zh_TW\",\"NavigationWidth\":235}');

-- --------------------------------------------------------

--
-- 資料表結構 `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- 資料表結構 `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- 資料表索引 `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- 資料表索引 `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- 資料表索引 `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- 資料表索引 `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- 資料表索引 `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- 資料表索引 `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- 資料表索引 `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- 資料表索引 `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- 資料表索引 `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- 資料表索引 `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- 資料表索引 `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- 資料表索引 `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- 資料表索引 `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- 資料表索引 `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- 資料表索引 `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- 資料表索引 `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- 資料表索引 `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 資料庫： `price`
--
CREATE DATABASE IF NOT EXISTS `price` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `price`;
--
-- 資料庫： `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
