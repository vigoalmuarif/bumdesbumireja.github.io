-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2021 at 03:11 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bumdes`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'vigoalmuarif', NULL, '2021-05-02 03:06:02', 0),
(2, '::1', 'vigoalmuarif', NULL, '2021-05-02 03:07:24', 0),
(3, '::1', 'vigoalmuarif', NULL, '2021-05-02 03:07:33', 0),
(4, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:07:39', 1),
(5, '::1', 'vigoalmuarif', NULL, '2021-05-02 03:09:30', 0),
(6, '::1', 'vigoalmuarif', NULL, '2021-05-02 03:09:45', 0),
(7, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:10:52', 1),
(8, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:45:21', 1),
(9, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:46:19', 1),
(10, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:46:47', 1),
(11, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:52:37', 1),
(12, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 03:53:17', 1),
(13, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:29:17', 1),
(14, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:30:18', 1),
(15, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:31:58', 1),
(16, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:39:20', 1),
(17, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:39:26', 1),
(18, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:41:20', 1),
(19, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:41:51', 1),
(20, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:42:37', 1),
(21, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:44:10', 1),
(22, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 04:44:39', 1),
(23, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 05:47:58', 1),
(24, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-02 05:48:17', 1),
(25, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-03 02:46:06', 1),
(26, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-03 15:45:54', 1),
(27, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-04 17:50:22', 1),
(28, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-05 21:31:10', 1),
(29, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-06 04:30:00', 1),
(30, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-06 13:49:57', 1),
(31, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-06 22:22:09', 1),
(32, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-07 15:54:25', 1),
(33, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-07 20:25:38', 1),
(34, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-08 22:48:08', 1),
(35, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-09 18:40:26', 1),
(36, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-10 02:53:53', 1),
(37, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-10 03:41:24', 1),
(38, '::1', 'kipli@gmail.com', 3, '2021-05-10 04:37:01', 1),
(39, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-10 14:23:48', 1),
(40, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-10 18:08:24', 1),
(41, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-10 22:48:56', 1),
(42, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-11 04:51:03', 1),
(43, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-16 21:58:48', 1),
(44, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-18 16:52:21', 1),
(45, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-18 20:43:40', 1),
(46, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-19 00:44:58', 1),
(47, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-21 04:37:28', 1),
(48, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-21 23:14:16', 1),
(49, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-22 04:16:04', 1),
(50, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-22 20:03:58', 1),
(51, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-23 02:02:16', 1),
(52, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-23 18:38:15', 1),
(53, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-24 00:35:28', 1),
(54, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-24 03:54:16', 1),
(55, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-24 14:13:36', 1),
(56, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-24 18:34:27', 1),
(57, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-24 21:54:45', 1),
(58, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-26 01:00:17', 1),
(59, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-26 08:23:00', 1),
(60, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-27 01:50:22', 1),
(61, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-27 13:18:02', 1),
(62, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-27 22:12:24', 1),
(63, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-29 04:11:31', 1),
(64, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-29 21:25:17', 1),
(65, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 10:46:18', 1),
(66, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 10:47:09', 1),
(67, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 10:52:20', 1),
(68, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:03:32', 1),
(69, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:06:58', 1),
(70, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:07:56', 1),
(71, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:13:03', 1),
(72, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:20:12', 1),
(73, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:21:19', 1),
(74, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:25:02', 1),
(75, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-30 16:35:30', 1),
(76, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 05:32:16', 1),
(77, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 05:33:16', 1),
(78, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 05:33:23', 1),
(79, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:13:18', 1),
(80, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:14:05', 1),
(81, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:39:20', 1),
(82, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:39:25', 1),
(83, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:39:45', 1),
(84, '::1', 'vigoalmuarif', NULL, '2021-05-31 06:41:15', 0),
(85, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:41:20', 1),
(86, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:41:33', 1),
(87, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:45:54', 1),
(88, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:46:44', 1),
(89, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:49:45', 1),
(90, '::1', 'vigoalmuarif', NULL, '2021-05-31 06:49:54', 0),
(91, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:49:59', 1),
(92, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 06:50:24', 1),
(93, '::1', 'vigoalmuarif@gmail.com', 4, '2021-05-31 07:07:36', 1),
(94, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 20:12:12', 1),
(95, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 22:16:13', 1),
(96, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 22:17:39', 1),
(97, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 22:22:46', 1),
(98, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 22:27:48', 1),
(99, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 22:56:55', 1),
(100, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-01 23:59:17', 1),
(101, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:30:01', 1),
(102, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:30:26', 1),
(103, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:32:29', 1),
(104, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:33:35', 1),
(105, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:38:00', 1),
(106, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:38:26', 1),
(107, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:43:17', 1),
(108, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:43:24', 1),
(109, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:43:41', 1),
(110, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:43:47', 1),
(111, '::1', 'vigoalmuarif', NULL, '2021-06-02 00:43:56', 0),
(112, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:44:01', 1),
(113, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:44:22', 1),
(114, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:44:41', 1),
(115, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:44:53', 1),
(116, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:45:00', 1),
(117, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:45:20', 1),
(118, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:45:56', 1),
(119, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:46:29', 1),
(120, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:46:42', 1),
(121, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:46:56', 1),
(122, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:47:07', 1),
(123, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:47:28', 1),
(124, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:47:38', 1),
(125, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:48:19', 1),
(126, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:49:29', 1),
(127, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:49:44', 1),
(128, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 00:50:01', 1),
(129, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 18:22:31', 1),
(130, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 18:23:01', 1),
(131, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 18:23:32', 1),
(132, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 18:24:10', 1),
(133, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-02 18:25:20', 1),
(134, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-03 04:47:25', 1),
(135, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-04 21:31:48', 1),
(136, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-04 21:52:02', 1),
(137, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-05 11:12:34', 1),
(138, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-05 14:05:07', 1),
(139, '::1', 'vigoalmuarif', NULL, '2021-06-05 20:49:21', 0),
(140, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-05 20:49:32', 1),
(141, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-17 20:41:09', 1),
(142, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-18 16:42:22', 1),
(143, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-18 22:12:28', 1),
(144, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-20 00:17:05', 1),
(145, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-21 23:31:09', 1),
(146, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-23 00:52:28', 1),
(147, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-23 14:38:42', 1),
(148, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-24 08:55:42', 1),
(149, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-25 23:13:18', 1),
(150, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-26 18:46:16', 1),
(151, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-27 08:13:27', 1),
(152, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-28 16:36:17', 1),
(153, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-29 02:26:09', 1),
(154, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-29 17:43:10', 1),
(155, '::1', 'vigoalmuarif', NULL, '2021-06-30 20:15:57', 0),
(156, '::1', 'vigoalmuarif@gmail.com', 4, '2021-06-30 20:16:04', 1),
(157, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-01 16:39:13', 1),
(158, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-02 11:03:48', 1),
(159, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-02 15:11:05', 1),
(160, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-02 21:28:50', 1),
(161, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-03 13:22:45', 1),
(162, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-04 06:07:43', 1),
(163, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-05 04:03:20', 1),
(164, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-05 21:08:43', 1),
(165, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-06 06:43:05', 1),
(166, '::1', 'vigoalmuarif', NULL, '2021-07-06 17:25:03', 0),
(167, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-06 17:25:12', 1),
(168, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-07 16:00:14', 1),
(169, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-07 18:59:35', 1),
(170, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-08 09:34:30', 1),
(171, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-08 18:12:26', 1),
(172, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-09 08:53:15', 1),
(173, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-09 16:54:09', 1),
(174, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-10 12:04:36', 1),
(175, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-11 08:35:03', 1),
(176, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-11 13:58:25', 1),
(177, '::1', 'kipli@gmail.com', 3, '2021-07-11 14:27:23', 1),
(178, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-12 01:10:20', 1),
(179, '::1', 'kipli@gmail.com', 3, '2021-07-12 02:09:30', 1),
(180, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-12 02:34:13', 1),
(181, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-12 02:49:49', 1),
(182, '::1', 'kipli@gmail.com', 3, '2021-07-12 02:50:44', 1),
(183, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-12 02:51:40', 1),
(184, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-12 15:23:43', 1),
(185, '::1', 'kipli@gmail.com', 3, '2021-07-12 17:15:04', 1),
(186, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-12 23:55:33', 1),
(187, '::1', 'kipli@gmail.com', 3, '2021-07-13 00:29:36', 1),
(188, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-13 18:39:45', 1),
(189, '::1', 'kipli@gmail.com', 3, '2021-07-14 03:39:53', 1),
(190, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-14 03:45:44', 1),
(191, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-14 03:45:59', 1),
(192, '::1', 'kipli@gmail.com', 3, '2021-07-14 03:46:13', 1),
(193, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-14 03:48:41', 1),
(194, '::1', 'kipli@gmail.com', 3, '2021-07-14 03:48:57', 1),
(195, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-14 20:42:45', 1),
(196, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-15 16:32:05', 1),
(197, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-15 22:21:37', 1),
(198, '::1', 'kipli@gmail.com', 3, '2021-07-16 01:11:58', 1),
(199, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-16 01:13:00', 1),
(200, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-16 13:37:22', 1),
(201, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-16 19:57:11', 1),
(202, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-17 06:06:46', 1),
(203, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-17 21:39:21', 1),
(204, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-18 03:25:49', 1),
(205, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-18 14:51:50', 1),
(206, '::1', 'vigoalmuarif', NULL, '2021-07-18 21:11:24', 0),
(207, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-18 21:11:32', 1),
(208, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-19 16:23:53', 1),
(209, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-20 00:40:51', 1),
(210, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-21 16:36:29', 1),
(211, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-21 16:41:21', 1),
(212, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-21 22:59:02', 1),
(213, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-22 02:18:52', 1),
(214, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-22 16:25:09', 1),
(215, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-22 21:12:46', 1),
(216, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-22 23:18:58', 1),
(217, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-24 01:30:22', 1),
(218, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-24 21:45:07', 1),
(219, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-25 07:45:08', 1),
(220, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-25 14:44:36', 1),
(221, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-26 17:16:20', 1),
(222, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-27 16:28:23', 1),
(223, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-27 21:39:30', 1),
(224, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-28 11:04:11', 1),
(225, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-28 11:05:29', 1),
(226, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-28 20:48:45', 1),
(227, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-29 19:55:05', 1),
(228, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-30 06:10:37', 1),
(229, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-30 10:11:17', 1),
(230, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-31 14:20:13', 1),
(231, '::1', 'vigoalmuarif@gmail.com', 4, '2021-07-31 19:11:18', 1),
(232, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-02 01:40:26', 1),
(233, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-02 16:34:35', 1),
(234, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-02 23:09:06', 1),
(235, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-03 16:09:51', 1),
(236, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-03 21:03:12', 1),
(237, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-04 01:28:32', 1),
(238, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-04 15:24:57', 1),
(239, '::1', 'vigoalmuarif', NULL, '2021-08-06 09:05:53', 0),
(240, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-06 09:06:00', 1),
(241, '::1', 'vigoalmuarif@gmail.com', 4, '2021-08-06 17:10:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_atk`
--

