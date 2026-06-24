-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for transport_management_db
CREATE DATABASE IF NOT EXISTS `transport_management_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `transport_management_db`;

-- Dumping structure for table transport_management_db.auth_groups_users
CREATE TABLE IF NOT EXISTS `auth_groups_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.auth_groups_users: ~0 rows (approximately)
DELETE FROM `auth_groups_users`;
INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
	(1, 1, 'superadmin', '2026-06-24 07:05:23');

-- Dumping structure for table transport_management_db.auth_identities
CREATE TABLE IF NOT EXISTS `auth_identities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secret` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `secret2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text COLLATE utf8mb4_general_ci,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_secret` (`type`,`secret`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.auth_identities: ~0 rows (approximately)
DELETE FROM `auth_identities`;
INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 'email_password', NULL, 'admin@domain.com', '$2y$12$Dvf2cueXIDZxb/VFSFk7g.uuMuXYdZzzrKpKEvpoKhkKfed5qsJDe', NULL, NULL, 0, '2026-06-24 14:30:27', '2026-06-24 07:05:22', '2026-06-24 14:30:27');

-- Dumping structure for table transport_management_db.auth_logins
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_identifier` (`id_type`,`identifier`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.auth_logins: ~0 rows (approximately)
DELETE FROM `auth_logins`;
INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
	(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'email_password', 'admin@domain.com', 1, '2026-06-24 14:16:44', 1),
	(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', NULL, '2026-06-24 14:24:19', 0),
	(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'email_password', 'admin@domain.com', 1, '2026-06-24 14:24:31', 1),
	(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'email_password', 'admin@example.com', NULL, '2026-06-24 14:30:15', 0),
	(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'email_password', 'admin@domain.com', 1, '2026-06-24 14:30:27', 1);

-- Dumping structure for table transport_management_db.auth_permissions_users
CREATE TABLE IF NOT EXISTS `auth_permissions_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_permissions_users_user_id_foreign` (`user_id`),
  CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.auth_permissions_users: ~0 rows (approximately)
DELETE FROM `auth_permissions_users`;

-- Dumping structure for table transport_management_db.auth_remember_tokens
CREATE TABLE IF NOT EXISTS `auth_remember_tokens` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hashedValidator` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `auth_remember_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.auth_remember_tokens: ~0 rows (approximately)
DELETE FROM `auth_remember_tokens`;
INSERT INTO `auth_remember_tokens` (`id`, `selector`, `hashedValidator`, `user_id`, `expires`, `created_at`, `updated_at`) VALUES
	(1, '0e1cf947c638bbb617d5f5f9', '98773a7002e2d0131b220757132f2ca5c245685717a4a89486373c1934b208b2', 1, '2026-07-24 14:30:27', '2026-06-24 14:30:27', '2026-06-24 14:30:27');

-- Dumping structure for table transport_management_db.auth_token_logins
CREATE TABLE IF NOT EXISTS `auth_token_logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type_identifier` (`id_type`,`identifier`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.auth_token_logins: ~0 rows (approximately)
DELETE FROM `auth_token_logins`;

-- Dumping structure for table transport_management_db.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `contact_person` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.customers: ~3 rows (approximately)
DELETE FROM `customers`;
INSERT INTO `customers` (`id`, `company_name`, `address`, `contact_person`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'PT. SENTOSA JAYAx', 'Jl. Raya Cirebon', 'Robert Hudson', '2026-06-24 14:05:23', '2026-06-24 15:06:55', NULL),
	(2, 'PT Trans News Corpora', 'Mampang Prapatan', 'Didinx', '2026-06-24 09:10:39', '2026-06-24 14:54:54', '2026-06-24 14:54:54'),
	(3, 'PT. CNN', 'jalan', 'arupi', '2026-06-24 15:16:21', '2026-06-24 16:08:36', NULL);

-- Dumping structure for table transport_management_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.migrations: ~1 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(8, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1782284717, 1),
	(9, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1782284717, 1),
	(10, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1782284717, 1),
	(11, '2026-06-24-062616', 'App\\Database\\Migrations\\Customers', 'default', 'App', 1782284717, 1),
	(12, '2026-06-24-062635', 'App\\Database\\Migrations\\Products', 'default', 'App', 1782284718, 1),
	(13, '2026-06-24-062649', 'App\\Database\\Migrations\\Transactions', 'default', 'App', 1782284718, 1),
	(14, '2026-06-24-062703', 'App\\Database\\Migrations\\TransactionDetails', 'default', 'App', 1782284718, 1);

-- Dumping structure for table transport_management_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.products: ~6 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `product_code`, `product_name`, `unit`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'PR01', 'Ban Luarxxx', 'Pcs', 230000045.00, '2026-06-24 14:05:23', '2026-06-24 15:15:29', NULL),
	(2, 'PR02', 'Baut Ukuran 18', 'Dus', 110000.00, '2026-06-24 14:05:23', '2026-06-24 09:28:29', '2026-06-24 09:28:29'),
	(3, 'PR03', 'Oli Mesin', 'Liter', 125000.00, '2026-06-24 14:05:23', '2026-06-24 14:05:23', NULL),
	(4, 'PROD002', 'Indomilk', 'pcs', 50000.00, '2026-06-24 09:24:21', '2026-06-24 09:34:06', '2026-06-24 09:34:06'),
	(5, 'PROD009', 'Indomilk', 'Pcs', 500000.00, '2026-06-24 15:10:10', '2026-06-24 15:10:10', NULL),
	(6, 'PROD006', 'Indomilk', 'Pcs', 5000.00, '2026-06-24 15:14:31', '2026-06-24 15:14:31', NULL);

-- Dumping structure for table transport_management_db.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `type` varchar(31) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `context` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.settings: ~0 rows (approximately)
DELETE FROM `settings`;

-- Dumping structure for table transport_management_db.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `pic_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `grand_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_number` (`invoice_number`),
  KEY `transactions_customer_id_foreign` (`customer_id`),
  CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.transactions: ~5 rows (approximately)
