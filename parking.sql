-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-05-14 15:28:51
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

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

-- --------------------------------------------------------

--
-- 資料表結構 `parking`
--

CREATE TABLE `parking` (
  `Number` int(11) NOT NULL COMMENT '聯單編號',
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
-- 傾印資料表的資料 `reservation`
--

INSERT INTO `reservation` (`LicensePlateNumber`, `Name`, `Phone`, `Milage`, `ReservationDayIn`, `ReservationDayOut`, `People`, `Remasks`, `Number`, `Backup`) VALUES
('321321', '0', '321321321', 0, '0000-00-00', '0000-00-00', 0, '0', 3, 0),
('1234', '0', '988888789', 1234123, '2024-04-28', '2024-04-29', 200, '0', 7, 0),
('1234-TBV', '王曉明', '0988888789', 1234123, '2024-04-28', '2024-04-29', 200, '', 8, 0),
('123123', 'test', '1212313', 0, '2024-06-01', '2024-06-30', 0, '', 9, 0),
('1234AAA', '王一', '09887765434', 0, '2024-06-01', '2024-06-30', 0, '', 10, 0),
('QQQ1133', '黃二', '098765432f1', 0, '2024-06-01', '2024-06-30', 0, '', 11, 0),
('EEG3333', '張三', '0911222333', 0, '2024-06-01', '2024-06-30', 0, '', 12, 0),
('asdqw3e', '李嗣', '1234123132', 0, '2024-06-01', '2024-06-30', 0, '', 13, 0),
('0192830', '測試', '01287398', 0, '2024-05-15', '2024-06-14', 0, '', 14, 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`Number`);

--
-- 資料表索引 `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Number`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Number` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
