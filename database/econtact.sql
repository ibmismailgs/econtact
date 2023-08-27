-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2023 at 04:31 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `econtact`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_sources`
--

CREATE TABLE `client_sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `thana_id` bigint(20) UNSIGNED NOT NULL,
  `client_source_id` bigint(20) UNSIGNED NOT NULL,
  `customer_category_id` bigint(20) UNSIGNED NOT NULL,
  `customer_type_id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primary_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_categories`
--

CREATE TABLE `customer_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_types`
--

CREATE TABLE `customer_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name`, `bn_name`, `lat`, `lon`, `url`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Comilla', 'কুমিল্লা', '23.4682747', '91.1788135', 'www.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Feni', 'ফেনী', '23.023231', '91.3840844', 'www.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', '23.9570904', '91.1119286', 'www.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 'Rangamati', 'রাঙ্গামাটি', NULL, NULL, 'www.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 'Noakhali', 'নোয়াখালী', '22.869563', '91.099398', 'www.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'Chandpur', 'চাঁদপুর', '23.2332585', '90.6712912', 'www.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'Lakshmipur', 'লক্ষ্মীপুর', '22.942477', '90.841184', 'www.lakshmipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'Chattogram', 'চট্টগ্রাম', '22.335109', '91.834073', 'www.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'Coxsbazar', 'কক্সবাজার', NULL, NULL, 'www.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'Khagrachhari', 'খাগড়াছড়ি', '23.119285', '91.984663', 'www.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Bandarban', 'বান্দরবান', '22.1953275', '92.2183773', 'www.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 2, 'Sirajganj', 'সিরাজগঞ্জ', '24.4533978', '89.7006815', 'www.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 2, 'Pabna', 'পাবনা', '23.998524', '89.233645', 'www.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 2, 'Bogura', 'বগুড়া', '24.8465228', '89.377755', 'www.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2, 'Rajshahi', 'রাজশাহী', NULL, NULL, 'www.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, 'Natore', 'নাটোর', '24.420556', '89.000282', 'www.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2, 'Joypurhat', 'জয়পুরহাট', NULL, NULL, 'www.joypurhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 2, 'Chapainawabganj', 'চাঁপাইনবাবগঞ্জ', '24.5965034', '88.2775122', 'www.chapainawabganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 2, 'Naogaon', 'নওগাঁ', NULL, NULL, 'www.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 3, 'Jashore', 'যশোর', '23.16643', '89.2081126', 'www.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 3, 'Satkhira', 'সাতক্ষীরা', NULL, NULL, 'www.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 3, 'Meherpur', 'মেহেরপুর', '23.762213', '88.631821', 'www.meherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 3, 'Narail', 'নড়াইল', '23.172534', '89.512672', 'www.narail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 3, 'Chuadanga', 'চুয়াডাঙ্গা', '23.6401961', '88.841841', 'www.chuadanga.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 3, 'Kushtia', 'কুষ্টিয়া', '23.901258', '89.120482', 'www.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 3, 'Magura', 'মাগুরা', '23.487337', '89.419956', 'www.magura.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 3, 'Khulna', 'খুলনা', '22.815774', '89.568679', 'www.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 3, 'Bagerhat', 'বাগেরহাট', '22.651568', '89.785938', 'www.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 3, 'Jhenaidah', 'ঝিনাইদহ', '23.5448176', '89.1539213', 'www.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 4, 'Jhalakathi', 'ঝালকাঠি', NULL, NULL, 'www.jhalakathi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 4, 'Patuakhali', 'পটুয়াখালী', '22.3596316', '90.3298712', 'www.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 4, 'Pirojpur', 'পিরোজপুর', NULL, NULL, 'www.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 4, 'Barisal', 'বরিশাল', NULL, NULL, 'www.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 4, 'Bhola', 'ভোলা', '22.685923', '90.648179', 'www.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 4, 'Barguna', 'বরগুনা', NULL, NULL, 'www.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 5, 'Sylhet', 'সিলেট', '24.8897956', '91.8697894', 'www.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 5, 'Moulvibazar', 'মৌলভীবাজার', '24.482934', '91.777417', 'www.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 5, 'Habiganj', 'হবিগঞ্জ', '24.374945', '91.41553', 'www.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 5, 'Sunamganj', 'সুনামগঞ্জ', '25.0658042', '91.3950115', 'www.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 6, 'Narsingdi', 'নরসিংদী', '23.932233', '90.71541', 'www.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 6, 'Gazipur', 'গাজীপুর', '24.0022858', '90.4264283', 'www.gazipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 6, 'Shariatpur', 'শরীয়তপুর', NULL, NULL, 'www.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 6, 'Narayanganj', 'নারায়ণগঞ্জ', '23.63366', '90.496482', 'www.narayanganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 6, 'Tangail', 'টাঙ্গাইল', NULL, NULL, 'www.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 6, 'Kishoreganj', 'কিশোরগঞ্জ', '24.444937', '90.776575', 'www.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 6, 'Manikganj', 'মানিকগঞ্জ', NULL, NULL, 'www.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 6, 'Dhaka', 'ঢাকা', '23.7115253', '90.4111451', 'www.dhaka.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 6, 'Munshiganj', 'মুন্সিগঞ্জ', NULL, NULL, 'www.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 6, 'Rajbari', 'রাজবাড়ী', '23.7574305', '89.6444665', 'www.rajbari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 6, 'Madaripur', 'মাদারীপুর', '23.164102', '90.1896805', 'www.madaripur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 6, 'Gopalganj', 'গোপালগঞ্জ', '23.0050857', '89.8266059', 'www.gopalganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 6, 'Faridpur', 'ফরিদপুর', '23.6070822', '89.8429406', 'www.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 7, 'Panchagarh', 'পঞ্চগড়', '26.3411', '88.5541606', 'www.panchagarh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 7, 'Dinajpur', 'দিনাজপুর', '25.6217061', '88.6354504', 'www.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 7, 'Lalmonirhat', 'লালমনিরহাট', NULL, NULL, 'www.lalmonirhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 7, 'Nilphamari', 'নীলফামারী', '25.931794', '88.856006', 'www.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 7, 'Gaibandha', 'গাইবান্ধা', '25.328751', '89.528088', 'www.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 7, 'Thakurgaon', 'ঠাকুরগাঁও', '26.0336945', '88.4616834', 'www.thakurgaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 7, 'Rangpur', 'রংপুর', '25.7558096', '89.244462', 'www.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 7, 'Kurigram', 'কুড়িগ্রাম', '25.805445', '89.636174', 'www.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 8, 'Sherpur', 'শেরপুর', '25.0204933', '90.0152966', 'www.sherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 8, 'Mymensingh', 'ময়মনসিংহ', NULL, NULL, 'www.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 8, 'Jamalpur', 'জামালপুর', '24.937533', '89.937775', 'www.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 8, 'Netrokona', 'নেত্রকোণা', '24.870955', '90.727887', 'www.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `bn_name`, `url`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chattagram', 'চট্টগ্রাম', 'www.chittagongdiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Rajshahi', 'রাজশাহী', 'www.rajshahidiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Khulna', 'খুলনা', 'www.khulnadiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Barisal', 'বরিশাল', 'www.barisaldiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Sylhet', 'সিলেট', 'www.sylhetdiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Dhaka', 'ঢাকা', 'www.dhakadiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Rangpur', 'রংপুর', 'www.rangpurdiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Mymensingh', 'ময়মনসিংহ', 'www.mymensinghdiv.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map` longtext COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `meeting_type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `reschedule_date` date DEFAULT NULL,
  `time` time NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `is_reschedule` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 = Yes | 0 = No',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_types`