DELETE FROM `transactions`;
INSERT INTO `transactions` (`id`, `invoice_number`, `invoice_date`, `customer_id`, `pic_name`, `grand_total`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '034/TD/XI/2024', '2024-06-25', 1, 'Ilham', 25925000.00, '2026-06-24 14:05:23', '2026-06-24 14:05:23', NULL),
	(10, 'INV-234', '2026-06-24', 1, 'Arupi', 2300000.00, '2026-06-24 13:53:52', '2026-06-24 13:55:41', '2026-06-24 13:55:41'),
	(11, 'INV-235', '2026-06-24', 1, 'Arupix', 5100000.00, '2026-06-24 13:55:26', '2026-06-24 14:05:30', '2026-06-24 14:05:30'),
	(12, 'INV-236', '2026-06-24', 1, 'Arupixc', 375000.00, '2026-06-24 15:07:18', '2026-06-24 16:08:45', NULL),
	(13, 'INV-237', '2026-06-24', 1, 'bvdb', 2300000450.00, '2026-06-24 15:18:46', '2026-06-24 15:42:45', NULL),
	(14, 'INV-239', '2026-06-24', 3, 'bvdb', 750000.00, '2026-06-24 15:36:10', '2026-06-24 15:42:51', NULL);

-- Dumping structure for table transport_management_db.transaction_details
CREATE TABLE IF NOT EXISTS `transaction_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_details_product_id_foreign` (`product_id`),
  CONSTRAINT `transaction_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.transaction_details: ~15 rows (approximately)
DELETE FROM `transaction_details`;
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `qty`, `price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 10, 2300000.00, 23000000.00, NULL, NULL, NULL),
	(2, 1, 2, 5, 110000.00, 550000.00, NULL, NULL, NULL),
	(3, 1, 3, 19, 125000.00, 2375000.00, NULL, NULL, NULL),
	(4, 10, 1, 1, 2300000.00, 2300000.00, '2026-06-24 13:53:52', '2026-06-24 13:53:52', NULL),
	(5, 11, 1, 2, 2300000.00, 4600000.00, '2026-06-24 13:55:26', '2026-06-24 14:05:30', '2026-06-24 14:05:30'),
	(6, 11, 3, 4, 125000.00, 500000.00, '2026-06-24 13:55:26', '2026-06-24 14:05:30', '2026-06-24 14:05:30'),
	(7, 12, 3, 1, 125000.00, 125000.00, '2026-06-24 15:07:18', '2026-06-24 15:42:32', '2026-06-24 15:42:32'),
	(8, 13, 1, 11, 230000045.00, 2530000495.00, '2026-06-24 15:18:46', '2026-06-24 15:42:45', '2026-06-24 15:42:45'),
	(9, 14, 5, 1, 500000.00, 500000.00, '2026-06-24 15:36:10', '2026-06-24 15:42:51', '2026-06-24 15:42:51'),
	(10, 14, 3, 1, 125000.00, 125000.00, '2026-06-24 15:36:10', '2026-06-24 15:42:51', '2026-06-24 15:42:51'),
	(11, 12, 3, 3, 125000.00, 375000.00, '2026-06-24 15:42:32', '2026-06-24 16:08:45', '2026-06-24 16:08:45'),
	(12, 13, 1, 10, 230000045.00, 2300000450.00, '2026-06-24 15:42:45', '2026-06-24 15:42:45', NULL),
	(13, 14, 5, 1, 500000.00, 500000.00, '2026-06-24 15:42:51', '2026-06-24 15:42:51', NULL),
	(14, 14, 3, 2, 125000.00, 250000.00, '2026-06-24 15:42:51', '2026-06-24 15:42:51', NULL),
	(15, 12, 3, 3, 125000.00, 375000.00, '2026-06-24 16:08:45', '2026-06-24 16:08:45', NULL);

-- Dumping structure for table transport_management_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_message` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table transport_management_db.users: ~1 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'admin_super', NULL, NULL, 0, NULL, '2026-06-24 07:05:22', '2026-06-24 07:05:22', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
