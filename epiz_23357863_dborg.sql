-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql300.byetcluster.com
-- Generation Time: Mar 11, 2019 at 10:30 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_23357863_dborg`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advisory`
--

CREATE TABLE IF NOT EXISTS `tbl_advisory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_no` varchar(50) NOT NULL,
  `course_year` varchar(50) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE IF NOT EXISTS `tbl_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_no` varchar(50) NOT NULL,
  `student_no` varchar(50) NOT NULL,
  `ontime_in` datetime DEFAULT CURRENT_TIMESTAMP,
  `ontime_out` datetime DEFAULT NULL,
  `event_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`id`, `event_no`, `student_no`, `ontime_in`, `ontime_out`, `event_date`) VALUES
(1, 'EVSU-E001', '2014-02390', '2019-03-10 13:06:37', NULL, '2019-03-10 13:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college`
--

CREATE TABLE IF NOT EXISTS `tbl_college` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no` varchar(100) NOT NULL,
  `college` varchar(100) NOT NULL,
  `remarks` varchar(50) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_college`
--

INSERT INTO `tbl_college` (`id`, `id_no`, `college`, `remarks`) VALUES
(1, 'ORG-001', 'College of Engineering', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE IF NOT EXISTS `tbl_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_desc` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `college`, `department`, `course_code`, `course_desc`, `date_created`) VALUES
(1, 'College of Engineering', 'Civil Engineering Department', 'BSCE', 'Bachelor of Science in Civil Engineering', '2019-03-09 21:24:09'),
(2, 'College of Engineering', 'Mechanical Engineering Department', 'BSME', 'Bachelor of Science in Mechanical Engineering', '2019-03-09 21:27:11'),
(3, 'College of Engineering', 'Industrial Engineering Department', 'BSIE', 'Bachelor of Science in Industrial Engineering', '2019-03-09 21:53:25'),
(4, 'College of Engineering', 'Geodetic Engineering Department', 'BSGE', 'Bachelor of Science in Geodetic Engineering', '2019-03-09 22:00:35'),
(5, 'College of Engineering', 'Electronics Communication  Engineering Department', 'BSECE', 'Bachelor of Science in Electronics Communication  Engineering', '2019-03-09 22:02:47'),
(6, 'College of Engineering', 'Electrical Engineering Department', 'BSEE', 'Bachelor of Science in Electrical Engineering', '2019-03-09 22:04:33'),
(7, 'College of Engineering', 'Chemical Engineering Department', 'BSCHE', 'Bachelor of Science in Chemical Engineering', '2019-03-09 22:06:07'),
(8, 'College of Engineering', 'Information Technology Department', 'BSINT', 'Bachelor of Science in Information Technology', '2019-03-09 22:06:57'),
(9, 'College of Technology', 'Hospitality Management Department', 'BSHM', 'Bachelor of Science in Hospitality Management', '2019-03-09 22:08:25'),
(10, 'College of Technology', 'Nutrition and Dietetics Department', 'BSNDD', 'Bachelor of Science in Nutrition and Dietetics', '2019-03-09 22:14:56'),
(11, 'College of Technology', 'Enhance Support Level Program for Marine Engineering Department', 'ESLPME', 'Enhance Support Level Program for Marine Engineering', '2019-03-09 22:16:58'),
(12, 'College of Technology', 'Industrial Technology Department', 'BSIT', 'Bachelor of Science in Industrial Technology', '2019-03-09 22:23:57'),
(13, 'College of Architecture and Allied Discipline', 'Architecture Department', 'BSArch', 'Bachelor of Science in Architecture', '2019-03-09 22:32:09'),
(14, 'College of Architecture and Allied Discipline', 'Interior Design Department', 'BS-ID', 'Bachelor of Science in Interior Design', '2019-03-09 22:34:29'),
(15, 'College of Arts and Sciences', 'Mathematics Department', 'BSM', 'Bachelor of Science in Mathematics', '2019-03-09 22:36:35'),
(16, 'College of Arts and Sciences', 'Environmental Science Department', 'BSES', 'Bachelor of Science in Environmental Science', '2019-03-09 22:37:43'),
(17, 'College of Arts and Sciences', 'Chemistry Department', 'BS Chem', 'Bachelor of Science in Chemistry', '2019-03-09 22:38:39'),
(18, 'College of Arts and Sciences', 'Statistics Department', 'BS STAT', 'Bachelor of Science in Statistics', '2019-03-09 22:40:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_credentials`
--

CREATE TABLE IF NOT EXISTS `tbl_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no` varchar(50) NOT NULL,
  `user` varchar(100) NOT NULL,
  `pass` varchar(500) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `remarks` varchar(10) NOT NULL DEFAULT 'Enabled',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_credentials`
--

INSERT INTO `tbl_credentials` (`id`, `id_no`, `user`, `pass`, `user_type`, `remarks`) VALUES
(1, 'admin', 'admin', 'admin', 'Administrator', 'Enabled'),
(2, '2014-02390', '2014-02390', '12345', 'Student', 'Enabled'),
(3, 'ORG-001', 'INTEL', 'amin', 'Organizer', 'Enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE IF NOT EXISTS `tbl_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer` varchar(100) NOT NULL,
  `event_no` varchar(50) NOT NULL,
  `event_date` date NOT NULL DEFAULT '2018-12-30',
  `login_time` time NOT NULL,
  `logout_time` time NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_venue` varchar(200) NOT NULL,
  `event_cover` varchar(100) NOT NULL,
  `event_description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`id`, `organizer`, `event_no`, `event_date`, `login_time`, `logout_time`, `event_name`, `event_venue`, `event_cover`, `event_description`, `date_created`) VALUES
(1, 'SCHOOL ORGANIZERS', 'EVSU-E001', '2019-03-12', '10:00:00', '17:00:00', 'JS PROM', 'EASTERN VISAYAS STATE UNIVERSITY', 'EVSU-E001.png', 'PROM NIGHT', '2019-03-10 13:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mails`
--

CREATE TABLE IF NOT EXISTS `tbl_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  `datesent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_mails`
--

INSERT INTO `tbl_mails` (`id`, `sender`, `receiver`, `email`, `msg`, `datesent`, `remarks`) VALUES
(1, 'admin', '2014-02390', 'vallejennyruth08@gmail.com', '\r\n        <!DOCTYPE html>\r\n        <html lang="en">\r\n        <head>\r\n            <meta charset="UTF-8">\r\n            <meta name="viewport" content="width=device-width, initial-scale=1.0">\r\n            <meta http-equiv="X-UA-Compatible" content="ie=edge">\r\n            <title>Document</title>\r\n        </head>\r\n        <body>\r\n            <div>\r\n            <p>\r\n            Good day JENNY RUTH VALLE!<br><br> This is to inform that your Account and QR Code has been successfully generated.\r\n            Download the attached image and used it as an attendance identification.\r\n            If you accidentally removed this mail, you can visit <a href="https://www.qr-code-generator.com">https://www.qr-code-generator.com<a>\r\n            and <i style="color:firebrick;">note to select as </i><b>Text</b> then generate a new QR code using your School ID Number.\r\n            </p>\r\n            <br>\r\n            <p>\r\n            To login, visit <a href="http://evsuevents.epizy.com">http://evsuevents.epizy.com<a> and use the following credentials:\r\n            <br>\r\n            <br>\r\n            Username: <i style="color:blue">Your ID Number</i>.<br>\r\n            Password: <i style="color:blue">12345</i>.<br>\r\n            <br>\r\n            <br>\r\n            You can change it in your dashboard.\r\n            </p>\r\n            Thank you.<br>\r\n            Eastern Visayas State University - Event Organizer\r\n            </div>\r\n        </body>\r\n        </html>\r\n        ', '2019-03-10 12:47:00', 'Successfull');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_respondent`
--

CREATE TABLE IF NOT EXISTS `tbl_respondent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_no` varchar(50) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_year` varchar(50) NOT NULL,
  `remarks` varchar(50) DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_respondent`
--

INSERT INTO `tbl_respondent` (`id`, `event_no`, `course_code`, `course_year`, `remarks`) VALUES
(1, 'EVSU-E001', 'All', 'All', 'Active'),
(2, 'EVSU-E001', 'All', 'Fourth Year', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scholarship`
--

CREATE TABLE IF NOT EXISTS `tbl_scholarship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grant_code` varchar(50) NOT NULL,
  `grant_desc` varchar(100) NOT NULL,
  `remarks` varchar(50) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tbl_scholarship`
--

INSERT INTO `tbl_scholarship` (`id`, `grant_code`, `grant_desc`, `remarks`) VALUES
(1, 'TES Grantees', 'Tertiary Education Subsidy', 'Active'),
(2, 'Babatngon Scholar', 'Babatngonanon Scholarship & Livelihood Program', 'Active'),
(3, 'GSIS Scholars', 'GSIS Scholarship Program', 'Active'),
(4, 'Provincial', 'Provincial Scholarship Program Management', 'Active'),
(5, 'OWWA Scholar', ' Overseas Workers Welfare Administration ', 'Active'),
(6, 'Sons & Daughters', 'Sons & Daughters Scholarship Program', 'Active'),
(7, 'Barangay Scholar', 'Barangay Scholarship', 'Active'),
(8, 'SM Scholar', 'SM Foundation College Scholarship Program', 'Active'),
(9, 'AY Foundation Scholar', 'AY Foundation, Inc.', 'Active'),
(10, 'COCOFOUNDATION Scholarship Program', 'COCOFOUNDATION Scholarship Program - UCPB-CIIF Foundation, Inc.', 'Active'),
(11, 'Double You''re Money', 'Double You''re Money Scholarship', 'Active'),
(12, 'Streetlight', 'Streetlight Foundation', 'Active'),
(13, 'De la Salle Lipa', 'De La Salle Lipa scholarship', 'Active'),
(14, 'AFTA', 'Alaska Frontier Trappers Association Academic Scholarship Program', 'Active'),
(15, 'DOST-Scei undergraduate Scholar', 'DOST-SEI Scholarships', 'Active'),
(17, 'OPT-OUT ', 'OPT-OUT Scholarship', 'Active'),
(18, 'Free Tuition', 'Free College Tuition Program', 'Active'),
(19, 'Real Life', 'Real LIFE Foundation', 'Active'),
(20, 'LGU', 'Local Government Unit Scholarship Grant', 'Active'),
(21, 'CARITAS', 'CARITAS Shcolarship', 'Active'),
(22, 'Edward and Eva Underwood', 'Edward and Eva Underwood Charitable foundation', 'Active'),
(23, 'ESGPPA Continuing Grantees', 'Expanded Students Grants-in-Aid Program for Poverty Alleviation', 'Active'),
(24, 'Tulong Dunong scholarship', 'CHED-Tulong Dunong Scholarship', 'Active'),
(25, 'Full Merit', ' Full Merit Scholarship', 'Active'),
(26, 'Half Merit', 'CHED-Half Merit Scholarship', 'Active'),
(27, 'DND-CHED-PASUC Scholarship Program ', 'DND-CHED-PASUC Scholarship Program ', 'Active'),
(28, 'CHED-TDP', 'Ched Tulong Dunong Scholarship Program', 'Active'),
(29, 'Partial', 'Ched Tulong Dunong Scholarship Program', 'Active'),
(30, 'Tulong Dunong Regular', 'Ched Tulong Dunong Scholarship Program', 'Active'),
(31, 'Andres P. Tamayo Sr. Foundation, Inc.', 'Andres P. Tamayo Sr. Foundation, Inc.', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sections`
--

CREATE TABLE IF NOT EXISTS `tbl_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(50) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sessiontracker`
--

CREATE TABLE IF NOT EXISTS `tbl_sessiontracker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no` varchar(50) NOT NULL,
  `activity` text NOT NULL,
  `reference` varchar(100) NOT NULL,
  `performed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `tbl_sessiontracker`
--

INSERT INTO `tbl_sessiontracker` (`id`, `id_no`, `activity`, `reference`, `performed_on`, `remarks`) VALUES
(1, 'admin', 'Login to an Account', 'admin', '2019-03-08 04:40:20', 'Successfull'),
(2, 'admin', 'Send SMS Notification', '09551386695', '2019-03-08 04:41:08', 'Successfull'),
(3, 'admin', 'Send SMS Notification', '09651347936', '2019-03-08 04:44:26', 'Successfull'),
(4, 'admin', 'Send SMS Notification', '09651347926', '2019-03-08 04:45:43', 'Successfull'),
(5, 'admin', 'Login to an Account', 'admin', '2019-03-09 13:08:50', 'Successfull'),
(6, 'admin', 'Added a Course', 'BSCE', '2019-03-09 13:24:09', 'Successfull'),
(7, 'admin', 'Added a Course', 'BSME', '2019-03-09 13:27:11', 'Successfull'),
(8, 'admin', 'Added a Course', 'BSIE', '2019-03-09 13:53:25', 'Successfull'),
(9, 'admin', 'Added a Course', 'BSGE', '2019-03-09 14:00:35', 'Successfull'),
(10, 'admin', 'Added a Course', 'BSECE', '2019-03-09 14:02:47', 'Successfull'),
(11, 'admin', 'Added a Course', 'BSEE', '2019-03-09 14:04:33', 'Successfull'),
(12, 'admin', 'Added a Course', 'BSCHE', '2019-03-09 14:06:07', 'Successfull'),
(13, 'admin', 'Added a Course', 'BSINT', '2019-03-09 14:06:57', 'Successfull'),
(14, 'admin', 'Added a Course', 'BSHM', '2019-03-09 14:08:25', 'Successfull'),
(15, 'admin', 'Added a Course', 'BSNDD', '2019-03-09 14:14:56', 'Successfull'),
(16, 'admin', 'Added a Course', 'ESLPME', '2019-03-09 14:16:58', 'Successfull'),
(17, 'admin', 'Added a Course', 'BSIT', '2019-03-09 14:23:57', 'Successfull'),
(18, 'admin', 'Added a Course', 'BSArch', '2019-03-09 14:32:09', 'Successfull'),
(19, 'admin', 'Added a Course', 'BS-ID', '2019-03-09 14:34:29', 'Successfull'),
(20, 'admin', 'Added a Course', 'BSM', '2019-03-09 14:36:35', 'Successfull'),
(21, 'admin', 'Added a Course', 'BSES', '2019-03-09 14:37:43', 'Successfull'),
(22, 'admin', 'Added a Course', 'BSC', '2019-03-09 14:38:39', 'Successfull'),
(23, 'admin', 'Updated a Course', 'BSCHEM', '2019-03-09 14:39:01', 'Successfull'),
(24, 'admin', 'Added a Course', 'BS STAT', '2019-03-09 14:40:19', 'Successfull'),
(25, 'admin', 'Updated a Course', 'BS Chem', '2019-03-09 14:41:40', 'Successfull'),
(26, 'admin', 'Login to an Account', 'admin', '2019-03-10 01:22:47', 'Successfull'),
(27, 'admin', 'Added a Scholarship', 'TES Grantees', '2019-03-10 03:35:54', 'Successfull'),
(28, 'admin', 'Added a Scholarship', 'Babatngon Scholar', '2019-03-10 03:38:12', 'Successfull'),
(29, 'admin', 'Added a Scholarship', 'GSIS Scholars', '2019-03-10 03:39:45', 'Successfull'),
(30, 'admin', 'Added a Scholarship', 'Provincial', '2019-03-10 03:41:02', 'Successfull'),
(31, 'admin', 'Added a Scholarship', 'OWWA Scholar', '2019-03-10 03:42:15', 'Successfull'),
(32, 'admin', 'Added a Scholarship', 'Sons & Daughters', '2019-03-10 03:43:31', 'Successfull'),
(33, 'admin', 'Added a Scholarship', 'Barangay Scholar', '2019-03-10 03:45:11', 'Successfull'),
(34, 'admin', 'Added a Scholarship', 'SM Scholar', '2019-03-10 03:46:22', 'Successfull'),
(35, 'admin', 'Added a Scholarship', 'AY Foundation Scholar', '2019-03-10 03:50:39', 'Successfull'),
(36, 'admin', 'Added a Scholarship', 'COCOFOUNDATION Scholarship Program', '2019-03-10 03:56:03', 'Successfull'),
(37, 'admin', 'Added a Scholarship', 'Double You''re Money', '2019-03-10 03:58:00', 'Successfull'),
(38, 'admin', 'Added a Scholarship', 'Streetlight', '2019-03-10 03:59:22', 'Successfull'),
(39, 'admin', 'Added a Scholarship', 'De la Salle Lipa', '2019-03-10 04:00:37', 'Successfull'),
(40, 'admin', 'Added a Scholarship', 'AFTA', '2019-03-10 04:03:33', 'Successfull'),
(41, 'admin', 'Added a Scholarship', 'DOST-Scei undergraduate Scholar', '2019-03-10 04:07:33', 'Successfull'),
(42, 'admin', 'Added a Scholarship', 'FME', '2019-03-10 04:12:35', 'Successfull'),
(43, 'admin', 'Added a Scholarship', 'OPT-OUT ', '2019-03-10 04:16:01', 'Successfull'),
(44, 'admin', 'Added a Scholarship', 'Free Tuition', '2019-03-10 04:17:18', 'Successfull'),
(45, 'admin', 'Added a Scholarship', 'Real Life', '2019-03-10 04:18:49', 'Successfull'),
(46, 'admin', 'Added a Scholarship', 'LGU', '2019-03-10 04:19:36', 'Successfull'),
(47, 'admin', 'Added a Scholarship', 'CARITAS', '2019-03-10 04:20:41', 'Successfull'),
(48, 'admin', 'Updated a Scholarship', 'CARITAS', '2019-03-10 04:20:58', 'Successfull'),
(49, 'admin', 'Added a Scholarship', 'Edward and Eva Underwood', '2019-03-10 04:22:11', 'Successfull'),
(50, 'admin', 'Added a Scholarship', 'ESGPPA Continuing Grantees', '2019-03-10 04:24:50', 'Successfull'),
(51, 'admin', 'Added a Scholarship', 'Tulong Dunong scholarship', '2019-03-10 04:26:34', 'Successfull'),
(52, 'admin', 'Added a Scholarship', 'Full Merit', '2019-03-10 04:28:27', 'Successfull'),
(53, 'admin', 'Added a Scholarship', 'Half Merit CHED-', '2019-03-10 04:33:40', 'Successfull'),
(54, 'admin', 'Updated a Scholarship', 'Half Merit', '2019-03-10 04:34:27', 'Successfull'),
(55, 'admin', 'Added a Scholarship', 'DND-CHED-PASUC Scholarship Program ', '2019-03-10 04:36:23', 'Successfull'),
(56, 'admin', 'Added a Scholarship', 'CHED-TDP', '2019-03-10 04:38:14', 'Successfull'),
(57, 'admin', 'Added a Scholarship', 'Partial', '2019-03-10 04:38:41', 'Successfull'),
(58, 'admin', 'Added a Scholarship', 'Tulong Dunong Regular', '2019-03-10 04:39:15', 'Successfull'),
(59, 'admin', 'Added a Scholarship', 'Andres P. Tamayo Sr. Foundation, Inc.', '2019-03-10 04:40:58', 'Successfull'),
(60, 'admin', 'Added a Student', '2014-02390', '2019-03-10 04:46:52', 'Successfull'),
(61, 'admin', 'Generates QR Code', '2014-02390', '2019-03-10 04:46:52', 'Successfull'),
(62, 'admin', 'Send Email Notification', '2014-02390', '2019-03-10 04:47:00', 'Successfull'),
(63, 'admin', 'Added a Respondent: All - All', 'EVSU-E001', '2019-03-10 05:06:16', 'Successfull'),
(64, 'admin', 'Added the Event', 'EVSU-E001', '2019-03-10 05:06:18', 'Successfull'),
(65, 'admin', 'Login to an Account', 'admin', '2019-03-10 05:56:28', 'Successfull'),
(66, 'admin', 'Login to an Account', 'admin', '2019-03-10 08:23:30', 'Successfull'),
(67, 'admin', 'Login to an Account', 'admin', '2019-03-10 08:23:30', 'Successfull'),
(68, 'admin', 'Login to an Account', 'admin', '2019-03-10 08:23:42', 'Successfull'),
(69, 'admin', 'Send Email Notification', 'relozjerwen@outlook.com', '2019-03-10 08:24:14', 'Successfull'),
(70, 'admin', 'Created an Account', 'ORG-001', '2019-03-10 08:26:08', 'Successfull'),
(71, 'admin', 'Created an Account - Account Exist', 'ORG-001', '2019-03-10 08:26:08', 'Failed'),
(72, 'admin', 'End Session', 'admin', '2019-03-10 08:26:32', 'Successfull'),
(73, 'ORG-001', 'Login to an Account', 'ORG-001', '2019-03-10 08:27:53', 'Successfull'),
(74, 'ORG-001', 'Remove Email sent item', 'Failed to record reference', '2019-03-10 08:32:34', 'Failed'),
(75, 'admin', 'Login to an Account', 'admin', '2019-03-10 09:41:51', 'Successfull'),
(76, 'ORG-001', 'End Session', 'ORG-001', '2019-03-10 09:52:29', 'Successfull'),
(77, '', 'End Session', '', '2019-03-10 09:52:29', 'Successfull'),
(78, 'admin', 'Login to an Account', 'admin', '2019-03-10 09:52:45', 'Successfull'),
(79, 'admin', 'Login to an Account', 'admin', '2019-03-10 09:52:45', 'Successfull'),
(80, 'admin', 'Login to an Account', 'admin', '2019-03-11 05:58:27', 'Successfull'),
(81, '', 'Deleted a Scholarship', 'FME', '2019-03-11 06:09:30', 'Successfull'),
(82, '', 'Deleted a Scholarship', 'FME', '2019-03-11 06:09:34', 'Successfull'),
(83, 'admin', 'Login to an Account', 'admin', '2019-03-11 06:09:46', 'Successfull'),
(84, 'admin', 'Login to an Account', 'admin', '2019-03-11 21:23:30', 'Successfull'),
(85, 'admin', 'Added a Respondent: Fourth Year - All', 'EVSU-E001', '2019-03-11 21:24:22', 'Successfull'),
(86, 'admin', 'Updated the Event', 'EVSU-E001', '2019-03-11 21:24:53', 'Successfull'),
(87, 'admin', 'End Session', 'admin', '2019-03-11 21:29:40', 'Successfull');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms`
--

CREATE TABLE IF NOT EXISTS `tbl_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  `datesent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_sms`
--

INSERT INTO `tbl_sms` (`id`, `sender`, `receiver`, `phone`, `msg`, `datesent`, `remarks`) VALUES
(1, 'admin', 'Failed to record recievers name ', '09551386695', 'Sample Sms', '2019-03-08 12:41:08', 'Successfull'),
(2, 'admin', 'Failed to record recievers name ', '09651347936', 'Hi ! Have a great day!', '2019-03-08 12:44:27', 'Successfull'),
(3, 'admin', 'Failed to record recievers name ', '09651347926', 'Hi ! Have a great day!', '2019-03-08 12:45:44', 'Successfull');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE IF NOT EXISTS `tbl_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_no` varchar(200) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.png',
  `cyear` varchar(50) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `college` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `scholarship` varchar(100) DEFAULT NULL,
  `section` varchar(50) NOT NULL,
  `caddress` varchar(191) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `student_no`, `first_name`, `middle_name`, `last_name`, `avatar`, `cyear`, `course_code`, `college`, `department`, `scholarship`, `section`, `caddress`, `birthday`, `phone`, `email`, `date_created`) VALUES
(1, '2014-02390', 'JENNY RUTH', 'CABIDOG', 'VALLE', 'default.png', 'Fourth Year', 'BSIT', 'College of Engineering', 'Information Technology Department', '', 'A', 'Block 53, Lot 3, Mindanao Drive , Kassel CIty Subdvision, Brgy. 91 Abucay. Tacloban City, Leyte', '1997-07-08', '09651347926', 'vallejennyruth08@gmail.com', '2019-03-10 12:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE IF NOT EXISTS `tbl_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_no` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `caddress` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `college` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
