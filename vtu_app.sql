-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 26, 2024 at 10:49 AM
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
-- Database: `vtu_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_bank`
--

CREATE TABLE `add_bank` (
  `serial` int(11) NOT NULL,
  `BankName` varchar(255) DEFAULT NULL,
  `AccNo` varchar(255) DEFAULT NULL,
  `AccName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `add_bank`
--

INSERT INTO `add_bank` (`serial`, `BankName`, `AccNo`, `AccName`) VALUES
(2, 'xxxx', 'xxxx', 'xxxx');

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `serial` int(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `pass` varchar(512) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`serial`, `user_id`, `pass`, `date`) VALUES
(1, 'admin', 'admin', '2017-11-22 21:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `airtime_package`
--

CREATE TABLE `airtime_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `gateway` varchar(100) NOT NULL,
  `discount` float UNSIGNED NOT NULL,
  `user_discount` float UNSIGNED NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `airtime_package`
--

INSERT INTO `airtime_package` (`serial`, `network`, `gateway`, `discount`, `user_discount`, `status`) VALUES
(11, 'mtn', 'n3t', 1, 1, 'enabled'),
(12, 'airtel', 'n3t', 1, 1, 'enabled'),
(13, 'glo', 'n3t', 1, 1, 'enabled'),
(14, 'etisalat', 'n3t', 1, 1, 'enabled'),
(15, 'ntel', 'n3t', 1.5, 0, 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `auto_funding`
--

CREATE TABLE `auto_funding` (
  `serial` int(11) NOT NULL,
  `id` varchar(50) NOT NULL,
  `bankName` varchar(50) NOT NULL,
  `accountNumber` varchar(20) NOT NULL,
  `bankCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bankinfo`
--

CREATE TABLE `bankinfo` (
  `serial` int(11) NOT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `accno` varchar(255) DEFAULT NULL,
  `accname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_gateway`
--

CREATE TABLE `bank_gateway` (
  `serial` int(11) NOT NULL,
  `bankname` varchar(200) DEFAULT NULL,
  `bankcode` varchar(50) DEFAULT NULL,
  `gateway` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bank_gateway`
--

INSERT INTO `bank_gateway` (`serial`, `bankname`, `bankcode`, `gateway`) VALUES
(4, 'FIRST CITY MONUMENT BANK PLC', '214', 'vulte'),
(9, 'OPAY', '305', 'monnify'),
(10, 'ACCESS BANK NIGERIA', '044', 'vulte'),
(15, 'KUDA MICROFINANCE BANK', '090267', 'monnify'),
(19, 'MONIEPOINT MICROFINANCE BANK', '50515', 'monnify');

-- --------------------------------------------------------

--
-- Table structure for table `bank_gateway_settings`
--

CREATE TABLE `bank_gateway_settings` (
  `serial` int(11) NOT NULL,
  `gateway` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bank_gateway_settings`
--

INSERT INTO `bank_gateway_settings` (`serial`, `gateway`) VALUES
(1, 'monnify');

-- --------------------------------------------------------

--
-- Table structure for table `betting_package`
--

CREATE TABLE `betting_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `gateway` varchar(100) NOT NULL,
  `discount` float UNSIGNED NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `betting_package`
--

INSERT INTO `betting_package` (`serial`, `network`, `plan`, `gateway`, `discount`, `status`) VALUES
(12, 'Bet9ja', 'BET9JA', 'epins', 0.8, 'enabled'),
(13, '1xBet', '1XBET', 'epins', 0.8, 'enabled'),
(14, 'Nairabet', 'NAIRABET', 'epins', 0.7, 'enabled'),
(15, 'Betking', 'BETKING', 'epins', 0.9, 'enabled'),
(16, 'NaijaBet', 'NAIJABET', 'epins', 0.8, 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `serial` int(11) NOT NULL,
  `airtelvtu` varchar(50) DEFAULT NULL,
  `mtnvtu` varchar(50) DEFAULT NULL,
  `glovtu` varchar(50) DEFAULT NULL,
  `9mobilevtu` varchar(50) DEFAULT NULL,
  `dstv` varchar(50) DEFAULT NULL,
  `gotv` varchar(50) DEFAULT NULL,
  `startimes` varchar(50) DEFAULT NULL,
  `airtelData` varchar(50) DEFAULT NULL,
  `mtnData` varchar(50) DEFAULT NULL,
  `gloData` varchar(50) DEFAULT NULL,
  `9mobileData` varchar(50) DEFAULT NULL,
  `IkejaElectric` varchar(50) DEFAULT NULL,
  `EkoElectric` varchar(50) DEFAULT NULL,
  `Kedc` varchar(50) DEFAULT NULL,
  `Phed` varchar(50) DEFAULT NULL,
  `Ibedc` varchar(50) DEFAULT NULL,
  `JosElectric` varchar(50) DEFAULT NULL,
  `AbujaElectric` varchar(50) DEFAULT NULL,
  `EnuguElectric` varchar(50) DEFAULT NULL,
  `smile` varchar(50) DEFAULT NULL,
  `waec` varchar(50) DEFAULT NULL,
  `reseller` varchar(50) DEFAULT NULL,
  `setup` varchar(50) DEFAULT NULL,
  `sms` varchar(50) DEFAULT NULL,
  `aedc` varchar(50) DEFAULT NULL,
  `affiliate` varchar(50) DEFAULT NULL,
  `sme` varchar(50) DEFAULT NULL,
  `jambApi` int(11) DEFAULT NULL,
  `jambmockApi` int(11) DEFAULT NULL,
  `nbaisApi` int(11) DEFAULT NULL,
  `nabtebApi` int(11) DEFAULT NULL,
  `necoApi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`serial`, `airtelvtu`, `mtnvtu`, `glovtu`, `9mobilevtu`, `dstv`, `gotv`, `startimes`, `airtelData`, `mtnData`, `gloData`, `9mobileData`, `IkejaElectric`, `EkoElectric`, `Kedc`, `Phed`, `Ibedc`, `JosElectric`, `AbujaElectric`, `EnuguElectric`, `smile`, `waec`, `reseller`, `setup`, `sms`, `aedc`, `affiliate`, `sme`, `jambApi`, `jambmockApi`, `nbaisApi`, `nabtebApi`, `necoApi`) VALUES
(1, '2', '2', '3', '2.5', '1', '1', '1.5', '2', '2', '3', '2.5', '0.8', '0.5', '0.5', '0.5', '0.5', '0.5', '0.7', '0.7', '1.5', '2950', '10000', '50000', '2.8', '0.8', '20', '5', 5700, 6700, 1050, 1050, 850);

-- --------------------------------------------------------

--
-- Table structure for table `buypin`
--

CREATE TABLE `buypin` (
  `serial` int(11) NOT NULL,
  `orderno` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `descr` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  `process` varchar(100) NOT NULL,
  `del` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `serial` int(11) NOT NULL,
  `service` varchar(50) NOT NULL,
  `user` float NOT NULL,
  `api` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`serial`, `service`, `user`, `api`) VALUES
(15, 'moneytransfer', 2, 2),
(17, 'accountupgrade', 10000, 10000),
(19, 'portalsetup', 10000, 60000),
(20, 'gotv', 0.5, 1),
(21, 'dstv', 0.5, 1),
(22, 'startimes', 0.8, 1.5),
(23, 'affiliate', 5, 5),
(24, 'bulksms', 2.75, 2.7);

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `serial` int(11) NOT NULL,
  `airtelvtu` varchar(255) NOT NULL,
  `mtnvtu` varchar(255) NOT NULL,
  `glovtu` varchar(255) NOT NULL,
  `9mobilevtu` varchar(255) NOT NULL,
  `dstv` varchar(255) NOT NULL,
  `gotv` varchar(255) NOT NULL,
  `startimes` varchar(255) NOT NULL,
  `airtelData` varchar(255) NOT NULL,
  `mtnData` varchar(255) NOT NULL,
  `gloData` varchar(255) NOT NULL,
  `9mobileData` varchar(255) NOT NULL,
  `IkejaElectric` varchar(255) NOT NULL,
  `EkoElectric` varchar(255) NOT NULL,
  `Kedc` varchar(255) NOT NULL,
  `Phed` varchar(255) NOT NULL,
  `Ibedc` varchar(255) NOT NULL,
  `JosElectric` varchar(255) NOT NULL,
  `smile` varchar(255) NOT NULL,
  `waec` varchar(255) NOT NULL,
  `reseller` varchar(255) DEFAULT NULL,
  `setup` varchar(255) DEFAULT NULL,
  `sms` varchar(255) DEFAULT NULL,
  `aedc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commission`
--

INSERT INTO `commission` (`serial`, `airtelvtu`, `mtnvtu`, `glovtu`, `9mobilevtu`, `dstv`, `gotv`, `startimes`, `airtelData`, `mtnData`, `gloData`, `9mobileData`, `IkejaElectric`, `EkoElectric`, `Kedc`, `Phed`, `Ibedc`, `JosElectric`, `smile`, `waec`, `reseller`, `setup`, `sms`, `aedc`) VALUES
(0, '0.00', '0.00', '0.00', '0.00', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', '0.01', NULL, NULL, '', '0.01');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `serial` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `numbers` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactx`
--

CREATE TABLE `contactx` (
  `serial` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_package`
--

CREATE TABLE `data_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) DEFAULT NULL,
  `datatype` varchar(50) DEFAULT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `plancode` varchar(50) DEFAULT NULL,
  `clientcode` varchar(50) DEFAULT NULL,
  `price_user` int(11) NOT NULL,
  `price_api` int(11) NOT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `data_package`
--

INSERT INTO `data_package` (`serial`, `network`, `datatype`, `plan`, `plancode`, `clientcode`, `price_user`, `price_api`, `gateway`, `status`) VALUES
(231, '01', 'sme', '1GB (SME) - 30days', '1000', '1000', 270, 265, 'n3t', 'enabled'),
(232, '01', 'sme', '500MB (SME) - 30days', '500', '500', 160, 150, 'n3t', 'enabled'),
(233, '01', 'sme', '2GB (SME) - 30days', '2000', '2000', 520, 510, 'n3t', 'enabled'),
(234, '01', 'sme', '3GB (SME) - 30days', '3000', '3000', 720, 700, 'n3t', 'enabled'),
(235, '01', 'sme', '5GB (SME) - 30days', '5000', '5000', 1220, 1180, 'n3t', 'enabled'),
(236, '01', 'sme', '10GB (SME) - 30 days', '10000', '10000', 2400, 2350, 'n3t', 'enabled'),
(239, '03', 'sme', '500MB (SME) - 30days', '500.01', '500.01', 150, 140, 'n3t', 'enabled'),
(240, '03', 'sme', '1GB (SME) -  30days', '1000.01', '1000.01', 270, 265, 'n3t', 'enabled'),
(242, '03', 'sme', '2GB (SME) - 30days', '2000.01', '2000.01', 540, 530, 'n3t', 'enabled'),
(244, '03', 'sme', '3GB (SME) -  30days', '3000.01', '3000.01', 810, 795, 'n3t', 'enabled'),
(245, '03', 'sme', '4GB (SME) - 30days', '4000.01', '4000.01', 1080, 1060, 'n3t', 'enabled'),
(246, '03', 'sme', '5GB (SME) - 30days', '5500.01', '5500.01', 1350, 1325, 'n3t', 'enabled'),
(249, '03', 'sme', '10GB (SME) - 30days', '110', '000', 2700, 2650, 'n3t', 'enabled'),
(251, '03', 'sme', '15GB (SME) - 30days', '15000.01', '15000.01', 3800, 3800, 'n3t', 'enabled'),
(252, '03', 'sme', '20GB (SME) -  30days', '20000.01', '20000.01', 4700, 4600, 'n3t', 'enabled'),
(255, '03', 'sme', '40GB (SME) - 30days', ' 40000.01', '40000.01', 9000, 8900, 'n3t', 'enabled'),
(256, '03', 'sme', '50GB (SME) - 30days', '50000.01', '50000.01', 11700, 11700, 'n3t', 'enabled'),
(257, '03', 'sme', '100GB (SME) - 30days', '100000.01', '100000.01', 23000, 23000, 'n3t', 'enabled'),
(258, '01', 'cglite', '1GB (CG_LITE)', '210', '210', 265, 263, 'n3t', 'enabled'),
(259, '01', 'cglite', '2GB (CG_LITE)', '211', '211', 530, 526, 'n3t', 'enabled'),
(260, '01', 'cglite', '3GB (CG_LITE)', '212', '212', 795, 789, 'n3t', 'enabled'),
(261, '01', 'cglite', '5GB (CG_LITE)', '213', '213', 1325, 1315, 'n3t', 'enabled'),
(262, '01', 'cglite', '10GB (CG_LITE)', '214', '214', 2650, 2630, 'n3t', 'enabled'),
(263, '01', 'cglite', '12GB (CG_LITE)', '215', '215', 3180, 3156, 'n3t', 'enabled'),
(264, '01', 'cglite', '15GB (CG_LITE)', '216', '216', 3975, 3945, 'n3t', 'enabled'),
(265, '01', 'cglite', '20GB (CG_LITE)', '217', '217', 5300, 5260, 'n3t', 'enabled'),
(266, '01', 'cglite', '25GB (CG_LITE)', '218', '218', 6625, 6575, 'n3t', 'enabled'),
(267, '01', 'cglite', '30GB (CG_LITE)', '219', '219', 7950, 7890, 'n3t', 'enabled'),
(268, '01', 'cglite', '40GB (CG_LITE)', '220', '220', 10600, 10520, 'n3t', 'enabled'),
(269, '01', 'cglite', '50GB (CG_LITE)', '221', '221', 13250, 13150, 'n3t', 'enabled'),
(270, '01', 'cglite', '60GB (CG_LITE)', '260', '260', 15900, 15780, 'n3t', 'enabled'),
(271, '01', 'cglite', '70GB (CG_LITE)', '270', '270', 18550, 18410, 'n3t', 'enabled'),
(272, '01', 'cglite', '75GB (CG_LITE)', '275', '275', 19875, 19725, 'n3t', 'enabled'),
(273, '01', 'cglite', '80GB (CG_LITE)', '278', '278', 21200, 21040, 'n3t', 'enabled'),
(274, '01', 'cglite', '90GB (CG_LITE)', '290', '290', 23850, 23670, 'n3t', 'enabled'),
(275, '01', 'cglite', '100GB (CG_LITE)', '296', '296', 26500, 26300, 'n3t', 'enabled'),
(278, '01', 'gifting', '500MB (CG) - 30days', '500m', '500m', 150, 140, 'n3t', 'enabled'),
(279, '01', 'gifting', '1GB (CG) - 30days', '1g', '1g', 300, 280, 'n3t', 'enabled'),
(280, '01', 'gifting', '2GB (CG) - 30days', '2g', '2g', 600, 560, 'n3t', 'enabled'),
(281, '01', 'gifting', '3GB (CG) - 30days', '3g', '3g', 900, 840, 'n3t', 'enabled'),
(282, '01', 'gifting', '5GB (CG) - 30days', '5g', '5g', 1500, 1400, 'n3t', 'enabled'),
(283, '01', 'gifting', '10GB (CG) - 30days', '10g', '10g', 2850, 2750, 'n3t', 'enabled'),
(284, '01', 'gifting', '12GB (CG) - 30days', '12g', '12g', 3300, 3200, 'n3t', 'enabled'),
(285, '01', 'gifting', '15GB (CG) - 30days', '15g', '15g', 4500, 4200, 'n3t', 'enabled'),
(286, '01', 'gifting', '20GB (CG) - 30days', '20g', '20g', 5500, 5200, 'n3t', 'enabled'),
(287, '01', 'gifting', '25GB (CG) - 30days', '25g', '25g', 7500, 7000, 'n3t', 'enabled'),
(288, '01', 'gifting', '30GB (CG) - 30days', '30g', '30g', 9000, 8400, 'n3t', 'enabled'),
(289, '01', 'gifting', '40GB (CG) - 30days', '40g', '40g', 12000, 11200, 'n3t', 'enabled'),
(290, '01', 'gifting', '50GB (CG) - 30days', '50g', '50g', 15000, 14000, 'n3t', 'enabled'),
(291, '01', 'gifting', '60GB (CG) - 30days', '60g', '60g', 18000, 16800, 'n3t', 'enabled'),
(292, '01', 'gifting', '70GB (CG) - 30days', '70g', '70g', 21000, 19600, 'n3t', 'enabled'),
(293, '01', 'gifting', '75GB (CG) - 30days', '75g', '75g', 22500, 21000, 'n3t', 'enabled'),
(294, '01', 'gifting', '80GB (CG) - 30days', '80g', '80g', 24000, 22400, 'n3t', 'enabled'),
(295, '01', 'gifting', '90GB (CG) - 30days', '90g', '90g', 27000, 25200, 'n3t', 'enabled'),
(296, '01', 'gifting', '100GB (CG) - 30days', '100g', '100g', 30000, 28000, 'n3t', 'enabled'),
(299, '04', 'gifting', '500MB (CG) - 30days', '12', '12', 200, 195, 'n3t', 'enabled'),
(300, '04', 'gifting', '1GB (CG) - 30days', '1000', '1000', 295, 290, 'n3t', 'enabled'),
(301, '04', 'gifting', '2GB (CG) - 30days', '2000', '2000', 590, 590, 'n3t', 'enabled'),
(302, '04', 'gifting', '5GB (CG) - 30days', '5000', '5000', 1400, 1395, 'n3t', 'enabled'),
(303, '04', 'gifting', '10GB (CG) - 30days,', '10000', '10000', 2500, 2495, 'n3t', 'enabled'),
(304, '04', 'gifting', '15GB (CG) - 30days', '15000', '15000', 3600, 3550, 'n3t', 'enabled'),
(305, '04', 'gifting', '20GB (CG) - 30days', '20000', '20000', 5000, 4950, 'n3t', 'enabled'),
(307, '02', 'gifting', '500MB (CG) - 30days', '500m', '500m', 150, 145, 'n3t', 'enabled'),
(308, '02', 'gifting', '1GB (CG) -  30days', '1000', '1000', 275, 270, 'n3t', 'enabled'),
(309, '02', 'gifting', '2GB (CG) - 30days', '2000', '2000', 550, 540, 'n3t', 'enabled'),
(310, '02', 'gifting', '3GB (CG) - 30days', '3000', '3000', 825, 810, 'n3t', 'enabled'),
(311, '02', 'gifting', '5GB (CG) - 30days', '5000', '5000', 1375, 1350, 'n3t', 'enabled'),
(312, '02', 'gifting', '10GB (CG) - 30days', '10000', '10000', 2750, 2700, 'n3t', 'enabled'),
(314, '03', 'gifting', '1GB (CG) - 30days', '', '', 200, 195, 'n3t', 'enabled'),
(315, '03', 'gifting', '1.5GB (CG) - 30days', '', '', 300, 293, 'n3t', 'enabled'),
(316, '03', 'gifting', '2GB (CG) - 30days', '', '', 400, 390, 'n3t', 'enabled'),
(317, '03', 'gifting', '2.5GB (CG) - 30days', '', '', 500, 488, 'n3t', 'enabled'),
(318, '03', 'gifting', '3GB (CG) - 30days', '', '', 600, 585, 'n3t', 'enabled'),
(319, '03', 'gifting', '4GB (CG) - 30days', '', '', 800, 780, 'n3t', 'enabled'),
(320, '03', 'gifting', '10GB (CG) - 30days', '', '', 2000, 1950, 'n3t', 'enabled'),
(321, '01', 'datacard', '1GB (DC) - 30days', '105', '105', 235, 230, 'n3t', 'enabled'),
(322, '01', 'datacard', '1.5GB (DC) - 30 Days', '1500', '1500', 310, 305, 'n3t', 'enabled'),
(323, '01', 'datacard', '2GB (DC) - 30days', '527', '527', 435, 430, 'n3t', 'enabled'),
(324, '01', 'directdata', 'MTN N100 100MB - (24 Hours)', 'mtn-10mb-100', '100', 100, 100, 'n3t', 'enabled'),
(325, '01', 'directdata', 'MTN N200 200MB - 3 days', 'mtn-50mb-200', '200', 200, 200, 'n3t', 'enabled'),
(326, '01', 'directdata', 'MTN N50 50MB 2Go  - (7 Days)', 'mtn-50mb-50', '50', 50, 50, 'n3t', 'enabled'),
(327, '01', 'directdata', 'MTN N150 160MB - 30 days', 'mtn-160mb-150', '150', 150, 150, 'n3t', 'enabled'),
(328, '01', 'directdata', 'MTN N500 750MB - 14 days', 'mtn-750mb-500', '500', 500, 500, 'n3t', 'enabled'),
(329, '01', 'directdata', 'MTN N1,000 1.5GB  - 30 days', 'mtn-100mb-1000', '1000', 1000, 1000, 'n3t', 'enabled'),
(330, '01', 'directdata', 'MTN N2,000 4.5GB  - 30 days', 'mtn-500mb-2000', '2000', 2000, 2000, 'n3t', 'enabled'),
(331, '01', 'directdata', 'MTN N300 350MB - 7 days', 'mtn-350mb-300', '300', 300, 300, 'n3t', 'enabled'),
(332, '01', 'directdata', 'MTN N1,500 6GB  - 7 days', 'mtn-20hrs-1500', '1500', 1500, 1500, 'n3t', 'enabled'),
(333, '01', 'directdata', 'MTN N2,500 6GB  - 30 days', 'mtn-3gb-2500', '2500', 2500, 2500, 'n3t', 'enabled'),
(334, '01', 'directdata', 'MTN N3,000 10GB  - 30 days', 'mtn-data-3000', '3000', 3000, 3000, 'n3t', 'enabled'),
(335, '01', 'directdata', 'MTN N3,500 12GB  - 30 days', 'mtn-1gb-3500', '3500', 3500, 3500, 'n3t', 'enabled'),
(336, '01', 'directdata', 'MTN N5,000 20GB  - 30 days', 'mtn-100hr-5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(337, '01', 'directdata', 'MTN N6,000 25GB  - 30 days', 'mtn-3gb-6000', '6000', 6000, 6000, 'n3t', 'enabled'),
(338, '01', 'directdata', 'MTN N10,000 40GB  - 30 days', 'mtn-40gb-10000', '10000', 10000, 10000, 'n3t', 'enabled'),
(339, '01', 'directdata', 'MTN N15,000 75GB  - 30 days', 'mtn-75gb-15000', '15000', 15000, 15000, 'n3t', 'enabled'),
(340, '01', 'directdata', 'MTN N20,000 75GB  - 60 days', 'mtn-75gb-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(341, '01', 'directdata', 'MTN N1500 3GB  - 30 days', 'mtn-3gb-1500', '1500', 1500, 1500, 'n3t', 'enabled'),
(342, '01', 'directdata', 'MTN N1,200 2GB  - 30 days', 'mtn-2gb-1200', '1200', 1200, 1200, 'n3t', 'enabled'),
(343, '01', 'directdata', 'MTN N8,000 30GB Monthly HyNetFlex Plan (4G Router)', 'mtn-30gb-8000', '8000', 8000, 8000, 'n3t', 'enabled'),
(344, '01', 'directdata', 'MTN N30,000 120GB  - 60days', 'mtn-120gb-30000', '30000', 30000, 30000, 'n3t', 'enabled'),
(345, '01', 'directdata', 'MTN N50,000 150GB  - 90days', 'mtn-150gb-50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(346, '01', 'directdata', 'MTN N75,000 250GB  - 90days', 'mtn-250gb-75000', '75000', 75000, 75000, 'n3t', 'enabled'),
(347, '01', 'directdata', 'MTN N60,000 550GB Monthly HyNetFlex Plan', 'mtn-550gb-60000', '60000', 60000, 60000, 'n3t', 'enabled'),
(348, '01', 'directdata', 'MTN N120,000 400GB  - 365 days', 'mtn-400gb-120000', '120000', 120000, 120000, 'n3t', 'enabled'),
(349, '01', 'directdata', 'MTN N250,000 1000GB  - 365 days', 'mtn-1000gb-250000', '250000', 250000, 250000, 'n3t', 'enabled'),
(350, '01', 'directdata', 'MTN N450,000 2000GB - 365 days', 'mtn-2000gb-450000', '450000', 450000, 450000, 'n3t', 'enabled'),
(351, '01', 'directdata', 'MTN N300 1GB - 1 day', 'mtn-1gb-300', '300', 300, 300, 'n3t', 'enabled'),
(352, '01', 'directdata', 'MTN N300 Xtradata', 'mtn-xtra-300', '300', 300, 300, 'n3t', 'enabled'),
(353, '01', 'directdata', 'MTN N500 1GB  - 7 days', 'mtn-1gb-500', '500', 500, 500, 'n3t', 'enabled'),
(354, '01', 'directdata', 'MTN N500 2.5GB  - 2 days', 'mtn-2-5gb-500', '500', 500, 500, 'n3t', 'enabled'),
(355, '01', 'directdata', 'MTN N500 Xtradata', 'mtn-xtra-500', '500', 500, 500, 'n3t', 'enabled'),
(356, '01', 'directdata', 'MTN N500 750MB 50% Deal Zone Offer (500MB+250MB) (', 'mtn-dealzone-500', '500', 500, 500, 'n3t', 'enabled'),
(357, '01', 'directdata', 'MTN N1,000 Xtradata', 'mtn-xtra-1000', '1000', 1000, 1000, 'n3t', 'enabled'),
(358, '01', 'directdata', 'MTN N2,000 Xtradata', 'mtn-xtra-2000', '2000', 2000, 2000, 'n3t', 'enabled'),
(359, '01', 'directdata', 'MTN N5,000 Xtradata', 'mtn-xtra-5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(360, '01', 'directdata', 'MTN N20,000 110GB  - 30 days', 'mtn-110gb-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(361, '01', 'directdata', 'MTN N10,000 Xtradata', 'mtn-xtra-10000', '10000', 10000, 10000, 'n3t', 'enabled'),
(362, '01', 'directdata', 'SME Data Share N13,500 - 35GB', 'mtn-sme30gb-13500', '13500', 13500, 13500, 'n3t', 'enabled'),
(363, '01', 'directdata', 'MTN N15,000 Xtradata', 'mtn-xtra-15000', '15000', 15000, 15000, 'n3t', 'enabled'),
(364, '01', 'directdata', 'MTN N20,000 Xtradata', 'mtn-xtra-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(365, '01', 'directdata', 'SME Data Share N40,000 - 90GB ', 'mtn-90gb-40000', '40000', 40000, 40000, 'n3t', 'enabled'),
(366, '01', 'directdata', 'SME Data Share N50,000 150GB 12-Months Plan', 'mtn-150gb-sme-50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(367, '01', 'directdata', 'MTN N3,000 11GB Monthly Plan', 'mtn-11gb-3000', '3000', 3000, 3000, 'n3t', 'enabled'),
(368, '01', 'directdata', 'MTN N20,000 150GB Bronze HyNetFlex Unlimited Plan ', 'mtn-130gb-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(369, '01', 'directdata', 'MTN N3,500 13GB Monthly Plan', 'mtn-13gb-3500', '3500', 3500, 3500, 'n3t', 'enabled'),
(370, '01', 'directdata', 'MTN N5,000 30GB Bronze HyNetFlex Unlimited Weekly ', 'mtn-20gb-5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(371, '01', 'directdata', 'MTN N5,000 22GB Monthly Plan', 'mtn-22gb-5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(372, '01', 'directdata', 'MTN N6,000 27GB Monthly Plan', 'mtn-27gb-6000', '6000', 6000, 6000, 'n3t', 'enabled'),
(373, '01', 'directdata', 'MTN N10,000 25GB SME Mobile Data ( 1 Month)', 'mtn-25gb-sme-10000', '10000', 10000, 10000, 'n3t', 'enabled'),
(374, '01', 'directdata', 'MTN N25,000 200GB Monthly HyNetFlex Plan', 'mtn-200gb-25000', '25000', 25000, 25000, 'n3t', 'enabled'),
(375, '01', 'directdata', 'MTN N36,000 300GB 2-Monthly HyNetFlex Plan  (4G Ro', 'mtn-300gb-36000', '36000', 36000, 36000, 'n3t', 'enabled'),
(376, '01', 'directdata', 'MTN N45,000 400GB 3-Monthly HyNetFlex Plan', 'mtn-400gb-45000', '45000', 45000, 45000, 'n3t', 'enabled'),
(377, '01', 'directdata', 'MTN N45,000 400GB Gold Monthly HyNetFlex Unlimited', 'mtn-400gb-46000', '45000', 45000, 45000, 'n3t', 'enabled'),
(378, '01', 'directdata', 'MTN N50,000 165GB SME Mobile Data (2-Months)', 'mtn-165gb-sme-50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(379, '01', 'directdata', 'MTN N100,000 1TB 6-Months HyNetFlex Plan (4G Route', 'mtn-1tb-100000', '100000', 100000, 100000, 'n3t', 'enabled'),
(380, '01', 'directdata', 'MTN N100,000 360GB SME Mobile Data (3 Months)', 'mtn-360gb-sme-100000', '100000', 100000, 100000, 'n3t', 'enabled'),
(381, '01', 'directdata', 'MTN N150,000 1.5TB Yearly HyNetFlex Plan (4G Route', 'mtn-1-5tb-150000', '150000', 150000, 150000, 'n3t', 'enabled'),
(382, '01', 'directdata', 'MTN N165,000 1.5TB 6-Months HyNetFlex Unlimited Pl', 'mtn-1-5tb-165000', '165000', 165000, 165000, 'n3t', 'enabled'),
(383, '01', 'directdata', 'MTN N250,000 1TB SME Mobile Data (3-Months)', 'mtn-1tb-sme-250000', '250000', 250000, 250000, 'n3t', 'enabled'),
(384, '01', 'directdata', 'MTN N100,000 325GB SME Mobile Data (6 Months)', 'mtn-325gb-sme-100000', '100000', 100000, 100000, 'n3t', 'enabled'),
(385, '01', 'directdata', 'MTN N450,000 1500GB Mobile Data (1 Year)', 'mtn-1-5tb-450000', '450000', 450000, 450000, 'n3t', 'enabled'),
(386, '01', 'directdata', 'MTN N100,000 1TB Mobile Data (1 Year)', 'mtn-1tb-110000', '100000', 100000, 100000, 'n3t', 'enabled'),
(387, '01', 'directdata', 'MTN N250,000 2.5TB Yearly Plan', 'mtn-2-5tb-275000', '250000', 250000, 250000, 'n3t', 'enabled'),
(388, '01', 'directdata', 'MTN N500 2.5GB - 2 days', 'mtn-2-5gb-500', '500', 500, 500, 'n3t', 'enabled'),
(389, '01', 'directdata', 'MTN N11,000 - 45GB Monthly HyNetFlex Plan (4G Rout', 'mtn-45gb-11000', '11000', 11000, 11000, 'n3t', 'enabled'),
(390, '01', 'directdata', 'MTN N18,000 - 100GB Monthly HyNetFlex Plan (4G Rou', 'mtn-100gb-18000', '18000', 18000, 18000, 'n3t', 'enabled'),
(391, '01', 'directdata', 'MTN N20000 120GB Monthly Plan', 'mtn-120gb-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(392, '01', 'directdata', 'MTN 100GB 2-Month Plan', 'mtn-100gb-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(393, '01', 'directdata', 'MTN N25,000 200GB Monthly Broadband Plan', 'mtn-200gb-broadband-25000', '25000', 25000, 25000, 'n3t', 'enabled'),
(394, '01', 'directdata', 'MTN N30,000 160GB 2-Month Plan', 'mtn-160gb-30000', '30000', 30000, 30000, 'n3t', 'enabled'),
(395, '01', 'directdata', 'MTN N30,000 300GB Monthly Plan (4G router)', 'mtn-300gb-30000', '30000', 30000, 30000, 'n3t', 'enabled'),
(396, '01', 'directdata', 'MTN N50,000 400GB 3-Month Plan', 'mtn-400gb-50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(397, '01', 'directdata', 'MTN N75,000 600GB 3-Months Plan', 'mtn-600gb-75000', '75000', 75000, 75000, 'n3t', 'enabled'),
(398, '01', 'directdata', 'MTN N200 Xtradata', 'mtn-xtra-200', '200', 200, 200, 'n3t', 'enabled'),
(399, '01', 'directdata', 'MTN N700 3GB  - 2 days', 'mtn-3gb-700', '700', 700, 700, 'n3t', 'enabled'),
(400, '01', 'directdata', 'MTN N1,800 7GB  - 7 days', 'mtn-7gb-1800', '1800', 1800, 1800, 'n3t', 'enabled'),
(402, '04', 'directdata', 'Airtel Data - 100 Naira - 100MB - 1Day', 'airt-100', '100', 100, 100, 'n3t', 'enabled'),
(403, '04', 'directdata', 'Airtel Data - 200 Naira - 200MB - 3Days', 'airt-200', '200', 200, 200, 'n3t', 'enabled'),
(404, '04', 'directdata', 'Airtel Data - 300 Naira - 350MB - 7 Days', 'airt-300', '300', 300, 300, 'n3t', 'enabled'),
(405, '04', 'directdata', 'Airtel Data - 500 Naira - 750MB - 14 Days', 'airt-500', '500', 500, 500, 'n3t', 'enabled'),
(406, '04', 'directdata', 'Airtel Data - 1,000 Naira - 1.5GB - 30 Days', 'airt-1000', '1000', 1000, 1000, 'n3t', 'enabled'),
(407, '04', 'directdata', 'Airtel Data - 1,500 Naira - 3GB - 30 Days', 'airt-1500', '1500', 1500, 1500, 'n3t', 'enabled'),
(408, '04', 'directdata', 'Airtel Data - 2,000 Naira - 4.5GB - 30 Days', 'airt-2000', '2000', 2000, 2000, 'n3t', 'enabled'),
(409, '04', 'directdata', 'Airtel Data - 3,000 Naira - 10GB - 30 Days', 'airt-3000', '3000', 3000, 3000, 'n3t', 'enabled'),
(410, '04', 'directdata', 'Airtel Data - 4,000 Naira - 11GB - 30 Days', 'airt-4000', '4000', 4000, 4000, 'n3t', 'enabled'),
(411, '04', 'directdata', 'Airtel Data - 5,000 Naira - 20GB - 30 Days', 'airt-5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(412, '04', 'directdata', 'Airtel Binge - 1,500 Naira (7 Days) - 6GB', 'airt-1500-2', '1500', 1500, 1500, 'n3t', 'enabled'),
(413, '04', 'directdata', 'Airtel Data - 10,000 Naira - 40GB - 30 Days', 'airt-10000', '10000', 10000, 10000, 'n3t', 'enabled'),
(414, '04', 'directdata', 'Airtel Data - 15,000 Naira - 75GB - 30 Days', 'airt-15000', '15000', 15000, 15000, 'n3t', 'enabled'),
(415, '04', 'directdata', 'Airtel Data - 36,000 Naira - 280GB - 30 Days', 'airt-36000', '36000', 36000, 36000, 'n3t', 'enabled'),
(416, '04', 'directdata', 'Airtel Data - 60,000 Naira - 500GB - 120 Days', 'airt-60000', '60000', 60000, 60000, 'n3t', 'enabled'),
(417, '04', 'directdata', 'Airtel Data - 100,000 Naira - 1TB - 365 Days', 'airt-100000', '100000', 100000, 100000, 'n3t', 'enabled'),
(418, '04', 'directdata', 'Airtel Data - 20,000 Naira - 120GB - 30 Days', 'airt-20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(419, '04', 'directdata', 'Airtel Data - 300 Naira - 1GB - 1 day', 'airt-300x', '300', 300, 300, 'n3t', 'enabled'),
(420, '04', 'directdata', 'Airtel Data - 500 Naira - 2GB - 1 days', 'airt-500x', '500', 500, 500, 'n3t', 'enabled'),
(421, '04', 'directdata', 'Airtel Data - 1,200 Naira - 2GB - 30 Days', 'airt-1200', '1200', 1200, 1200, 'n3t', 'enabled'),
(422, '04', 'directdata', 'Airtel Data - 2,500 Naira - 6GB - 30 Days', 'airt-2500', '2500', 2500, 2500, 'n3t', 'enabled'),
(423, '04', 'directdata', 'Airtel Data - 8,000 Naira - 25GB - 30 Days', 'airt-8000', '8000', 8000, 8000, 'n3t', 'enabled'),
(424, '04', 'directdata', 'Airtel Data - 30,000 Naira - 200GB - 30 Days', 'airt-30000', '30000', 30000, 30000, 'n3t', 'enabled'),
(425, '04', 'directdata', 'Airtel Data - 50,000 Naira - 400GB - 90 Days', 'airt-50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(426, '02', 'directdata', 'Glo Data N100 -  150MB - 1 day', 'glo100', '100', 100, 100, 'n3t', 'enabled'),
(427, '02', 'directdata', 'Glo Data N200 -  350MB - 2 days', 'glo200', '200', 200, 200, 'n3t', 'enabled'),
(428, '02', 'directdata', 'Glo Data N500 -  1.35GB - 14 days', 'glo500', '500', 500, 500, 'n3t', 'enabled'),
(429, '02', 'directdata', 'Glo Data N1000 -  2.9GB - 30 days', 'glo1000', '1000', 1000, 1000, 'n3t', 'enabled'),
(430, '02', 'directdata', 'Glo Data N2000 -  5.8GB - 30 days', 'glo2000', '2000', 2000, 2000, 'n3t', 'enabled'),
(431, '02', 'directdata', 'Glo Data N2500 -  7.7GB - 30 days', 'glo2500', '2500', 2500, 2500, 'n3t', 'enabled'),
(432, '02', 'directdata', 'Glo Data N3000 -  10GB - 30 days', 'glo3000', '3000', 3000, 3000, 'n3t', 'enabled'),
(433, '02', 'directdata', 'Glo Data N4000 -  13.25GB - 30 days', 'glo4000', '4000', 4000, 4000, 'n3t', 'enabled'),
(434, '02', 'directdata', 'Glo Data N5000 -  18.25GB - 30 days', 'glo5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(435, '02', 'directdata', 'Glo Data N8000 -  29.5GB - 30 days', 'glo8000', '8000', 8000, 8000, 'n3t', 'enabled'),
(436, '02', 'directdata', 'Glo Data N10000 -  50GB - 30 days', 'glo10000', '10000', 10000, 10000, 'n3t', 'enabled'),
(437, '02', 'directdata', 'Glo Data N15000 -  93GB - 30 days', 'glo15000', '15000', 15000, 15000, 'n3t', 'enabled'),
(438, '02', 'directdata', 'Glo Data N18000 -  119GB - 30 days', 'glo18000', '18000', 18000, 18000, 'n3t', 'enabled'),
(439, '02', 'directdata', 'Glo Data N1500 -  4.1GB - 30 days', 'glo1500', '1500', 1500, 1500, 'n3t', 'enabled'),
(440, '02', 'directdata', 'Glo Data N20000 -  138GB - 30 days', 'glo20000', '20000', 20000, 20000, 'n3t', 'enabled'),
(441, '02', 'directdata', 'Glo Data  N25 -  250MB - 1 Night', 'glo25', '25', 25, 25, 'n3t', 'enabled'),
(442, '02', 'directdata', 'Glo Data N50 -  500MB - (1 Night)', 'glo50', '50', 50, 50, 'n3t', 'enabled'),
(443, '02', 'directdata', 'Glo Data N50 -  50MB - 1 day', 'glo50x', '50', 50, 50, 'n3t', 'enabled'),
(444, '02', 'directdata', 'Glo Data N100 -  1GB - (5 Nights)', 'glo100x', '100', 100, 100, 'n3t', 'enabled'),
(445, '02', 'directdata', 'Glo Data N200 - 1.25GB - (on Sunday)', 'glo200x', '200', 200, 200, 'n3t', 'enabled'),
(446, '02', 'directdata', 'Glo Data N1500 -  7GB - 7 day', 'glo1500x', '1500', 1500, 1500, 'n3t', 'enabled'),
(447, '02', 'directdata', 'Glo Data N30,000 -  225GB - 30 days', 'glo30000', '30000', 30000, 30000, 'n3t', 'enabled'),
(448, '02', 'directdata', 'Glo Data N36,000 -  300GB - 30 days', 'glo36000', '36000', 36000, 36000, 'n3t', 'enabled'),
(449, '02', 'directdata', 'Glo Data N50,000 -  425GB - 90 days', 'glo50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(450, '02', 'directdata', 'Glo Data N60,000 -  525GB - 120 days', 'glo60000', '60000', 60000, 60000, 'n3t', 'enabled'),
(451, '02', 'directdata', 'Glo Data N75,000 -  675GB - 120 days', 'glo75000', '75000', 75000, 75000, 'n3t', 'enabled'),
(452, '02', 'directdata', 'Glo Data N100,000 -  1TB - 365 days', 'glo100000', '100000', 100000, 100000, 'n3t', 'enabled'),
(453, '02', 'directdata', 'Glo Data (SME) N50 -  200MB - 14 days', 'glo-dg-50', '50', 50, 50, 'n3t', 'enabled'),
(454, '02', 'directdata', 'Glo Data (SME) N250 - 1GB 30 days', 'glo-dg-250', '250', 250, 250, 'n3t', 'enabled'),
(455, '02', 'directdata', 'Glo Data (SME) N750 - 3GB 30 days', 'glo-dg-750', '750', 750, 750, 'n3t', 'enabled'),
(456, '02', 'directdata', 'Glo Data (SME) N2500 - 10GB - 30 Days', 'glo-dg-2500', '2500', 2500, 2500, 'n3t', 'enabled'),
(457, '02', 'directdata', 'Glo Data (SME) N500 - 2GB 30 days', 'glo-dg-500', '500', 500, 500, 'n3t', 'enabled'),
(458, '02', 'directdata', 'Glo Data (SME) N125 - 500MB 14 days', 'glo-dg-125-14', '125', 125, 125, 'n3t', 'enabled'),
(459, '02', 'directdata', 'Glo Data (SME) N125 - 500MB 30 days', 'glo-dg-125-30', '125', 125, 125, 'n3t', 'enabled'),
(460, '02', 'directdata', 'Glo Data (SME) N1250 - 5GB 30 days', 'glo-dg-1250', '1250', 1250, 1250, 'n3t', 'enabled'),
(464, '03', 'directdata', '9mobile 1.5GB - 1,000 Naira - 30 days', 'eti-1000', '1000', 1000, 1000, 'n3t', 'enabled'),
(465, '03', 'directdata', '9mobile 11GB - 4,000 Naira - 30 days', 'eti-4000', '4000', 4000, 4000, 'n3t', 'enabled'),
(466, '03', 'directdata', '9mobile 4.5GB - 2000 Naira - 30 Days', 'eti-2000', '2000', 2000, 2000, 'n3t', 'enabled'),
(467, '03', 'directdata', '9mobile 15GB - 5,000 Naira - 30 Days', 'eti-5000', '5000', 5000, 5000, 'n3t', 'enabled'),
(468, '03', 'directdata', '9mobile 40GB - 10,000 Naira - 30 days', 'eti-10000', '10000', 10000, 10000, 'n3t', 'enabled'),
(469, '03', 'directdata', '9mobile 75GB - 15,000 Naira - 30 Days', 'eti-15000', '15000', 15000, 15000, 'n3t', 'enabled'),
(470, '03', 'directdata', '9mobile 2GB - 1,200 Naira - 30 Days', 'eti-1200', '1200', 1200, 1200, 'n3t', 'enabled'),
(471, '03', 'directdata', '9mobile 25MB - 50 Naira - 1 day', 'eti-50', '50', 50, 50, 'n3t', 'enabled'),
(472, '03', 'directdata', '9mobile 100GB - 84,992 Naira - 100 days', 'eti-84992', '84992', 84992, 84992, 'n3t', 'enabled'),
(473, '03', 'directdata', '9mobile 7GB - 1,500 Naira - 7 days', 'eti-1500', '1500', 1500, 1500, 'n3t', 'enabled'),
(474, '03', 'directdata', '9mobile 75GB - 25,000 Naira - 90 days', 'eti-25000', '25000', 25000, 25000, 'n3t', 'enabled'),
(475, '03', 'directdata', '9mobile 165GB - 50,000 Naira - 180 days', 'eti-50000', '50000', 50000, 50000, 'n3t', 'enabled'),
(476, '03', 'directdata', '9mobile 365GB - 100,000 Naira - 365 days', 'eti-100000', '100000', 100000, 100000, 'n3t', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `data_packages`
--

CREATE TABLE `data_packages` (
  `id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL,
  `network` varchar(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_type` varchar(50) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `duration` varchar(20) NOT NULL,
  `plan_code` varchar(20) NOT NULL,
  `gateway` varchar(20) NOT NULL DEFAULT 'n3t',
  `status` varchar(20) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_packages`
--

INSERT INTO `data_packages` (`id`, `network_id`, `network`, `plan_id`, `plan_type`, `plan_name`, `amount`, `duration`, `plan_code`, `gateway`, `status`) VALUES
(1, 1, 'MTN', 1, 'SME', '500MB', 130, '1 month', '500MB', 'n3t', 'enabled'),
(2, 1, 'MTN', 2, 'SME', '1GB', 260, '1 month', '1GB', 'n3t', 'enabled'),
(3, 1, 'MTN', 3, 'SME', '2GB', 520, '1 month', '2GB', 'n3t', 'enabled'),
(4, 1, 'MTN', 4, 'SME', '3GB', 780, '1 month', '3GB', 'n3t', 'enabled'),
(5, 1, 'MTN', 5, 'SME', '5GB', 1300, '1 month', '5GB', 'n3t', 'enabled'),
(6, 1, 'MTN', 6, 'SME', '10GB', 2600, '1 month', '10GB', 'n3t', 'enabled'),
(7, 4, '9MOBILE', 36, 'GIFTING', '1.5GB', 880, '1 month', '1.5GB', 'n3t', 'enabled'),
(8, 4, '9MOBILE', 37, 'GIFTING', '2GB', 1000, '1 month', '2GB', 'n3t', 'enabled'),
(9, 4, '9MOBILE', 38, 'GIFTING', '3GB', 1300, '1 month', '3GB', 'n3t', 'enabled'),
(10, 4, '9MOBILE', 39, 'GIFTING', '4.5GB', 1750, '1 month', '4.5GB', 'n3t', 'enabled'),
(11, 2, 'AIRTEL', 46, 'COOPERATE GIFTING', '500MB', 137, '1 month', '500MB', 'n3t', 'enabled'),
(12, 2, 'AIRTEL', 47, 'COOPERATE GIFTING', '1GB', 275, '1 month', '1GB', 'n3t', 'enabled'),
(13, 2, 'AIRTEL', 48, 'COOPERATE GIFTING', '2GB', 550, '1 month', '2GB', 'n3t', 'enabled'),
(14, 2, 'AIRTEL', 49, 'COOPERATE GIFTING', '5GB', 1375, '1 month', '5GB', 'n3t', 'enabled'),
(15, 1, 'MTN', 50, 'COOPERATE GIFTING', '500MB', 130, '1 month', '500MB', 'n3t', 'enabled'),
(16, 1, 'MTN', 51, 'COOPERATE GIFTING', '1GB', 260, '1 month', '1GB', 'n3t', 'enabled'),
(17, 1, 'MTN', 52, 'COOPERATE GIFTING', '2GB', 520, '1 month', '2GB', 'n3t', 'enabled'),
(18, 1, 'MTN', 53, 'COOPERATE GIFTING', '3GB', 780, '1 month', '3GB', 'n3t', 'enabled'),
(19, 1, 'MTN', 54, 'COOPERATE GIFTING', '5GB', 1300, '1 month', '5GB', 'n3t', 'enabled'),
(20, 1, 'MTN', 55, 'COOPERATE GIFTING', '10GB', 2600, '1 month', '10GB', 'n3t', 'enabled'),
(21, 2, 'AIRTEL', 56, 'COOPERATE GIFTING', '10GB', 2750, '1 month', '10GB', 'n3t', 'enabled'),
(22, 3, 'GLO', 57, 'COOPERATE GIFTING', '200MB', 50, '1 month', '200MB', 'n3t', 'enabled'),
(23, 3, 'GLO', 58, 'COOPERATE GIFTING', '500MB', 135, '1 month', '500MB', 'n3t', 'enabled'),
(24, 3, 'GLO', 59, 'COOPERATE GIFTING', '1GB', 270, '1 month', '1GB', 'n3t', 'enabled'),
(25, 3, 'GLO', 60, 'COOPERATE GIFTING', '2GB', 540, '1 month', '2GB', 'n3t', 'enabled'),
(26, 3, 'GLO', 61, 'COOPERATE GIFTING', '3GB', 810, '1 month', '3GB', 'n3t', 'enabled'),
(27, 3, 'GLO', 62, 'COOPERATE GIFTING', '5GB', 1350, '1 month', '5GB', 'n3t', 'enabled'),
(28, 3, 'GLO', 63, 'COOPERATE GIFTING', '10GB', 2700, '1 month', '10GB', 'n3t', 'enabled'),
(29, 1, 'MTN', 65, 'GIFTING', '5GB', 1200, '1 month', '5GB', 'n3t', 'enabled'),
(30, 1, 'MTN', 66, 'GIFTING', '3GB', 720, '1 month', '3GB', 'n3t', 'enabled'),
(31, 1, 'MTN', 67, 'GIFTING', '2GB', 480, '1 month', '2GB', 'n3t', 'enabled'),
(32, 1, 'MTN', 68, 'GIFTING', '1GB', 240, '1 month', '1GB', 'n3t', 'enabled'),
(33, 1, 'MTN', 69, 'GIFTING', '500MB', 120, '1 month', '500MB', 'n3t', 'enabled'),
(34, 2, 'AIRTEL', 70, 'COOPERATE GIFTING', '300MB', 85, '1 month', '300MB', 'n3t', 'enabled'),
(35, 2, 'AIRTEL', 71, 'COOPERATE GIFTING', '100MB', 30, '1 month', '100MB', 'n3t', 'enabled'),
(36, 4, '9MOBILE', 72, 'COOPERATE GIFTING', '500MB', 90, '1 month', '500MB', 'n3t', 'enabled'),
(37, 4, '9MOBILE', 73, 'COOPERATE GIFTING', '1GB', 170, '1 month', '1GB', 'n3t', 'enabled'),
(38, 4, '9MOBILE', 74, 'COOPERATE GIFTING', '2GB', 340, '1 month', '2GB', 'n3t', 'enabled'),
(39, 4, '9MOBILE', 75, 'COOPERATE GIFTING', '3GB', 510, '1 month', '3GB', 'n3t', 'enabled'),
(40, 4, '9MOBILE', 76, 'COOPERATE GIFTING', '5GB', 850, '1 month', '5GB', 'n3t', 'enabled'),
(41, 4, '9MOBILE', 77, 'COOPERATE GIFTING', '10GB', 1700, '1 month', '10GB', 'n3t', 'enabled'),
(42, 1, 'MTN', 78, 'GIFTING', '1GB', 225, '1Day Awoof Data', '1GB', 'n3t', 'enabled'),
(43, 1, 'MTN', 79, 'GIFTING', '3.5GB', 550, '2Days Awoof Data', '3.5GB', 'n3t', 'enabled'),
(44, 1, 'MTN', 80, 'GIFTING', '15GB', 2050, '7Days Awoof Data', '15GB', 'n3t', 'enabled'),
(45, 2, 'AIRTEL', 82, 'GIFTING', '100MB', 70, '1Day Awoof Data', '100MB', 'n3t', 'enabled'),
(46, 2, 'AIRTEL', 83, 'GIFTING', '300MB', 125, '2Days Awoof Data', '300MB', 'n3t', 'enabled'),
(47, 2, 'AIRTEL', 84, 'GIFTING', '1GB', 230, '2Days Awoof Data', '1GB', 'n3t', 'enabled'),
(48, 2, 'AIRTEL', 85, 'GIFTING', '2GB', 350, '2Days Awoof Data', '2GB', 'n3t', 'enabled'),
(49, 2, 'AIRTEL', 86, 'GIFTING', '3GB', 550, '7Days Awoof Data', '3GB', 'n3t', 'enabled'),
(50, 2, 'AIRTEL', 87, 'GIFTING', '4GB', 1030, '1Month Awoof Data', '4GB', 'n3t', 'enabled'),
(51, 2, 'AIRTEL', 88, 'GIFTING', '10GB', 2050, '1Month Awoof Data', '10GB', 'n3t', 'enabled'),
(52, 2, 'AIRTEL', 89, 'GIFTING', '15GB', 3050, '1Month Awoof Data', '15GB', 'n3t', 'enabled'),
(53, 3, 'GLO', 90, 'GIFTING', '1GB', 220, '1Day Awoof Data', '1GB', 'n3t', 'enabled'),
(54, 3, 'GLO', 91, 'GIFTING', '2GB', 320, '1Day Awoof Data', '2GB', 'n3t', 'enabled'),
(55, 3, 'GLO', 92, 'GIFTING', '3.5GB', 500, '2Days Awoof Data', '3.5GB', 'n3t', 'enabled'),
(56, 3, 'GLO', 93, 'GIFTING', '15GB', 2000, '7Days Awoof Data', '15GB', 'n3t', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `serial` int(11) NOT NULL,
  `orderno` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `charge` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `method` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `reg` varchar(100) NOT NULL,
  `process` varchar(100) NOT NULL,
  `del` varchar(100) NOT NULL,
  `switch` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `ref` varchar(255) NOT NULL,
  `refer` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `serial` int(11) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `commission` varchar(255) NOT NULL,
  `withdrawal` varchar(255) NOT NULL,
  `alltime` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `period` varchar(255) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`serial`, `transaction`, `commission`, `withdrawal`, `alltime`, `status`, `user`, `period`, `date`) VALUES
(1, '', '', '100', '0', '', 'test@gmail.com', '2020-04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `earnlog`
--

CREATE TABLE `earnlog` (
  `serial` int(11) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `refby` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electric_package`
--

CREATE TABLE `electric_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `gateway` varchar(100) NOT NULL,
  `discount` float UNSIGNED NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `electric_package`
--

INSERT INTO `electric_package` (`serial`, `network`, `plan`, `gateway`, `discount`, `status`) VALUES
(1, 'abuja', 'AEDC', 'epins', 0.2, 'enabled'),
(2, 'enugu', 'EEDC', 'epins', 0.4, 'enabled'),
(3, 'eko', 'EKEDC', 'epins', 0.2, 'enabled'),
(4, 'ikeja', 'EKEDC', 'epins', 0.3, 'enabled'),
(5, 'ibadan', 'IBEDC', 'epins', 0.2, 'enabled'),
(6, 'benin', 'BEDC', 'epins', 0.4, 'enabled'),
(7, 'portharcourt', 'PHED', 'n3t', 0.6, 'enabled'),
(8, 'jos', 'JED', 'epins', 0.3, 'enabled'),
(9, 'kano', 'KEDCO', 'epins', 0.4, 'enabled'),
(10, 'kaduna', 'KAEDCO', 'epins', 0.4, 'enabled'),
(11, 'yola', 'YODC', 'husmodata', 0.1, 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `epins_dataplan`
--

CREATE TABLE `epins_dataplan` (
  `serial` int(11) NOT NULL,
  `500m` varchar(11) NOT NULL,
  `1g` varchar(11) NOT NULL,
  `2g` varchar(11) NOT NULL,
  `3g` varchar(11) NOT NULL,
  `5g` varchar(11) NOT NULL,
  `10g` varchar(11) NOT NULL,
  `12g` varchar(11) NOT NULL,
  `15g` varchar(11) NOT NULL,
  `20g` varchar(11) NOT NULL,
  `25g` varchar(11) NOT NULL,
  `30g` varchar(11) NOT NULL,
  `35g` varchar(11) NOT NULL,
  `40g` varchar(11) NOT NULL,
  `50g` varchar(11) NOT NULL,
  `60g` varchar(11) NOT NULL,
  `network` varchar(50) DEFAULT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `datatype` varchar(50) DEFAULT NULL,
  `70g` varchar(50) DEFAULT NULL,
  `75g` varchar(50) DEFAULT NULL,
  `80g` varchar(50) DEFAULT NULL,
  `90g` varchar(50) DEFAULT NULL,
  `100g` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `epins_dataplan`
--

INSERT INTO `epins_dataplan` (`serial`, `500m`, `1g`, `2g`, `3g`, `5g`, `10g`, `12g`, `15g`, `20g`, `25g`, `30g`, `35g`, `40g`, `50g`, `60g`, `network`, `gateway`, `datatype`, `70g`, `75g`, `80g`, `90g`, `100g`) VALUES
(16, '500', '1000', '2000', '3000', '5000', '10000', '', '', '', '', '', '', '', '', '', 'mtn', 'epins', 'sme', '', '', '', '', '64');

-- --------------------------------------------------------

--
-- Table structure for table `epin_package`
--

CREATE TABLE `epin_package` (
  `serial` int(11) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `commission` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `epin_package`
--

INSERT INTO `epin_package` (`serial`, `duration`, `plan`, `amount`, `commission`) VALUES
(1, '1', 'Classic', '5000', '500'),
(3, '12', 'Premium', '3500', '500');

-- --------------------------------------------------------

--
-- Table structure for table `exam_package`
--

CREATE TABLE `exam_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `plancode` varchar(50) NOT NULL,
  `clientcode` varchar(50) DEFAULT NULL,
  `price_user` int(11) NOT NULL,
  `price_api` int(11) NOT NULL,
  `gateway` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `exam_package`
--

INSERT INTO `exam_package` (`serial`, `network`, `plan`, `plancode`, `clientcode`, `price_user`, `price_api`, `gateway`, `status`) VALUES
(3, 'jamb', 'JAMB UTME', 'UTME', 'UTME', 6700, 6600, 'epins', 'enabled'),
(4, 'jamb', 'JAMB MOCK', 'UTME_MOCK', 'UTME_MOCK', 5800, 5700, 'epins', 'enabled'),
(5, 'nabteb', 'NABTEB RESULT CHECKER', 'NABTEB', 'NABTEB', 1100, 1000, 'epins', 'enabled'),
(7, 'waec', 'WAEC Result Checker', 'WAEC', 'WAEC', 3100, 3000, 'n3t', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `gifting-data`
--

CREATE TABLE `gifting-data` (
  `serial` int(11) NOT NULL,
  `airtel_1` varchar(50) DEFAULT NULL,
  `airtel_2` varchar(50) DEFAULT NULL,
  `airtel_3` varchar(50) DEFAULT NULL,
  `airtel_4` varchar(50) DEFAULT NULL,
  `airtel_5` varchar(50) DEFAULT NULL,
  `airtel_6` varchar(50) DEFAULT NULL,
  `airtel_7` varchar(50) DEFAULT NULL,
  `airtel_8` varchar(50) DEFAULT NULL,
  `airtel_9` varchar(50) DEFAULT NULL,
  `airtel_10` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `serial` int(11) NOT NULL,
  `network` varchar(100) NOT NULL,
  `recipient` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_info`
--

CREATE TABLE `kyc_info` (
  `serial` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `bvn` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `serial` int(11) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `caller` varchar(255) NOT NULL,
  `callgroup` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loginattempts`
--

CREATE TABLE `loginattempts` (
  `IP` varchar(20) NOT NULL,
  `Attempts` int(11) NOT NULL,
  `LastLogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_history`
--

CREATE TABLE `message_history` (
  `serial` int(11) NOT NULL,
  `mobile` mediumtext NOT NULL,
  `username` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `message` varchar(650) NOT NULL,
  `refid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `senttime` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `message_history`
--

INSERT INTO `message_history` (`serial`, `mobile`, `username`, `sender`, `message`, `refid`, `status`, `charge`, `senttime`, `action`) VALUES
(1, '07031197671, 08071135561', 'ppfdigibrand@gmail.com', 'VIRTUALPRENEURNG ', 'hfdhddhjhjjjjjjjshs', '398524248', '', '5', '25-06-2020 09:06:37', 'View Report'),
(2, '08064981375', 'joarumona@gmail.com', 'Hasotel', 'Hello', '295575415', '', '2.5', '02-07-2020 15:07:20', 'View Report'),
(3, '08066169431', 'iweakarin@gmail.com', 'ade enterprises', 'hello are you there', '620313518', '', '2.5', '29-11-2020 18:11:41', 'View Report'),
(4, '08092866937', 'visiblepage@gmail.com', 'RECHARGEBYVTU', 'Cuz cheap data', '400710431', '', '2.5', '25-04-2021 05:04:59', 'View Report'),
(5, '08066532759', 'kconlinebizz@gmail.com', '247bills', 'Just testing ', '284944750', '', '2.5', '19-01-2023 16:01:46', 'View Report');

-- --------------------------------------------------------

--
-- Table structure for table `monnify_api`
--

CREATE TABLE `monnify_api` (
  `serial_no` int(11) NOT NULL,
  `monn_apikey` varchar(255) NOT NULL,
  `monn_secret` varchar(255) NOT NULL,
  `monn_contra` varchar(100) NOT NULL,
  `monn_walletid` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monnify_api`
--

INSERT INTO `monnify_api` (`serial_no`, `monn_apikey`, `monn_secret`, `monn_contra`, `monn_walletid`) VALUES
(1, 'MK_PROD_CAGTHFZES4', 'TVN9GVZ4G2UQ8GS2B4SW9VDR47E26K87', '646294275325', '6000000726');

-- --------------------------------------------------------

--
-- Table structure for table `mypin`
--

CREATE TABLE `mypin` (
  `serial` int(11) NOT NULL,
  `net` varchar(50) NOT NULL,
  `cat` varchar(50) NOT NULL,
  `pins` longtext NOT NULL,
  `email` varchar(100) NOT NULL,
  `ref` varchar(100) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `cardname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mypin`
--

INSERT INTO `mypin` (`serial`, `net`, `cat`, `pins`, `email`, `ref`, `order_date`, `cardname`) VALUES
(16, 'airtel', '1', 'Dial *126*pin#', 'gabrielonabulu400@gmail.com', '7942887630159601', '2023-07-03 15:20:50', 'Fatch'),
(17, 'airtel', '1', '1387714104657253', 'gabrielonabulu400@gmail.com', '1696720830859471', '2023-07-03 15:28:10', 'Kepp'),
(18, 'mtn', '1', '0000002384588804361967804247473764000000100BC\r', 'gabrielonabulu400@gmail.com', '1878095073126496', '2023-07-05 23:54:50', 'Fatch'),
(19, 'mtn', '1', '0000002384588805502202340848120315000000100BC\r', 'gabrielonabulu400@gmail.com', '6947128105670893', '2023-07-06 01:47:08', 'Tin'),
(20, 'mtn', '1', '0000002384588807581467523760552214000000100BC\r', 'gabrielonabulu400@gmail.com', '7900735488696211', '2023-07-06 01:50:51', 'Fatch'),
(22, 'mtn', '1', '0000002384588888605613793219801008000000100BC', 'gabrielonabulu400@gmail.com', '5071704869639218', '2023-07-06 08:18:36', 'Kepp'),
(23, 'mtn', '1', '0000002384588852259935824356022470000000100BC\r', 'gabrielonabulu400@gmail.com', '6802173089645197', '2023-07-06 12:42:53', 'Fatch'),
(24, 'mtn', '1', '0000002384588853520056166872599206000000100BC\r', 'favourchuk994@gmail.com', '6907782190415683', '2023-07-08 13:29:47', 'fachuzy'),
(25, 'mtn', '1', '0000002384588854960317771766823452000000100BC\r', 'gabrielonabulu400@gmail.com', '9357660081748921', '2023-07-08 13:52:30', 'Fatch'),
(26, 'mtn', '1', '0000002384588855896086090186748548000000100BC\r', 'favourchuk994@gmail.com', '6098773610895124', '2023-07-08 18:55:39', 'fachuzy'),
(27, 'mtn', '1', '0000002384588859359930462025860387000000100BC\r', 'gabrielonabulu400@gmail.com', '5806942187361970', '2023-07-08 19:08:04', 'Fachuzydatas'),
(30, 'airtel', '1', '1387714104657253 Dial *126*pin#', 'gabrielonabulu400@gmail.com', '1268400671875939', '2023-07-10 08:59:54', 'Fatch'),
(31, 'mtn', '1', '0000002384588861415711214872167144000000100BC\r', 'gabrielonabulu400@gmail.com', '5147813269976080', '2023-07-10 09:02:28', 'Fatch'),
(32, 'mtn', '1', '0000002384588862859947682425108313000000100BC', 'rovingtechsolution@gmail.com', '0367499128815076', '2023-07-10 11:20:13', NULL),
(33, 'mtn', '1', '0000002385395550892980130860618104000000100BC\r', 'gabrielonabulu400@gmail.com', '1082691590837467', '2023-07-10 12:01:10', 'Fatch'),
(34, 'mtn', '1', '0000002385395551330468812581669497000000100BC\r', 'rovingtechsolution@gmail.com', '4291088659107673', '2023-07-10 12:03:18', NULL),
(35, 'mtn', '1', '0000002385395551949230735847847345000000100BC\r', 'rovingtechsolution@gmail.com', '1079180896573462', '2023-07-10 12:10:52', NULL),
(39, 'mtn', '1', '0000002385395568320401590317052899000000100BC\r', 'gabrielonabulu400@gmail.com', '4170719958320686', '2023-07-10 22:50:41', 'Fatch'),
(40, 'mtn', '1', '0000002385395572957191879147225734000000100BC\r', 'siorlaha@gmail.com', '0617120679953848', '2023-07-10 22:53:33', 'Samik Telecoms'),
(41, 'mtn', '1', '0000002385395573592008018283938039000000100BC\r', 'chukwujike55@gmail.com', '7580148697931206', '2023-07-11 12:48:20', NULL),
(42, 'mtn', '1', '0000002385395574098236013190580756000000100BC\r', 'chukwujike55@gmail.com', '7758396061412089', '2023-07-11 13:29:29', NULL),
(43, 'mtn', '1', '0000002385395575944261386801263993000000100BC\r', 'chukwujike55@gmail.com', '2947716189005386', '2023-07-11 16:00:39', NULL),
(44, 'mtn', '1', '0000002385395580409443075552279311000000100BC\r', 'chukwujike55@gmail.com', '3062781945176089', '2023-07-11 16:09:45', NULL),
(45, 'mtn', '1', '0000002385395582932082810672701416000000100BC\r', 'chukwujike55@gmail.com', '8814900937172656', '2023-07-11 17:17:35', NULL),
(46, 'mtn', '1', '0000002385395585117622973657423803000000100BC\r', 'chukwujike55@gmail.com', '6038780495721691', '2023-07-11 17:37:30', NULL),
(47, 'mtn', '1', '0000002385395586133886965279557344000000100BC\r', 'chukwujike55@gmail.com', '6209415088637197', '2023-07-11 17:47:06', NULL),
(48, 'mtn', '1', '0000002385395586551909690657761757000000100BC\r', 'chukwujike55@gmail.com', '6672380195971840', '2023-07-11 18:30:37', NULL),
(49, 'mtn', '1', '0000002385395589707677327672155763000000100BC\r', 'chukwujike55@gmail.com', '0269870184539671', '2023-07-11 23:16:16', NULL),
(50, 'mtn', '1', '0000002385395590097524391283404280000000100BC\r', 'siorlaha@gmail.com', '2376880456197910', '2023-07-12 05:38:19', 'Samik Telecoms'),
(51, 'mtn', '1', '0000002385395591122055685847036329000000100BC\r', 'gabrielonabulu400@gmail.com', '5907176263889410', '2023-07-12 19:34:36', NULL),
(52, 'mtn', '1', '0000002385395592219206552041030535000000100BC\r', 'gabrieloc400@gmail.com', '1327910497506886', '2023-07-13 02:46:11', NULL),
(53, 'mtn', '1', '0000002385395593433887814934545311000000100BC\r', 'gabrieloc400@gmail.com', '7995083110626478', '2023-07-13 02:47:01', NULL),
(54, 'mtn', '1', '0000002385395596832081601123431048000000100BC\r\n0000002385395598555596871306365413000000100BC\r\n0000002385395599249236498403451686000000100BC\r\n0000002385395599764980341152052611000000100BC\n0000002384588862859947682425108313000000100BC', 'favourchuk994@gmail.com', '7283599810604761', '2023-07-13 06:06:22', 'FACHUZY'),
(55, 'mtn', '1', '0000002424977327190325203187626951000000100BC\r', 'siorlaha@gmail.com', '7925468311897006', '2023-07-19 07:55:33', NULL),
(56, 'mtn', '1', '0000002424977329039569834676788233000000100BC\r', 'chukwujike55@gmail.com', '2361009547988176', '2023-07-19 07:56:56', 'fachuzy telecome service'),
(57, 'mtn', '1', '0000002424977331025379230143785642000000100BC\r', 'siorlaha@gmail.com', '3096211878670495', '2023-07-19 08:54:48', NULL),
(58, 'airtel', '1', '5705264264248911,2.0607299427581E+19,0000100,00000,19/07/2026\r', 'siorlaha@gmail.com', '7100593168486792', '2023-07-19 08:57:15', NULL),
(59, 'glo', '1', 'DITCOS2.scratch1.create,end_date=22/03/2026,pin=\"19804\",scnum=\"3506703639\",senum=\"3599983405505683\",SCRPREF=\"100\",SUSP_F=\"0\";\r\n\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"26799\",scnum=\"3777630623\",senum=\"3799983319714046\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"72726\",scnum=\"3751820736\",senum=\"3799983319714047\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"38130\",scnum=\"3713963354\",senum=\"3799983319714048\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"24015\",scnum=\"3751177488\",senum=\"3799983319714049\",SCRPREF=\"100\",SUSP_F=\"0\";\r', 'siorlaha@gmail.com', '5739409608126871', '2023-07-19 09:17:24', NULL),
(60, 'mtn', '1', '0000002425880718257103659639035645000000100BC\r\n0000002425880719066877525151046841000000100BC\r\n0000002425880719216702617936437726000000100BC\r\n0000002425880720803051462796043225000000100BC\r\n0000002425880721510869436539162404000000100BC\r', 'chukwujike55@gmail.com', '0157481369692807', '2023-07-21 05:39:34', NULL),
(61, 'mtn', '1', '0000002425880722192386598245980167000000100BC\r', 'adachitech170@gmail.com', '9641577861008239', '2023-07-21 07:50:27', 'Adachi'),
(62, 'airtel', '1', '5603845282707972,2.0607299427581E+19,0000100,00000,19/07/2026\r', 'adachitech170@gmail.com', '8467176931892050', '2023-07-21 08:49:08', 'Adachi'),
(63, 'mtn', '1', '0000002425880724203919767995150938000000100BC\r', 'adachitech170@gmail.com', '4809311607856927', '2023-07-21 10:08:09', NULL),
(64, 'glo', '1', 'DITCOS2.scratch1.create,end_date=22/03/2026,pin=\"19804\",scnum=\"3506703639\",senum=\"3599983405505683\",SCRPREF=\"100\",SUSP_F=\"0\";\r\n', 'adachitech170@gmail.com', '1584617392706890', '2023-07-21 10:23:39', NULL),
(65, 'airtel', '1', '5186967275797169,2.0607299427581E+19,0000100,00000,19/07/2026\r', 'adachitech170@gmail.com', '5083012977498166', '2023-07-21 12:43:15', NULL),
(66, 'glo', '1', 'DITCOS2.scratch1.create,end_date=22/03/2026,pin=\"19804\",scnum=\"3506703639\",senum=\"3599983405505683\",SCRPREF=\"100\",SUSP_F=\"0\";\r\n', 'adachitech170@gmail.com', '4568090737186291', '2023-07-21 12:46:49', 'Adachi'),
(67, 'mtn', '1', '0000002425880727613048439554674335000000100BC\r', 'adachitech170@gmail.com', '7143062957196880', '2023-07-21 16:13:24', NULL),
(68, 'glo', '1', 'DITCOS2.scratch1.create,end_date=22/03/2026,pin=\"19804\",scnum=\"3506703639\",senum=\"3599983405505683\",SCRPREF=\"100\",SUSP_F=\"0\";\r\n\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"21425\",scnum=\"3760202074\",senum=\"3799983319714050\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"13520\",scnum=\"3757775313\",senum=\"3799983319714051\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"70217\",scnum=\"3775066503\",senum=\"3799983319714052\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"56286\",scnum=\"3757997664\",senum=\"3799983319714053\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"47906\",scnum=\"3744755375\",senum=\"3799983319714054\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"04111\",scnum=\"3720428003\",senum=\"3799983319714055\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"92981\",scnum=\"3708312122\",senum=\"3799983319714056\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"82257\",scnum=\"3766551173\",senum=\"3799983319714057\",SCRPREF=\"100\",SUSP_F=\"0\";\r\nDITCOS2.scratch1.create,end_date=19/07/2026,pin=\"75350\",scnum=\"3785554266\",senum=\"3799983319714058\",SCRPREF=\"100\",SUSP_F=\"0\";\r', 'siorlaha@gmail.com', '3216750884679910', '2023-07-23 07:22:56', NULL),
(69, 'airtel', '1', '1098039831250679,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1377167564289207,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1062525518124414,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1982907606845128,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1559993134054726,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1014970471964419,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1196343182005414,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1508438188221518,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1269673611183679,2.0607738877396E+19,0000100,00000,20/07/2026\r\n1284038411056747,2.0607738877396E+19,0000100,00000,20/07/2026\r', 'siorlaha@gmail.com', '1091436256778890', '2023-07-23 18:34:19', NULL),
(70, 'mtn', '1', '0000002425880740509811071151969701000000100BC\r\n0000002425880740881242451627196706000000100BC\r\n0000002425880741419879373666915110000000100BC\r\n0000002425880742516862961442421676000000100BC\r\n0000002425880746114301846683301281000000100BC\r', 'chukwujike55@gmail.com', '2319784085610976', '2023-07-24 06:16:13', NULL),
(71, 'mtn', '1', '0000002425880747690621953521446726000000100BC\r', 'chukwujike55@gmail.com', '8711964852396700', '2023-07-24 10:12:58', NULL),
(72, 'mtn', '1', '0000002425880751071388914186824270000000100BC\r\n0000002425880752724729445091109801000000100BC\r\n0000002425880756044586578499248625000000100BC', 'chukwujike55@gmail.com', '6195924010367788', '2023-07-24 10:27:57', NULL),
(73, 'mtn', '1', '0000002418377913346542325625627251000000100BC\r', 'gabrielonabulu400@gmail.com', '3168771069250948', '2023-07-25 01:20:39', NULL),
(74, 'glo', '1', 'DITCOS2.scratch1.create,end_date=22/03/2026,pin=\"19804\",scnum=\"3506703639\",senum=\"3599983405505683\",SCRPREF=\"100\",SUSP_F=\"0\";\r\n', 'adachitech170@gmail.com', '4671301978582906', '2023-07-25 08:50:11', NULL),
(75, 'mtn', '1', '0000002418377915392976894431930425000000100BC\r', 'gabrieloc400@gmail.com', '1287909647051863', '2023-07-25 09:03:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `newsalert`
--

CREATE TABLE `newsalert` (
  `serial` int(11) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `btn` varchar(50) NOT NULL,
  `link` varchar(250) NOT NULL,
  `heading` varchar(100) NOT NULL,
  `img_link` varchar(150) DEFAULT NULL,
  `img_stat` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `newsalert`
--

INSERT INTO `newsalert` (`serial`, `content`, `btn`, `link`, `heading`, `img_link`, `img_stat`) VALUES
(1, ' You can now generate and print recharge card without installing any software. ', ' Generate & Print Card ', '    airtime-pins.php   ', ' Direct Recharge Card Printing ', NULL, 'show');

-- --------------------------------------------------------

--
-- Table structure for table `payalert`
--

CREATE TABLE `payalert` (
  `serial` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `teller` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `del` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `serial` int(11) NOT NULL,
  `paystackSecret` varchar(255) DEFAULT NULL,
  `paystackpub` varchar(255) DEFAULT NULL,
  `flutterpub` varchar(255) DEFAULT NULL,
  `flutterSecret` varchar(255) DEFAULT NULL,
  `bitpub` varchar(500) DEFAULT NULL,
  `bitsec` varchar(500) DEFAULT NULL,
  `activepay` varchar(255) NOT NULL,
  `mfnkey` varchar(512) DEFAULT NULL,
  `mfnsec` varchar(512) DEFAULT NULL,
  `mfnco` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`serial`, `paystackSecret`, `paystackpub`, `flutterpub`, `flutterSecret`, `bitpub`, `bitsec`, `activepay`, `mfnkey`, `mfnsec`, `mfnco`) VALUES
(36, '', '', '', '', '', '', 'flutterwave', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pinstock`
--

CREATE TABLE `pinstock` (
  `serial` int(11) NOT NULL,
  `net` varchar(100) NOT NULL,
  `deno` varchar(50) NOT NULL,
  `pins` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pins_package`
--

CREATE TABLE `pins_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `price_user` float UNSIGNED NOT NULL,
  `price_api` float UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pins_package`
--

INSERT INTO `pins_package` (`serial`, `network`, `plan`, `code`, `price_user`, `price_api`) VALUES
(3, 'mtn', 'N100 PIN', '1', 97.9, 97.9),
(4, 'airtel', 'N100 PIN', '1', 97.9, 97.9),
(5, 'glo', 'N100 PIN', '1', 97.5, 97.5),
(6, 'etisalat', 'N100 PIN', '1', 97.5, 97.5),
(7, 'mtn', 'N200 PIN', '2', 195.8, 195.8),
(8, 'airtel', 'N200 PIN', '2', 195.8, 195.8),
(9, 'glo', 'N200 PIN', '2', 194, 194),
(10, 'etisalat', 'N200 PIN', '2', 195, 195),
(11, 'mtn', 'N400 PIN', '4', 391.6, 391.6),
(12, 'airtel', 'N500 PIN', '5', 489.5, 489.5),
(13, 'glo', 'N500 PIN', '5', 487.5, 487.5),
(14, 'etisalat', 'N500 PIN', '5', 487.5, 487.5),
(15, 'mtn', 'N500 PIN', '5', 489.5, 489.5);

-- --------------------------------------------------------

--
-- Table structure for table `pins_packages`
--

CREATE TABLE `pins_packages` (
  `id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL,
  `network` varchar(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan` varchar(20) NOT NULL,
  `price_user` decimal(10,2) NOT NULL,
  `price_api` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pins_packages`
--

INSERT INTO `pins_packages` (`id`, `network_id`, `network`, `plan_id`, `plan`, `price_user`, `price_api`) VALUES
(1, 1, 'MTN', 1, 'N100', 98.00, 98.00),
(2, 1, 'MTN', 2, 'N200', 196.00, 196.00),
(3, 1, 'MTN', 3, 'N500', 490.00, 490.00),
(4, 3, 'GLO', 4, 'N100', 97.00, 97.00),
(5, 3, 'GLO', 5, 'N200', 194.00, 194.00),
(6, 3, 'GLO', 6, 'N500', 485.00, 485.00),
(7, 2, 'AIRTEL', 7, 'N100', 97.00, 97.00),
(8, 2, 'AIRTEL', 8, 'N200', 194.00, 194.00),
(9, 2, 'AIRTEL', 9, 'N500', 485.00, 485.00);

-- --------------------------------------------------------

--
-- Table structure for table `pin_billing`
--

CREATE TABLE `pin_billing` (
  `serial` int(11) NOT NULL,
  `mtn` varchar(255) DEFAULT NULL,
  `airtel` varchar(255) DEFAULT NULL,
  `glo` varchar(255) DEFAULT NULL,
  `etisalat` varchar(255) DEFAULT NULL,
  `1month` varchar(255) DEFAULT NULL,
  `2month` varchar(255) DEFAULT NULL,
  `3month` varchar(255) DEFAULT NULL,
  `6month` varchar(255) DEFAULT NULL,
  `12month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pin_billing`
--

INSERT INTO `pin_billing` (`serial`, `mtn`, `airtel`, `glo`, `etisalat`, `1month`, `2month`, `3month`, `6month`, `12month`) VALUES
(1, '97', '96.80', '94.5', '96.80', '5000', '10000', '15000', '30000', '60000');

-- --------------------------------------------------------

--
-- Table structure for table `pin_dealers`
--

CREATE TABLE `pin_dealers` (
  `serial` int(11) NOT NULL,
  `userId` varchar(100) NOT NULL,
  `package` varchar(100) NOT NULL,
  `amount` float UNSIGNED NOT NULL,
  `exp` float UNSIGNED NOT NULL,
  `status` varchar(100) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pin_merchants`
--

CREATE TABLE `pin_merchants` (
  `serial` int(11) NOT NULL,
  `merchantid` varchar(150) DEFAULT NULL,
  `package` varchar(100) NOT NULL,
  `amountpaid` varchar(50) DEFAULT NULL,
  `duration` float UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL,
  `plan` varchar(100) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pin_merchants`
--

INSERT INTO `pin_merchants` (`serial`, `merchantid`, `package`, `amountpaid`, `duration`, `status`, `plan`, `created_date`) VALUES
(33, 'ike@gmail.com', 'Premium', '3500', 12, 'ACTIVE', 'Premium', '2024-12-15 06:00:45');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `serial` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `shortdes` varchar(100) NOT NULL,
  `salespage` varchar(200) NOT NULL,
  `download` varchar(200) NOT NULL,
  `code` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `del` varchar(100) NOT NULL,
  `downloadbutton` varchar(100) NOT NULL,
  `detailbutton` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `providers_api_key`
--

CREATE TABLE `providers_api_key` (
  `serial` int(11) NOT NULL,
  `provider` varchar(100) DEFAULT NULL,
  `privatekey` varchar(512) DEFAULT NULL,
  `secretkey` varchar(512) DEFAULT NULL,
  `contractcode` varchar(100) DEFAULT NULL,
  `wallet_no` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `baseurl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `providers_api_key`
--

INSERT INTO `providers_api_key` (`serial`, `provider`, `privatekey`, `secretkey`, `contractcode`, `wallet_no`, `username`, `password`, `baseurl`) VALUES
(49, 'n3tdata', NULL, NULL, NULL, NULL, 'ATEEKU', '41279191', 'https://n3tdata.com/api');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_pin`
--

CREATE TABLE `purchased_pin` (
  `serial` int(11) NOT NULL,
  `network` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `pins` longtext NOT NULL,
  `email` varchar(100) NOT NULL,
  `ref` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regular_billing`
--

CREATE TABLE `regular_billing` (
  `serial` int(11) NOT NULL,
  `airtelvtu` varchar(50) DEFAULT NULL,
  `mtnvtu` varchar(50) DEFAULT NULL,
  `glovtu` varchar(50) DEFAULT NULL,
  `9mobilevtu` varchar(50) DEFAULT NULL,
  `dstv` varchar(50) DEFAULT NULL,
  `gotv` varchar(50) DEFAULT NULL,
  `startimes` varchar(50) DEFAULT NULL,
  `airtelData` varchar(50) DEFAULT NULL,
  `mtnData` varchar(50) DEFAULT NULL,
  `gloData` varchar(50) DEFAULT NULL,
  `9mobileData` varchar(50) DEFAULT NULL,
  `IkejaElectric` varchar(50) DEFAULT NULL,
  `EkoElectric` varchar(50) DEFAULT NULL,
  `Kedc` varchar(50) DEFAULT NULL,
  `Phed` varchar(50) DEFAULT NULL,
  `Ibedc` varchar(50) DEFAULT NULL,
  `JosElectric` varchar(50) DEFAULT NULL,
  `AbujaElectric` varchar(50) DEFAULT NULL,
  `EnuguElectric` varchar(50) DEFAULT NULL,
  `smile` varchar(50) DEFAULT NULL,
  `waec` varchar(50) DEFAULT NULL,
  `reseller` varchar(50) DEFAULT NULL,
  `setup` varchar(50) DEFAULT NULL,
  `sms` varchar(50) DEFAULT NULL,
  `aedc` varchar(50) DEFAULT NULL,
  `affiliate` varchar(50) DEFAULT NULL,
  `conv` varchar(50) DEFAULT NULL,
  `neco` int(11) DEFAULT NULL,
  `jamb` int(11) DEFAULT NULL,
  `jambmock` int(11) DEFAULT NULL,
  `nbais` int(11) DEFAULT NULL,
  `nabteb` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `regular_billing`
--

INSERT INTO `regular_billing` (`serial`, `airtelvtu`, `mtnvtu`, `glovtu`, `9mobilevtu`, `dstv`, `gotv`, `startimes`, `airtelData`, `mtnData`, `gloData`, `9mobileData`, `IkejaElectric`, `EkoElectric`, `Kedc`, `Phed`, `Ibedc`, `JosElectric`, `AbujaElectric`, `EnuguElectric`, `smile`, `waec`, `reseller`, `setup`, `sms`, `aedc`, `affiliate`, `conv`, `neco`, `jamb`, `jambmock`, `nbais`, `nabteb`) VALUES
(1, '1', '1', '1.5', '1.2', '0.5', '0.5', '1', '1', '1', '1.5', '1.2', '0.4', '0.3', '0.3', '0.3', '0.3', '0.3', '0.7', '0.7', '1', '2790', '5000', '30000', '3', '0.4', '10', '50', 900, 5700, 6700, 1100, 1100);

-- --------------------------------------------------------

--
-- Table structure for table `robocall`
--

CREATE TABLE `robocall` (
  `serial` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `fileurl` varchar(255) NOT NULL,
  `fileno` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `charge` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sentsms`
--

CREATE TABLE `sentsms` (
  `serial` int(11) NOT NULL,
  `service` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `msg` varchar(2000) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `charge` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `serial` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `fileurl` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `edit` varchar(255) NOT NULL,
  `del` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serial`, `filename`, `fileurl`, `link`, `name`, `description`, `action`, `date`, `edit`, `del`, `category`) VALUES
(6, '18112019120535EKEDC-1280x720.jpg', ' localhost/ap/admin/uploads/18112019120535EKEDC-1280x720.jpg ', 'electricity.php', 'Eko Electric Payment', 'Generate Eko Electric Prepaid Meter Token Instantly. Pay for Postpaid Meter. ', 'Generate Token', '2023-05-31 12:00:39', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(7, '18112019121439Smile-Payment.jpg', ' localhost/ap/admin/uploads/18112019121439Smile-Payment.jpg ', 'smile.php', 'Smile Internet Payment', 'Top up Smile Internet data and Voice account instantly.', 'Recharge Now', '2022-09-07 03:40:28', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'data'),
(9, '18112019122710Gotv-Payment.jpg', ' localhost/ap/admin/uploads/18112019122710Gotv-Payment.jpg ', 'paytv.php', 'GOTV Payment', 'Renew your GOTV account and get it activated instantly', 'Renew Now', '2023-05-18 10:42:01', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(10, '18112019123054IBEDC-Ibadan-Electricity-Distribution-Company.jpg', ' localhost/ap/admin/uploads/18112019123054IBEDC-Ibadan-Electricity-Distribution-Company.jpg ', 'electricity.php', 'Ibadan Electric Payment', 'Generate IBEDC Electric Prepaid Meter Token Instantly or Pay for Postpaid Meter. ', 'Generate Token', '2023-05-31 12:00:45', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(12, '18112019124118Pay-DSTV-Subscription.jpg', ' localhost/ap/admin/uploads/18112019124118Pay-DSTV-Subscription.jpg ', 'paytv.php', 'DSTV Payment', 'Renew your DSTV account and get it activated instantly ', 'Renew Now', '2023-05-18 10:41:49', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', NULL),
(13, '18112019124358Startimes-Subscription.jpg', ' localhost/ap/admin/uploads/18112019124358Startimes-Subscription.jpg ', 'paytv.php', 'Startimes Payment', 'Renew your Startimes account and get it activated instantly ', 'Renew Now', '2023-05-18 10:42:09', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(14, '18112019125457WAEC-Result-Checker.jpg', ' localhost/ap/admin/uploads/18112019125457WAEC-Result-Checker.jpg ', 'waec.php', 'WAEC Result Checker PIN', 'Generate WAEC result checker PIN instantly', 'Generate  PIN', '2022-09-07 03:40:48', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'others'),
(15, '18112019141721Port-Harcourt-Electric.jpg', ' localhost/ap/admin/uploads/18112019141721Port-Harcourt-Electric.jpg ', 'electricity.php', 'Port Harcourt Electricity Payment', 'Generate Port Harcourt Electric Prepaid Meter Token Instantly or Pay for Postpaid Meter. ', 'Generate Token', '2023-05-31 12:00:51', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(16, '18112019143015Ikeja-Electric-Payment-PHCN.jpg', ' localhost/ap/admin/uploads/18112019143015Ikeja-Electric-Payment-PHCN.jpg ', 'electricity.php', 'Ikeja Electric Payment', 'Generate Ikeja Electric Prepaid Meter Token Instantly or Pay for Postpaid Meter.', 'Generate Token', '2023-05-31 12:00:55', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(17, '18112019143807Jos-Electric-JED.jpg', ' localhost/ap/admin/uploads/18112019143807Jos-Electric-JED.jpg ', 'electricity.php', 'Jos Electric Payment', 'Generate Jos Electric Prepaid Meter Token Instantly or Pay for Postpaid Meter. ', 'Generate Token', '2023-05-31 12:01:01', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(18, '18112019150117EEDC-Enugu-electricity-payment.jpg', ' localhost/ap/admin/uploads/18112019150117EEDC-Enugu-electricity-payment.jpg ', 'electricity.php', 'Enugu Electricity Payment', 'Generate EEDC Electric Prepaid Meter Token Instantly or Pay for Postpaid Meter. ', 'Generate Token', '2023-05-31 12:01:05', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'bill'),
(21, '18112019181703cheap-bulksms-to-dnd-numbers.jpg', ' localhost/ap/admin/uploads/18112019181703cheap-bulksms-to-dnd-numbers.jpg ', 'sendsms.php', 'Send BulkSMS', 'Send bulksms to any GSM Number', 'Send SMS', '2022-09-07 03:41:13', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'others'),
(29, '0303202020411307022020172151buy-data.jpg', ' localhost/ap/admin/uploads/0303202020411307022020172151buy-data.jpg ', 'data.php', 'Buy Internet Data', 'Topup your internet Data Directly', 'Buy Data', '2023-05-17 11:46:22', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'data'),
(31, '06032020012306one-card.jpg', ' localhost/ap/admin/uploads/06032020012306one-card.jpg ', 'onecard.php', 'Universal Airtime', 'Send airtime to any phone even if you do not know the receivers network', 'Recharge Now', '2023-04-01 00:50:17', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'airtime'),
(32, '0712202014292318112019123605MTN-Data.jpg', ' rovahost.com.ng/ap/admin/uploads/0712202014292318112019123605MTN-Data.jpg ', 'airtime.php', 'Airtime Topup', 'Instant Airtime Topup For All Network', 'Recharge', '2023-07-03 21:31:33', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'airtime'),
(33, '2301202310585826052022102728jamb-epins-nigeria.jpg', ' app.247bills.ng/ap/admin/uploads/2301202310585826052022102728jamb-epins-nigeria.jpg ', 'jamb.php', 'JAMB ePINs', 'Buy UTME and MOCK ePINs', 'Buy PIN', '2023-01-23 11:01:21', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'edu'),
(34, '230120231111080408202006015123072020153028NECO-Result-Checker.jpg', ' app.247bills.ng/ap/admin/uploads/230120231111080408202006015123072020153028NECO-Result-Checker.jpg ', 'neco-pin.php', 'NECO PIN', 'Buy NECO ePIN', 'Buy PIN', '2023-01-23 11:11:08', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'edu'),
(36, '23012023111915e-pins-generator.jpg', ' app.247bills.ng/ap/admin/uploads/23012023111915e-pins-generator.jpg ', 'airtime-pins.php', 'ePINs Generator', 'Recharge card Printing', 'Buy PINs', '2023-01-23 11:19:15', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'airtime'),
(37, '230120231139421807202006315210072020100218spectranet.jpg', ' app.247bills.ng/ap/admin/uploads/230120231139421807202006315210072020100218spectranet.jpg ', 'spectranet.php', 'Spectranet PIN', 'Buy spectranet PIN', 'Buy PIN', '2023-01-23 11:39:42', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'data'),
(38, '23012023130412040320211555163010202013304718082020173624bet9ja-pay.jpg', ' app.247bills.ng/ap/admin/uploads/23012023130412040320211555163010202013304718082020173624bet9ja-pay.jpg ', 'betpay.php', 'Sport Betting', 'Fund betting account', 'Proceed', '2023-01-23 13:04:12', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'others'),
(39, '01022023142858nabteb-result.png', ' app.247bills.ng/ap/admin/uploads/01022023142858nabteb-result.png ', 'nabtebpin.php', 'NABTEB PIN', 'Buy NABTEB PIN', 'Buy PIN', '2023-02-01 14:40:49', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'edu'),
(40, '01022023144954nbais-Result-Checker.jpg', ' app.247bills.ng/ap/admin/uploads/01022023144954nbais-Result-Checker.jpg ', 'nbais.php', 'NBAIS PIN', 'Buy NBAIS PIN', 'Buy PIN', '2023-02-01 14:49:54', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'edu'),
(41, '13032023100739datacard-epins-reseller.png', ' app.eloaded.ng/ap/admin/uploads/13032023100739datacard-epins-reseller.png ', 'datacard.php', 'MTN DATA CARD', 'Buy MTN DATA CARD', 'Buy Data Card', '2023-03-13 10:07:39', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'data'),
(42, '11042023113713bank-transfer-epins-nigeria.png', ' app.eloaded.ng/ap/admin/uploads/11042023113713bank-transfer-epins-nigeria.png ', 'transfer.php', 'Bank Transfer', 'Wallet to Bank transfer', 'Transfer', '2023-04-11 11:37:13', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'others'),
(43, '2007202312064607072022051420wallet-transfer.jpg', ' markersapi.com.ng/ap/admin/uploads/2007202312064607072022051420wallet-transfer.jpg ', 'wallet-transfer.php', 'Wallet Transfer', 'Wallet to Wallet Transfer', 'Transfer', '2023-07-20 12:06:46', '<button class=\"btn btn-info\" style=\"cursor:pointer\">Edit</button>', '<button class=\"btn btn-danger\" style=\"cursor:pointer\">Delete</button>', 'others');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `serial` int(11) NOT NULL,
  `sitekey` varchar(255) NOT NULL,
  `secretkey` varchar(255) NOT NULL,
  `sitelogo` varchar(255) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`serial`, `sitekey`, `secretkey`, `sitelogo`, `sitename`, `mobile`, `email`) VALUES
(1, '6LcZM00nAAAAAEzBzcstJWOfxRYe7bOk8LZ4RVsX', '6LcZM00nAAAAAFkstxwCcUg5rblln3owJHmzEXbe', 'xx', 'VTU Portal Creator', '08084121526', 'epinsnigeria@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `sme_data`
--

CREATE TABLE `sme_data` (
  `serial` int(11) NOT NULL,
  `mtnA` varchar(255) NOT NULL,
  `mtnB` varchar(255) NOT NULL,
  `mtnC` varchar(255) NOT NULL,
  `mtnD` varchar(255) NOT NULL,
  `mtnE` varchar(255) NOT NULL,
  `mtnF` varchar(255) NOT NULL,
  `airtelA` varchar(255) NOT NULL,
  `airtelB` varchar(2552) NOT NULL,
  `airtelC` varchar(255) NOT NULL,
  `airtelD` varchar(255) NOT NULL,
  `airtelE` varchar(255) NOT NULL,
  `airtelF` varchar(255) NOT NULL,
  `gloA` varchar(255) NOT NULL,
  `gloB` varchar(255) NOT NULL,
  `gloC` varchar(255) NOT NULL,
  `gloD` varchar(255) NOT NULL,
  `gloE` varchar(255) NOT NULL,
  `gloF` varchar(255) NOT NULL,
  `gloG` varchar(255) NOT NULL,
  `gloH` varchar(255) NOT NULL,
  `gloI` varchar(255) NOT NULL,
  `etisalatA` varchar(255) NOT NULL,
  `etisalatB` varchar(255) NOT NULL,
  `etisalatC` varchar(255) NOT NULL,
  `etisalatD` varchar(255) NOT NULL,
  `etisalatE` varchar(255) NOT NULL,
  `etisalatF` varchar(255) NOT NULL,
  `etisalatG` varchar(255) NOT NULL,
  `etisalatH` varchar(255) NOT NULL,
  `etisalatI` varchar(255) NOT NULL,
  `airtel_1` varchar(50) DEFAULT NULL,
  `airtel_2` varchar(50) DEFAULT NULL,
  `airtel_3` varchar(50) DEFAULT NULL,
  `airtel_4` varchar(50) DEFAULT NULL,
  `airtel_5` varchar(50) DEFAULT NULL,
  `airtel_6` varchar(50) DEFAULT NULL,
  `airtel_7` varchar(50) DEFAULT NULL,
  `airtel_8` varchar(50) DEFAULT NULL,
  `airtel_9` varchar(50) DEFAULT NULL,
  `airtel_10` varchar(50) DEFAULT NULL,
  `mg1` varchar(10) DEFAULT NULL,
  `mg2` varchar(10) DEFAULT NULL,
  `mg3` varchar(10) DEFAULT NULL,
  `mg4` varchar(10) DEFAULT NULL,
  `mg5` varchar(10) DEFAULT NULL,
  `mg6` varchar(10) DEFAULT NULL,
  `mg7` varchar(10) DEFAULT NULL,
  `mg8` varchar(10) DEFAULT NULL,
  `mg9` varchar(10) DEFAULT NULL,
  `mg10` varchar(10) DEFAULT NULL,
  `mtng` int(11) DEFAULT NULL,
  `mtndatacard` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sme_data`
--

INSERT INTO `sme_data` (`serial`, `mtnA`, `mtnB`, `mtnC`, `mtnD`, `mtnE`, `mtnF`, `airtelA`, `airtelB`, `airtelC`, `airtelD`, `airtelE`, `airtelF`, `gloA`, `gloB`, `gloC`, `gloD`, `gloE`, `gloF`, `gloG`, `gloH`, `gloI`, `etisalatA`, `etisalatB`, `etisalatC`, `etisalatD`, `etisalatE`, `etisalatF`, `etisalatG`, `etisalatH`, `etisalatI`, `airtel_1`, `airtel_2`, `airtel_3`, `airtel_4`, `airtel_5`, `airtel_6`, `airtel_7`, `airtel_8`, `airtel_9`, `airtel_10`, `mg1`, `mg2`, `mg3`, `mg4`, `mg5`, `mg6`, `mg7`, `mg8`, `mg9`, `mg10`, `mtng`, `mtndatacard`) VALUES
(1, '245', '270', '1000', '2000', '4000', '8800', '240', '500', '750', '50', '125', '70', '950', '1850', '2350', '2800', '3700', '4700', '7500', '14300', '17200', '480', '960', '1152', '1440', '1950', '3850', '4820', '9800', '14850', '1000', '2000', '3000', '4000', '5000', '6000', '7000', '8000', NULL, NULL, '280', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 270, 280);

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `serial` int(11) NOT NULL,
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtpport` varchar(50) DEFAULT NULL,
  `smtp_user` varchar(250) DEFAULT NULL,
  `smtp_pass` varchar(250) DEFAULT NULL,
  `adminEmail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`serial`, `smtp_host`, `smtpport`, `smtp_user`, `smtp_pass`, `adminEmail`) VALUES
(1, 'mail.site.ng', '587', 'info@site.ng', 'info@site.ng', 'support@site.ng');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `serviceid` varchar(50) DEFAULT NULL,
  `vcode` varchar(100) DEFAULT NULL,
  `meterno` bigint(20) UNSIGNED DEFAULT NULL,
  `channel` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `charge` int(10) UNSIGNED DEFAULT NULL,
  `ref` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(50) NOT NULL,
  `refer` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `customer` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `del` varchar(50) DEFAULT NULL,
  `credit` varchar(50) DEFAULT NULL,
  `metertoken` varchar(50) DEFAULT NULL,
  `servicetype` varchar(50) DEFAULT NULL,
  `newBal` float UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `qty` int(10) UNSIGNED DEFAULT NULL,
  `cardname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`serial`, `network`, `serviceid`, `vcode`, `meterno`, `channel`, `phone`, `amount`, `charge`, `ref`, `status`, `date`, `email`, `refer`, `token`, `customer`, `action`, `del`, `credit`, `metertoken`, `servicetype`, `newBal`, `customer_name`, `qty`, `cardname`) VALUES
(1, 'MTN Airtime', 'mtn', NULL, 0, 'Wallet', '08064507989', 100, 100, '4178731650892096', 'Failed', '2024-06-05 00:06:00', 'rovingtechsolution@gmail.com', '666054d66aec5', '666054ddf1af6', 'avra vfat', NULL, NULL, NULL, NULL, 'mtn', 555, NULL, NULL, NULL),
(2, 'MTN Airtime', 'mtn', NULL, 0, 'Wallet', '08064507989', 100, 99, '9802601177534698', 'Completed', '2024-06-05 02:00:00', 'rovingtechsolution@gmail.com', '66606d381b54f', '66606f91c616b', 'avra vfat', NULL, NULL, NULL, NULL, 'mtn', 456, NULL, NULL, NULL),
(3, 'PHED (prepaid)', 'portharcourt-electric', 'prepaid', 610124000742641, 'Wallet', '610124000742641', 8000, 8000, '7018795196648320', 'Failed', '2024-11-22 05:54:35', 'ike@gmail.com', '67401c9bb914d', '67401d4a78590', 'vic Ike', NULL, NULL, NULL, NULL, NULL, 10000, 'ADEJOKE EPKEYCU', NULL, NULL),
(4, 'PHED (prepaid)', 'portharcourt-electric', 'prepaid', 610124000742641, 'Wallet', '610124000742641', 1000, 1000, '0698871390742651', 'Failed', '2024-11-22 06:11:54', 'ike@gmail.com', '674020aaf353d', '67404e2f085d1', 'vic Ike', NULL, NULL, NULL, NULL, NULL, 10000, 'ADEJOKE EPKEYCU', NULL, NULL),
(5, 'MTN Airtime', 'mtn', NULL, NULL, 'Wallet', '07065606123', 200, 200, '7847091306682591', 'Failed', '2024-11-22 04:14:49', 'ike@gmail.com', '6740a7ead4708', '6740adf95b951', 'vic Ike', NULL, NULL, NULL, NULL, 'mtn', 10000, NULL, NULL, NULL),
(6, 'MTN 1GB (SME) - 30days', '01', '1000', NULL, NULL, '07065606123', 270, NULL, '5178496160328970', 'pending', '2024-11-22 05:11:53', 'ike@gmail.com', '6740bb59b47ac', '6740bb59b47ac', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'AIRTEL 500MB (CG) - 30days', '04', '12', NULL, NULL, '07065606123', 200, NULL, '9407883196105627', 'pending', '2024-11-22 05:12:32', 'ike@gmail.com', '6740bb806e0a5', '6740bb806e0a5', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'GLO 1GB (CG) -  30days', '02', '1000', NULL, NULL, '07065606123', 275, NULL, '9204181773805696', 'pending', '2024-11-22 05:13:34', 'ike@gmail.com', '6740bbbe081f7', '6740bbbe081f7', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '9MOBILE 1.5GB (CG) - 30days', '03', '', NULL, NULL, '07065606123', 300, NULL, '7028469195803176', 'pending', '2024-11-22 05:13:47', 'ike@gmail.com', '6740bbcb742cd', '6740bbcb742cd', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '9MOBILE 1.5GB (CG) - 30days', '03', '', NULL, 'Wallet', '07065606123', 300, 200, '9677906381508412', 'Failed', '2024-11-22 05:17:42', 'ike@gmail.com', '6740bcb69aec2', '674180ee8993a', 'vic Ike', NULL, NULL, NULL, NULL, NULL, 10000, NULL, NULL, NULL),
(11, 'AIRTEL ', '2', NULL, NULL, NULL, '07065606123', 0, NULL, '0801265917689374', 'pending', '2024-11-26 01:02:55', 'ike@gmail.com', '6745c6ff8f480', '6745c6ff8f480', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'MTN 1GB', '1', '1GB', NULL, 'Wallet', '07065606123', 260, 260, '5260486977381190', 'Failed', '2024-11-26 09:52:07', 'ike@gmail.com', '6746430779bdc', '6746d30f49542', 'vic Ike', NULL, NULL, NULL, NULL, NULL, 10000, NULL, NULL, NULL),
(13, 'Upgrade with Portal Setup', NULL, NULL, NULL, NULL, '07065606123', 60000, NULL, '7782061359806419', 'pending', '2024-12-03 13:58:27', 'ike@gmail.com', '674f0e830d8c8', '674f0e830d8c8', 'vic Ike', NULL, 'Delete', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'GOtv Jinja', 'gotv', 'GOtv_Jinja', NULL, 'Wallet', '2009387707', 3284, 3300, '1604152783680997', 'Failed', '2024-12-04 04:39:50', 'ike@gmail.com', '675085d6ac96e', '67508ef45ae71', 'vic Ike', NULL, NULL, NULL, NULL, NULL, 10000, NULL, NULL, NULL),
(15, 'MTN N100(5)', 'mtn', NULL, NULL, 'Wallet', '07065606123', 490, 490, '4721606980751893', 'pending', '2024-12-15 06:14:36', 'ike@gmail.com', '675e73ccaad0c', '675e73ccaad0c', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(16, 'AIRTEL N200(5)', 'airtel', NULL, NULL, 'Wallet', '07065606123', 970, 970, '6927450613189078', 'pending', '2024-12-23 00:21:22', 'ike@gmail.com', '676955c27c421', '676955c27c421', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(17, 'AIRTEL N200(5)', 'airtel', NULL, NULL, 'Wallet', '07065606123', 970, 970, '7185102367468099', 'pending', '2024-12-23 00:23:43', 'ike@gmail.com', '6769564f6153a', '6769564f6153a', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(18, 'MTN N100(9)', 'mtn', NULL, NULL, 'Wallet', '07065606123', 882, 882, '4112680036977958', 'pending', '2024-12-23 00:24:20', 'ike@gmail.com', '676956742fbfb', '676956742fbfb', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL),
(19, 'MTN N100(9)', 'mtn', NULL, NULL, 'Wallet', '07065606123', 882, 882, '6905430188721796', 'pending', '2024-12-23 00:24:30', 'ike@gmail.com', '6769567ed113c', '6769567ed113c', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL),
(20, 'MTN N100(9)', 'mtn', NULL, NULL, 'Wallet', '07065606123', 882, 882, '5201877640919638', 'pending', '2024-12-23 00:41:43', 'ike@gmail.com', '67695a879524b', '67695a879524b', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL),
(21, 'MTN N200(5)', 'mtn', NULL, NULL, 'Wallet', '07065606123', 980, 980, '1613287907856094', 'pending', '2024-12-23 00:42:12', 'ike@gmail.com', '67695aa42043a', '67695aa42043a', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(22, 'MTN N200(5)', 'mtn', NULL, NULL, 'Wallet', '07065606123', 980, 980, '5889964260711073', 'pending', '2024-12-23 00:48:48', 'ike@gmail.com', '67695c30569f7', '67695c30569f7', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(23, 'AIRTEL N100(5)', 'airtel', '7', NULL, 'Wallet', '07065606123', 485, 485, '9475362781081096', 'pending', '2024-12-23 01:01:00', 'ike@gmail.com', '67695f0c1bb2c', '67695f0c1bb2c', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(24, 'MTN N100(5)', 'mtn', '1', NULL, 'Wallet', '07065606123', 490, 490, '3078691274560819', 'pending', '2024-12-23 02:16:15', 'ike@gmail.com', '676970af19053', '676970af19053', 'vic Ike', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL),
(25, 'MTN Airtime', 'mtn', NULL, NULL, 'Wallet', '07065606123', 300, 300, '1160797089863254', 'Failed', '2024-12-23 02:17:43', 'ike@gmail.com', '676970f208c7a', '6769710763a8f', 'vic Ike', NULL, NULL, NULL, NULL, 'mtn', 6500, NULL, NULL, NULL),
(26, '9MOBILE Airtime', 'etisalat', NULL, NULL, 'Wallet', '07065606123', 100, NULL, '0382159678019647', 'pending', '2024-12-23 02:18:46', 'ike@gmail.com', '67697146c9f12', '67697146c9f12', 'vic Ike', NULL, NULL, NULL, NULL, 'etisalat', 6400, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_response`
--

CREATE TABLE `transfer_response` (
  `serial` int(11) NOT NULL,
  `gateway` varchar(20) NOT NULL,
  `responseMessage` text NOT NULL,
  `responseCode` text NOT NULL,
  `amount` float NOT NULL,
  `fee` float NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tv_package`
--

CREATE TABLE `tv_package` (
  `serial` int(11) NOT NULL,
  `network` varchar(50) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `plancode` varchar(50) NOT NULL,
  `clientcode` varchar(50) DEFAULT NULL,
  `amount` float UNSIGNED NOT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tv_package`
--

INSERT INTO `tv_package` (`serial`, `network`, `plan`, `plancode`, `clientcode`, `amount`, `gateway`, `status`) VALUES
(1, 'gotv', 'Smallie Monthly - 1,200', 'GOLITE', 'GOLITE', 1200, 'n3t', 'enabled'),
(4, 'startimes', 'Basic - 2,050 Naira', 'basic', 'basic', 2, 'epins', 'enabled'),
(5, 'startimes', 'Smart - 2,750 Naira', 'smart', 'smart', 2750, 'epins', 'enabled'),
(7, 'dstv', 'DStv Confam N5400', 'NNJ2E36', 'NNJ2E36', 5400, 'epins', 'enabled'),
(8, 'dstv', 'DStv Yanga  N3600', 'NNJ1E36', 'NNJ1E36', 3600, 'epins', 'enabled'),
(11, 'startimes', 'Nova Daily', 'DTT_Nova - Daily', 'DTT_Nova - Daily', 150, 'epins', 'enabled'),
(12, 'startimes', 'Nova Weekly', 'DTT_Nova', 'DTT_Nova', 600, 'epins', 'enabled'),
(13, 'startimes', 'Nova Monthly', 'DTT_Nova', 'DTT_Nova', 1300, 'epins', 'enabled'),
(14, 'startimes', 'Basic Daily', 'DTT_Basic', 'DTT_Basic', 250, 'epins', 'enabled'),
(15, 'startimes', 'Basic Weekly', 'DTT_Basic', 'DTT_Basic', 900, 'epins', 'enabled'),
(16, 'startimes', 'Basic Montly', 'DTT_Basic', 'DTT_Basic', 2300, 'epins', 'enabled'),
(17, 'startimes', 'Classic Daily', 'DTT_Classic', 'DTT_Classic', 340, 'epins', 'enabled'),
(18, 'startimes', 'Classic Weekly', 'DTT_Classic', 'DTT_Classic', 1350, 'epins', 'enabled'),
(19, 'startimes', 'Classic Monthly', 'DTT_Classic', 'DTT_Classic', 3200, 'epins', 'enabled'),
(20, 'startimes', 'Smart - Daily', 'DTH_Smart', 'DTH_Smart', 300, 'epins', 'enabled'),
(21, 'startimes', 'Smart - Weekly', 'DTH_Smart', 'DTH_Smart', 1000, 'epins', 'enabled'),
(22, 'startimes', 'Smart - Monthly', 'DTH_Smart', 'DTH_Smart', 3000, 'epins', 'enabled'),
(23, 'startimes', 'Special Daily', 'DTH_Special', 'DTH_Special', 500, 'epins', 'enabled'),
(24, 'startimes', 'Special Weekly', 'DTH_Special', 'DTH_Special', 1400, 'epins', 'enabled'),
(25, 'startimes', 'Special Monthly', 'DTH_Special', 'DTH_Special', 3950, 'epins', 'enabled'),
(26, 'startimes', 'Super Daily', 'DTH_Super', 'DTH_Super', 600, 'epins', 'enabled'),
(27, 'startimes', 'Super Weekly', 'DTH_Super', 'DTH_Super', 1950, 'epins', 'enabled'),
(28, 'startimes', 'Super Monthly', 'DTH_Super', 'DTH_Super', 5400, 'epins', 'enabled'),
(30, 'dstv', 'DStv Compact N10,600', 'COMPE36', 'COMPE36', 10600, 'epins', 'enabled'),
(31, 'dstv', 'DStv Padi N2,300', 'NLTESE36', 'NLTESE36', 2300, 'epins', 'enabled'),
(33, 'dstv', 'DStv Compact Plus N16,800', 'COMPLE36', 'COMPLE36', 16800, 'epins', 'enabled'),
(35, 'dstv', 'DStv Premium N24,700', 'PRWE36', 'PRWE36', 24700, 'epins', 'enabled'),
(36, 'dstv', 'DStv Premium Asia N27,800', 'PRWASIE36', 'PRWASIE36', 27800, 'epins', 'enabled'),
(37, 'dstv', 'DStv Premium French N36,900', 'PRWFRNSE36', 'PRWFRNSE36', 36900, 'epins', 'enabled'),
(38, 'dstv', 'Asian Bouqet N8,400', 'ASIAE36', 'ASIAE36', 8400, 'epins', 'enabled'),
(41, 'gotv', 'GOtv Smallie - yearly - N8,650', 'GOLITE', 'GOLITE', 8650, 'epins', 'enabled'),
(42, 'gotv', 'GOtv Supa - monthly - N6,450', 'GOTVSUPA', 'GOTVSUPA', 6450, 'epins', 'enabled'),
(43, 'gotv', 'GOtv Max - monthly - N4,900', 'GOTVMAX', 'GOTVMAX', 4900, 'epins', 'enabled'),
(44, 'gotv', 'GOtv Jolli - monthly - N3,400', 'GOTVNJ2', 'GOTVNJ2', 3400, 'epins', 'enabled'),
(45, 'gotv', 'GOtv Jinja - monthly - N2,350', 'GOTVNJ1', 'GOTVNJ1', 2350, 'epins', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tv_packages`
--

CREATE TABLE `tv_packages` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `cable_id` int(11) NOT NULL,
  `cable` varchar(30) NOT NULL,
  `plan_name` varchar(30) NOT NULL,
  `plan_code` varchar(30) NOT NULL,
  `amount` float NOT NULL,
  `gateway` varchar(20) NOT NULL DEFAULT 'n3t',
  `status` varchar(20) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tv_packages`
--

INSERT INTO `tv_packages` (`id`, `plan_id`, `cable_id`, `cable`, `plan_name`, `plan_code`, `amount`, `gateway`, `status`) VALUES
(1, 1, 2, 'DSTV', 'DStv Padi', 'DStv_Padi', 3600, 'n3t', 'enabled'),
(2, 2, 2, 'DSTV', 'DSTV -YANGA', 'DSTV_YANGA', 5100, 'n3t', 'enabled'),
(3, 9, 2, 'DSTV', 'DStv Premium-Asia', 'DStv_Premium_Asia', 33000, 'n3t', 'enabled'),
(4, 10, 2, 'DSTV', 'DStv Confam + ExtraView', 'DStv_Confam_ExtraView', 11500, 'n3t', 'enabled'),
(5, 34, 2, 'DSTV', 'Dstv Confam', 'Dstv_Confam', 9300, 'n3t', 'enabled'),
(6, 35, 2, 'DSTV', 'DStv Compact', 'DStv_Compact', 15700, 'n3t', 'enabled'),
(7, 36, 2, 'DSTV', 'DStv Premium', 'DStv_Premium', 37000, 'n3t', 'enabled'),
(8, 37, 2, 'DSTV', 'DStv Asia', 'DStv_Asia', 10000, 'n3t', 'enabled'),
(9, 38, 2, 'DSTV', 'DStv Compact Plus', 'DStv_Compact_Plus', 25000, 'n3t', 'enabled'),
(10, 43, 2, 'DSTV', 'DStv Padi + ExtraView', 'DStv_Padi_ExtraView', 5400, 'n3t', 'enabled'),
(11, 59, 1, 'GOTV', 'GOtv Max', 'GOtv_Max', 7200, 'n3t', 'enabled'),
(12, 60, 1, 'GOTV', 'GOtv Jolli', 'GOtv_Jolli', 4850, 'n3t', 'enabled'),
(13, 61, 1, 'GOTV', 'GOtv Jinja', 'GOtv_Jinja', 3300, 'n3t', 'enabled'),
(14, 62, 1, 'GOTV', 'GOtv Smallie - monthly', 'GOtv_Smallie_monthly', 1575, 'n3t', 'enabled'),
(15, 65, 1, 'GOTV', 'GOtv Supa - monthly', 'GOtv_Supa_monthly', 9600, 'n3t', 'enabled'),
(16, 66, 3, 'STARTIMES', 'Nova - 1 Month', 'Nova_1Month', 1700, 'n3t', 'enabled'),
(17, 67, 3, 'STARTIMES', 'Basic (Antenna) - 1 Month', 'Basic_Antenna_1Month', 3000, 'n3t', 'enabled'),
(18, 68, 3, 'STARTIMES', 'Smart (Dish) -1 Month', 'Smart_Dish_1Month', 3500, 'n3t', 'enabled'),
(19, 69, 3, 'STARTIMES', 'Classic (Antenna) - 1 Month', 'Classic_Antenna_1Month', 4500, 'n3t', 'enabled'),
(20, 70, 3, 'STARTIMES', 'Super (Dish) - 1 Month', 'Super_Dish_1Month', 7500, 'n3t', 'enabled'),
(21, 71, 3, 'STARTIMES', 'Nova - 1 Week', 'Nova_1Week', 500, 'n3t', 'enabled'),
(22, 72, 3, 'STARTIMES', 'Basic (Antenna) - 1 Week', 'Basic_Antenna_1Week', 900, 'n3t', 'enabled'),
(23, 73, 3, 'STARTIMES', 'Smart (Dish) - 1 Week', 'Smart_Dish_1Week', 1100, 'n3t', 'enabled'),
(24, 74, 3, 'STARTIMES', 'Classic (Antenna) - 1 Week', 'Classic_Antenna_1Week', 1500, 'n3t', 'enabled'),
(25, 75, 3, 'STARTIMES', 'Super (Dish) - 1 Week', 'Super_Dish_1Week', 2200, 'n3t', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `acc` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `firstname` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `joining_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `level` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `IPaddress` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `block` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `blockpro` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `unblock` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `activate` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `blockinfo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `blockstat` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `del` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bal` decimal(22,2) NOT NULL DEFAULT 0.00,
  `pincredit` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `currency` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `acctype` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `accno` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `refid` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `refcount` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `refby` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `refbyid` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `refwallet` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `reflink` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `refunverified` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `refverified` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `apikey` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `credit` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `accountName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `accountNumber` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bankName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pins` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `xct` int(11) DEFAULT NULL,
  `cwallet` decimal(22,2) NOT NULL DEFAULT 0.00,
  `wema` varchar(50) DEFAULT NULL,
  `moniepoint` varchar(50) DEFAULT NULL,
  `sterling` varchar(50) DEFAULT NULL,
  `reserve` int(11) DEFAULT NULL,
  `tcode` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=armscii8 COLLATE=armscii8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `acc`, `firstname`, `lastname`, `email`, `pass`, `phone`, `joining_date`, `level`, `IPaddress`, `block`, `blockpro`, `unblock`, `activate`, `blockinfo`, `blockstat`, `del`, `bal`, `pincredit`, `currency`, `acctype`, `country`, `accno`, `refid`, `refcount`, `refby`, `refbyid`, `refwallet`, `reflink`, `refunverified`, `refverified`, `apikey`, `credit`, `accountName`, `accountNumber`, `bankName`, `pins`, `xct`, `cwallet`, `wema`, `moniepoint`, `sterling`, `reserve`, `tcode`) VALUES
(61, NULL, 'vic', 'Ike', 'ike@gmail.com', '$2y$10$tJj6jINPqFGJOJ41xpj0heVBiS2pAczIBM.d4v.Iz/k23SfqTNEfm', '07065606123', '2024-11-18 20:40:25', 'free', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6500.00, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `serial` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `del` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xpress`
--

CREATE TABLE `xpress` (
  `serial` int(11) NOT NULL,
  `network` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `orderno` varchar(100) NOT NULL,
  `serviceid` varchar(100) NOT NULL,
  `meter` varchar(100) NOT NULL,
  `meter_type` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_bank`
--
ALTER TABLE `add_bank`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `airtime_package`
--
ALTER TABLE `airtime_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `auto_funding`
--
ALTER TABLE `auto_funding`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `bankinfo`
--
ALTER TABLE `bankinfo`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `bank_gateway`
--
ALTER TABLE `bank_gateway`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `bank_gateway_settings`
--
ALTER TABLE `bank_gateway_settings`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `betting_package`
--
ALTER TABLE `betting_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `buypin`
--
ALTER TABLE `buypin`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `contactx`
--
ALTER TABLE `contactx`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `data_package`
--
ALTER TABLE `data_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `data_packages`
--
ALTER TABLE `data_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `earnlog`
--
ALTER TABLE `earnlog`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `electric_package`
--
ALTER TABLE `electric_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `epins_dataplan`
--
ALTER TABLE `epins_dataplan`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `epin_package`
--
ALTER TABLE `epin_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `exam_package`
--
ALTER TABLE `exam_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `gifting-data`
--
ALTER TABLE `gifting-data`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `kyc_info`
--
ALTER TABLE `kyc_info`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `message_history`
--
ALTER TABLE `message_history`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `monnify_api`
--
ALTER TABLE `monnify_api`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `mypin`
--
ALTER TABLE `mypin`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `newsalert`
--
ALTER TABLE `newsalert`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `payalert`
--
ALTER TABLE `payalert`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `pinstock`
--
ALTER TABLE `pinstock`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `pins_package`
--
ALTER TABLE `pins_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `pins_packages`
--
ALTER TABLE `pins_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pin_billing`
--
ALTER TABLE `pin_billing`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `pin_dealers`
--
ALTER TABLE `pin_dealers`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `pin_merchants`
--
ALTER TABLE `pin_merchants`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `providers_api_key`
--
ALTER TABLE `providers_api_key`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `purchased_pin`
--
ALTER TABLE `purchased_pin`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `regular_billing`
--
ALTER TABLE `regular_billing`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `robocall`
--
ALTER TABLE `robocall`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `sentsms`
--
ALTER TABLE `sentsms`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `sme_data`
--
ALTER TABLE `sme_data`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `transfer_response`
--
ALTER TABLE `transfer_response`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `tv_package`
--
ALTER TABLE `tv_package`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `tv_packages`
--
ALTER TABLE `tv_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `xpress`
--
ALTER TABLE `xpress`
  ADD PRIMARY KEY (`serial`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_bank`
--
ALTER TABLE `add_bank`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `serial` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `airtime_package`
--
ALTER TABLE `airtime_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `auto_funding`
--
ALTER TABLE `auto_funding`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `bankinfo`
--
ALTER TABLE `bankinfo`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bank_gateway`
--
ALTER TABLE `bank_gateway`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bank_gateway_settings`
--
ALTER TABLE `bank_gateway_settings`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `betting_package`
--
ALTER TABLE `betting_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buypin`
--
ALTER TABLE `buypin`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactx`
--
ALTER TABLE `contactx`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_package`
--
ALTER TABLE `data_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=477;

--
-- AUTO_INCREMENT for table `data_packages`
--
ALTER TABLE `data_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `earnlog`
--
ALTER TABLE `earnlog`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electric_package`
--
ALTER TABLE `electric_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `epins_dataplan`
--
ALTER TABLE `epins_dataplan`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `epin_package`
--
ALTER TABLE `epin_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_package`
--
ALTER TABLE `exam_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gifting-data`
--
ALTER TABLE `gifting-data`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4796;

--
-- AUTO_INCREMENT for table `kyc_info`
--
ALTER TABLE `kyc_info`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_history`
--
ALTER TABLE `message_history`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `monnify_api`
--
ALTER TABLE `monnify_api`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mypin`
--
ALTER TABLE `mypin`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `newsalert`
--
ALTER TABLE `newsalert`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payalert`
--
ALTER TABLE `payalert`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pinstock`
--
ALTER TABLE `pinstock`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pins_package`
--
ALTER TABLE `pins_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pins_packages`
--
ALTER TABLE `pins_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pin_billing`
--
ALTER TABLE `pin_billing`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pin_dealers`
--
ALTER TABLE `pin_dealers`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pin_merchants`
--
ALTER TABLE `pin_merchants`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `providers_api_key`
--
ALTER TABLE `providers_api_key`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `purchased_pin`
--
ALTER TABLE `purchased_pin`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regular_billing`
--
ALTER TABLE `regular_billing`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `robocall`
--
ALTER TABLE `robocall`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `sentsms`
--
ALTER TABLE `sentsms`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sme_data`
--
ALTER TABLE `sme_data`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `transfer_response`
--
ALTER TABLE `transfer_response`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tv_package`
--
ALTER TABLE `tv_package`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tv_packages`
--
ALTER TABLE `tv_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `xpress`
--
ALTER TABLE `xpress`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
