-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2018 at 07:21 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eei_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log_t`
--

CREATE TABLE `activity_log_t` (
  `activity_log_id` int(5) NOT NULL,
  `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `activity_log_details` varchar(250) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logger` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attachment_t`
--

CREATE TABLE `attachment_t` (
  `file_id` int(11) NOT NULL,
  `file` varchar(250) DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq_article_t`
--

CREATE TABLE `faq_article_t` (
  `article_id` int(3) NOT NULL,
  `subcategory_id` int(3) NOT NULL,
  `category` enum('Technicals','Access','Network') NOT NULL,
  `article_title` varchar(100) NOT NULL,
  `article_body` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_article_t`
--

INSERT INTO `faq_article_t` (`article_id`, `subcategory_id`, `category`, `article_title`, `article_body`) VALUES
(5, 2, 'Technicals', '*For problems on the auto reset button on the monitors', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li></ol></span>'),
(7, 2, 'Technicals', 'My monitor is not displaying anything. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form</span></p></li></ol></span>'),
(13, 2, 'Technicals', 'My monitor does not turn on. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(15, 3, 'Technicals', 'A paper has been jammed while printing and I cannot print. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(17, 3, 'Technicals', 'My printer does not turn on / work. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(19, 6, 'Network', 'The Network appears to be disconnected', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li></ol></span>'),
(21, 4, 'Access', 'I cannot log in to my PC and/or Windows account. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(23, 5, 'Access', 'Windows is not loading in my unit. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(25, 5, 'Access', 'I cannot access the in-house application. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(27, 5, 'Access', 'The program / application is not responding. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(29, 5, 'Access', 'I cannot open a program / application. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(31, 5, 'Access', 'My web browser keeps on opening multiple pages whenever I click on a link. What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(33, 5, 'Access', 'My web browser appears to be outdated / slow / â€¦ What do I do?', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(37, 0, 'Access', 'Donna\'s concern', '<span id=\"docs-internal-guid-5eddb3a4-099a-00b3-0e44-d567ebf0f234\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li><li><p><span>5. trial po</span></p></li></ol></span>'),
(39, 1, 'Technicals', 'My CPU does not turn on. What do I do?', '<span id=\"docs-internal-guid-677ae5c0-7ffa-45ae-dc52-40aaa2d20148\"><ol><li><div><span>Please check if power cable is plugged in. Is it plugged in?</span></div></li><li><p><span>Please check if cables are properly inserted. Are they inserted properly?</span></p></li><li><p><span>Please check AVR And UPS. Are they running?</span></p></li><li><p><span>If the problem still persists, kindly accomplish service request form.</span></p></li></ol></span>'),
(40, 1, 'Technicals', 'My PC is very slow. What do I do?', '<div><div><ol><li>Try restarting the PC. Does the problem still persist?</li><li>If the problem still persists, kindly accomplish service request form.</li></ol></div></div><div><br></div>');

-- --------------------------------------------------------

--
-- Table structure for table `faq_subcategory_t`
--

CREATE TABLE `faq_subcategory_t` (
  `subcategory_id` int(3) NOT NULL,
  `subcategory_name` varchar(40) NOT NULL,
  `category` enum('Technicals','Access','Network') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_subcategory_t`
--

INSERT INTO `faq_subcategory_t` (`subcategory_id`, `subcategory_name`, `category`) VALUES
(1, 'CPU', 'Technicals'),
(2, 'Monitor', 'Technicals'),
(3, 'Printer', 'Technicals'),
(4, 'Password', 'Access'),
(5, 'Application', 'Access'),
(6, 'Network Connection', 'Network');

-- --------------------------------------------------------

--
-- Table structure for table `notification_t`
--

CREATE TABLE `notification_t` (
  `notification_id` int(4) NOT NULL,
  `ticket_id` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `notification_description` varchar(100) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  `isSeen` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_details_t`
--

CREATE TABLE `request_details_t` (
  `details_id` int(11) NOT NULL,
  `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `name` char(40) NOT NULL,
  `request_type` enum('New','Additional','Reset Password','Deactivate') NOT NULL,
  `application_name` varchar(40) NOT NULL,
  `access_request` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_ticket_t`
--

CREATE TABLE `service_ticket_t` (
  `ticket_id` int(3) UNSIGNED ZEROFILL NOT NULL,
  `request_details` varchar(250) DEFAULT NULL,
  `asset_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sla_t`
--

CREATE TABLE `sla_t` (
  `id` int(3) NOT NULL,
  `severity_level` varchar(4) NOT NULL,
  `description` varchar(30) NOT NULL,
  `resolution_time` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sla_t`
--

INSERT INTO `sla_t` (`id`, `severity_level`, `description`, `resolution_time`) VALUES
(1, 'SEV1', 'Critical', 4),
(2, 'SEV2', 'Important', 6),
(3, 'SEV3', 'Normal', 8),
(4, 'SEV4', 'Low', 24),
(5, 'SEV5', 'Very Low', 48);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_returns_t`
--

CREATE TABLE `ticket_returns_t` (
  `return_id` int(11) NOT NULL,
  `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status_t`
--

CREATE TABLE `ticket_status_t` (
  `status_id` int(1) NOT NULL,
  `ticket_status` varchar(15) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket_status_t`
--

INSERT INTO `ticket_status_t` (`status_id`, `ticket_status`, `description`) VALUES
(1, 'New', NULL),
(2, 'Checked', NULL),
(3, 'Approved', NULL),
(4, 'Rejected', NULL),
(5, 'Pending', NULL),
(6, 'Assigned', NULL),
(7, 'Resolved', NULL),
(8, 'Closed', NULL),
(9, 'Cancelled', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_t`
--

CREATE TABLE `ticket_t` (
  `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `ticket_number` int(11) NOT NULL,
  `ticket_title` varchar(40) NOT NULL,
  `dept_proj` varchar(50) NOT NULL,
  `rc_no` int(5) NOT NULL,
  `date_prepared` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ticket_type` enum('Service','User Access') DEFAULT NULL,
  `ticket_category` enum('Technicals','Access','Network') DEFAULT NULL,
  `severity_level` int(1) DEFAULT NULL,
  `ticket_status` int(1) DEFAULT NULL,
  `date_assigned` datetime DEFAULT NULL,
  `date_required` datetime DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `resolution_date` datetime DEFAULT NULL,
  `auto_close_date` datetime DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `ticket_agent_id` int(5) DEFAULT NULL,
  `return_reason` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `token_t`
--

CREATE TABLE `token_t` (
  `email_address` varchar(50) NOT NULL,
  `token` varchar(40) NOT NULL,
  `is_used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_access_ticket_t`
--

CREATE TABLE `user_access_ticket_t` (
  `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `company` varchar(45) NOT NULL,
  `access_type` enum('New','Additional','Reset Password','Deactivate') NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `approver` int(11) DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT NULL,
  `checker` int(11) DEFAULT NULL,
  `isChecked` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_t`
--

CREATE TABLE `user_t` (
  `user_id` int(5) NOT NULL,
  `first_name` char(30) NOT NULL,
  `last_name` char(20) NOT NULL,
  `userid` char(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `user_type` enum('Administrator','Requestor','Technicals Group Manager','Access Group Manager','Network Group Manager','Technician','Network Engineer') NOT NULL,
  `is_firstlogin` tinyint(1) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `deactivation_date` datetime DEFAULT NULL,
  `reactivation_date` datetime DEFAULT NULL,
  `next_update` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_t`
--

INSERT INTO `user_t` (`user_id`, `first_name`, `last_name`, `userid`, `password`, `email_address`, `user_type`, `is_firstlogin`, `isActive`, `deactivation_date`, `reactivation_date`, `next_update`, `last_update`) VALUES
(676, 'User', 'Administrator', 'administrator', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Administrator', 1, 1, NULL, NULL, '2018-06-25 09:40:25', '2018-03-27 09:40:25'),
(677, 'Juan', 'Dela Cruz', 'accessmanager', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Access Group Manager', 1, 1, '2018-03-31 21:30:45', '2018-03-31 21:32:21', '2018-06-25 10:28:29', '2018-03-27 10:28:29'),
(678, 'Juan', 'Dela Cruz', 'technicalsmanager2', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Technicals Group Manager', 1, 1, NULL, NULL, '2018-06-25 10:14:57', '2018-03-27 10:14:57'),
(679, 'User', 'Network Manager', 'networkmanager', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Network Group Manager', 1, 1, NULL, NULL, '2018-06-25 11:28:30', '2018-03-27 11:28:30'),
(680, 'User', 'Requestor', 'requestor', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Requestor', 1, 1, NULL, NULL, '2018-06-25 10:16:17', '2018-03-27 10:16:17'),
(681, 'Juan', 'Dela Cruz', 'technicalsmanager', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Technicals Group Manager', 1, 1, '2018-03-27 07:44:41', '2018-03-27 07:50:14', '2018-06-25 12:37:52', '2018-03-27 12:37:52'),
(682, 'User', 'Network Engineer', 'networkengineer', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Network Engineer', 1, 1, NULL, NULL, '2018-06-25 11:29:00', '2018-03-27 11:29:00'),
(683, 'User', 'Requestor Two', 'requestortwo', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Requestor', 1, 1, NULL, NULL, '2018-06-25 10:23:35', '2018-03-27 10:23:35'),
(685, 'User', 'Requestor Four', 'requestorfour', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Requestor', 1, 1, NULL, NULL, '2018-06-30 16:11:32', '2018-04-01 16:11:32'),
(686, 'User', 'Requestor Five', 'requestorfive', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Requestor', NULL, 0, NULL, NULL, '2018-06-09 12:14:01', '2018-03-11 12:14:01'),
(688, 'User', 'Technician2', 'techniciantwo', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Technician', NULL, 1, NULL, NULL, '2018-06-09 18:04:09', '2018-03-11 18:04:09'),
(689, 'User', 'Technician3', 'technicianthree', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Technician', NULL, 1, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(691, 'Lennon', 'Villanueva', 'lvillanueva', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'lvillanueva@eei.com.ph', 'Requestor', NULL, 1, '2018-03-31 17:13:09', '2018-03-31 17:15:39', NULL, NULL),
(693, 'April', 'Angelo', 'ahangelo', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'aprilhannangelo@gmail.com', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(694, 'Ana Clarizza', 'Asignacion', 'acpasignacion', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'acpasignacion@eei.com.ph', 'Network Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(695, 'Anthony', 'Belista', 'acbelista', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'acbelista@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(696, 'Christopher', 'Portillo', 'cdportillo', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'cdportillo@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(697, 'Edgar', 'Sta. Ines', 'evstaines', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'evstaines@eei.com.ph', 'Technicals Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(698, 'Emelita Ruth', 'Pendre', 'erdpendre', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'erdpendre@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(699, 'Eric', 'Hing', 'eahing', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'eahing@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(700, 'Erwin', 'Llaguno', 'emllaguno', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'emllaguno@eei.com.ph', 'Technician', NULL, 1, NULL, NULL, NULL, NULL),
(701, 'Evelyn', 'Picorro', 'evpicorro', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'evpicorro@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(702, 'Ivy', 'Quitalig', 'ibquitalig', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'ibquitalig@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(703, 'Jade', 'Angeles', 'jcangeles', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'jcangeles@eei.com.ph', 'Technician', NULL, 1, NULL, NULL, NULL, NULL),
(704, 'Jayson', 'Vargas', 'jnvargas', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'jnvargas@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(705, 'Jeson', 'Mendoza', 'jmmendoza', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'jmmendoza@eei.com.ph', 'Network Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(706, 'John Edward', 'Torres', 'jettorres', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'jettorres@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(707, 'Jorge', 'Lagrosa', 'jplagrosa', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'jplagrosa@eei.com.ph', 'Technician', NULL, 1, NULL, NULL, NULL, NULL),
(708, 'Kimberly', 'Mercado', 'kgmercado', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'kgmercado@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(709, 'Lauro', 'Matias', 'lcmatias', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'lcmatias@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(710, 'Leandro', 'Esma', 'lmesma', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'lmesma@eei.com.ph', 'Technician', NULL, 1, NULL, NULL, NULL, NULL),
(711, 'Ma. Socorro', 'Barrios', 'mscbarrios', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'mscbarrios@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(712, 'Ma. Victoria', 'Lomuntad', 'mvplomuntad', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'mvplomuntad@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(713, 'Mark Christian', 'Aliado', 'mcoaliado', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'mcoaliado@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(714, 'Marlito', 'Jimenez', 'mjjimenez', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'mjjimenez@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(715, 'Mary Grace', 'Mendoza', 'mgbmendoza', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'mgbmendoza@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(716, 'Ramil', 'Cruz', 'rgcruz', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'rgcruz@eei.com.ph', 'Technician', NULL, 1, NULL, NULL, NULL, NULL),
(717, 'Renz Martin', 'Reyes', 'rmareyes', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'rmareyes@eei.com.ph', 'Network Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(718, 'Rex', 'Mandalupe', 'rfmandalupe', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'rfmandalupe@eei.com.ph', 'Network Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(719, 'Rogelio', 'Lucena', 'rolucena', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'rolucena@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(720, 'Rogelio', 'Nicolas Jr.', 'rvnicolasjr', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'rvnicolasjr@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL),
(721, 'Sheila Marie', 'Pascual', 'smrpascual', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'smrpascual@eei.com.ph', 'Access Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(722, 'Sizairra', 'Valdez', 'sfvaldez', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'sfvaldez@eei.com.ph', 'Administrator', NULL, 1, NULL, NULL, NULL, NULL),
(723, 'Unica Paola', 'Yuso', 'uptyuso', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'uptyuso@eei.com.ph', 'Network Group Manager', NULL, 1, NULL, NULL, NULL, NULL),
(724, 'Victor', 'Berdin', 'vbberdin', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'vbberdin@eei.com.ph', 'Technician', NULL, 1, NULL, NULL, NULL, NULL),
(725, 'Yvolin', 'Tindugan', 'yctindugan', 'aa15a654dad571bb6a60a3c5ac1f6eae', 'yctindugan@eei.com.ph', 'Requestor', NULL, 1, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log_t`
--
ALTER TABLE `activity_log_t`
  ADD PRIMARY KEY (`activity_log_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `attachment_t`
--
ALTER TABLE `attachment_t`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `faq_article_t`
--
ALTER TABLE `faq_article_t`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `faq_subcategory_t`
--
ALTER TABLE `faq_subcategory_t`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- Indexes for table `notification_t`
--
ALTER TABLE `notification_t`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `request_details_t`
--
ALTER TABLE `request_details_t`
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `service_ticket_t`
--
ALTER TABLE `service_ticket_t`
  ADD KEY `service_ticket_t_ibfk_1` (`ticket_id`);

--
-- Indexes for table `sla_t`
--
ALTER TABLE `sla_t`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_returns_t`
--
ALTER TABLE `ticket_returns_t`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `ticket_status_t`
--
ALTER TABLE `ticket_status_t`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ticket_t`
--
ALTER TABLE `ticket_t`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `requestor_id` (`user_id`),
  ADD KEY `ticket_number` (`ticket_number`),
  ADD KEY `severity_level` (`severity_level`),
  ADD KEY `ticket_status` (`ticket_status`);

--
-- Indexes for table `user_access_ticket_t`
--
ALTER TABLE `user_access_ticket_t`
  ADD UNIQUE KEY `ticket_id_2` (`ticket_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `user_t`
--
ALTER TABLE `user_t`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log_t`
--
ALTER TABLE `activity_log_t`
  MODIFY `activity_log_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachment_t`
--
ALTER TABLE `attachment_t`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faq_article_t`
--
ALTER TABLE `faq_article_t`
  MODIFY `article_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `faq_subcategory_t`
--
ALTER TABLE `faq_subcategory_t`
  MODIFY `subcategory_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notification_t`
--
ALTER TABLE `notification_t`
  MODIFY `notification_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sla_t`
--
ALTER TABLE `sla_t`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket_returns_t`
--
ALTER TABLE `ticket_returns_t`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_status_t`
--
ALTER TABLE `ticket_status_t`
  MODIFY `status_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ticket_t`
--
ALTER TABLE `ticket_t`
  MODIFY `ticket_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_t`
--
ALTER TABLE `user_t`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=726;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log_t`
--
ALTER TABLE `activity_log_t`
  ADD CONSTRAINT `activity_log_t_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_t` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attachment_t`
--
ALTER TABLE `attachment_t`
  ADD CONSTRAINT `attachment_t_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_t` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attachment_t_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_t` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_t`
--
ALTER TABLE `notification_t`
  ADD CONSTRAINT `notification_t_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_t` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request_details_t`
--
ALTER TABLE `request_details_t`
  ADD CONSTRAINT `request_details_t_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_t` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_ticket_t`
--
ALTER TABLE `service_ticket_t`
  ADD CONSTRAINT `service_ticket_t_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_t` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_returns_t`
--
ALTER TABLE `ticket_returns_t`
  ADD CONSTRAINT `ticket_returns_t_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_t` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_t`
--
ALTER TABLE `ticket_t`
  ADD CONSTRAINT `ticket_t_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_t` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_t_ibfk_3` FOREIGN KEY (`severity_level`) REFERENCES `sla_t` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_t_ibfk_4` FOREIGN KEY (`ticket_status`) REFERENCES `ticket_status_t` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_access_ticket_t`
--
ALTER TABLE `user_access_ticket_t`
  ADD CONSTRAINT `user_access_ticket_t_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_t` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
