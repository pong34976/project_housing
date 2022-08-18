-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2022 at 10:38 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_housing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_check`
--

CREATE TABLE `tb_check` (
  `id_check` int(2) NOT NULL,
  `idcard` varchar(13) NOT NULL,
  `id_housing` int(2) NOT NULL,
  `date` date NOT NULL,
  `id_log` int(2) NOT NULL,
  `checkout` int(1) NOT NULL,
  `checkout_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_check`
--

INSERT INTO `tb_check` (`id_check`, `idcard`, `id_housing`, `date`, `id_log`, `checkout`, `checkout_date`) VALUES
(2, '12132123', 4, '2021-11-11', 2, 1, '0000-00-00'),
(3, '12132123', 24, '2021-11-11', 2, 1, '2021-12-01'),
(4, '123123121', 17, '2021-11-14', 2, 1, '2021-12-01'),
(5, '123123121', 17, '2021-11-14', 2, 1, '2021-12-01'),
(6, '123123121', 17, '2021-11-14', 2, 1, '2021-12-01'),
(7, '123123121', 3, '2021-11-14', 2, 1, '2021-12-01'),
(8, '123123121', 3, '2021-11-14', 2, 1, '2021-12-01'),
(9, '123123121', 38, '2021-11-14', 2, 1, '2021-12-01'),
(11, '1232132332132', 37, '2021-11-18', 2, 1, '2021-12-01'),
(12, '1232132332132', 33, '2021-11-18', 2, 1, '2021-12-01'),
(13, '12132123', 38, '2021-11-18', 2, 1, '2021-12-01'),
(14, '1232132332132', 23, '2021-11-18', 2, 1, '2021-12-01'),
(15, '123123123123', 38, '2021-11-28', 2, 1, '2021-12-01'),
(16, '12132123', 22, '2021-12-01', 2, 1, '2021-12-01'),
(17, '213213123', 38, '2021-12-01', 2, 1, '2021-12-01'),
(18, '213213123', 38, '2021-12-01', 2, 1, '2021-12-01'),
(19, '1232132332132', 38, '2021-12-01', 2, 1, '2021-12-01'),
(20, '1232132332132', 38, '2021-12-01', 2, 1, '2021-12-01'),
(22, '1232132332132', 38, '2021-12-01', 2, 1, '2021-12-01'),
(23, '213213123', 22, '2021-12-01', 2, 1, '2021-12-01'),
(24, '12132123', 38, '2021-12-01', 2, 1, '2021-12-14'),
(25, '12132123', 3, '2021-12-14', 2, 1, '2021-12-18'),
(26, '1232132332132', 5, '2022-01-09', 2, 1, '2022-01-09'),
(27, '12132123', 5, '2022-01-09', 2, 1, '2022-01-11'),
(28, '12132123', 20, '2022-01-11', 2, 0, '0000-00-00'),
(29, '123123121', 4, '2022-01-11', 2, 1, '2022-01-12'),
(30, '123123121', 5, '2022-01-11', 2, 1, '2022-01-11'),
(31, '123123121', 8, '2022-01-12', 2, 1, '2022-01-12'),
(32, '1111111111111', 8, '2022-01-12', 2, 0, '0000-00-00'),
(33, '123123121', 30, '2022-01-12', 2, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_checkout`
--