CREATE TABLE `customer_atk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jk` enum('L','P','','') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_atk`
--

INSERT INTO `customer_atk` (`id`, `nama`, `jk`, `alamat`, `no_hp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Umum', 'L', '                  -', '-', '2021-07-03 22:53:35', '2021-07-29 22:53:35', '2021-07-22 22:53:35'),
(2, 'Restu Saputra', 'L', 'Suren, Tambakreja', '087441555662', '2021-07-08 01:10:50', '2021-07-29 01:10:50', '2021-07-22 01:10:50'),
(4, 'Sarwin Jr', 'L', 'Sidamukti', '085223665888', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Nita Rahmawati', 'P', ' Yogyakarta', '087554221639', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Tio', 'L', ' Bumireja', '085225654112', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Mey Wahyu', 'L', ' Suren', '087445121444', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Candra Akbar', 'P', '  Pasar Suren', '087665225888', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `faktur`
--

CREATE TABLE `faktur` (
  `id` int(11) NOT NULL,
  `faktur` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `pembuat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faktur`
--

INSERT INTO `faktur` (`id`, `faktur`, `jenis`, `pembuat`) VALUES
(75, 'PJ1807210001', 'Penjualan', 4),
(76, 'PJ1807210002', 'Penjualan', 4),
(81, 'PJ1807210003', 'Penjualan', 4),
(82, 'PJ1807210004', 'Penjualan', 4),
(83, 'PJ1807210005', 'Penjualan', 4),
(84, 'PJ1807210006', 'Penjualan', 4),
(86, 'PJ1807210007', 'Penjualan', 4),
(87, 'PJ1807210008', 'Penjualan', 4),
(88, 'PJ1807210009', 'Penjualan', 4),
(89, 'PJ1807210010', 'Penjualan', 4),
(90, 'PJ1907210001', 'Penjualan', 4),
(91, 'PJ1907210002', 'Penjualan', 4),
(92, 'PB2307210001', 'Pembelian', 4),
(94, 'PB2307210002', 'Pembelian', 4),
(95, 'PB2307210003', 'Pembelian', 4),
(96, 'PB2307210004', 'Pembelian', 4),
(97, 'PB2307210005', 'Pembelian', 4),
(98, 'PB2307210006', 'Pembelian', 4),
(100, 'PB2307210007', 'Pembelian', 4),
(101, 'PJ2307210001', 'Penjualan', 4),
(103, 'PJ2307210002', 'Penjualan', 4),
(104, 'PJ2307210003', 'Penjualan', 4),
(105, 'PJ2307210004', 'Penjualan', 4),
(106, 'PJ2307210005', 'Penjualan', 4),
(137, 'PB2307210008', 'Pembelian', 4),
(138, 'PJ2407210001', 'Penjualan', 4),
(139, 'PB2407210001', 'Pembelian', 4),
(141, 'PB2407210002', 'Pembelian', 4),
(142, 'PB2407210003', 'Pembelian', 4),
(143, 'PJ2407210002', 'Penjualan', 4),
(144, 'PB2407210004', 'Pembelian', 4),
(147, 'PB2407210005', 'Pembelian', 4),
(148, 'PJ2407210003', 'Penjualan', 4),
(149, 'PJ2407210004', 'Penjualan', 4),
(150, 'PJ2407210005', 'Penjualan', 4),
(151, 'PB2407210006', 'Pembelian', 4),
(152, 'PB2407210007', 'Pembelian', 4),
(153, 'PJ2507210001', 'Penjualan', 4),
(159, 'PJ2507210002', 'Penjualan', 4),
(160, 'PJ2507210003', 'Penjualan', 4),
(162, 'PB2507210001', 'Pembelian', 4),
(163, 'PB2507210002', 'Pembelian', 4),
(165, 'PB2507210003', 'Pembelian', 4),
(166, 'PB2507210004', 'Pembelian', 4),
(167, 'PJ2507210004', 'Penjualan', 4),
(168, 'PJ2507210005', 'Penjualan', 4),
(169, 'PJ2507210006', 'Penjualan', 4),
(170, 'PJ2507210007', 'Penjualan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama`) VALUES
(1, 'Ketua'),
(2, 'Bendahara'),
(3, 'Bendahara Umum'),
(4, 'Sekretaris'),
(5, 'Humas'),
(6, 'Anggota'),
(7, 'Petugas Parkir'),
(8, 'Petugas Pasar'),
(9, 'Petugas Fotocopy');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `lokasi`) VALUES
(1, 'selatan'),
(2, 'hall');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(4, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1619897344, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pedagang`
--

CREATE TABLE `pedagang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `jenis_kelamin` enum('L','P','','') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `jenis_usaha` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `expired` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pedagang`
--

INSERT INTO `pedagang` (`id`, `nama`, `nik`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `jenis_usaha`, `status`, `expired`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 'Agung Ade Saputra', '3301013008970002', 'L', 'Klaten', '1998-08-30', 'cilacap', '081325139066', 'sayuran', 1, '2054-08-05', '2021-05-24 03:55:41', '2021-06-30 20:33:14', NULL),
(13, 'Mei Wahyu', '3301013008970005', 'L', 'Cilacap', '1995-06-06', 'Bumireja, RT 03 RW 12, CILACAP', '081328696998', 'Pakaian', 0, NULL, '2021-06-03 04:51:57', '2021-06-26 03:39:33', NULL),
(14, 'Wisnu Aji Bintoro', '3301013008970001', 'P', 'Cilacap', '1974-06-27', 'Sidamukti RT 03 RW 12, Patimuan, CILACAP', '081325139066', 'Sayuran', 1, '2061-08-04', '2021-06-26 18:54:58', '2021-07-14 04:08:48', NULL),
(17, 'Nisa Ramadhani', '3301013008960001', 'P', 'Cilacap', '2021-07-29', 'Cinyawang', '081328696994', 'Pakaian', 0, NULL, '2021-07-31 19:30:02', '2021-07-31 19:30:02', NULL),
(18, 'Mey Resti Hidayah', '3301010108970001', 'P', 'Cilacap', '2021-07-09', 'Patimuan', '081328696551', 'Pakaian', 0, NULL, '2021-07-31 19:34:12', '2021-07-31 19:34:12', NULL),
(19, 'Kukuh Aji Pangestu', '3301010508970001', 'P', 'trtr', '2021-07-22', 'tr', '56546', 'rtfr', 0, NULL, '2021-07-31 20:12:38', '2021-07-31 20:12:38', NULL),
(20, 'jole', '3301013008970009', 'P', 're', '2021-07-27', 'esdfe', '45464', '363rdtgd', 0, NULL, '2021-07-31 20:18:38', '2021-07-31 20:18:38', NULL),
(23, 'Andri Setyawan', '3301013008970008', 'L', 'Cilacap', '1997-08-24', 'Semarang', '081328696994', 'Elektronik', 0, NULL, '2021-08-04 18:53:12', '2021-08-04 18:53:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_bulanan`
--

CREATE TABLE `pembayaran_bulanan` (
  `id` int(11) NOT NULL,
  `pedagang_id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bayar` int(255) NOT NULL,
  `tarif` int(11) NOT NULL,
  `metode` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran_bulanan`
--

INSERT INTO `pembayaran_bulanan` (`id`, `pedagang_id`, `periode_id`, `user_id`, `bayar`, `tarif`, `metode`, `created_at`, `updated_at`, `deleted_at`) VALUES
(188, 12, 168, 0, 0, 100000, '', '0000-00-00 00:00:00', NULL, NULL),
(189, 14, 168, 4, 400000, 400000, '', '2021-08-06 18:22:30', NULL, NULL),
(190, 14, 169, 4, 100000, 100000, '', '2021-08-06 18:19:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_retribusi`
--

CREATE TABLE `pembayaran_retribusi` (
  `id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `petugas_id` int(11) DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `retribusi_id` int(11) NOT NULL,
  `bayar` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_sewa`
--

CREATE TABLE `pembayaran_sewa` (
  `id` int(11) NOT NULL,
  `sewa_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `bayar` varchar(255) NOT NULL,
  `metode` enum('Transfer','Tunai','','') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran_sewa`
--

INSERT INTO `pembayaran_sewa` (`id`, `sewa_id`, `user_id`, `bayar`, `metode`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(100, 126, 4, '30000000', 'Transfer', '', '2021-08-04 19:04:34', NULL, NULL),
(105, 131, 4, '5000000', 'Transfer', '', '2021-08-04 19:21:05', NULL, NULL),
(106, 132, 4, '10000000', 'Transfer', '', '2021-08-04 19:21:50', NULL, NULL),
(107, 133, 4, '1000000', 'Transfer', '', '2021-08-04 19:22:17', NULL, NULL),
(108, 131, 4, '1000000', 'Tunai', '', '2021-08-04 19:31:42', NULL, NULL),
(109, 131, 4, '100000', 'Transfer', '', '2021-08-04 19:34:10', NULL, NULL),
(110, 134, 4, '20000000', 'Transfer', '', '2021-08-04 23:20:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `faktur_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `referensi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `pembayaran` enum('Tunai','Kredit','','') NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `faktur_id`, `total`, `bayar`, `supplier_id`, `referensi`, `keterangan`, `pembayaran`, `created_at`, `updated_at`) VALUES
(11, 139, 300000, 300000, 7, 'B/213/SHB/VII//2021', 'LUNAS', 'Tunai', '2021-07-24', '2021-07-24 02:26:18'),
(13, 141, 1000000, 1000000, 1, '', 'lunas', 'Tunai', '2021-07-24', '2021-07-24 02:29:45'),
(14, 142, 1250000, 1250000, 1, '', 'lunas', 'Tunai', '2021-07-24', '2021-07-24 03:24:14'),
(15, 144, 3000000, 3000000, 2, '', 'lunas', 'Tunai', '2021-07-24', '2021-07-24 10:34:05'),
(18, 147, 6000000, 6000000, NULL, '', '', 'Tunai', '2021-07-24', '2021-07-24 10:40:56'),
(19, 151, 2500000, 100000, NULL, '', '', 'Kredit', '2021-07-24', '2021-07-24 22:01:15'),
(20, 152, 500000, 500000, 1, '', '', 'Tunai', '2021-07-24', '2021-07-24 23:37:01'),
(22, 162, 5000000, 5000000, NULL, '', '', 'Tunai', '2021-07-25', '2021-07-25 10:28:40'),
(23, 163, 1000000, 500000, 8, '12/08/BP/VII/2021', 'Piutang', 'Kredit', '2021-07-25', '2021-07-25 10:40:04'),
(24, 165, 200000, 200000, NULL, '', '', 'Tunai', '2021-07-25', '2021-07-25 14:46:16'),
(25, 166, 400000, 100000, NULL, '', '', 'Kredit', '2021-07-25', '2021-07-25 14:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id` int(11) NOT NULL,
  `pembelian_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id`, `pembelian_id`, `produk_id`, `harga`, `qty`, `sub_total`, `keterangan`) VALUES
(5, 11, 35, 170000, 2, 300000, 'kondisi baik'),
(7, 13, 36, 150000, 10, 1000000, 'Kondisi Baik'),
(8, 14, 35, 170000, 5, 750000, ''),
(9, 14, 36, 150000, 5, 500000, ''),
(10, 15, 39, 150000, 5, 500000, NULL),
(11, 15, 40, 170000, 10, 1500000, NULL),
(12, 15, 41, 250000, 5, 1000000, NULL),
(15, 18, 42, 150000, 50, 6000000, NULL),
(16, 19, 36, 150000, 5, 500000, ''),
(17, 19, 40, 170000, 10, 1500000, ''),
(18, 19, 39, 150000, 5, 500000, ''),
(19, 20, 43, 30000, 20, 500000, NULL),
(21, 22, 44, 600000, 10, 5000000, NULL),
(22, 23, 39, 150000, 10, 1000000, 'lunas'),
(23, 24, 41, 250000, 1, 200000, ''),
(24, 25, 42, 150000, 2, 240000, ''),
(25, 25, 45, 100000, 2, 160000, '');

--
-- Triggers `pembelian_detail`
--
DELIMITER $$
CREATE TRIGGER `tg_after_insert_pembelian` AFTER INSERT ON `pembelian_detail` FOR EACH ROW BEGIN

UPDATE produk
SET 
stok = stok + new.qty,
stok_in = stok_in + new.qty
WHERE id = new.produk_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_temp`
--

CREATE TABLE `pembelian_temp` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `faktur_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total` varchar(255) NOT NULL,
  `bayar` int(11) NOT NULL,
  `pembayaran` enum('Tunai','Kredit','','') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `faktur_id`, `customer_id`, `total`, `bayar`, `pembayaran`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(108, 138, 1, '340000', 350000, 'Tunai', '', '2021-07-24 00:00:00', '2021-07-24 02:23:21', NULL),
(109, 143, 1, '640000', 650000, 'Tunai', '', '2021-07-24 00:00:00', '2021-07-24 03:24:56', NULL),
(110, 148, 1, '1240000', 1240000, 'Tunai', '', '2021-07-24 00:00:00', '2021-07-24 14:42:51', NULL),
(111, 149, 1, '1740000', 1740000, 'Tunai', '', '2021-07-24 00:00:00', '2021-07-24 14:48:25', NULL),
(112, 150, 1, '1920000', 1920000, 'Tunai', '', '2021-07-24 00:00:00', '2021-07-24 14:52:35', NULL),
(113, 153, 1, '1500000', 1500000, 'Tunai', '', '2021-07-25 00:00:00', '2021-07-25 08:57:12', NULL),
(119, 159, 1, '170000', 170000, 'Tunai', '', '2021-07-25 00:00:00', '2021-07-25 10:16:10', NULL),
(120, 160, 1, '490000', 490000, 'Tunai', '', '2021-07-25 00:00:00', '2021-07-25 10:16:40', NULL),
(121, 167, 1, '1540000', 1540000, '', '', '2021-07-25 00:00:00', '2021-07-25 14:50:32', NULL),
(122, 168, 4, '170000', 0, '', '', '2021-07-25 00:00:00', '2021-07-25 14:57:32', NULL),
(123, 169, 1, '170000', 170000, 'Tunai', '', '2021-07-25 00:00:00', '2021-07-25 14:59:33', NULL),
(124, 170, 2, '340000', 0, 'Kredit', '', '2021-07-25 00:00:00', '2021-07-25 14:59:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` int(11) NOT NULL,
  `penjualan_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `penjualan_id`, `produk_id`, `harga`, `qty`, `sub_total`) VALUES
(83, 108, 35, 170000, 2, 340000),
(84, 109, 36, 150000, 2, 300000),
(85, 109, 35, 170000, 2, 340000),
(86, 110, 39, 150000, 5, 750000),
(87, 110, 42, 150000, 1, 150000),
(88, 110, 40, 170000, 2, 340000),
(89, 111, 41, 250000, 5, 1250000),
(90, 111, 42, 150000, 1, 150000),
(91, 111, 40, 170000, 2, 340000),
(92, 112, 40, 170000, 6, 1020000),
(93, 112, 36, 150000, 4, 600000),
(94, 112, 42, 150000, 2, 300000),
(95, 113, 39, 150000, 10, 1500000),
(101, 119, 35, 170000, 1, 170000),
(102, 120, 35, 170000, 2, 340000),
(103, 120, 36, 150000, 1, 150000),
(104, 121, 35, 170000, 2, 340000),
(105, 121, 44, 600000, 2, 1200000),
(106, 122, 35, 170000, 1, 170000),
(107, 123, 35, 170000, 1, 170000),
(108, 124, 35, 170000, 2, 340000);

--
-- Triggers `penjualan_detail`
--
DELIMITER $$
CREATE TRIGGER `tg_after_insert_penjualan` AFTER INSERT ON `penjualan_detail` FOR EACH ROW BEGIN
UPDATE produk 
SET stok = stok - new.qty,
stok_out = stok_out + new.qty
WHERE id = new.produk_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_temp`
--

CREATE TABLE `penjualan_temp` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `periode_bulanan`
--

CREATE TABLE `periode_bulanan` (
  `id` int(11) NOT NULL,
  `periode` varchar(255) NOT NULL,
  `tarif` varchar(255) NOT NULL,
  `jenis` varchar(11) NOT NULL,
  `total` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periode_bulanan`
--

INSERT INTO `periode_bulanan` (`id`, `periode`, `tarif`, `jenis`, `total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(168, '2021-08-01', '100000', 'Semua', '500000', '2021-08-04 23:55:59', NULL, NULL),
(169, '2021-09-01', '100000', 'Kios', '100000', '2021-08-06 09:19:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `periode_retribusi`
--

CREATE TABLE `periode_retribusi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periode_retribusi`
--

INSERT INTO `periode_retribusi` (`id`, `tanggal`, `total`) VALUES
(31, '2021-06-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P','','') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `jabatan_id`, `nik`, `nama`, `alamat`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `no_hp`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 7, '3301013008970001', 'Wisnu Aji Bintoro', '', 'L', 'Cilacap', '0000-00-00', '081325139066', 1, '2021-06-29 06:22:45', '2021-06-29 06:22:45', NULL),
(9, 8, '3301013008970002', 'Mei Wahyu', '', 'L', 'Cilacap', '0000-00-00', '081325139066', 1, '2021-06-29 06:23:22', '2021-06-29 06:23:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_in` int(11) NOT NULL,
  `stok_out` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `satuan_id` int(255) NOT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `sku`, `kategori_id`, `stok`, `stok_in`, `stok_out`, `supplier_id`, `nama`, `satuan_id`, `harga_beli`, `harga_jual`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(35, '11112', 'DP0012', 67, 14, 27, 13, 1, 'Dispenser Cosmos LO3', 1, '150000', '170000', '', '2021-07-24 02:21:33', '2021-07-25 08:14:20', NULL),
(36, NULL, 'KA001', 66, 18, 25, 7, NULL, 'Kipas Angin Dinding Maspion', 1, '100000', '150000', '', '2021-07-24 02:22:19', NULL, NULL),
(39, NULL, 'KA002', 66, 0, 25, 25, 8, 'Kipas Angin Berdiri Miyako L907', 1, '100000', '150000', 'lunas', '2021-07-24 09:10:08', NULL, NULL),
(40, NULL, 'PB001', 78, 10, 25, 15, NULL, 'Power Bank Robot 10.000 mAh RT-002', 1, '150000', '170000', '', '2021-07-24 09:23:44', NULL, NULL),
(41, '1221', 'PB002', 78, 16, 21, 5, NULL, 'PowerBank Robot 20.000 MAH RB-90T', 1, '200000', '250000', '', '2021-07-24 09:25:12', NULL, NULL),
(42, NULL, 'PB003', 78, 48, 52, 4, NULL, 'PB Vivan 15.000 Mah K-M50', 1, '120000', '150000', '', '2021-07-24 10:37:02', NULL, NULL),
(43, NULL, 'KU001', 79, 20, 20, 0, 1, 'Kabel USB Type C Vivan B-GH9', 1, '25000', '30000', '', '2021-07-24 23:34:31', NULL, NULL),
(44, NULL, 'HDD001', 80, 33, 35, 2, NULL, 'Harddisk Seagate Plus 1000GB ', 1, '500000', '600000', '', '2021-07-24 23:45:15', NULL, NULL),
(45, '11111', 'MS001', 81, 14, 14, 0, NULL, 'Mouse Logitech M150', 1, '80000', '100000', '', '2021-07-25 08:27:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk_kategori`
--

CREATE TABLE `produk_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk_kategori`
--

INSERT INTO `produk_kategori` (`id`, `nama`) VALUES
(1, 'buku'),
(2, 'Alat Tulis'),
(3, 'Kertas'),
(64, 'Spidol'),
(65, 'Tali'),
(66, 'Kipas Angin'),
(67, 'Dispenser'),
(68, 'anu'),
(69, 'hmm'),
(70, 'hehee'),
(71, 'testsssss'),
(72, 'yaya'),
(73, 're'),
(74, 'jemm'),
(75, 'Cahyo Vigo Al Mu Arif'),
(76, 'siapa'),
(77, 'tambah'),
(78, 'PowerBank'),
(79, 'Kabel USB'),
(80, 'Memory'),
(81, 'Mouse');

-- --------------------------------------------------------

--
-- Table structure for table `produk_satuan`
--

CREATE TABLE `produk_satuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk_satuan`
--

INSERT INTO `produk_satuan` (`id`, `nama`) VALUES
(1, 'pcs'),
(3, 'Lembar'),
(4, 'Rim'),
(5, 'Buah'),
(14, 'Box'),
(16, 'ton'),
(17, 'test'),
(18, 'kg'),
(19, 'ons'),
(20, 'item'),
(21, 'hahhehe'),
(22, 'angel'),
(23, 'KG');

-- --------------------------------------------------------

--
-- Table structure for table `produk_stok`
--

CREATE TABLE `produk_stok` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `type` enum('in','out','','') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `faktur_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk_stok`
--

INSERT INTO `produk_stok` (`id`, `produk_id`, `qty`, `type`, `keterangan`, `user_id`, `faktur_id`, `created_at`) VALUES
(204, 35, 20, 'in', 'stok awal, manual', 4, 0, '2021-07-24 02:21:33'),
(205, 36, 5, 'in', 'stok awal, manual', 4, 0, '2021-07-24 02:22:19'),
(206, 35, 2, 'out', 'Penjualan', 0, 0, '2021-07-24 02:23:21'),
(207, 35, 2, 'in', 'Pembelian', 0, 0, '0000-00-00 00:00:00'),
(209, 36, 10, 'in', 'Pembelian', 0, 0, '0000-00-00 00:00:00'),
(210, 35, 5, 'in', 'Pembelian', 0, 0, '0000-00-00 00:00:00'),
(211, 36, 5, 'in', 'Pembelian', 0, 0, '0000-00-00 00:00:00'),
(212, 36, 2, 'out', 'Penjualan', 0, 0, '2021-07-24 03:24:56'),
(213, 35, 2, 'out', 'Penjualan', 0, 0, '2021-07-24 03:24:56'),
(214, 39, 5, 'in', 'Pembelian', 0, 0, '2021-07-24 10:34:05'),
(215, 40, 10, 'in', 'Pembelian', 0, 0, '2021-07-24 10:34:05'),
(216, 41, 5, 'in', 'Pembelian', 0, 0, '2021-07-24 10:34:05'),
(219, 42, 50, 'in', 'Pembelian', 0, 0, '2021-07-24 10:40:56'),
(220, 39, 5, 'out', 'Penjualan', 0, 0, '2021-07-24 14:42:51'),
(221, 42, 1, 'out', 'Penjualan', 0, 0, '2021-07-24 14:42:51'),
(222, 40, 2, 'out', 'Penjualan', 0, 0, '2021-07-24 14:42:51'),
(223, 41, 5, 'out', 'Penjualan', 0, 0, '2021-07-24 14:48:25'),
(224, 42, 1, 'out', 'Penjualan', 0, 0, '2021-07-24 14:48:25'),
(225, 40, 2, 'out', 'Penjualan', 0, 0, '2021-07-24 14:48:25'),
(226, 40, 6, 'out', 'Penjualan', 0, 0, '2021-07-24 14:52:35'),
(227, 36, 4, 'out', 'Penjualan', 0, 0, '2021-07-24 14:52:35'),
(228, 42, 2, 'out', 'Penjualan', 0, 0, '2021-07-24 14:52:35'),
(229, 36, 5, 'in', 'Pembelian', 0, 0, '2021-07-24 22:01:15'),
(230, 40, 10, 'in', 'Pembelian', 0, 0, '2021-07-24 22:01:15'),
(231, 39, 5, 'in', 'Pembelian', 0, 0, '2021-07-24 22:01:15'),
(232, 43, 20, 'in', 'Pembelian', 0, 0, '2021-07-24 23:37:01'),
(233, 44, 5, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:15:43'),
(234, 44, 5, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:15:48'),
(235, 44, 10, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:16:00'),
(236, 41, 5, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:22:56'),
(237, 41, 5, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:24:10'),
(238, 41, 2, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:24:59'),
(239, 41, 3, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:28:24'),
(240, 39, 5, 'in', 'penambahan manual', 4, 0, '2021-07-25 03:49:19'),
(241, 45, 10, 'in', 'stok awal, manual', 4, 0, '2021-07-25 08:27:36'),
(242, 45, 2, 'in', 'bonus', 4, 0, '2021-07-25 08:38:49'),
(243, 39, 10, 'out', 'Penjualan', 0, 0, '2021-07-25 08:57:12'),
(244, 40, 5, 'out', 'rusak', 4, 0, '2021-07-25 09:33:44'),
(245, 35, 1, 'out', 'Penjualan/PJ2507210002', 4, 0, '2021-07-25 10:16:10'),
(246, 35, 2, 'out', 'Penjualan/PJ2507210003', 4, 0, '2021-07-25 10:16:40'),
(247, 36, 1, 'out', 'Penjualan/PJ2507210003', 4, 0, '2021-07-25 10:16:40'),
(248, 44, 10, 'in', 'Pembelian/PB2507210001', 4, 0, '2021-07-25 10:28:40'),
(249, 44, 5, 'in', 'Bonus', 4, 0, '2021-07-25 10:29:56'),
(250, 40, 5, 'in', 'hadiah', 4, 0, '2021-07-25 10:31:03'),
(251, 39, 10, 'in', 'Pembelian/PB2507210002', 4, 0, '2021-07-25 10:40:04'),
(252, 41, 1, 'in', 'Pembelian/PB2507210003', 4, 0, '2021-07-25 14:46:16'),
(253, 42, 2, 'in', 'Pembelian/PB2507210004', 4, 0, '2021-07-25 14:47:08'),
(254, 45, 2, 'in', 'Pembelian/PB2507210004', 4, 0, '2021-07-25 14:47:08'),
(255, 35, 2, 'out', 'Penjualan/PJ2507210004', 4, 0, '2021-07-25 14:50:32'),
(256, 44, 2, 'out', 'Penjualan/PJ2507210004', 4, 0, '2021-07-25 14:50:32'),
(257, 35, 1, 'out', 'Penjualan/PJ2507210005', 4, 0, '2021-07-25 14:57:32'),
(258, 35, 1, 'out', 'Penjualan/PJ2507210006', 4, 0, '2021-07-25 14:59:33'),
(259, 35, 2, 'out', 'Penjualan/PJ2507210007', 4, 0, '2021-07-25 14:59:56'),
(260, 39, 10, 'out', 'hilang', 4, 0, '2021-07-26 17:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `produk_supplier`
--

CREATE TABLE `produk_supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk_supplier`
--

INSERT INTO `produk_supplier` (`id`, `nama`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'Pena', 'Sidareja', '081328696994', NULL, NULL),
(2, 'Matahari Pintar', 'Sidareja', '081328696554', NULL, NULL),
(7, 'Sahabat ', 'cilacap', '081325139066', '2021-07-08 18:21:17', NULL),
(8, 'Buku Pintar', 'Cilacap Barat', '081658444112', '2021-07-24 11:23:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `property_id` int(11) NOT NULL,
  `kode_property` varchar(20) NOT NULL,
  `jenis_property` varchar(50) NOT NULL,
  `luas_tanah` varchar(20) NOT NULL,
  `luas_bangunan` varchar(20) NOT NULL,
  `sertifikat` varchar(255) NOT NULL,
  `fasilitas` varchar(255) NOT NULL,
  `harga` varchar(25) NOT NULL,
  `status` int(50) NOT NULL DEFAULT 0,
  `jangka` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT 'store.png',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`property_id`, `kode_property`, `jenis_property`, `luas_tanah`, `luas_bangunan`, `sertifikat`, `fasilitas`, `harga`, `status`, `jangka`, `alamat`, `gambar`, `keterangan`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KS-0001', 'Kios', '4 x 5', '3,5 x 4', 'SHM', 'Estalase, kursi, ac', '33000000', 0, 40, 'fd', 'default.png', 'Masih tersedia gan', NULL, NULL, '2021-04-30 21:51:13', '2021-06-30 20:33:14', NULL),
(2, 'KS-0002', 'Kios', '4 X 5', '3 X 4', 'SHM', 'kasur, ac, almari, estales', '30000000', 1, 40, 'gdd', 'store.png', 'ready gan', NULL, NULL, '2021-04-30 14:51:20', '2021-06-23 23:50:00', NULL),
(3, 'LP-0001', 'Los', '4 X 5', '3 X 4', 'SHM', 'Tempat tidur, kamar mandi', '25000000', 0, 30, 'jalan cisumur, Bumireja, kedungreja', 'store.png', '', NULL, NULL, '2021-04-30 15:02:52', '2021-06-26 03:39:03', NULL),
(4, 'LP-0003', 'Los', '4 X 5', '3 X 4', 'SHM', 'Tempat tidur, kamar mandi', '25000000', 0, 33, 'jalan cisumur, Bumireja, kedungreja', 'store.png', '', NULL, NULL, '2021-04-30 15:03:45', '2021-06-26 03:39:33', NULL),
(15, 'LP-0007', 'Los', '4 X 5', '3 X 5', 'SHM', 'Tempat tidur, kamar mandi', '30000000', 0, 30, 'jalan cisumur, Bumireja, kedungreja', 'store.png', '', NULL, NULL, '2021-05-10 02:38:50', '2021-06-23 23:06:52', NULL),
(31, 'LP-0002', 'Los', '4 X 6', '4 X 5', 'SKM', 'Tempat tidur, kamar mandi', '20000000', 0, 20, 'Pasar Bumireja', 'store.png', '', NULL, NULL, '2021-07-08 20:08:35', '2021-07-08 20:09:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `retribusi`
--

CREATE TABLE `retribusi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `retribusi`
--

INSERT INTO `retribusi` (`id`, `nama`) VALUES
(11, 'Parkir 1'),
(12, 'Parkir 2'),
(13, 'Parkir 3'),
(14, 'Parkir 4'),
(15, 'Pasar');

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `pedagang_id` int(11) NOT NULL,
  `no_transaksi` varchar(255) NOT NULL,
  `property_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tanggal_sewa` date DEFAULT NULL,
  `tanggal_batas` date DEFAULT NULL,
  `jenis_pembayaran` enum('Tunai','Kredit','','') NOT NULL,
  `status` enum('Aktif','Selesai','Terlambat','') NOT NULL DEFAULT 'Aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id`, `user_id`, `pedagang_id`, `no_transaksi`, `property_id`, `harga`, `total_bayar`, `tanggal_sewa`, `tanggal_batas`, `jenis_pembayaran`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(126, 4, 14, 'SP040820210001', 15, 30000000, 30000000, '2021-08-04', '2051-08-04', 'Tunai', 'Aktif', '2021-08-04 19:04:34', NULL, NULL),
(131, 4, 14, 'SP040820210002', 31, 20000000, 6100000, '2021-08-04', '2041-08-04', 'Tunai', 'Aktif', '2021-08-04 19:21:05', '2021-08-04 19:34:10', NULL),
(132, 4, 14, 'SP040820210003', 1, 33000000, 10000000, '2021-08-04', '2061-08-04', 'Tunai', 'Aktif', '2021-08-04 19:21:50', NULL, NULL),
(133, 4, 14, 'SP040820210004', 3, 25000000, 1000000, '2021-08-04', '2051-08-04', 'Tunai', 'Aktif', '2021-08-04 19:22:17', NULL, NULL),
(134, 4, 12, 'SP040820210005', 4, 25000000, 20000000, '2021-08-05', '2054-08-05', 'Tunai', 'Aktif', '2021-08-04 23:20:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sewa_item`
--

CREATE TABLE `sewa_item` (
  `id` int(11) NOT NULL,
  `sewa_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `fullName`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'kipli@gmail.com', 'kipli', '$2y$10$3bZBiez6aZOu3UPcMcUXiuLkko54Q73HCysnECPdRgSLYy4dEpjXO', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-05-02 03:05:55', '2021-05-02 03:05:55', NULL),
(4, 'vigoalmuarif@gmail.com', 'vigoalmuarif', '$2y$10$3bZBiez6aZOu3UPcMcUXiuLkko54Q73HCysnECPdRgSLYy4dEpjXO', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-05-02 03:07:19', '2021-05-02 03:07:19', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `customer_atk`
--
ALTER TABLE `customer_atk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedagang`
--
ALTER TABLE `pedagang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_bulanan`
--
ALTER TABLE `pembayaran_bulanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sewa_id` (`pedagang_id`,`periode_id`),
  ADD KEY `pembayaran_bulanan_ibfk_2` (`periode_id`);

--
-- Indexes for table `pembayaran_retribusi`
--
ALTER TABLE `pembayaran_retribusi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retribusi_id` (`periode_id`),
  ADD KEY `bayar` (`bayar`),
  ADD KEY `petugas_id` (`petugas_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `retribusi_id_2` (`retribusi_id`);

--
-- Indexes for table `pembayaran_sewa`
--
ALTER TABLE `pembayaran_sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sewa_id` (`sewa_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_temp`
--
ALTER TABLE `pembelian_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`customer_id`),
  ADD KEY `faktur_id` (`faktur_id`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `penjualan_id` (`penjualan_id`);

--
-- Indexes for table `penjualan_temp`
--
ALTER TABLE `penjualan_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `periode_bulanan`
--
ALTER TABLE `periode_bulanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis` (`jenis`);

--
-- Indexes for table `periode_retribusi`
--
ALTER TABLE `periode_retribusi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `stok_id` (`stok`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `satuan_id` (`satuan_id`);

--
-- Indexes for table `produk_kategori`
--
ALTER TABLE `produk_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_satuan`
--
ALTER TABLE `produk_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_stok`
--
ALTER TABLE `produk_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`) USING BTREE;

--
-- Indexes for table `produk_supplier`
--
ALTER TABLE `produk_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`property_id`);

--
-- Indexes for table `retribusi`
--
ALTER TABLE `retribusi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`pedagang_id`),
  ADD KEY `sewa_ibfk_2` (`pedagang_id`);

--
-- Indexes for table `sewa_item`
--
ALTER TABLE `sewa_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_atk`
--
ALTER TABLE `customer_atk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `faktur`
--
ALTER TABLE `faktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pedagang`
--
ALTER TABLE `pedagang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pembayaran_bulanan`
--
ALTER TABLE `pembayaran_bulanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `pembayaran_retribusi`
--
ALTER TABLE `pembayaran_retribusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `pembayaran_sewa`
--
ALTER TABLE `pembayaran_sewa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pembelian_temp`
--
ALTER TABLE `pembelian_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `penjualan_temp`
--
ALTER TABLE `penjualan_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=392;

--
-- AUTO_INCREMENT for table `periode_bulanan`
--
ALTER TABLE `periode_bulanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `periode_retribusi`
--
ALTER TABLE `periode_retribusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `produk_kategori`
--
ALTER TABLE `produk_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `produk_satuan`
--
ALTER TABLE `produk_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `produk_stok`
--
ALTER TABLE `produk_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `produk_supplier`
--
ALTER TABLE `produk_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `retribusi`
--
ALTER TABLE `retribusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `sewa_item`
--
ALTER TABLE `sewa_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran_retribusi`
--
ALTER TABLE `pembayaran_retribusi`
  ADD CONSTRAINT `pembayaran_retribusi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_retribusi_ibfk_4` FOREIGN KEY (`periode_id`) REFERENCES `periode_retribusi` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_retribusi_ibfk_5` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_retribusi_ibfk_6` FOREIGN KEY (`retribusi_id`) REFERENCES `retribusi` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_atk` (`id`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`faktur_id`) REFERENCES `faktur` (`id`);

--
-- Constraints for table `petugas`
--
ALTER TABLE `petugas`
  ADD CONSTRAINT `petugas_ibfk_1` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `produk_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_ibfk_3` FOREIGN KEY (`satuan_id`) REFERENCES `produk_satuan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `produk_supplier` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `produk_stok`
--
ALTER TABLE `produk_stok`
  ADD CONSTRAINT `produk_stok_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
