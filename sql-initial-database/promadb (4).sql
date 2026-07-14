-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 09:33 PM
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
-- Database: `promadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE `collaborators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `establishment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `worker_code` varchar(50) NOT NULL,
  `establishment` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collaborators`
--

INSERT INTO `collaborators` (`id`, `establishment_id`, `name`, `worker_code`, `establishment`, `created_at`, `updated_at`) VALUES
(3, 23, 'Promise Sabau Waize', 'PM67', 'Nampula Escritorios', '2026-07-13 04:20:58', '2026-07-14 12:38:44'),
(4, 23, 'Maines Gandawa', 'PM56', 'Nampula Escritorios', '2026-07-13 04:22:26', '2026-07-14 12:38:02'),
(5, 2, 'Alberto Francisco Buque', '', 'Nampula loja 2', '2026-07-13 04:22:58', '2026-07-13 04:22:58'),
(6, 2, 'Takunda Lavumo Mateko', '', 'Nampula loja 2', '2026-07-13 04:23:20', '2026-07-13 04:23:20'),
(7, 2, 'Rodrigues Lourenco Nheta', '', 'Nampula loja 2', '2026-07-13 04:23:52', '2026-07-13 04:23:52'),
(9, 2, 'Gildo Luis Foguete', '', 'Nampula loja 2', '2026-07-13 04:32:50', '2026-07-13 04:32:50'),
(10, 3, 'Neima Fernando Cumbane', '', 'Pemba Loja', '2026-07-13 04:33:26', '2026-07-13 12:53:57'),
(11, 23, 'Jaimina Pedro Manuel', 'PM23', 'Nampula Escritorios', '2026-07-13 04:33:54', '2026-07-14 12:36:58'),
(12, 2, 'Miguel Silvio B. Caconque', '', 'Nampula loja 2', '2026-07-13 04:34:32', '2026-07-13 04:34:32'),
(13, 2, 'Leonel Da Conceicao Nazare', '', 'Nampula loja 2', '2026-07-13 04:34:55', '2026-07-13 04:34:55'),
(14, 1, 'Jeronimo Elias Siripuite', '', 'Motorista', '2026-07-13 04:35:17', '2026-07-13 04:35:46'),
(15, 3, 'Anagi Amade', '', 'Pemba Loja', '2026-07-13 04:36:08', '2026-07-13 04:36:08'),
(16, 4, 'Flora Januario Santos', '', 'Loja Malema', '2026-07-13 04:36:29', '2026-07-13 04:36:29'),
(17, 5, 'Miranda Camucho Nlogo', '', 'Guarda Nampula 1', '2026-07-13 04:36:53', '2026-07-13 04:36:53'),
(18, 6, 'Lauresciencia Marcos Nhone', '', 'Armazem de Sementes', '2026-07-13 04:37:16', '2026-07-13 04:37:16'),
(19, 4, 'Paulo Ilidio C. Gulumanha', '', 'Loja Malema', '2026-07-13 04:37:35', '2026-07-13 04:37:35'),
(20, 8, 'Patricio Avelino Abel', '', 'Mecanico', '2026-07-13 04:37:53', '2026-07-13 04:37:53'),
(21, 7, 'Rita Omar Abdala', '', 'Loja Lioma', '2026-07-13 04:38:10', '2026-07-13 04:38:10'),
(22, 9, 'Lucas Camuzu Inloco', '', 'Loja Tete', '2026-07-13 04:38:31', '2026-07-13 04:38:31'),
(23, 10, 'Alberto Jose Leite', '', 'Guarda Nampula 2', '2026-07-13 04:39:00', '2026-07-13 04:39:00'),
(24, 3, 'Cipriano Cardoso Muarupaca', '', 'Pemba Loja', '2026-07-13 04:39:25', '2026-07-13 12:41:48'),
(25, 21, 'Vania Miguel Chilengue', '', 'Nampula Loja 1', '2026-07-13 04:40:58', '2026-07-13 04:40:58'),
(26, 22, 'Vasco Cardoso Muarupaca', '', 'Guarda Pemba', '2026-07-13 04:42:02', '2026-07-13 04:42:02'),
(27, 23, 'Hernane De Melo Gonçalves', 'PM21', 'Nampula Escritorios', '2026-07-13 04:42:22', '2026-07-14 12:36:35'),
(28, 10, 'Raimundo Agostinho', '', 'Guarda Nampula 2', '2026-07-13 04:42:41', '2026-07-13 04:42:41'),
(29, 11, 'Sandra Raul Amisse', '', 'Loja Lichinga', '2026-07-13 04:42:58', '2026-07-13 04:42:58'),
(30, 19, 'Judite Orlando', '', 'Loja Montepuez', '2026-07-13 04:43:23', '2026-07-13 04:43:23'),
(31, 12, 'Lucas Elias Araujo Lampe', '', 'Loja Changara Tete', '2026-07-13 04:43:41', '2026-07-13 04:43:41'),
(32, 13, 'Amelia Carlos Repele', '', 'Limpeza Nampula 2', '2026-07-13 04:43:59', '2026-07-13 04:43:59'),
(33, 23, 'Roberto Joao Nhamua Mioche', 'PM87', 'Nampula Escritorios', '2026-07-13 04:44:16', '2026-07-14 12:39:02'),
(34, 4, 'Paulino Agostinho', '', 'Loja Malema', '2026-07-13 04:45:14', '2026-07-13 04:45:14'),
(35, 1, 'Geraldo Agostinho Mulucuvaha', '', 'Motorista', '2026-07-13 04:45:45', '2026-07-13 04:45:45'),
(36, 20, 'Loise Ramadane', '', 'Loja Ribaue', '2026-07-13 04:46:01', '2026-07-13 04:46:01'),
(37, 5, 'Jorge Bernardo Jose Taio', '', 'Guarda Nampula 1', '2026-07-13 04:46:17', '2026-07-13 10:34:13'),
(38, 19, 'Anselmo Osorio Monteiro', '', 'Loja Montepuez', '2026-07-13 04:46:46', '2026-07-13 04:46:46'),
(39, 18, 'Divatonk Francisco Ampuaia', '', 'Jardineiro Nampula 2', '2026-07-13 04:47:09', '2026-07-13 04:47:09'),
(40, 14, 'Luis Paulo Culauone', '', 'Loja Tete Central', '2026-07-13 04:47:38', '2026-07-13 04:47:38'),
(41, 2, 'Miguel F. A. Jose', '', 'Nampula loja 2', '2026-07-13 04:47:59', '2026-07-13 04:47:59'),
(42, 17, 'Oliver Jose Xavier', '', 'Tete Chitima Loja', '2026-07-13 04:48:20', '2026-07-13 04:48:20'),
(43, 14, 'Albertina M. A. Quartel', '', 'Loja Tete Central', '2026-07-13 04:48:45', '2026-07-13 04:48:45'),
(44, 16, 'Idai Fernando', '', 'Loja Mucumbura Tete', '2026-07-13 04:49:08', '2026-07-13 04:49:08'),
(45, 15, 'Raul Ganancio Biquiwane', '', 'Loja Marara Tete', '2026-07-13 04:49:27', '2026-07-13 04:49:27'),
(46, 14, 'Wellack Mande', '', 'Loja Tete Central', '2026-07-13 04:49:59', '2026-07-13 04:49:59'),
(47, 2, 'Ruquia Jamal Ramadane', '', 'Nampula loja 2', '2026-07-13 04:50:21', '2026-07-13 04:50:21'),
(49, 10, 'Angelo Simao Taio', '', 'Guarda Nampula 2', '2026-07-13 04:51:07', '2026-07-13 10:33:58'),
(51, 10, 'Albano Moises S. Campira', '', 'Guarda Nampula 2', '2026-07-13 04:51:50', '2026-07-13 04:51:50'),
(52, 2, 'Arminda Antonio C. Muiocha', '', 'Nampula loja 2', '2026-07-13 04:52:08', '2026-07-13 04:52:08'),
(54, 14, 'Benjamim Geronimo Ribeiro', '', 'Loja Tete Central', '2026-07-13 04:53:03', '2026-07-13 04:53:03'),
(55, 2, 'Euneta Zaidine Zitha', '', 'Nampula loja 2', '2026-07-13 04:53:24', '2026-07-13 04:53:24'),
(57, 2, 'Davide Jacinto Antonio', '', 'Nampula loja 2', '2026-07-13 04:54:03', '2026-07-13 04:54:03'),
(58, 23, 'Arsenia Lucas F. Jeremias', 'PM20', 'Nampula Escritorios', '2026-07-13 04:54:24', '2026-07-14 12:35:49'),
(59, 2, 'Antonio Amarso', '', 'Nampula loja 2', '2026-07-13 06:07:53', '2026-07-13 06:07:53'),
(60, 23, 'Katia Karina Aurelio Jose', 'PM45', 'Nampula Escritorios', '2026-07-13 06:34:10', '2026-07-14 12:37:36'),
(61, 2, 'Olivia', '', 'Nampula loja 2', '2026-07-13 06:58:51', '2026-07-13 06:58:51'),
(62, 2, 'Isolinda', '', 'Nampula loja 2', '2026-07-13 07:00:22', '2026-07-13 07:00:22'),
(63, 2, 'Valeria', '', 'Nampula loja 2', '2026-07-13 07:00:35', '2026-07-13 07:00:35'),
(64, 2, 'Guinalda', '', 'Nampula loja 2', '2026-07-13 07:00:46', '2026-07-13 07:00:46'),
(65, 2, 'Dercia Joaneta Lumbe', '', 'Nampula loja 2', '2026-07-13 07:12:14', '2026-07-13 07:12:14'),
(66, 21, 'Didalicia Albano De Sousa', '', 'Nampula Loja 1', '2026-07-13 12:14:45', '2026-07-14 07:46:53'),
(67, 3, 'Cecilia Carlos', '', 'Pemba Loja', '2026-07-13 12:53:22', '2026-07-13 12:53:22'),
(68, 2, 'Agostinho Soberano', 'R200', 'Nampula loja 2', '2026-07-14 07:52:43', '2026-07-14 11:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `establishments`
--

CREATE TABLE `establishments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `establishments`
--

INSERT INTO `establishments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Motorista', '2026-07-09 21:09:43', '2026-07-13 04:06:43'),
(2, 'Nampula loja 2', '2026-07-09 21:09:43', '2026-07-13 04:06:24'),
(3, 'Pemba Loja', '2026-07-13 04:06:57', '2026-07-13 04:06:57'),
(4, 'Loja Malema', '2026-07-13 04:07:11', '2026-07-13 04:07:11'),
(5, 'Guarda Nampula 1', '2026-07-13 04:07:29', '2026-07-13 04:07:29'),
(6, 'Armazem de Sementes', '2026-07-13 04:07:44', '2026-07-13 04:07:44'),
(7, 'Loja Lioma', '2026-07-13 04:08:15', '2026-07-13 04:08:15'),
(8, 'Mecanico', '2026-07-13 04:08:45', '2026-07-13 04:08:45'),
(9, 'Loja Tete', '2026-07-13 04:09:03', '2026-07-13 04:09:03'),
(10, 'Guarda Nampula 2', '2026-07-13 04:09:25', '2026-07-13 04:09:25'),
(11, 'Loja Lichinga', '2026-07-13 04:09:45', '2026-07-13 04:09:45'),
(12, 'Loja Changara Tete', '2026-07-13 04:10:23', '2026-07-13 04:10:23'),
(13, 'Limpeza Nampula 2', '2026-07-13 04:10:51', '2026-07-13 04:11:10'),
(14, 'Loja Tete Central', '2026-07-13 04:11:44', '2026-07-13 04:11:44'),
(15, 'Loja Marara Tete', '2026-07-13 04:13:00', '2026-07-13 04:13:00'),
(16, 'Loja Mucumbura Tete', '2026-07-13 04:13:24', '2026-07-13 04:13:24'),
(17, 'Tete Chitima Loja', '2026-07-13 04:14:03', '2026-07-13 04:14:03'),
(18, 'Jardineiro Nampula 2', '2026-07-13 04:14:38', '2026-07-13 04:14:38'),
(19, 'Loja Montepuez', '2026-07-13 04:15:08', '2026-07-13 04:15:08'),
(20, 'Loja Ribaue', '2026-07-13 04:15:33', '2026-07-13 04:15:33'),
(21, 'Nampula Loja 1', '2026-07-13 04:40:39', '2026-07-13 04:40:39'),
(22, 'Guarda Pemba', '2026-07-13 04:41:35', '2026-07-13 04:41:35'),
(23, 'Nampula Escritorios', '2026-07-14 12:34:28', '2026-07-14 12:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `establishment_managements`
--

CREATE TABLE `establishment_managements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `collaborator_id` bigint(20) UNSIGNED NOT NULL,
  `closed_by_collaborator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `opened_at` time DEFAULT NULL,
  `closed_at` time DEFAULT NULL,
  `establishment_state` enum('Aberto','Fechado','Parcialmente') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_status` enum('critico','razoavel','bom') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `establishment_managements`
--

INSERT INTO `establishment_managements` (`id`, `collaborator_id`, `closed_by_collaborator_id`, `date`, `opened_at`, `closed_at`, `establishment_state`, `description`, `description_status`, `created_at`, `updated_at`) VALUES
(2, 10, 10, '2026-07-13', '07:16:00', '17:35:00', 'Aberto', 'Camera 06 e Camera 08 Indisponivel', 'critico', '2026-07-14 05:37:52', '2026-07-14 11:52:40'),
(3, 55, 55, '2026-07-13', '07:22:00', '17:28:00', 'Aberto', 'Camera 7 –Problema de tremor de imagem', 'razoavel', '2026-07-14 10:31:16', '2026-07-14 10:31:16'),
(4, 25, 25, '2026-07-13', '07:04:00', '17:11:00', 'Aberto', 'Camera 08-Indisponivel', 'critico', '2026-07-14 10:58:44', '2026-07-14 11:02:04');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_07_09_212116_create_collaborators_table', 1),
(6, '2026_07_09_212117_create_time_entries_table', 1),
(7, '2026_07_09_220232_add_description_status_to_time_entries_table', 2),
(8, '2026_07_09_220253_add_description_status_to_time_entries_table', 2),
(9, '2026_07_09_225801_create_establishments_table', 3),
(10, '2026_07_09_225802_add_establishment_id_to_collaborators_table', 3),
(11, '2026_07_09_232137_add_establishment_state_to_time_entries_table', 4),
(12, '2026_07_10_000001_add_role_to_users_table', 5),
(13, '2026_07_13_120000_drop_workload_hours_from_time_entries_table', 6),
(14, '2026_07_14_000000_create_establishment_managements_table', 7),
(15, '2026_07_14_010000_add_closed_by_collaborator_id_to_establishment_managements_table', 8),
(16, '2026_07_14_020000_update_presence_enum_in_time_entries_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_entries`
--

CREATE TABLE `time_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `collaborator_id` bigint(20) UNSIGNED NOT NULL,
  `establishment` varchar(255) NOT NULL,
  `entry_time` time DEFAULT NULL,
  `exit_time` time DEFAULT NULL,
  `presence` enum('Presente','Ausente','Justificado') NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_entries`
--

INSERT INTO `time_entries` (`id`, `date`, `collaborator_id`, `establishment`, `entry_time`, `exit_time`, `presence`, `description`, `created_at`, `updated_at`) VALUES
(4, '2026-07-13', 55, 'Nampula loja 2', '07:12:00', '17:21:00', 'Presente', NULL, '2026-07-13 05:47:08', '2026-07-14 07:11:31'),
(5, '2026-07-13', 59, 'Nampula loja 2', '07:17:00', '17:01:00', 'Presente', NULL, '2026-07-13 06:10:37', '2026-07-14 06:23:50'),
(6, '2026-07-13', 57, 'Nampula loja 2', '07:26:00', '17:16:00', 'Presente', NULL, '2026-07-13 06:26:32', '2026-07-14 06:57:06'),
(7, '2026-07-13', 52, 'Nampula loja 2', '07:27:00', '17:15:00', 'Presente', NULL, '2026-07-13 06:31:46', '2026-07-14 06:50:22'),
(8, '2026-07-13', 60, 'Nampula loja 2', '07:27:00', '17:18:00', 'Presente', NULL, '2026-07-13 06:34:52', '2026-07-14 07:08:04'),
(9, '2026-07-13', 64, 'Nampula loja 2', '07:28:00', '17:15:00', 'Presente', NULL, '2026-07-13 07:09:20', '2026-07-14 06:51:56'),
(10, '2026-07-13', 63, 'Nampula loja 2', '07:28:00', '17:15:00', 'Presente', NULL, '2026-07-13 07:10:35', '2026-07-14 06:55:00'),
(11, '2026-07-13', 65, 'Nampula loja 2', '07:29:00', '17:21:00', 'Presente', NULL, '2026-07-13 07:13:15', '2026-07-14 07:12:15'),
(12, '2026-07-13', 62, 'Nampula loja 2', '07:29:00', '17:16:00', 'Presente', NULL, '2026-07-13 07:16:59', '2026-07-14 06:56:24'),
(13, '2026-07-13', 61, 'Nampula loja 2', '07:31:00', '17:17:00', 'Presente', NULL, '2026-07-13 07:20:32', '2026-07-14 06:58:38'),
(14, '2026-07-13', 11, 'Nampula loja 2', '07:27:00', '17:10:00', 'Presente', NULL, '2026-07-13 07:23:29', '2026-07-14 06:41:51'),
(16, '2026-07-13', 32, 'Limpeza Nampula 2', '07:33:00', '17:28:00', 'Presente', NULL, '2026-07-13 07:34:15', '2026-07-14 07:29:16'),
(18, '2026-07-13', 27, 'Nampula loja 2', '07:33:00', '17:10:00', 'Presente', NULL, '2026-07-13 07:35:39', '2026-07-14 06:44:38'),
(19, '2026-07-13', 9, 'Nampula loja 2', '07:40:00', '17:08:00', 'Presente', NULL, '2026-07-13 07:56:23', '2026-07-14 06:45:44'),
(20, '2026-07-13', 12, 'Nampula loja 2', '07:55:00', '17:18:00', 'Presente', NULL, '2026-07-13 08:03:46', '2026-07-14 07:06:11'),
(22, '2026-07-13', 6, 'Nampula loja 2', '08:04:00', '17:17:00', 'Presente', NULL, '2026-07-13 10:14:04', '2026-07-14 07:00:42'),
(23, '2026-07-13', 49, 'Guarda Nampula 2', '06:56:00', '17:31:00', 'Presente', NULL, '2026-07-13 10:55:36', '2026-07-14 07:16:26'),
(24, '2026-07-13', 58, 'Nampula loja 2', '08:17:00', '17:10:00', 'Presente', NULL, '2026-07-13 11:17:30', '2026-07-14 06:43:04'),
(25, '2026-07-13', 38, 'Loja Montepuez', '07:22:00', '17:22:00', 'Presente', NULL, '2026-07-13 11:30:29', '2026-07-14 12:12:34'),
(26, '2026-07-13', 25, 'Nampula Loja 1', '07:04:00', '17:11:00', 'Presente', NULL, '2026-07-13 11:42:33', '2026-07-14 12:00:12'),
(27, '2026-07-13', 37, 'Guarda Nampula 1', '06:05:00', '17:11:00', 'Presente', NULL, '2026-07-13 11:45:18', '2026-07-14 12:01:13'),
(28, '2026-07-13', 66, 'Nampula Loja 1', '07:22:00', '17:11:00', 'Presente', NULL, '2026-07-13 12:16:20', '2026-07-14 11:18:52'),
(29, '2026-07-13', 10, 'Pemba Loja', '07:16:00', '17:35:00', 'Presente', NULL, '2026-07-13 12:25:39', '2026-07-14 11:54:48'),
(30, '2026-07-13', 15, 'Pemba Loja', '07:20:00', '17:35:00', 'Presente', NULL, '2026-07-13 12:29:39', '2026-07-14 11:55:31'),
(31, '2026-07-13', 24, 'Pemba Loja', '07:25:00', '17:35:00', 'Presente', NULL, '2026-07-13 12:46:16', '2026-07-14 11:51:32'),
(32, '2026-07-13', 67, 'Pemba Loja', '07:29:00', '17:35:00', 'Presente', NULL, '2026-07-13 12:54:39', '2026-07-14 11:57:54'),
(34, '2026-07-13', 33, 'Nampula loja 2', NULL, NULL, 'Justificado', 'motivos de saude(doente)', '2026-07-14 06:12:29', '2026-07-14 06:12:29'),
(35, '2026-07-13', 39, 'Jardineiro Nampula 2', NULL, '17:10:00', 'Presente', 'Por verificar a hora de entrada', '2026-07-14 06:36:05', '2026-07-14 06:37:03'),
(36, '2026-07-13', 68, 'Nampula loja 2', '07:24:00', '17:21:00', 'Presente', NULL, '2026-07-14 11:28:45', '2026-07-14 11:28:45'),
(37, '2026-07-13', 7, 'Nampula loja 2', '07:30:00', '17:44:00', 'Presente', NULL, '2026-07-14 11:35:15', '2026-07-14 11:35:15'),
(38, '2026-07-13', 30, 'Loja Montepuez', '07:29:00', '17:22:00', 'Presente', NULL, '2026-07-14 12:16:09', '2026-07-14 12:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@pm.com', NULL, '$2y$12$mQDcU0mMVNS.5hgK0l0zheWMuFuACf2I0QbpXxx05IeEzwxBQdtQW', 'admin', 'iOmeCqf1k47Kaixg5q9NNkYa7lqCsWOPEoeHG3YQdGQVHGIaj5Lp6GlzqTKQ', '2026-07-09 23:34:28', '2026-07-09 23:34:28'),
(2, 'Manager', 'Manager@pm.com', NULL, '$2y$12$surEZIWBkeAYVbifDpEUV.iREC3WiHZpoVBK15zERPVHnhujksuZK', 'user', NULL, '2026-07-09 23:34:29', '2026-07-09 23:34:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collaborators_establishment_id_foreign` (`establishment_id`);

--
-- Indexes for table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `establishments_name_unique` (`name`);

--
-- Indexes for table `establishment_managements`
--
ALTER TABLE `establishment_managements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `establishment_managements_date_index` (`date`),
  ADD KEY `establishment_managements_collaborator_id_date_index` (`collaborator_id`,`date`),
  ADD KEY `establishment_managements_closed_by_collaborator_id_foreign` (`closed_by_collaborator_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `time_entries`
--
ALTER TABLE `time_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_entries_collaborator_id_foreign` (`collaborator_id`);

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
-- AUTO_INCREMENT for table `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `establishment_managements`
--
ALTER TABLE `establishment_managements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_entries`
--
ALTER TABLE `time_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD CONSTRAINT `collaborators_establishment_id_foreign` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `establishment_managements`
--
ALTER TABLE `establishment_managements`
  ADD CONSTRAINT `establishment_managements_closed_by_collaborator_id_foreign` FOREIGN KEY (`closed_by_collaborator_id`) REFERENCES `collaborators` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `establishment_managements_collaborator_id_foreign` FOREIGN KEY (`collaborator_id`) REFERENCES `collaborators` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `time_entries`
--
ALTER TABLE `time_entries`
  ADD CONSTRAINT `time_entries_collaborator_id_foreign` FOREIGN KEY (`collaborator_id`) REFERENCES `collaborators` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