CREATE TABLE `tb_checkout` (
  `id_check` int(2) NOT NULL,
  `date` date NOT NULL,
  `id_log` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_checkout`
--

INSERT INTO `tb_checkout` (`id_check`, `date`, `id_log`) VALUES
(2, '2021-11-24', 1),
(38, '2021-11-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_damaged`
--

CREATE TABLE `tb_damaged` (
  `dam_id` int(3) NOT NULL,
  `id_housing` int(3) NOT NULL,
  `list` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `repair_status` varchar(10) NOT NULL,
  `repair_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_damaged`
--

INSERT INTO `tb_damaged` (`dam_id`, `id_housing`, `list`, `date`, `repair_status`, `repair_date`) VALUES
(19, 17, '            หน้าต่างแตก            ', '2021-12-18', '', '0000-00-00'),
(20, 4, 'aaa', '2022-01-20', '', '0000-00-00'),
(22, 32, 'asdasd', '2022-01-20', '', '2022-01-26');

-- --------------------------------------------------------

--
-- Table structure for table `tb_housing`
--

CREATE TABLE `tb_housing` (
  `id` int(255) NOT NULL,
  `noroom` varchar(200) CHARACTER SET utf8 NOT NULL,
  `housingrow` int(2) NOT NULL,
  `building` varchar(255) NOT NULL,
  `idcard` varchar(12) NOT NULL,
  `status` enum('1','2','3','4') NOT NULL COMMENT '''people'',''free'',''maintain'',''off'''
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_housing`
--

INSERT INTO `tb_housing` (`id`, `noroom`, `housingrow`, `building`, `idcard`, `status`) VALUES
(3, '111', 1, '', '', '1'),
(4, '11', 1, '', '', '3'),
(5, 'ฟฟฟ', 1, '', '', '1'),
(8, 'pp', 1, '', '111111111111', '2'),
(17, 'หลังที่10', 1, '', '', '3'),
(20, '1111', 1, '', '1', '3'),
(21, '11111', 1, '', '1', '4'),
(22, '202/10', 1, '', '', '1'),
(23, '111222', 1, '', '123123123123', '2'),
(24, '1111222', 1, '', '1', '1'),
(26, '1111222333', 1, '', '1', '1'),
(30, '1123', 1, '', '123123121', '2'),
(32, '1123123132', 1, '', '', '3'),
(33, '111112222', 1, '', '1', '1'),
(34, '111222333', 1, '', '1', '1'),
(36, '12222', 1, '', '1', '1'),
(37, '121', 1, '', '1', '1'),
(38, '202/111', 1, '', '123213233213', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_login`
--

CREATE TABLE `tb_login` (
  `log_id` int(3) NOT NULL,
  `log_level` int(2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_login`
--

INSERT INTO `tb_login` (`log_id`, `log_level`, `username`, `password`, `prefix`, `rname`, `lname`, `birthdate`) VALUES
(2, 1, 'admin', 'admin', 'นาย', 'admin', 'admin', '2530-01-01'),
(3, 3, 'user', '1234', 'sss', 'sss', 'ss', '2530-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `tb_permission`
--

CREATE TABLE `tb_permission` (
  `id` int(2) NOT NULL,
  `pmiss` varchar(100) NOT NULL,
  `showname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_permission`
--

INSERT INTO `tb_permission` (`id`, `pmiss`, `showname`) VALUES
(1, 'ADMIN', 'ผู้ดูแลระบบ'),
(2, 'MASTER', 'หัวหน้างาน'),
(3, 'USER', 'ผู้บันทึกข้อมูล');

-- --------------------------------------------------------

--
-- Table structure for table `tb_repair`
--

CREATE TABLE `tb_repair` (
  `repair_id` int(3) NOT NULL,
  `dam_id` int(3) NOT NULL,
  `date_re` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `price` float(100,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_repair`
--

INSERT INTO `tb_repair` (`repair_id`, `dam_id`, `date_re`, `status`, `price`) VALUES
(1, 19, '2222-02-19', '0', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(3) NOT NULL,
  `idcard` varchar(13) NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `sex` enum('ชาย','หญิง') NOT NULL,
  `affiliation` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `address` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `phones` varchar(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `idcard`, `prefix`, `rname`, `lname`, `sex`, `affiliation`, `birthdate`, `address`, `email`, `phones`, `img`) VALUES
(10, '12132123', '12312', '312', '123', 'หญิง', '123', '2537-04-25', '123123', '123213@gmail.com', '123312', '12132123.jpg'),
(19, '1111111111111', '213', '123', '123', 'หญิง', 'ddd', '2530-01-01', '123123', 'kk_kk129@hotmail.com', '6600010101', 'nons.jpg'),
(20, '123123123', 'sss', 'sss', 'sss', 'ชาย', '221312', '2530-01-01', '1231321', '11@gmail.com', '123123', 'nonm.jpg'),
(22, '123123123123', '12312', '313', '123123', 'ชาย', '123123', '2530-01-01', '12312312', 'kk_kkk129@hotmail.com', '1111', 'nonm.jpg'),
(25, '123123121', 'ร้อยตรี', 'ชัยณรง', 'โพธิ์มาย', 'ชาย', 'ม ท บ 1 3.', '2530-01-01', '123123\r\nads\r\n\r\nads\r\nads\r\nads\r\n\r\nad\r\nasasdasd\r\nsda\r\nsad\r\nadsasd\r\nd\r\nsdasdaasaddsadads', '123123@gmail.com', '0655682334', 'nonm.jpg'),
(26, '1232132332132', 'sd', 'asd', 'asd', 'ชาย', 'asd', '2530-01-01', '132123', 'popo@gmail.com', '222222', 'nonm.jpg'),
(27, '222222222', '213123', '12312312', '321123', 'หญิง', '13123', '2530-01-01', '123123', '2222s@asad', '123123213', 'nons.jpg'),
(28, '213213123', '213321', '123123231', '123123', 'ชาย', '123123', '2530-01-01', '123', '123123@dsasadsa', '123321', 'nonm.jpg'),
(29, '1111', 'da', 'asd', 'asd', 'หญิง', 'asddas', '2530-01-01', '2222', 'dsad@as', '222', 'nons.jpg'),
(30, '1179900276113', 'ว่าที่ รต', 'พงศ์พล', 'โพธิ์วิฑูรย์', 'ชาย', 'มทบ13', '2537-04-25', 'dassad', 'pong@ssss.com', '0655682664', 'nonm.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_check`
--
ALTER TABLE `tb_check`
  ADD PRIMARY KEY (`id_check`);

--
-- Indexes for table `tb_checkout`
--
ALTER TABLE `tb_checkout`
  ADD PRIMARY KEY (`id_check`);

--
-- Indexes for table `tb_damaged`
--
ALTER TABLE `tb_damaged`
  ADD PRIMARY KEY (`dam_id`);

--
-- Indexes for table `tb_housing`
--
ALTER TABLE `tb_housing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `noroom` (`noroom`);

--
-- Indexes for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_permission`
--
ALTER TABLE `tb_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_repair`
--
ALTER TABLE `tb_repair`
  ADD PRIMARY KEY (`repair_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phones` (`phones`),
  ADD KEY `rname` (`rname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_check`
--
ALTER TABLE `tb_check`
  MODIFY `id_check` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tb_damaged`
--
ALTER TABLE `tb_damaged`
  MODIFY `dam_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_housing`
--
ALTER TABLE `tb_housing`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `log_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_permission`
--
ALTER TABLE `tb_permission`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_repair`
--
ALTER TABLE `tb_repair`
  MODIFY `repair_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
