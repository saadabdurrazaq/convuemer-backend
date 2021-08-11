-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2021 at 10:54 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravue`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_slug`, `brand_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 'Apple', 'apple', '1705794152842774.png', '2021-07-20 02:07:52', '2021-07-20 02:07:52', NULL),
(14, 'Vivo', 'vivo', '1705949926990229.png', '2021-07-20 06:05:45', '2021-07-21 19:29:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `category_icon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(29, 'Perawatan Hewan', 'perawatan-hewan', 'fas fa-star', NULL, '2021-08-01 00:05:29', NULL),
(30, 'Rumah Tangga', 'rumah-tangga', 'fas fa-user', NULL, '2021-07-31 22:42:38', NULL),
(32, 'Olahragax', 'olahragax', 'fa fa-check', NULL, '2021-07-31 23:31:25', NULL),
(33, ' Otomotif', 'otomotif', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(35, 'Tour & Travel', 'tour-&-travel', 'fa fa-check', NULL, '2021-07-31 23:30:45', NULL),
(36, ' Kamera', 'kamera', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(37, ' Elektronik', 'elektronik', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(38, ' Kesehatan', 'kesehatan', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(45, 'Properti', 'properti', 'fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(46, 'Buku', 'buku', 'fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(47, 'Office & Stationery', 'office-&-stationery', 'fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(48, 'Perawatan Tubuh', 'perawatan-tubuh', 'fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(49, 'Pertukangan', 'pertukangan', 'fa fa-check', NULL, '2021-08-01 00:55:20', NULL),
(50, ' Wedding', 'wedding', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(51, ' Perlengkapan Pesta & Craft', 'perlengkapan-pesta-&-craft', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(52, ' Film & Musik', 'film-&-musik', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(53, 'Gamingc', 'gamingc', 'fa fa-check', NULL, '2021-08-01 01:02:53', NULL),
(54, ' Handphone & Tablet', 'handphone-&-tablet', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(55, ' Ibu & Bayi', 'ibu-&-bayi', ' fa fa-check', NULL, '2021-07-31 22:42:38', NULL),
(66, 'debdeb', 'debdeb', 'erw', NULL, '2021-07-31 23:59:41', NULL),
(67, 'sfds', 'sfds', 'wetre', NULL, '2021-07-31 22:42:38', NULL),
(68, 'wer', 'wer', 'ghf', NULL, '2021-07-31 22:42:38', NULL),
(69, 'dfg', 'dfg', 'rtyrt', NULL, NULL, NULL),
(70, 'dfhfdh', 'dfhfdh', 'retryr', NULL, NULL, NULL),
(71, 'cvbcvb', 'cvbcvb', 'qweqw', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(9, '2021_06_09_032832_create_admins_table', 2),
(12, '2021_06_09_044919_create_sessions_table', 3),
(23, '2014_10_12_000000_create_users_table', 4),
(24, '2014_10_12_100000_create_password_resets_table', 4),
(25, '2014_10_12_200000_add_two_factor_columns_to_users_table', 4),
(26, '2016_06_01_000001_create_oauth_auth_codes_table', 4),
(27, '2016_06_01_000002_create_oauth_access_tokens_table', 4),
(28, '2016_06_01_000003_create_oauth_refresh_tokens_table', 4),
(29, '2016_06_01_000004_create_oauth_clients_table', 4),
(30, '2016_06_01_000005_create_oauth_personal_access_clients_table', 4),
(31, '2019_08_19_000000_create_failed_jobs_table', 4),
(32, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(33, '2021_02_09_054528_create_brands_table', 5),
(34, '2021_02_09_111701_create_categories_table', 6),
(35, '2021_02_09_121910_create_sub_categories_table', 7),
(36, '2021_02_16_183944_create_sub_sub_categories_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('010b4252b0b8eb10ea251920b08110f332071bb54848d69ffa69d29dac80d837571c204cfebc87e8', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-04 21:32:32', '2021-07-04 21:32:32', '2022-07-05 04:32:32'),
('0e43d357b287f0ae48bc197f08455cd359c0fee530db8b82de92cfb1c0536f25786fd893e5eda4ad', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-08-01 01:21:33', '2021-08-01 01:21:33', '2022-08-01 08:21:33'),
('18f29b50b645f1fe2dc3967d67a567293f95a2fa89ec7e27bcddedf338a72abb407bda1e6420b4b2', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-06-28 15:16:38', '2021-06-28 15:16:38', '2022-06-28 22:16:38'),
('1e67cd1eefb9e6e3cc8bb9e76c08c4da26cc25611e98a3412758acab254fff8edc30fc17703bad3b', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 00:22:37', '2021-07-01 00:22:37', '2022-07-01 07:22:37'),
('295286191804a742e15b6e50830c2b32301803bedb0401068550560c71ac8bdcd2526f338e229aee', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-06-30 23:21:32', '2021-06-30 23:21:32', '2022-07-01 06:21:32'),
('2c47871a6df309d1a2386e8789f9af4092f36b59a79d610f02edad95d5dd1decac5561661bc8e5d1', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-22 17:03:30', '2021-07-22 17:03:30', '2022-07-23 00:03:30'),
('33d94bdcb27379c5236f479e4b5f7cd4e863253797dfba83e2060afe6fa38fa5755c17d4eaeea3f8', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-04 16:56:32', '2021-07-04 16:56:32', '2022-07-04 23:56:32'),
('37e57c955d308f839e0c72a593a38aa74af35a3c7262fc2a1d892fefadf3020c98607364a217a437', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 17:42:02', '2021-07-01 17:42:02', '2022-07-02 00:42:02'),
('3b6305336a7c0a4039ecb9581fc742c974acab8e17207ce1bd7e0360bba72610e922c83bf78ef6e5', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-02 15:20:05', '2021-07-02 15:20:05', '2022-07-02 22:20:05'),
('3f324b281a6519b240bd643ea3f40fccef47b557958d33dbdb1b457464730b74d44e60f1934f85f6', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 16:03:01', '2021-07-01 16:03:01', '2022-07-01 23:03:01'),
('4010d3fe68669832d17af2f24cba3b8c3377d8fd836669b4ad9c7f53a68ddb87c012ca6065aad261', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-15 03:07:34', '2021-07-15 03:07:34', '2022-07-15 10:07:34'),
('47783b6b88d2d62f98e0579a76691f0775229bb45eee0609575abe0e670ce636ae0ce0d2b5ef174c', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-04 17:08:52', '2021-07-04 17:08:52', '2022-07-05 00:08:52'),
('57a5b8f2788b12e9a8a7fda1f9516f15b95fb071fb3c0041a43b3642d774822b6c16d46aee2f208b', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 23:43:06', '2021-07-01 23:43:06', '2022-07-02 06:43:06'),
('5fbbd2662320ec7848e08be6f584ae5679d311fe82be941ef314538f7324496dd6197343a05f56be', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-04 17:53:52', '2021-07-04 17:53:52', '2022-07-05 00:53:52'),
('63351b63ef81c8656384dd4d7655625cb9b74cadd04cfd07c8115d2e136798319a47545916d29f79', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-06-26 23:08:29', '2021-06-26 23:08:29', '2022-06-27 06:08:29'),
('66c0541d9b8d74b69d5cffcfb0ca2b485f7c716a601ff67757017e381d08999919c6efe0ffda22ab', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 19:08:29', '2021-07-01 19:08:29', '2022-07-02 02:08:29'),
('6859b4145dd9331ac368bdb8f53202af8eddccf6c08143d08fad0298948af4ee3d5277526081b37c', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-06-26 16:54:01', '2021-06-26 16:54:01', '2022-06-26 23:54:01'),
('6fe4b1c948c0b1fda7274c9269f9aa721bf6c5c3f13d4937555043dc07af4c952259d3cb7a87f4a4', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-15 03:08:40', '2021-07-15 03:08:40', '2022-07-15 10:08:40'),
('71b21a2ed493694c4cabf607005927402655d6eb1a06d96b5830202bc504eafddf0664a40d8da03f', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-15 03:25:27', '2021-07-15 03:25:27', '2022-07-15 10:25:27'),
('78202f8c69131180c36fbc89bf71bb8bac0b39492767107f6f12356100823458c0279b05ec75b22e', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-15 03:29:46', '2021-07-15 03:29:46', '2022-07-15 10:29:46'),
('7fc9ebf145cdef5fb530bde63090a5274fb71e4f66ffb1f30be7077017849c9383ce042168491c7e', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-02 01:46:02', '2021-07-02 01:46:02', '2022-07-02 08:46:02'),
('8010c4b30e951ffc561a0202791f826d42e867c39114809c3a44880e7ab325aa4ebf06f08a78dadf', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-06-26 16:55:08', '2021-06-26 16:55:08', '2022-06-26 23:55:08'),
('816004d0a1501918c75224de1683bace4a07c7d9a6751aaa80676d3823581721e602d43bbc6cbbbe', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 16:00:43', '2021-07-01 16:00:43', '2022-07-01 23:00:43'),
('8a57ef0bb1c75e575e733f7f6396e36cf3d25a8d71cba25042e0afda252d59e18c6b67d50d32c299', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-04 17:37:24', '2021-07-04 17:37:24', '2022-07-05 00:37:24'),
('8e14f59c501c0e4f43a05cdaf11ee30517b895f981315f560dde484282530d1040ae4e3a38a42e41', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 17:07:19', '2021-07-01 17:07:19', '2022-07-02 00:07:19'),
('9da83d5a5ac8c71b4f1fc2d69a0c6760a42bc0158c26682605aa1cd51b0365149fba85729a4897c8', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-07-16 05:42:08', '2021-07-16 05:42:08', '2022-07-16 12:42:08'),
('9e52d2d5adcf894f4759b75c7a728ed76f7a24b051399ae5703fd646b828e00f605d7f4b5ddca686', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-08-01 01:24:54', '2021-08-01 01:24:54', '2022-08-01 08:24:54'),
('a61119f8530b374492b3d0eb6ceef4836ae14d68ba46b0cbceee69d9c5b07e4b6d848cb0ca7aa625', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 16:04:59', '2021-07-01 16:04:59', '2022-07-01 23:04:59'),
('ac3cfc5f545c8f620ed47555a1642f10fb322697208ccf4b8b1e44f825aa31da35acad43eee7759f', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-02 22:36:22', '2021-07-02 22:36:22', '2022-07-03 05:36:22'),
('ac76161ff1e3cb6df46b727da7a6e8e369fff1cf3a6043f4f01095571c919d2ddd3bb710da062235', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-04 16:58:28', '2021-07-04 16:58:28', '2022-07-04 23:58:28'),
('b4afbedcfc7b1e6a5b26cb413cd74d6efc24c9920eab99d186f83364f2edea0cf214040ef367b457', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-04 21:42:45', '2021-07-04 21:42:45', '2022-07-05 04:42:45'),
('bec5a77a83b828ecdc90460c6972e47f91d8e30dad3be6a926d6bcf2538fbc9d21540218b18e8707', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 15:56:56', '2021-07-01 15:56:56', '2022-07-01 22:56:56'),
('c34f41ad46c58565a0be73b6b43f0b359ae201cb29502610ba8e57acc5e15be02ed67ce6055f5899', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-07-04 21:06:02', '2021-07-04 21:06:02', '2022-07-05 04:06:02'),
('c90b1eaf6ffac269a2bd9abe8dbdaaf43a151783119d4f89449bd5bc9e9e9c26426c85030998efc2', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-04 17:54:19', '2021-07-04 17:54:19', '2022-07-05 00:54:19'),
('c93962ddb9be1d51c6967d11f59370576b44811a247fec900bed3c56dd5434451dc6321a27538484', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-05 04:28:19', '2021-07-05 04:28:19', '2022-07-05 11:28:19'),
('cd760fb809d17f6db381b7ffce9ec0cade2c3620f889672739241cbbb42917086d234e885e4290bc', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-06-26 23:28:24', '2021-06-26 23:28:24', '2022-06-27 06:28:24'),
('cebf267009a0d806439abb47f76cfa43d17afbc00fafe546d3aeec53ce63b2d36601e92c02bd3ef9', 1, 3, 'MyApp', '[\"user\"]', 1, '2021-07-04 21:04:06', '2021-07-04 21:04:06', '2022-07-05 04:04:06'),
('d13139cbd0e5fa684c5a79e74053866e1684e883912474180802025aad72870438b332d6bec4ae80', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-06-30 23:13:08', '2021-06-30 23:13:08', '2022-07-01 06:13:08'),
('d26bbda4a3ba07d9a80e318757ff920aa4c0efd0a48bd347d0a374f45f109e9cd9e3e3664118ca08', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 18:30:28', '2021-07-01 18:30:28', '2022-07-02 01:30:28'),
('d2a11eafa5fa56ca91462b034ab920b27c5ec8d46d2a5e162fe15fb428987170cb8d6afba22637c9', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-07-15 03:20:43', '2021-07-15 03:20:43', '2022-07-15 10:20:43'),
('db5d42e0a67ab9a6aa8dd8124b55c56c407690fdefe9165efddc4ac6f911e6c0905e951931f5c1d4', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-06-30 23:03:54', '2021-06-30 23:03:54', '2022-07-01 06:03:54'),
('de3259092845076f3021704746f7395086eb7da37dc5b60ae8b851ea24176dbae28dadf7877a88e7', 1, 3, 'MyApp', '[\"user\"]', 0, '2021-06-29 06:11:22', '2021-06-29 06:11:22', '2022-06-29 13:11:22'),
('e202eb7d5295aa6fe06cff880485f79f47f326cd9638b56036c2a97947c2e61eeed8897c314374b8', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-22 17:01:30', '2021-07-22 17:01:30', '2022-07-23 00:01:30'),
('e4724961552e42e082b85d52a6a7b0d645d670f6208c4782a9b5fd539db3e968edfe8dfc67b4b714', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 17:07:07', '2021-07-01 17:07:07', '2022-07-02 00:07:07'),
('ef35ec7fb0b483b894b5d19024d0727c1a88b765dbfe16fea986b81fa0f1c3005e6726561d014247', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-01 22:41:07', '2021-07-01 22:41:07', '2022-07-02 05:41:07'),
('f06cef4a293600abdc9d90fa773d02339015cb47948aab18216d68c8904693f4def38c71812aedce', 1, 3, 'MyApp', '[\"staff\"]', 1, '2021-07-15 03:19:19', '2021-07-15 03:19:19', '2022-07-15 10:19:19'),
('fb051491f0b287e7123d16e026380702aae5125c3e717c09b43188803a2b4267d37fe5182d823e8e', 1, 3, 'MyApp', '[\"staff\"]', 0, '2021-07-15 23:32:54', '2021-07-15 23:32:54', '2022-07-16 06:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'QnpBtKSWnF3t2EUx35FGTK7rcP053sv49zpafufa', NULL, 'http://localhost', 1, 0, 0, '2021-06-26 16:53:24', '2021-06-26 16:53:24'),
(2, NULL, 'Laravel Password Grant Client', 'f9UGcF4f1kGLwNjYyXDa5bWJk3SPOjuZKKzpSnCS', 'users', 'http://localhost', 0, 1, 0, '2021-06-26 16:53:24', '2021-06-26 16:53:24'),
(3, NULL, 'Laravel Personal Access Client', 'nymRwyq0o0vTR4hrajFyorzB37UxZopiuKadebvq', NULL, 'http://localhost', 1, 0, 0, '2021-06-26 16:53:40', '2021-06-26 16:53:40'),
(4, NULL, 'Laravel Password Grant Client', '7hJ7057XO5dm1XOACzHVBYGgFwhHbgQGtWLag4PI', 'users', 'http://localhost', 0, 1, 0, '2021-06-26 16:53:40', '2021-06-26 16:53:40');

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

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-06-26 16:53:24', '2021-06-26 16:53:24'),
(2, 3, '2021-06-26 16:53:40', '2021-06-26 16:53:40');

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
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6anWG3NQJUaTxgix16rYq2L84JXWwK54L1i9bqy3', NULL, '::1', 'PostmanRuntime/7.28.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFRsaDFzUmdmSkJSRldXdTUxUEZ3d2U0Q29BdWJrTkVpTG5QdWs2WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1625460282),
('7TpDyxZRd2ToPHgZhvKTJ4lxKh5kvWaJ0duZb93A', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiR2NheWxnME9mUlkwajN6cDJQamh3VUl4eE5SVUxYckt0S2FRc3N0UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJDkySVhVTnBrak8wck9RNWJ5TWkuWWU0b0tvRWEzUm85bGxDLy5vZy9hdDIudWhlV0cvaWdpIjtzOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjcxOiJodHRwOi8vbG9jYWxob3N0L215LXByb2plY3QvbGFyYXZ1ZS9zdGFmZi9zdGFmZi1tYW5hZ2VtZW50L2Rvd25sb2FkLXBkZiI7fX0=', 1624748333),
('96URUwkbINBT1tDQZdsb0LZXEi1FwRqsNEInIlMk', NULL, '::1', 'PostmanRuntime/7.28.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjUyQ3VNWDRNeVFyaHFhNjFEMjZRMXJUY1RJTjBzT2h0UkRGdXJiTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1624790598),
('C3wKYgohyMQTSkqhRf1A5XiqT0x6mJL7Ujr5IrDG', NULL, '::1', 'PostmanRuntime/7.28.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3NvdkZFMDZjdllJQ0hiWE5UUlpZZ3R3S2RXZG11S0t1dElOMlZVeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1627280813),
('EQj7HCfhvXtuuicuwW4DQNq8gsQG0eau94ShNzfZ', NULL, '::1', 'PostmanRuntime/7.28.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGJwQzFXUzZOMDE3NXJtMFBoMGxOUFhRVVdBdXlaeDhLNVByUVlZUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1624774344),
('G0wkGDlUia92eGt5Qy1Au2dZxobZ9mJCkNI4iNOh', NULL, '::1', 'PostmanRuntime/7.28.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFJiSWJIVE5IVUNob3Nvdlg0cWhrUFRoUzJrRTE3NThSc2tnN3Z5YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1624752452),
('LqEpEWR8DLl7eACj4Qb6ZRLr208qW9wn8w55WxKC', NULL, '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnF5aFBFNHY5RDJ0QlVzZ20waldHeUU5Uk9acHFQTTRwZW1iYUFybCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1626919708),
('NpUwoJhYrMNJjF6SOlRBJndjrfbCcfq3pbITEJFL', NULL, '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUp0eFlPMlJha0dPaVJ2NFBaUFM5VDlXS2JNaXltWlhFRHl6R2tUQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1624774400),
('xrnGmHD7ybKjKKgYizeYH4j2VF3MrT2eTWUQ0735', NULL, '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXBDWnJHWDJNeUppa3JWYjBKUHB6WTVVamxMNG9GdkthVENzZGFESSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1626928104),
('zUIipbIbpPAiQXt1SSxLq7HBiHIIhQSqJjfFntwu', NULL, '::1', 'PostmanRuntime/7.28.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjdjbDZZYWNzUzBuQW51WVRNd1QzUmI2WFo0a0U2ekRXQjNieFZ6aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvbXktcHJvamVjdC9sYXJhdnVlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1626344838);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `email`, `password`, `gender`, `avatar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Saad Abdurrazaq', 'seadclark@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Male', '', NULL, NULL, NULL),
(3, 'Sit Amet', 'sitamet@mail.com', '$2y$10$yvoshOD.Js4/nugnGsjV3OfkxbVxPYeCpVmG0BI9qCY2r8951d76i', NULL, NULL, '2021-06-20 23:12:57', '2021-06-24 18:06:21', NULL),
(5, 'Aliquam', 'aliquam@mail.com', '$2y$10$faKTD0HZYUdqrW2/D9kJvuBhMd/hvwruV3211w.N87OQI59BVSQRO', NULL, NULL, '2021-06-21 22:38:50', '2021-06-24 23:36:28', NULL),
(6, 'General User', 'generaluser@gmail.com', '$2y$10$fFZ.NjIrNQIbDuqcrGUdd.1AK11l0lSYNkjuNJgVrxuKqAGk.baS6', NULL, NULL, '2021-06-21 22:39:19', '2021-06-24 18:06:21', NULL),
(7, 'Adipiscing', 'adipiscing@gmail.com', '$2y$10$iPDMZRNirSxu1L5XTPugIeEL/YE9iwOHmLYFSM9BkaceNHaDrqYOS', NULL, NULL, '2021-06-21 22:39:46', '2021-06-24 23:35:53', NULL),
(8, 'Lorem', 'lorem@mail.com', '$2y$10$Naj9SL3Him5zhKtT6VNXnu0zhookjz7Q9BF8Us4FZSZhzS1uV/CfG', NULL, NULL, '2021-06-21 23:04:24', '2021-06-24 18:05:05', NULL),
(9, 'Consectetur', 'consectetur@mail.com', '$2y$10$mGZtQloIJZo29VCStRtPt.2T14NGVYI5IwloFbdi.34kq7egKrjXe', NULL, NULL, '2021-06-23 06:07:50', '2021-06-24 23:35:21', NULL),
(10, 'Ipsum', 'ipsum@mail.com', '$2y$10$tM7eLOZvI5u1Vtm3h2P9COGfwzOhRtfB4L3F8I1ra.lJ5eUa4LVTy', NULL, NULL, '2021-06-23 06:16:02', '2021-06-24 18:03:20', NULL),
(11, 'Dolor', 'dolor@mail.com', '$2y$10$e7NIdBAIOerBU6wf/KvogenFOXVSwQoJ5j3MjdJvbNwuvrb1kEv5u', NULL, NULL, '2021-06-24 00:09:01', '2021-06-24 18:03:20', NULL),
(12, 'porro', 'porro@mail.com', '$2y$10$/1ib9rdvzQ2rQmTyfpuZz.i/TWMOHzNSx9X2bMrH1r1lTuP/EjOCu', NULL, NULL, '2021-06-25 18:17:52', '2021-06-25 18:17:52', NULL),
(13, 'Neque', 'Neque@mail.com', '$2y$10$vcOEhSWNDzTuGQTT0Vyx2e7YhUD8h0S1kMoLCq4mt8fOtbnh3n1ou', NULL, NULL, '2021-06-25 18:56:22', '2021-06-26 17:15:21', NULL),
(14, 'quisquam', 'quisquam@mail.com', '$2y$10$iXHJ6Ayoh7O0hyf5jcJ3iuM/vytBgw5A9954eu2/bRqxcNMiQN0l6', NULL, NULL, '2021-06-25 18:57:30', '2021-06-26 17:15:21', NULL),
(17, 'veliti', 'velit@mail.com', '$2y$10$rL76Ojo6DJ679NdJxB73gOfayw8Ngj8MA/KnNtEDQLQ2.KGQw0Ckm', NULL, NULL, '2021-06-26 21:48:12', '2021-06-27 04:29:30', '2021-06-27 04:29:30'),
(18, 'dogdog', 'dogdog@mail.com', '$2y$10$gIdrL1Me0mnL5hR6nxeHF.H1QgLvaXTquSAPCp2cibu4430YBFfgG', NULL, NULL, '2021-06-27 04:25:40', '2021-06-27 04:29:30', '2021-06-27 04:29:30'),
(19, 'dum', 'dum@mail.com', '$2y$10$69yX85DW2oueI.gRV7KutuT6cne3IVZkSke5BJxqyarncoUqM2ME.', NULL, NULL, '2021-06-27 04:28:04', '2021-06-27 04:28:59', '2021-06-27 04:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `subcategory_name`, `subcategory_slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 46, 'Buku Masakan', 'buku-masakan', NULL, '2021-07-31 19:59:20', NULL),
(12, 46, ' Buku Persiapan Ujian', 'buku-persiapan-ujian', NULL, '2021-07-31 19:59:20', NULL),
(13, 46, ' Buku Remaja dan Anak', 'buku-remaja-dan-anak', NULL, '2021-07-31 19:59:20', NULL),
(14, 46, 'Komik', 'komik', NULL, '2021-07-31 19:59:20', NULL),
(15, 46, ' Majalah', 'majalah', NULL, '2021-07-31 19:59:20', NULL),
(16, 30, ' Peralatan Masak', 'peralatan-masak', NULL, '2021-07-31 19:59:20', NULL),
(17, 30, ' Peralatan Makan & Minum', 'peralatan-makan-&-minum', NULL, '2021-07-31 19:59:20', NULL),
(18, 36, 'Aksesoris Kamera', 'aksesoris-kamera', NULL, '2021-07-31 19:59:20', NULL),
(19, 36, ' Camcorder', 'camcorder', NULL, '2021-07-31 19:59:20', NULL),
(20, 37, ' Analog', 'analog', NULL, '2021-07-31 19:59:20', NULL),
(21, 37, ' Digital', 'digital', NULL, '2021-07-31 19:59:20', NULL),
(22, 37, ' Audio', 'audio', NULL, '2021-07-31 19:59:20', NULL),
(23, 37, ' Alat Pendingin Ruangan', 'alat-pendingin-ruangan', NULL, '2021-07-31 19:59:20', NULL),
(24, 37, ' Elektronik Kantor', 'elektronik-kantor', NULL, '2021-07-31 19:59:20', NULL),
(25, 36, ' Kamera Pengintai', 'kamera-pengintai', NULL, '2021-07-31 19:59:20', NULL),
(26, 37, ' Media Player', 'media-player', NULL, '2021-07-31 19:59:20', NULL),
(27, 37, ' Printer', 'printer', NULL, '2021-07-31 19:59:20', NULL),
(28, 38, ' Suplemen Diet', 'suplemen-diet', NULL, '2021-07-31 19:59:20', NULL),
(29, 38, ' Essential Oil', 'essential-oil', NULL, '2021-07-31 19:59:20', NULL),
(30, 38, ' Obat-obatan', 'obat-obatan', NULL, '2021-07-31 19:59:20', NULL),
(31, 38, ' Masker', 'masker', NULL, '2021-07-31 19:59:20', NULL),
(32, 35, ' Paket Tour', 'paket-tour', NULL, '2021-07-31 19:59:20', NULL),
(33, NULL, ' Tiket Transportasi', 'tiket-transportasi', NULL, '2021-07-31 19:59:20', NULL),
(34, NULL, ' Voucher Travel', 'voucher-travel', NULL, '2021-07-31 20:04:45', NULL),
(35, 45, ' Perumahan', 'perumahan', NULL, '2021-07-31 19:59:20', NULL),
(36, 33, ' Aksesoris Motor', 'aksesoris-motor', NULL, '2021-07-31 19:59:20', NULL),
(37, 33, ' Eksterior Mobil', 'eksterior-mobil', NULL, '2021-07-31 19:59:20', NULL),
(38, 33, ' Interior Mobil', 'interior-mobil', NULL, '2021-07-31 19:59:20', NULL),
(39, 33, ' Helm Motor', 'helm-motor', NULL, '2021-07-31 19:59:20', NULL),
(40, 32, ' Aksesoris Olahraga', 'aksesoris-olahraga', NULL, '2021-07-31 19:59:20', NULL),
(41, 32, ' Beladiri', 'beladiri', NULL, '2021-07-31 19:59:20', NULL),
(42, 32, 'Boxing', 'boxing', NULL, '2021-07-31 19:59:20', NULL),
(43, 32, ' Panahan', 'panahan', NULL, '2021-07-31 19:59:20', NULL),
(44, 32, ' Tenis', 'tenis', NULL, '2021-07-31 19:59:20', NULL),
(45, 30, ' Dekorasi', 'dekorasi', NULL, '2021-07-31 19:59:20', NULL),
(46, 30, ' Kamar Mandi', 'kamar-mandi', NULL, '2021-07-31 19:59:20', NULL),
(47, 30, ' Kebersihan', 'kebersihan', NULL, '2021-07-31 19:59:20', NULL),
(48, NULL, ' Taman', 'taman', NULL, '2021-07-31 19:59:20', NULL),
(49, 30, ' Tempat Penyimpanan', 'tempat-penyimpanan', NULL, '2021-07-31 19:59:20', NULL),
(50, 29, ' Grooming Hewan', 'grooming-hewan', NULL, '2021-07-31 19:59:20', NULL),
(51, 29, ' Perawatan Burung', 'perawatan-burung', NULL, '2021-07-31 19:59:20', NULL),
(52, 29, ' Perawatan Kucing', 'perawatan-kucing', NULL, '2021-07-31 19:59:20', NULL),
(53, 29, ' Perawatan Anjing', 'perawatan-anjing', NULL, '2021-07-31 07:03:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_categories`
--

CREATE TABLE `sub_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subsubcategory_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subsubcategory_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_sub_categories`
--

INSERT INTO `sub_sub_categories` (`id`, `category_id`, `subcategory_id`, `subsubcategory_name`, `subsubcategory_slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 46, 11, 'Resep Kue', 'resep-kue', NULL, '2021-07-30 23:26:18', NULL),
(2, NULL, NULL, 'Bass Akustik', 'bass-akustik', NULL, '2021-07-30 15:45:54', NULL),
(3, 35, 32, ' Bass Elektrik', 'bass-elektrik', NULL, '2021-07-31 04:26:29', NULL),
(4, 45, 35, ' Mainan Mandi Bayi', 'mainan-mandi-bayi', NULL, '2021-07-31 04:27:41', NULL),
(5, NULL, NULL, ' Pagar Pengaman Bayi', 'pagar-pengaman-bayi', NULL, '2021-07-31 04:50:54', NULL),
(6, 46, 15, 'Majalah Anak', 'majalah-anak', NULL, '2021-07-31 21:00:22', NULL),
(7, 46, 15, ' Majalah Desain', 'majalah-desain', NULL, '2021-07-31 21:00:22', NULL),
(8, 46, 15, 'Majalah Fashion', 'majalah-fashion', NULL, '2021-07-31 21:00:22', NULL),
(9, 46, 15, ' Majalah Musik', 'majalah-musik', NULL, '2021-07-31 21:00:22', NULL),
(10, 46, 13, 'Katalog', 'katalog', NULL, '2021-07-30 23:26:09', NULL);

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
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user@mail.com', NULL, '$2y$10$JTCYA3LwsyGDkYuzh7/H3ORwNayG6xUw2LYQfdXqn39Hs2QUIRh.C', NULL, NULL, NULL, NULL, NULL, 'Male', NULL, '2021-07-04 21:44:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_index` (`category_id`);

--
-- Indexes for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_sub_categories_category_id_index` (`category_id`),
  ADD KEY `sub_sub_categories_subcategory_id_index` (`subcategory_id`);

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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD CONSTRAINT `sub_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `sub_sub_categories_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