--

CREATE TABLE `meeting_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(160, '2023_06_11_113311_create_mettings_table', 3),
(230, '2014_10_12_000000_create_users_table', 4),
(231, '2014_10_12_100000_create_password_resets_table', 4),
(232, '2016_06_01_000001_create_oauth_auth_codes_table', 4),
(233, '2016_06_01_000002_create_oauth_access_tokens_table', 4),
(234, '2016_06_01_000003_create_oauth_refresh_tokens_table', 4),
(235, '2016_06_01_000004_create_oauth_clients_table', 4),
(236, '2016_06_01_000005_create_oauth_personal_access_clients_table', 4),
(237, '2019_08_19_000000_create_failed_jobs_table', 4),
(238, '2020_03_09_135529_create_permission_tables', 4),
(239, '2023_06_10_055327_create_general_settings_table', 4),
(240, '2023_06_10_065806_create_divisions_table', 4),
(241, '2023_06_10_065833_create_districts_table', 4),
(242, '2023_06_10_065844_create_thanas_table', 4),
(243, '2023_06_11_095620_create_client_sources_table', 4),
(244, '2023_06_11_095649_create_customer_categories_table', 4),
(245, '2023_06_11_095658_create_customer_types_table', 4),
(246, '2023_06_11_100047_create_outlets_table', 4),
(247, '2023_06_11_100200_create_meeting_types_table', 4),
(248, '2023_06_11_100228_create_quotation_types_table', 4),
(249, '2023_06_11_114841_create_customers_table', 4),
(250, '2023_06_11_115325_create_meetings_table', 4),
(251, '2023_06_11_115547_create_s_m_s_table', 4),
(252, '2023_06_11_120027_create_quotations_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE `outlets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'manage_role', 'web', NULL, NULL),
(3, 'manage_permission', 'web', NULL, NULL),
(4, 'manage_user', 'web', NULL, NULL),
(5, 'manage_sales', 'web', NULL, NULL),
(6, 'manage_projects', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `quotation_type_id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` bigint(20) UNSIGNED NOT NULL,
  `quotation_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_types`
--

CREATE TABLE `quotation_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', NULL, NULL),
(2, 'Admin', 'web', NULL, NULL),
(3, 'Project Manager', 'web', NULL, NULL),
(4, 'Sales Manager', 'web', NULL, NULL),
(5, 'Member', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 2),
(5, 2),
(6, 2),
(6, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `s_m_s`
--

CREATE TABLE `s_m_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 = Yes | 0 = No',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thanas`
--

CREATE TABLE `thanas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `deleted_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thanas`
--

INSERT INTO `thanas` (`id`, `district_id`, `name`, `bn_name`, `url`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Debidwar', 'দেবিদ্বার', 'debidwar.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Barura', 'বরুড়া', 'barura.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'Brahmanpara', 'ব্রাহ্মণপাড়া', 'brahmanpara.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 'Chandina', 'চান্দিনা', 'chandina.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 'Chauddagram', 'চৌদ্দগ্রাম', 'chauddagram.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'Daudkandi', 'দাউদকান্দি', 'daudkandi.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'Homna', 'হোমনা', 'homna.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'Laksam', 'লাকসাম', 'laksam.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'Muradnagar', 'মুরাদনগর', 'muradnagar.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'Nangalkot', 'নাঙ্গলকোট', 'nangalkot.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Comilla Sadar', 'কুমিল্লা সদর', 'comillasadar.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 'Meghna', 'মেঘনা', 'meghna.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 'Monohargonj', 'মনোহরগঞ্জ', 'monohargonj.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 'Sadarsouth', 'সদর দক্ষিণ', 'sadarsouth.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 'Titas', 'তিতাস', 'titas.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 1, 'Burichang', 'বুড়িচং', 'burichang.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 'Lalmai', 'লালমাই', 'lalmai.comilla.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 2, 'Chhagalnaiya', 'ছাগলনাইয়া', 'chhagalnaiya.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 2, 'Feni Sadar', 'ফেনী সদর', 'sadar.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 2, 'Sonagazi', 'সোনাগাজী', 'sonagazi.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 2, 'Fulgazi', 'ফুলগাজী', 'fulgazi.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 2, 'Parshuram', 'পরশুরাম', 'parshuram.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 2, 'Daganbhuiyan', 'দাগনভূঞা', 'daganbhuiyan.feni.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 3, 'Brahmanbaria Sadar', 'ব্রাহ্মণবাড়িয়া সদর', 'sadar.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 3, 'Kasba', 'কসবা', 'kasba.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 3, 'Nasirnagar', 'নাসিরনগর', 'nasirnagar.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 3, 'Sarail', 'সরাইল', 'sarail.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 3, 'Ashuganj', 'আশুগঞ্জ', 'ashuganj.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 3, 'Akhaura', 'আখাউড়া', 'akhaura.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 3, 'Nabinagar', 'নবীনগর', 'nabinagar.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 3, 'Bancharampur', 'বাঞ্ছারামপুর', 'bancharampur.brahmanbaria.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 3, 'Bijoynagar', 'বিজয়নগর', 'bijoynagar.brahmanbaria.gov.bd    ', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 4, 'Rangamati Sadar', 'রাঙ্গামাটি সদর', 'sadar.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 4, 'Kaptai', 'কাপ্তাই', 'kaptai.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 4, 'Kawkhali', 'কাউখালী', 'kawkhali.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 4, 'Baghaichari', 'বাঘাইছড়ি', 'baghaichari.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 4, 'Barkal', 'বরকল', 'barkal.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 4, 'Langadu', 'লংগদু', 'langadu.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 4, 'Rajasthali', 'রাজস্থলী', 'rajasthali.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 4, 'Belaichari', 'বিলাইছড়ি', 'belaichari.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 4, 'Juraichari', 'জুরাছড়ি', 'juraichari.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 4, 'Naniarchar', 'নানিয়ারচর', 'naniarchar.rangamati.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 5, 'Noakhali Sadar', 'নোয়াখালী সদর', 'sadar.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 5, 'Companiganj', 'কোম্পানীগঞ্জ', 'companiganj.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 5, 'Begumganj', 'বেগমগঞ্জ', 'begumganj.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 5, 'Hatia', 'হাতিয়া', 'hatia.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 5, 'Subarnachar', 'সুবর্ণচর', 'subarnachar.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 5, 'Kabirhat', 'কবিরহাট', 'kabirhat.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 5, 'Senbug', 'সেনবাগ', 'senbug.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 5, 'Chatkhil', 'চাটখিল', 'chatkhil.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 5, 'Sonaimori', 'সোনাইমুড়ী', 'sonaimori.noakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 6, 'Haimchar', 'হাইমচর', 'haimchar.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 6, 'Kachua', 'কচুয়া', 'kachua.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 6, 'Shahrasti', 'শাহরাস্তি	', 'shahrasti.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 6, 'Chandpur Sadar', 'চাঁদপুর সদর', 'sadar.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 6, 'Matlab South', 'মতলব দক্ষিণ', 'matlabsouth.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 6, 'Hajiganj', 'হাজীগঞ্জ', 'hajiganj.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 6, 'Matlab North', 'মতলব উত্তর', 'matlabnorth.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 6, 'Faridgonj', 'ফরিদগঞ্জ', 'faridgonj.chandpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 7, 'Lakshmipur Sadar', 'লক্ষ্মীপুর সদর', 'sadar.lakshmipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 7, 'Kamalnagar', 'কমলনগর', 'kamalnagar.lakshmipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 7, 'Raipur', 'রায়পুর', 'raipur.lakshmipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 7, 'Ramgati', 'রামগতি', 'ramgati.lakshmipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 7, 'Ramganj', 'রামগঞ্জ', 'ramganj.lakshmipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 8, 'Rangunia', 'রাঙ্গুনিয়া', 'rangunia.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 8, 'Sitakunda', 'সীতাকুন্ড', 'sitakunda.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 8, 'Mirsharai', 'মীরসরাই', 'mirsharai.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 8, 'Patiya', 'পটিয়া', 'patiya.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 8, 'Sandwip', 'সন্দ্বীপ', 'sandwip.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 8, 'Banshkhali', 'বাঁশখালী', 'banshkhali.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 8, 'Boalkhali', 'বোয়ালখালী', 'boalkhali.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 8, 'Anwara', 'আনোয়ারা', 'anwara.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 8, 'Chandanaish', 'চন্দনাইশ', 'chandanaish.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 8, 'Satkania', 'সাতকানিয়া', 'satkania.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 8, 'Lohagara', 'লোহাগাড়া', 'lohagara.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 8, 'Hathazari', 'হাটহাজারী', 'hathazari.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 8, 'Fatikchhari', 'ফটিকছড়ি', 'fatikchhari.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 8, 'Raozan', 'রাউজান', 'raozan.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 8, 'Karnafuli', 'কর্ণফুলী', 'karnafuli.chittagong.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 9, 'Coxsbazar Sadar', 'কক্সবাজার সদর', 'sadar.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 9, 'Chakaria', 'চকরিয়া', 'chakaria.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 9, 'Kutubdia', 'কুতুবদিয়া', 'kutubdia.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 9, 'Ukhiya', 'উখিয়া', 'ukhiya.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 9, 'Moheshkhali', 'মহেশখালী', 'moheshkhali.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 9, 'Pekua', 'পেকুয়া', 'pekua.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 9, 'Ramu', 'রামু', 'ramu.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 9, 'Teknaf', 'টেকনাফ', 'teknaf.coxsbazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 10, 'Khagrachhari Sadar', 'খাগড়াছড়ি সদর', 'sadar.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 10, 'Dighinala', 'দিঘীনালা', 'dighinala.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 10, 'Panchari', 'পানছড়ি', 'panchari.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 10, 'Laxmichhari', 'লক্ষীছড়ি', 'laxmichhari.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 10, 'Mohalchari', 'মহালছড়ি', 'mohalchari.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 10, 'Manikchari', 'মানিকছড়ি', 'manikchari.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 10, 'Ramgarh', 'রামগড়', 'ramgarh.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 10, 'Matiranga', 'মাটিরাঙ্গা', 'matiranga.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 10, 'Guimara', 'গুইমারা', 'guimara.khagrachhari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 11, 'Bandarban Sadar', 'বান্দরবান সদর', 'sadar.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 11, 'Alikadam', 'আলীকদম', 'alikadam.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 11, 'Naikhongchhari', 'নাইক্ষ্যংছড়ি', 'naikhongchhari.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 11, 'Rowangchhari', 'রোয়াংছড়ি', 'rowangchhari.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 11, 'Lama', 'লামা', 'lama.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 11, 'Ruma', 'রুমা', 'ruma.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 11, 'Thanchi', 'থানচি', 'thanchi.bandarban.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 12, 'Belkuchi', 'বেলকুচি', 'belkuchi.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 12, 'Chauhali', 'চৌহালি', 'chauhali.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 12, 'Kamarkhand', 'কামারখন্দ', 'kamarkhand.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 12, 'Kazipur', 'কাজীপুর', 'kazipur.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 12, 'Raigonj', 'রায়গঞ্জ', 'raigonj.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 12, 'Shahjadpur', 'শাহজাদপুর', 'shahjadpur.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 12, 'Sirajganj Sadar', 'সিরাজগঞ্জ সদর', 'sirajganjsadar.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 12, 'Tarash', 'তাড়াশ', 'tarash.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 12, 'Ullapara', 'উল্লাপাড়া', 'ullapara.sirajganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 13, 'Sujanagar', 'সুজানগর', 'sujanagar.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 13, 'Ishurdi', 'ঈশ্বরদী', 'ishurdi.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 13, 'Bhangura', 'ভাঙ্গুড়া', 'bhangura.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 13, 'Pabna Sadar', 'পাবনা সদর', 'pabnasadar.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 13, 'Bera', 'বেড়া', 'bera.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 13, 'Atghoria', 'আটঘরিয়া', 'atghoria.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 13, 'Chatmohar', 'চাটমোহর', 'chatmohar.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 13, 'Santhia', 'সাঁথিয়া', 'santhia.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 13, 'Faridpur', 'ফরিদপুর', 'faridpur.pabna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 14, 'Kahaloo', 'কাহালু', 'kahaloo.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 14, 'Bogra Sadar', 'বগুড়া সদর', 'sadar.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 14, 'Shariakandi', 'সারিয়াকান্দি', 'shariakandi.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 14, 'Shajahanpur', 'শাজাহানপুর', 'shajahanpur.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 14, 'Dupchanchia', 'দুপচাচিঁয়া', 'dupchanchia.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 14, 'Adamdighi', 'আদমদিঘি', 'adamdighi.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 14, 'Nondigram', 'নন্দিগ্রাম', 'nondigram.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 14, 'Sonatala', 'সোনাতলা', 'sonatala.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 14, 'Dhunot', 'ধুনট', 'dhunot.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 14, 'Gabtali', 'গাবতলী', 'gabtali.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 14, 'Sherpur', 'শেরপুর', 'sherpur.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 14, 'Shibganj', 'শিবগঞ্জ', 'shibganj.bogra.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 15, 'Paba', 'পবা', 'paba.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 15, 'Durgapur', 'দুর্গাপুর', 'durgapur.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 15, 'Mohonpur', 'মোহনপুর', 'mohonpur.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 15, 'Charghat', 'চারঘাট', 'charghat.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 15, 'Puthia', 'পুঠিয়া', 'puthia.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 15, 'Bagha', 'বাঘা', 'bagha.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 15, 'Godagari', 'গোদাগাড়ী', 'godagari.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 15, 'Tanore', 'তানোর', 'tanore.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 15, 'Bagmara', 'বাগমারা', 'bagmara.rajshahi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 16, 'Natore Sadar', 'নাটোর সদর', 'natoresadar.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 16, 'Singra', 'সিংড়া', 'singra.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 16, 'Baraigram', 'বড়াইগ্রাম', 'baraigram.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 16, 'Bagatipara', 'বাগাতিপাড়া', 'bagatipara.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 16, 'Lalpur', 'লালপুর', 'lalpur.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 16, 'Gurudaspur', 'গুরুদাসপুর', 'gurudaspur.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 16, 'Naldanga', 'নলডাঙ্গা', 'naldanga.natore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 17, 'Akkelpur', 'আক্কেলপুর', 'akkelpur.joypurhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 17, 'Kalai', 'কালাই', 'kalai.joypurhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 17, 'Khetlal', 'ক্ষেতলাল', 'khetlal.joypurhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 17, 'Panchbibi', 'পাঁচবিবি', 'panchbibi.joypurhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 17, 'Joypurhat Sadar', 'জয়পুরহাট সদর', 'joypurhatsadar.joypurhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 18, 'Chapainawabganj Sadar', 'চাঁপাইনবাবগঞ্জ সদর', 'chapainawabganjsadar.chapainawabganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 18, 'Gomostapur', 'গোমস্তাপুর', 'gomostapur.chapainawabganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 18, 'Nachol', 'নাচোল', 'nachol.chapainawabganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 18, 'Bholahat', 'ভোলাহাট', 'bholahat.chapainawabganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 18, 'Shibganj', 'শিবগঞ্জ', 'shibganj.chapainawabganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 19, 'Mohadevpur', 'মহাদেবপুর', 'mohadevpur.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 19, 'Badalgachi', 'বদলগাছী', 'badalgachi.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 19, 'Patnitala', 'পত্নিতলা', 'patnitala.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 19, 'Dhamoirhat', 'ধামইরহাট', 'dhamoirhat.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 19, 'Niamatpur', 'নিয়ামতপুর', 'niamatpur.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 19, 'Manda', 'মান্দা', 'manda.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 19, 'Atrai', 'আত্রাই', 'atrai.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 19, 'Raninagar', 'রাণীনগর', 'raninagar.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 19, 'Naogaon Sadar', 'নওগাঁ সদর', 'naogaonsadar.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 19, 'Porsha', 'পোরশা', 'porsha.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 19, 'Sapahar', 'সাপাহার', 'sapahar.naogaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 20, 'Manirampur', 'মণিরামপুর', 'manirampur.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 20, 'Abhaynagar', 'অভয়নগর', 'abhaynagar.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 20, 'Bagherpara', 'বাঘারপাড়া', 'bagherpara.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 20, 'Chougachha', 'চৌগাছা', 'chougachha.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 20, 'Jhikargacha', 'ঝিকরগাছা', 'jhikargacha.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 20, 'Keshabpur', 'কেশবপুর', 'keshabpur.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 20, 'Jessore Sadar', 'যশোর সদর', 'sadar.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 20, 'Sharsha', 'শার্শা', 'sharsha.jessore.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 21, 'Assasuni', 'আশাশুনি', 'assasuni.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 21, 'Debhata', 'দেবহাটা', 'debhata.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 21, 'Kalaroa', 'কলারোয়া', 'kalaroa.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 21, 'Satkhira Sadar', 'সাতক্ষীরা সদর', 'satkhirasadar.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 21, 'Shyamnagar', 'শ্যামনগর', 'shyamnagar.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 21, 'Tala', 'তালা', 'tala.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 21, 'Kaliganj', 'কালিগঞ্জ', 'kaliganj.satkhira.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 22, 'Mujibnagar', 'মুজিবনগর', 'mujibnagar.meherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 22, 'Meherpur Sadar', 'মেহেরপুর সদর', 'meherpursadar.meherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 22, 'Gangni', 'গাংনী', 'gangni.meherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 23, 'Narail Sadar', 'নড়াইল সদর', 'narailsadar.narail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 23, 'Lohagara', 'লোহাগড়া', 'lohagara.narail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 23, 'Kalia', 'কালিয়া', 'kalia.narail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 24, 'Chuadanga Sadar', 'চুয়াডাঙ্গা সদর', 'chuadangasadar.chuadanga.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 24, 'Alamdanga', 'আলমডাঙ্গা', 'alamdanga.chuadanga.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 24, 'Damurhuda', 'দামুড়হুদা', 'damurhuda.chuadanga.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 24, 'Jibannagar', 'জীবননগর', 'jibannagar.chuadanga.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 25, 'Kushtia Sadar', 'কুষ্টিয়া সদর', 'kushtiasadar.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 25, 'Kumarkhali', 'কুমারখালী', 'kumarkhali.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 25, 'Khoksa', 'খোকসা', 'khoksa.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 25, 'Mirpur', 'মিরপুর', 'mirpurkushtia.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 25, 'Daulatpur', 'দৌলতপুর', 'daulatpur.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 25, 'Bheramara', 'ভেড়ামারা', 'bheramara.kushtia.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(202, 26, 'Shalikha', 'শালিখা', 'shalikha.magura.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 26, 'Sreepur', 'শ্রীপুর', 'sreepur.magura.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 26, 'Magura Sadar', 'মাগুরা সদর', 'magurasadar.magura.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 26, 'Mohammadpur', 'মহম্মদপুর', 'mohammadpur.magura.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 27, 'Paikgasa', 'পাইকগাছা', 'paikgasa.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 27, 'Fultola', 'ফুলতলা', 'fultola.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 27, 'Digholia', 'দিঘলিয়া', 'digholia.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 27, 'Rupsha', 'রূপসা', 'rupsha.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 27, 'Terokhada', 'তেরখাদা', 'terokhada.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 27, 'Dumuria', 'ডুমুরিয়া', 'dumuria.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 27, 'Botiaghata', 'বটিয়াঘাটা', 'botiaghata.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 27, 'Dakop', 'দাকোপ', 'dakop.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 27, 'Koyra', 'কয়রা', 'koyra.khulna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 28, 'Fakirhat', 'ফকিরহাট', 'fakirhat.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 28, 'Bagerhat Sadar', 'বাগেরহাট সদর', 'sadar.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 28, 'Mollahat', 'মোল্লাহাট', 'mollahat.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 28, 'Sarankhola', 'শরণখোলা', 'sarankhola.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 28, 'Rampal', 'রামপাল', 'rampal.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 28, 'Morrelganj', 'মোড়েলগঞ্জ', 'morrelganj.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 28, 'Kachua', 'কচুয়া', 'kachua.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 28, 'Mongla', 'মোংলা', 'mongla.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 28, 'Chitalmari', 'চিতলমারী', 'chitalmari.bagerhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 29, 'Jhenaidah Sadar', 'ঝিনাইদহ সদর', 'sadar.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(225, 29, 'Shailkupa', 'শৈলকুপা', 'shailkupa.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 29, 'Harinakundu', 'হরিণাকুন্ডু', 'harinakundu.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 29, 'Kaliganj', 'কালীগঞ্জ', 'kaliganj.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(228, 29, 'Kotchandpur', 'কোটচাঁদপুর', 'kotchandpur.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 29, 'Moheshpur', 'মহেশপুর', 'moheshpur.jhenaidah.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 30, 'Jhalakathi Sadar', 'ঝালকাঠি সদর', 'sadar.jhalakathi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(231, 30, 'Kathalia', 'কাঠালিয়া', 'kathalia.jhalakathi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(232, 30, 'Nalchity', 'নলছিটি', 'nalchity.jhalakathi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(233, 30, 'Rajapur', 'রাজাপুর', 'rajapur.jhalakathi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(234, 31, 'Bauphal', 'বাউফল', 'bauphal.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(235, 31, 'Patuakhali Sadar', 'পটুয়াখালী সদর', 'sadar.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(236, 31, 'Dumki', 'দুমকি', 'dumki.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(237, 31, 'Dashmina', 'দশমিনা', 'dashmina.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(238, 31, 'Kalapara', 'কলাপাড়া', 'kalapara.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(239, 31, 'Mirzaganj', 'মির্জাগঞ্জ', 'mirzaganj.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(240, 31, 'Galachipa', 'গলাচিপা', 'galachipa.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(241, 31, 'Rangabali', 'রাঙ্গাবালী', 'rangabali.patuakhali.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(242, 32, 'Pirojpur Sadar', 'পিরোজপুর সদর', 'sadar.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 32, 'Nazirpur', 'নাজিরপুর', 'nazirpur.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(244, 32, 'Kawkhali', 'কাউখালী', 'kawkhali.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 32, 'Zianagar', 'জিয়ানগর', 'zianagar.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(246, 32, 'Bhandaria', 'ভান্ডারিয়া', 'bhandaria.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 32, 'Mathbaria', 'মঠবাড়ীয়া', 'mathbaria.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 32, 'Nesarabad', 'নেছারাবাদ', 'nesarabad.pirojpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 33, 'Barisal Sadar', 'বরিশাল সদর', 'barisalsadar.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 33, 'Bakerganj', 'বাকেরগঞ্জ', 'bakerganj.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 33, 'Babuganj', 'বাবুগঞ্জ', 'babuganj.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 33, 'Wazirpur', 'উজিরপুর', 'wazirpur.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 33, 'Banaripara', 'বানারীপাড়া', 'banaripara.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 33, 'Gournadi', 'গৌরনদী', 'gournadi.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 33, 'Agailjhara', 'আগৈলঝাড়া', 'agailjhara.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 33, 'Mehendiganj', 'মেহেন্দিগঞ্জ', 'mehendiganj.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 33, 'Muladi', 'মুলাদী', 'muladi.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 33, 'Hizla', 'হিজলা', 'hizla.barisal.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 34, 'Bhola Sadar', 'ভোলা সদর', 'sadar.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(260, 34, 'Borhan Sddin', 'বোরহান উদ্দিন', 'borhanuddin.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 34, 'Charfesson', 'চরফ্যাশন', 'charfesson.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 34, 'Doulatkhan', 'দৌলতখান', 'doulatkhan.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(263, 34, 'Monpura', 'মনপুরা', 'monpura.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(264, 34, 'Tazumuddin', 'তজুমদ্দিন', 'tazumuddin.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(265, 34, 'Lalmohan', 'লালমোহন', 'lalmohan.bhola.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(266, 35, 'Amtali', 'আমতলী', 'amtali.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(267, 35, 'Barguna Sadar', 'বরগুনা সদর', 'sadar.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(268, 35, 'Betagi', 'বেতাগী', 'betagi.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 35, 'Bamna', 'বামনা', 'bamna.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 35, 'Pathorghata', 'পাথরঘাটা', 'pathorghata.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(271, 35, 'Taltali', 'তালতলি', 'taltali.barguna.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(272, 36, 'Balaganj', 'বালাগঞ্জ', 'balaganj.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(273, 36, 'Beanibazar', 'বিয়ানীবাজার', 'beanibazar.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(274, 36, 'Bishwanath', 'বিশ্বনাথ', 'bishwanath.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(275, 36, 'Companiganj', 'কোম্পানীগঞ্জ', 'companiganj.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(276, 36, 'Fenchuganj', 'ফেঞ্চুগঞ্জ', 'fenchuganj.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(277, 36, 'Golapganj', 'গোলাপগঞ্জ', 'golapganj.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(278, 36, 'Gowainghat', 'গোয়াইনঘাট', 'gowainghat.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(279, 36, 'Jaintiapur', 'জৈন্তাপুর', 'jaintiapur.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(280, 36, 'Kanaighat', 'কানাইঘাট', 'kanaighat.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(281, 36, 'Sylhet Sadar', 'সিলেট সদর', 'sylhetsadar.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(282, 36, 'Zakiganj', 'জকিগঞ্জ', 'zakiganj.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 36, 'Dakshinsurma', 'দক্ষিণ সুরমা', 'dakshinsurma.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(284, 36, 'Osmaninagar', 'ওসমানী নগর', 'osmaninagar.sylhet.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(285, 37, 'Barlekha', 'বড়লেখা', 'barlekha.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(286, 37, 'Kamolganj', 'কমলগঞ্জ', 'kamolganj.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(287, 37, 'Kulaura', 'কুলাউড়া', 'kulaura.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(288, 37, 'Moulvibazar Sadar', 'মৌলভীবাজার সদর', 'moulvibazarsadar.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(289, 37, 'Rajnagar', 'রাজনগর', 'rajnagar.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(290, 37, 'Sreemangal', 'শ্রীমঙ্গল', 'sreemangal.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(291, 37, 'Juri', 'জুড়ী', 'juri.moulvibazar.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(292, 38, 'Nabiganj', 'নবীগঞ্জ', 'nabiganj.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(293, 38, 'Bahubal', 'বাহুবল', 'bahubal.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(294, 38, 'Ajmiriganj', 'আজমিরীগঞ্জ', 'ajmiriganj.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(295, 38, 'Baniachong', 'বানিয়াচং', 'baniachong.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(296, 38, 'Lakhai', 'লাখাই', 'lakhai.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(297, 38, 'Chunarughat', 'চুনারুঘাট', 'chunarughat.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(298, 38, 'Habiganj Sadar', 'হবিগঞ্জ সদর', 'habiganjsadar.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(299, 38, 'Madhabpur', 'মাধবপুর', 'madhabpur.habiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(300, 39, 'Sunamganj Sadar', 'সুনামগঞ্জ সদর', 'sadar.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(301, 39, 'South Sunamganj', 'দক্ষিণ সুনামগঞ্জ', 'southsunamganj.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(302, 39, 'Bishwambarpur', 'বিশ্বম্ভরপুর', 'bishwambarpur.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(303, 39, 'Chhatak', 'ছাতক', 'chhatak.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(304, 39, 'Jagannathpur', 'জগন্নাথপুর', 'jagannathpur.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(305, 39, 'Dowarabazar', 'দোয়ারাবাজার', 'dowarabazar.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(306, 39, 'Tahirpur', 'তাহিরপুর', 'tahirpur.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(307, 39, 'Dharmapasha', 'ধর্মপাশা', 'dharmapasha.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(308, 39, 'Jamalganj', 'জামালগঞ্জ', 'jamalganj.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(309, 39, 'Shalla', 'শাল্লা', 'shalla.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(310, 39, 'Derai', 'দিরাই', 'derai.sunamganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(311, 40, 'Belabo', 'বেলাবো', 'belabo.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(312, 40, 'Monohardi', 'মনোহরদী', 'monohardi.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(313, 40, 'Narsingdi Sadar', 'নরসিংদী সদর', 'narsingdisadar.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(314, 40, 'Palash', 'পলাশ', 'palash.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(315, 40, 'Raipura', 'রায়পুরা', 'raipura.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(316, 40, 'Shibpur', 'শিবপুর', 'shibpur.narsingdi.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(317, 41, 'Kaliganj', 'কালীগঞ্জ', 'kaliganj.gazipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(318, 41, 'Kaliakair', 'কালিয়াকৈর', 'kaliakair.gazipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(319, 41, 'Kapasia', 'কাপাসিয়া', 'kapasia.gazipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(320, 41, 'Gazipur Sadar', 'গাজীপুর সদর', 'sadar.gazipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(321, 41, 'Sreepur', 'শ্রীপুর', 'sreepur.gazipur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(322, 42, 'Shariatpur Sadar', 'শরিয়তপুর সদর', 'sadar.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(323, 42, 'Naria', 'নড়িয়া', 'naria.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(324, 42, 'Zajira', 'জাজিরা', 'zajira.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(325, 42, 'Gosairhat', 'গোসাইরহাট', 'gosairhat.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(326, 42, 'Bhedarganj', 'ভেদরগঞ্জ', 'bhedarganj.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(327, 42, 'Damudya', 'ডামুড্যা', 'damudya.shariatpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(328, 43, 'Araihazar', 'আড়াইহাজার', 'araihazar.narayanganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(329, 43, 'Bandar', 'বন্দর', 'bandar.narayanganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(330, 43, 'Narayanganj Sadar', 'নারায়নগঞ্জ সদর', 'narayanganjsadar.narayanganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(331, 43, 'Rupganj', 'রূপগঞ্জ', 'rupganj.narayanganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(332, 43, 'Sonargaon', 'সোনারগাঁ', 'sonargaon.narayanganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(333, 44, 'Basail', 'বাসাইল', 'basail.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(334, 44, 'Bhuapur', 'ভুয়াপুর', 'bhuapur.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(335, 44, 'Delduar', 'দেলদুয়ার', 'delduar.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(336, 44, 'Ghatail', 'ঘাটাইল', 'ghatail.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(337, 44, 'Gopalpur', 'গোপালপুর', 'gopalpur.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(338, 44, 'Madhupur', 'মধুপুর', 'madhupur.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(339, 44, 'Mirzapur', 'মির্জাপুর', 'mirzapur.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(340, 44, 'Nagarpur', 'নাগরপুর', 'nagarpur.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(341, 44, 'Sakhipur', 'সখিপুর', 'sakhipur.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(342, 44, 'Tangail Sadar', 'টাঙ্গাইল সদর', 'tangailsadar.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(343, 44, 'Kalihati', 'কালিহাতী', 'kalihati.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(344, 44, 'Dhanbari', 'ধনবাড়ী', 'dhanbari.tangail.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(345, 45, 'Itna', 'ইটনা', 'itna.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(346, 45, 'Katiadi', 'কটিয়াদী', 'katiadi.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(347, 45, 'Bhairab', 'ভৈরব', 'bhairab.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(348, 45, 'Tarail', 'তাড়াইল', 'tarail.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(349, 45, 'Hossainpur', 'হোসেনপুর', 'hossainpur.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(350, 45, 'Pakundia', 'পাকুন্দিয়া', 'pakundia.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(351, 45, 'Kuliarchar', 'কুলিয়ারচর', 'kuliarchar.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(352, 45, 'Kishoreganj Sadar', 'কিশোরগঞ্জ সদর', 'kishoreganjsadar.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(353, 45, 'Karimgonj', 'করিমগঞ্জ', 'karimgonj.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(354, 45, 'Bajitpur', 'বাজিতপুর', 'bajitpur.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(355, 45, 'Austagram', 'অষ্টগ্রাম', 'austagram.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(356, 45, 'Mithamoin', 'মিঠামইন', 'mithamoin.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(357, 45, 'Nikli', 'নিকলী', 'nikli.kishoreganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(358, 46, 'Harirampur', 'হরিরামপুর', 'harirampur.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(359, 46, 'Saturia', 'সাটুরিয়া', 'saturia.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(360, 46, 'Manikganj Sadar', 'মানিকগঞ্জ সদর', 'sadar.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(361, 46, 'Gior', 'ঘিওর', 'gior.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(362, 46, 'Shibaloy', 'শিবালয়', 'shibaloy.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(363, 46, 'Doulatpur', 'দৌলতপুর', 'doulatpur.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(364, 46, 'Singiar', 'সিংগাইর', 'singiar.manikganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(365, 47, 'Savar', 'সাভার', 'savar.dhaka.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(366, 47, 'Dhamrai', 'ধামরাই', 'dhamrai.dhaka.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(367, 47, 'Keraniganj', 'কেরাণীগঞ্জ', 'keraniganj.dhaka.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(368, 47, 'Nawabganj', 'নবাবগঞ্জ', 'nawabganj.dhaka.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(369, 47, 'Dohar', 'দোহার', 'dohar.dhaka.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(370, 47, 'Adabor', 'আদাবর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(371, 47, 'Badda', 'বাড্ডা', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(372, 47, 'Banani', 'বনানী', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(373, 47, 'Bangshal', 'বংশাল', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(374, 47, 'Bimanbandar', 'বিমানবন্দর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(375, 47, 'Bsahantek', 'বসহানটেক', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(376, 47, 'Cantonment', 'ক্যান্টনমেন্ট', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(377, 47, 'Chalkbazar', 'চকবাজার', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(378, 47, 'Dakhin Khan', 'দখিন খান', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(379, 47, 'Darus-Salam', 'দারুস-সালাম', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(380, 47, 'Demra', 'ডেমরা', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(381, 47, 'Dhanmondi', 'ধানমন্ডি', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(382, 47, 'Gandaria', 'গেন্ডারিয়া', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(384, 47, 'Gulshan', 'গুলশান', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(385, 47, 'Hazaribag', 'হাজারীবাগ', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(386, 47, 'Jattrabari', 'যাত্রাবাড়ী', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(387, 47, 'Kafrul', 'কাফরুল', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(388, 47, 'Kalabagan', 'কলাবাগান', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(389, 47, 'Kamrangirchar', 'কামরাঙ্গীরচর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(390, 47, 'Khilgaon', 'খিলগাঁও', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(391, 47, 'Khilkhet', 'খিলক্ষেত', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(392, 47, 'Kodomtali', 'কদোমতলী', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(393, 47, 'Kotwali', 'কোতোয়ালি', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(394, 47, 'Lalbagh', 'লালবাগ', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(395, 47, 'Mirpur Model', 'মিরপুর মডেল', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(396, 47, 'Mohammadpur', 'মোহাম্মদপুর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(397, 47, 'Motijheel', 'মতিঝিল', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(398, 47, 'Mugda', 'মুগদা', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(399, 47, 'New Market', 'নিউমার্কেট', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(400, 47, 'Pallabi', 'পল্লবী', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(401, 47, 'Paltan', 'পল্টন', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(402, 47, 'Ramna Model', 'রমনা মডেল', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(403, 47, 'Rampura', 'রামপুরা', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(404, 47, 'Rupnagar', 'রূপনগর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(405, 47, 'Sabujbag', 'সবুজবাগ', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(406, 47, 'Shah Ali', 'শাহ আলী', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(407, 47, 'Shahbag', 'শাহবাগ', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(408, 47, 'Shahjahanpur', 'শাহজাহানপুর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(409, 47, 'Sutrapur', 'সূত্রাপুর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(410, 47, 'Shyampur', 'শ্যামপুর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(411, 47, 'Sher-e-Bangla Nagar', 'শেরেবাংলা নগর', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(412, 47, 'Tejgaon Industrial Police', 'তেজগাঁও শিল্প পুলিশ', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(413, 47, 'Tejgaon', 'তেজগাঁও', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(414, 47, 'Turag', 'তুরাগ', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(415, 47, 'Uttara East', 'উত্তরা পূর্ব', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(416, 47, 'Uttara West', 'উত্তরা পশ্চিম', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(417, 47, 'Uttar Khan', 'উত্তর খান', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(418, 47, 'Vatara', 'ভাটারা', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(419, 47, 'Wari', 'ওয়ারী', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(420, 48, 'Munshiganj Sadar', 'মুন্সিগঞ্জ সদর', 'sadar.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(421, 48, 'Sreenagar', 'শ্রীনগর', 'sreenagar.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(422, 48, 'Sirajdikhan', 'সিরাজদিখান', 'sirajdikhan.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(423, 48, 'Louhajanj', 'লৌহজং', 'louhajanj.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(424, 48, 'Gajaria', 'গজারিয়া', 'gajaria.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(425, 48, 'Tongibari', 'টংগীবাড়ি', 'tongibari.munshiganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(426, 49, 'Rajbari Sadar', 'রাজবাড়ী সদর', 'sadar.rajbari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(427, 49, 'Goalanda', 'গোয়ালন্দ', 'goalanda.rajbari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(428, 49, 'Pangsa', 'পাংশা', 'pangsa.rajbari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(429, 49, 'Baliakandi', 'বালিয়াকান্দি', 'baliakandi.rajbari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(430, 49, 'Kalukhali', 'কালুখালী', 'kalukhali.rajbari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(431, 50, 'Madaripur Sadar', 'মাদারীপুর সদর', 'sadar.madaripur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(432, 50, 'Shibchar', 'শিবচর', 'shibchar.madaripur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(433, 50, 'Kalkini', 'কালকিনি', 'kalkini.madaripur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(434, 50, 'Rajoir', 'রাজৈর', 'rajoir.madaripur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(435, 51, 'Gopalganj Sadar', 'গোপালগঞ্জ সদর', 'sadar.gopalganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(436, 51, 'Kashiani', 'কাশিয়ানী', 'kashiani.gopalganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(437, 51, 'Tungipara', 'টুংগীপাড়া', 'tungipara.gopalganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(438, 51, 'Kotalipara', 'কোটালীপাড়া', 'kotalipara.gopalganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(439, 51, 'Muksudpur', 'মুকসুদপুর', 'muksudpur.gopalganj.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(440, 52, 'Faridpur Sadar', 'ফরিদপুর সদর', 'sadar.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(441, 52, 'Alfadanga', 'আলফাডাঙ্গা', 'alfadanga.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(442, 52, 'Boalmari', 'বোয়ালমারী', 'boalmari.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(443, 52, 'Sadarpur', 'সদরপুর', 'sadarpur.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(444, 52, 'Nagarkanda', 'নগরকান্দা', 'nagarkanda.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(445, 52, 'Bhanga', 'ভাঙ্গা', 'bhanga.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(446, 52, 'Charbhadrasan', 'চরভদ্রাসন', 'charbhadrasan.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(447, 52, 'Madhukhali', 'মধুখালী', 'madhukhali.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(448, 52, 'Saltha', 'সালথা', 'saltha.faridpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(449, 53, 'Panchagarh Sadar', 'পঞ্চগড় সদর', 'panchagarhsadar.panchagarh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(450, 53, 'Debiganj', 'দেবীগঞ্জ', 'debiganj.panchagarh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(451, 53, 'Boda', 'বোদা', 'boda.panchagarh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(452, 53, 'Atwari', 'আটোয়ারী', 'atwari.panchagarh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(453, 53, 'Tetulia', 'তেতুলিয়া', 'tetulia.panchagarh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(454, 54, 'Nawabganj', 'নবাবগঞ্জ', 'nawabganj.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(455, 54, 'Birganj', 'বীরগঞ্জ', 'birganj.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(456, 54, 'Ghoraghat', 'ঘোড়াঘাট', 'ghoraghat.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(457, 54, 'Birampur', 'বিরামপুর', 'birampur.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(458, 54, 'Parbatipur', 'পার্বতীপুর', 'parbatipur.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(459, 54, 'Bochaganj', 'বোচাগঞ্জ', 'bochaganj.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(460, 54, 'Kaharol', 'কাহারোল', 'kaharol.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(461, 54, 'Fulbari', 'ফুলবাড়ী', 'fulbari.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(462, 54, 'Dinajpur Sadar', 'দিনাজপুর সদর', 'dinajpursadar.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(463, 54, 'Hakimpur', 'হাকিমপুর', 'hakimpur.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(464, 54, 'Khansama', 'খানসামা', 'khansama.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(465, 54, 'Birol', 'বিরল', 'birol.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(466, 54, 'Chirirbandar', 'চিরিরবন্দর', 'chirirbandar.dinajpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(467, 55, 'Lalmonirhat Sadar', 'লালমনিরহাট সদর', 'sadar.lalmonirhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(468, 55, 'Kaliganj', 'কালীগঞ্জ', 'kaliganj.lalmonirhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(469, 55, 'Hatibandha', 'হাতীবান্ধা', 'hatibandha.lalmonirhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(470, 55, 'Patgram', 'পাটগ্রাম', 'patgram.lalmonirhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(471, 55, 'Aditmari', 'আদিতমারী', 'aditmari.lalmonirhat.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(472, 56, 'Syedpur', 'সৈয়দপুর', 'syedpur.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(473, 56, 'Domar', 'ডোমার', 'domar.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(474, 56, 'Dimla', 'ডিমলা', 'dimla.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(475, 56, 'Jaldhaka', 'জলঢাকা', 'jaldhaka.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(476, 56, 'Kishorganj', 'কিশোরগঞ্জ', 'kishorganj.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(477, 56, 'Nilphamari Sadar', 'নীলফামারী সদর', 'nilphamarisadar.nilphamari.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(478, 57, 'Sadullapur', 'সাদুল্লাপুর', 'sadullapur.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(479, 57, 'Gaibandha Sadar', 'গাইবান্ধা সদর', 'gaibandhasadar.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(480, 57, 'Palashbari', 'পলাশবাড়ী', 'palashbari.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(481, 57, 'Saghata', 'সাঘাটা', 'saghata.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(482, 57, 'Gobindaganj', 'গোবিন্দগঞ্জ', 'gobindaganj.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(483, 57, 'Sundarganj', 'সুন্দরগঞ্জ', 'sundarganj.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(484, 57, 'Phulchari', 'ফুলছড়ি', 'phulchari.gaibandha.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(485, 58, 'Thakurgaon Sadar', 'ঠাকুরগাঁও সদর', 'thakurgaonsadar.thakurgaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(486, 58, 'Pirganj', 'পীরগঞ্জ', 'pirganj.thakurgaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(487, 58, 'Ranisankail', 'রাণীশংকৈল', 'ranisankail.thakurgaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(488, 58, 'Haripur', 'হরিপুর', 'haripur.thakurgaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(489, 58, 'Baliadangi', 'বালিয়াডাঙ্গী', 'baliadangi.thakurgaon.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(490, 59, 'Rangpur Sadar', 'রংপুর সদর', 'rangpursadar.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(491, 59, 'Gangachara', 'গংগাচড়া', 'gangachara.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(492, 59, 'Taragonj', 'তারাগঞ্জ', 'taragonj.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(493, 59, 'Badargonj', 'বদরগঞ্জ', 'badargonj.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(494, 59, 'Mithapukur', 'মিঠাপুকুর', 'mithapukur.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(495, 59, 'Pirgonj', 'পীরগঞ্জ', 'pirgonj.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(496, 59, 'Kaunia', 'কাউনিয়া', 'kaunia.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(497, 59, 'Pirgacha', 'পীরগাছা', 'pirgacha.rangpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(498, 60, 'Kurigram Sadar', 'কুড়িগ্রাম সদর', 'kurigramsadar.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(499, 60, 'Nageshwari', 'নাগেশ্বরী', 'nageshwari.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(500, 60, 'Bhurungamari', 'ভুরুঙ্গামারী', 'bhurungamari.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(501, 60, 'Phulbari', 'ফুলবাড়ী', 'phulbari.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(502, 60, 'Rajarhat', 'রাজারহাট', 'rajarhat.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(503, 60, 'Ulipur', 'উলিপুর', 'ulipur.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(504, 60, 'Chilmari', 'চিলমারী', 'chilmari.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `thanas` (`id`, `district_id`, `name`, `bn_name`, `url`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(505, 60, 'Rowmari', 'রৌমারী', 'rowmari.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(506, 60, 'Charrajibpur', 'চর রাজিবপুর', 'charrajibpur.kurigram.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(507, 61, 'Sherpur Sadar', 'শেরপুর সদর', 'sherpursadar.sherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(508, 61, 'Nalitabari', 'নালিতাবাড়ী', 'nalitabari.sherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(509, 61, 'Sreebordi', 'শ্রীবরদী', 'sreebordi.sherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(510, 61, 'Nokla', 'নকলা', 'nokla.sherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(511, 61, 'Jhenaigati', 'ঝিনাইগাতী', 'jhenaigati.sherpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(512, 62, 'Fulbaria', 'ফুলবাড়ীয়া', 'fulbaria.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(513, 62, 'Trishal', 'ত্রিশাল', 'trishal.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(514, 62, 'Bhaluka', 'ভালুকা', 'bhaluka.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(515, 62, 'Muktagacha', 'মুক্তাগাছা', 'muktagacha.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(516, 62, 'Mymensingh Sadar', 'ময়মনসিংহ সদর', 'mymensinghsadar.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(517, 62, 'Dhobaura', 'ধোবাউড়া', 'dhobaura.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(518, 62, 'Phulpur', 'ফুলপুর', 'phulpur.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(519, 62, 'Haluaghat', 'হালুয়াঘাট', 'haluaghat.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(520, 62, 'Gouripur', 'গৌরীপুর', 'gouripur.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(521, 62, 'Gafargaon', 'গফরগাঁও', 'gafargaon.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(522, 62, 'Iswarganj', 'ঈশ্বরগঞ্জ', 'iswarganj.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(523, 62, 'Nandail', 'নান্দাইল', 'nandail.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(524, 62, 'Tarakanda', 'তারাকান্দা', 'tarakanda.mymensingh.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(525, 63, 'Jamalpur Sadar', 'জামালপুর সদর', 'jamalpursadar.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(526, 63, 'Melandah', 'মেলান্দহ', 'melandah.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(527, 63, 'Islampur', 'ইসলামপুর', 'islampur.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(528, 63, 'Dewangonj', 'দেওয়ানগঞ্জ', 'dewangonj.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(529, 63, 'Sarishabari', 'সরিষাবাড়ী', 'sarishabari.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(530, 63, 'Madarganj', 'মাদারগঞ্জ', 'madarganj.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(531, 63, 'Bokshiganj', 'বকশীগঞ্জ', 'bokshiganj.jamalpur.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(532, 64, 'Barhatta', 'বারহাট্টা', 'barhatta.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(533, 64, 'Durgapur', 'দুর্গাপুর', 'durgapur.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(534, 64, 'Kendua', 'কেন্দুয়া', 'kendua.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(535, 64, 'Atpara', 'আটপাড়া', 'atpara.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(536, 64, 'Madan', 'মদন', 'madan.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(537, 64, 'Khaliajuri', 'খালিয়াজুরী', 'khaliajuri.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(538, 64, 'Kalmakanda', 'কলমাকান্দা', 'kalmakanda.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(539, 64, 'Mohongonj', 'মোহনগঞ্জ', 'mohongonj.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(540, 64, 'Purbadhala', 'পূর্বধলা', 'purbadhala.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(541, 64, 'Netrokona Sadar', 'নেত্রকোণা সদর', 'netrokonasadar.netrokona.gov.bd', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@test.com', NULL, '$2y$10$fGD9vRQZ9PjpUnc7HM9yJu9Wgp7Tzt1ZEmU.jrfAw.e5R4/hWI/Q6', NULL, NULL, NULL),
(2, 'Project Manager', 'pm@test.com', NULL, '$2y$10$zrezWcHg6LC00MboeA5uNOrNF7rvs5IgXXOc4YWVpIKZ.olez2Esq', NULL, NULL, NULL),
(3, 'Sales Manager', 'sm@test.com', NULL, '$2y$10$c//1nrR5tVcP89U72hyXGuHQozKLtMd3PKl32cqyaicxgYqmOZ0au', NULL, NULL, NULL),
(4, 'HR', 'hr@test.com', NULL, '$2y$10$030P4/Bt6/u2llLhEs3iYOTY6RoQLmsxj2SS6zoQEHXhKWkn/IKlS', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_sources`
--
ALTER TABLE `client_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_division_id_index` (`division_id`),
  ADD KEY `customers_district_id_index` (`district_id`),
  ADD KEY `customers_thana_id_index` (`thana_id`),
  ADD KEY `customers_client_source_id_index` (`client_source_id`),
  ADD KEY `customers_customer_category_id_index` (`customer_category_id`),
  ADD KEY `customers_customer_type_id_index` (`customer_type_id`),
  ADD KEY `customers_outlet_id_index` (`outlet_id`);

--
-- Indexes for table `customer_categories`
--
ALTER TABLE `customer_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_types`
--
ALTER TABLE `customer_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_division_id_index` (`division_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_customer_id_index` (`customer_id`),
  ADD KEY `meetings_meeting_type_id_index` (`meeting_type_id`);

--
-- Indexes for table `meeting_types`
--
ALTER TABLE `meeting_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outlets`
--
ALTER TABLE `outlets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_customer_id_index` (`customer_id`),
  ADD KEY `quotations_quotation_type_id_index` (`quotation_type_id`),
  ADD KEY `quotations_meeting_id_index` (`meeting_id`);

--
-- Indexes for table `quotation_types`
--
ALTER TABLE `quotation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `s_m_s`
--
ALTER TABLE `s_m_s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `s_m_s_customer_id_index` (`customer_id`),
  ADD KEY `s_m_s_batch_id_index` (`batch_id`);

--
-- Indexes for table `thanas`
--
ALTER TABLE `thanas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thanas_district_id_index` (`district_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_sources`
--
ALTER TABLE `client_sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_categories`
--
ALTER TABLE `customer_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_types`
--
ALTER TABLE `customer_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_types`
--
ALTER TABLE `meeting_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outlets`
--
ALTER TABLE `outlets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation_types`
--
ALTER TABLE `quotation_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `s_m_s`
--
ALTER TABLE `s_m_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thanas`
--
ALTER TABLE `thanas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=542;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
