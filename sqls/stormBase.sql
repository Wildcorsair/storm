-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2014 at 11:54 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stormBase`
--

-- --------------------------------------------------------

--
-- Table structure for table `stm_boards`
--

CREATE TABLE IF NOT EXISTS `stm_boards` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fboardType` varchar(45) CHARACTER SET ucs2 NOT NULL,
  `fboardName` varchar(45) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица описания плат DSLAM' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stm_boards`
--

INSERT INTO `stm_boards` (`fid`, `fboardType`, `fboardName`) VALUES
(1, '1753 (64)', 'IskraTel 1753'),
(2, 'ECI-8 (1)', 'ECI-8 (плата № 1)'),
(3, 'ECI-8 (2)', 'ECI-8 (плата № 2)'),
(4, 'ECI-8 (3)', 'ECI-8 (плата № 3)');

-- --------------------------------------------------------

--
-- Table structure for table `stm_tasks`
--

CREATE TABLE IF NOT EXISTS `stm_tasks` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fphoneNumber` varchar(5) NOT NULL,
  `fboardId` mediumint(9) NOT NULL,
  `fport` tinyint(4) NOT NULL,
  `fdamageReason` text NOT NULL,
  `frepairNote` text,
  `fstartDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fendDateTime` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fid`),
  KEY `fphoneNumber` (`fphoneNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица нарядов на обработку обращений клиентов' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `stm_tasks`
--

INSERT INTO `stm_tasks` (`fid`, `fphoneNumber`, `fboardId`, `fport`, `fdamageReason`, `frepairNote`, `fstartDateTime`, `fendDateTime`) VALUES
(1, '61554', 1, 16, 'Blah blah blah...', 'Bleh bleh bleh...', '2014-10-13 17:02:45', '0000-00-00 00:00:00'),
(2, '61510', 1, 10, 'Мигает индикатор DSL', NULL, '2014-10-14 00:00:00', '0000-00-00 00:00:00'),
(3, '61381', 3, 12, 'Модем перегружается', NULL, '2014-10-14 00:00:00', '0000-00-00 00:00:00'),
(4, '61550', 4, 5, 'Частые обрывы модема', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(5, '61280', 3, 34, 'Модем самопроизвольно перегружается', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '61318', 3, 10, 'Не соединяется модем', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(7, '61945', 4, 5, 'Не горит индикатор "Internet"', NULL, '2014-10-14 00:00:00', '0000-00-00 00:00:00'),
(8, '61818', 2, 16, 'Модем не реагирует на включение', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(9, '61118', 1, 44, 'Не грузятся странички', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(10, '', 0, 0, '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, '61824', 2, 33, 'Не горит индикатор "DSL"', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(12, '61515', 1, 0, 'kjh  gjh gjhgjh', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(13, '61212', 4, 0, 'kjhkjhkjhkjhkj', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(14, '61213', 2, 57, 'hgf h jhgf hgf fyg tr4q  trt  45  ydy', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(15, '63311', 4, 8, 'jhgjhg g gjhg', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(16, '63111', 4, 5, 'cfcgfgf f gf gfg', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00'),
(17, '63310', 3, 9, 'gghgf gfh gfh gfh gfh fghgfh', NULL, '2014-10-15 00:00:00', '0000-00-00 00:00:00');
