-- Create database
CREATE DATABASE IF NOT EXISTS `phptest` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `phptest`;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `activation_token` VARCHAR(64) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `reset_token` VARCHAR(64) DEFAULT NULL,
  `reset_expires` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
