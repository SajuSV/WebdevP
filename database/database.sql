-- ============================================================
-- Portfolio database (MySQL / MariaDB)
-- Use this file OR "php artisan migrate --seed", NOT both.
-- Import in phpMyAdmin: create database "portfolio_db", then Import.
-- WARNING: it drops and re-creates these tables.
-- ============================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Login accounts
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  `remember_token` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`name`, `email`, `password`, `is_admin`, `created_at`, `updated_at`) VALUES ('John Doe', 'johndoe@example.com', '$2y$12$yC0wSUZzyCZt92innH83XulEarMOszU8UmtV8nXkIMMArKacsUAF2', 1, NOW(), NOW());

-- Used by Laravel
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Keeps users logged in
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Laravel cache (also counts login attempts)
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` BIGINT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Used by Laravel cache
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` BIGINT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- General website text (one row)
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  `role` VARCHAR(500) NULL,
  `tagline` VARCHAR(500) NULL,
  `hero_title_line1` VARCHAR(500) NULL,
  `hero_title_line2` VARCHAR(500) NULL,
  `hero_cta_label` VARCHAR(500) NULL,
  `services_heading` VARCHAR(500) NULL,
  `about_title` VARCHAR(500) NULL,
  `work_in_focus_title` VARCHAR(500) NULL,
  `projects_page_title` VARCHAR(500) NULL,
  `projects_page_muted_title` VARCHAR(500) NULL,
  `footer_cta_label` VARCHAR(500) NULL,
  `footer_disclaimer` VARCHAR(500) NULL,
  `email` VARCHAR(500) NULL,
  `phone` VARCHAR(500) NULL,
  `phone_href` VARCHAR(500) NULL,
  `location` VARCHAR(500) NULL,
  `linkedin_url` VARCHAR(500) NULL,
  `linkedin_label` VARCHAR(500) NULL,
  `contact_heading` VARCHAR(500) NULL,
  `avatar` VARCHAR(500) NULL,
  `resume_url` VARCHAR(500) NULL,
  `hero_video_url` VARCHAR(500) NULL,
  `copyright` VARCHAR(500) NULL,
  `require_user_login` TINYINT(1) NOT NULL DEFAULT 0,
  `user_access_password` TEXT NULL,
  `hero_subtitle` TEXT NULL,
  `description` TEXT NULL,
  `projects_page_description` TEXT NULL,
  `footer_heading` TEXT NULL,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`name`, `role`, `tagline`, `hero_title_line1`, `hero_title_line2`, `hero_subtitle`, `hero_cta_label`, `description`, `services_heading`, `about_title`, `work_in_focus_title`, `projects_page_title`, `projects_page_muted_title`, `projects_page_description`, `footer_heading`, `footer_cta_label`, `footer_disclaimer`, `email`, `phone`, `phone_href`, `location`, `linkedin_url`, `linkedin_label`, `contact_heading`, `avatar`, `resume_url`, `hero_video_url`, `copyright`, `created_at`, `updated_at`) VALUES ('John Doe', 'Lorem Ipsum Designer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Hi, I’m John Doe —', 'Lorem Ipsum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 'View Projects', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 'Lorem ipsum.', 'Lorem ipsum dolor.', 'Lorem Ipsum', 'Lorem', 'Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit?', 'Contact me', 'Lorem ipsum dolor sit amet.', 'johndoe@example.com', '+1 (555) 010-2030', 'tel:+15550102030', 'Lorem City, Dolor', 'https://www.linkedin.com/in/johndoe', 'linkedin.com/in/johndoe', 'Lorem ipsum.', 'https://placehold.co/600x750/18181b/e4e4e7?text=John+Doe', '', '', '© 2026 John Doe. All rights reserved.', NOW(), NOW());

-- Scroll statements
DROP TABLE IF EXISTS `statements`;
CREATE TABLE `statements` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `body` TEXT NOT NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `statements` (`body`, `sort_order`, `created_at`, `updated_at`) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 0, NOW(), NOW());
INSERT INTO `statements` (`body`, `sort_order`, `created_at`, `updated_at`) VALUES ('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 1, NOW(), NOW());
INSERT INTO `statements` (`body`, `sort_order`, `created_at`, `updated_at`) VALUES ('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 2, NOW(), NOW());

-- My Journey in Numbers
DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(50) NOT NULL,
  `label` VARCHAR(255) NOT NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `stats` (`value`, `label`, `sort_order`, `created_at`, `updated_at`) VALUES ('5+', 'Lorem Ipsum', 0, NOW(), NOW());
INSERT INTO `stats` (`value`, `label`, `sort_order`, `created_at`, `updated_at`) VALUES ('20+', 'Dolor Sit Amet', 1, NOW(), NOW());
INSERT INTO `stats` (`value`, `label`, `sort_order`, `created_at`, `updated_at`) VALUES ('15+', 'Consectetur Elit', 2, NOW(), NOW());
INSERT INTO `stats` (`value`, `label`, `sort_order`, `created_at`, `updated_at`) VALUES ('50+', 'Tempor Incididunt', 3, NOW(), NOW());

-- Skill pills
DROP TABLE IF EXISTS `toolkits`;
CREATE TABLE `toolkits` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Lorem', 0, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Ipsum', 1, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Dolor', 2, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Sit Amet', 3, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Consectetur', 4, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Adipiscing', 5, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Elit', 6, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Tempor', 7, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Incididunt', 8, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Labore', 9, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Dolore', 10, NOW(), NOW());
INSERT INTO `toolkits` (`name`, `sort_order`, `created_at`, `updated_at`) VALUES ('Magna', 11, NOW(), NOW());

-- Quick facts
DROP TABLE IF EXISTS `quick_facts`;
CREATE TABLE `quick_facts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(255) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `quick_facts` (`label`, `value`, `sort_order`, `created_at`, `updated_at`) VALUES ('Based', 'Lorem City, Dolor', 0, NOW(), NOW());
INSERT INTO `quick_facts` (`label`, `value`, `sort_order`, `created_at`, `updated_at`) VALUES ('Studied', 'Lorem University (2018–2022)', 1, NOW(), NOW());
INSERT INTO `quick_facts` (`label`, `value`, `sort_order`, `created_at`, `updated_at`) VALUES ('Now', 'Lorem Ipsum, Dolor Studio', 2, NOW(), NOW());

-- Experience timeline
DROP TABLE IF EXISTS `experiences`;
CREATE TABLE `experiences` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(255) NOT NULL,
  `period` VARCHAR(100) NULL,
  `place` VARCHAR(255) NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `experiences` (`role`, `period`, `place`, `sort_order`, `created_at`, `updated_at`) VALUES ('Lorem Ipsum Lead', '2024 – Now', 'Dolor Studio', 0, NOW(), NOW());
INSERT INTO `experiences` (`role`, `period`, `place`, `sort_order`, `created_at`, `updated_at`) VALUES ('Consectetur Designer', '2023 – 2024', 'Adipiscing Agency', 1, NOW(), NOW());
INSERT INTO `experiences` (`role`, `period`, `place`, `sort_order`, `created_at`, `updated_at`) VALUES ('Tempor Incididunt Intern', '2022 – 2023', 'Lorem, Ipsum, Dolor, Sit Amet', 2, NOW(), NOW());
INSERT INTO `experiences` (`role`, `period`, `place`, `sort_order`, `created_at`, `updated_at`) VALUES ('Bachelor of Lorem Ipsum', '2018 – 2022', 'Lorem University', 3, NOW(), NOW());

-- Service cards
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` VARCHAR(10) NULL,
  `slug` VARCHAR(100) NULL,
  `title` VARCHAR(255) NOT NULL,
  `text` TEXT NULL,
  `icon` VARCHAR(500) NULL,
  `variant` VARCHAR(20) NOT NULL DEFAULT 'lime',
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`number`, `slug`, `title`, `text`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('01.', '/projects/lorem-alpha', 'Lorem Alpha', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.', 'https://placehold.co/96x96/111111/c8f169?text=01', 'lime', 0, NOW(), NOW());
INSERT INTO `services` (`number`, `slug`, `title`, `text`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('02.', '/projects/ipsum-beta', 'Ipsum Beta', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.', 'https://placehold.co/96x96/f5f5f5/111111?text=02', 'ink', 1, NOW(), NOW());
INSERT INTO `services` (`number`, `slug`, `title`, `text`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('03.', '/projects/dolor-gamma', 'Dolor Gamma', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'https://placehold.co/96x96/111111/f5f5f5?text=03', 'tissue', 2, NOW(), NOW());

-- Contact cards
DROP TABLE IF EXISTS `contact_items`;
CREATE TABLE `contact_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(100) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `href` VARCHAR(500) NULL,
  `icon` VARCHAR(30) NOT NULL DEFAULT 'globe',
  `icon_image` VARCHAR(500) NULL,
  `variant` VARCHAR(20) NOT NULL DEFAULT 'lime',
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_items` (`label`, `value`, `href`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('Email', 'johndoe@example.com', 'mailto:johndoe@example.com', 'email', 'lime', 0, NOW(), NOW());
INSERT INTO `contact_items` (`label`, `value`, `href`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('Place', 'Lorem City, Dolor', '', 'location', 'ink', 1, NOW(), NOW());
INSERT INTO `contact_items` (`label`, `value`, `href`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('Phone', '+1 (555) 010-2030', 'tel:+15550102030', 'phone', 'paper', 2, NOW(), NOW());
INSERT INTO `contact_items` (`label`, `value`, `href`, `icon`, `variant`, `sort_order`, `created_at`, `updated_at`) VALUES ('LinkedIn', 'linkedin.com/in/johndoe', 'https://www.linkedin.com/in/johndoe', 'linkedin', 'tissue', 3, NOW(), NOW());

-- Projects
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(100) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `headline_dim` VARCHAR(255) NULL,
  `headline_rest` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `focus` VARCHAR(255) NULL,
  `tools` VARCHAR(255) NULL,
  `cover` VARCHAR(500) NULL,
  `cover_alt` VARCHAR(255) NULL,
  `gallery_label` VARCHAR(100) NULL,
  `enable_lightbox` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_slug_unique` (`slug`),
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projects` (`id`, `slug`, `title`, `headline_dim`, `headline_rest`, `description`, `focus`, `tools`, `cover`, `cover_alt`, `gallery_label`, `enable_lightbox`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'lorem-alpha', 'Lorem Alpha', 'Lorem ipsum', 'dolor sit amet consectetur.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.', 'Lorem Alpha', 'Lorem, Ipsum & Dolor', 'https://placehold.co/1200x800/18181b/e4e4e7?text=Lorem+Alpha', 'Lorem Alpha cover', 'Lorem Gallery', 1, 0, NOW(), NOW());
INSERT INTO `projects` (`id`, `slug`, `title`, `headline_dim`, `headline_rest`, `description`, `focus`, `tools`, `cover`, `cover_alt`, `gallery_label`, `enable_lightbox`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'ipsum-beta', 'Ipsum Beta', 'Ut enim ad', 'minim veniam quis nostrud.', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.', 'Ipsum Beta', 'Consectetur & Adipiscing', 'https://placehold.co/1200x800/18181b/c8f169?text=Ipsum+Beta', 'Ipsum Beta cover', 'Ipsum Gallery', 1, 1, NOW(), NOW());
INSERT INTO `projects` (`id`, `slug`, `title`, `headline_dim`, `headline_rest`, `description`, `focus`, `tools`, `cover`, `cover_alt`, `gallery_label`, `enable_lightbox`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'dolor-gamma', 'Dolor Gamma', 'Duis aute', 'irure dolor in reprehenderit.', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.', 'Dolor Gamma', 'Elit, Tempor', 'https://placehold.co/1200x800/27272a/f4f4f5?text=Dolor+Gamma', 'Dolor Gamma cover', 'Dolor Gallery', 0, 2, NOW(), NOW());

-- Gallery images (many per project)
DROP TABLE IF EXISTS `project_images`;
CREATE TABLE `project_images` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` BIGINT UNSIGNED NOT NULL,
  `src` VARCHAR(500) NOT NULL,
  `alt` VARCHAR(255) NULL,
  `href` VARCHAR(500) NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `project_images_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'https://placehold.co/1200x800/27272a/f4f4f5?text=Lorem+Alpha+1', 'Lorem Alpha 1', 0, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'https://placehold.co/1200x800/27272a/f4f4f5?text=Lorem+Alpha+2', 'Lorem Alpha 2', 1, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'https://placehold.co/1200x800/27272a/f4f4f5?text=Lorem+Alpha+3', 'Lorem Alpha 3', 2, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (1, 'https://placehold.co/1200x800/27272a/f4f4f5?text=Lorem+Alpha+4', 'Lorem Alpha 4', 3, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'https://placehold.co/1200x800/27272a/c8f169?text=Ipsum+Beta+1', 'Ipsum Beta 1', 0, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'https://placehold.co/1200x800/27272a/c8f169?text=Ipsum+Beta+2', 'Ipsum Beta 2', 1, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'https://placehold.co/1200x800/27272a/c8f169?text=Ipsum+Beta+3', 'Ipsum Beta 3', 2, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (2, 'https://placehold.co/1200x800/27272a/c8f169?text=Ipsum+Beta+4', 'Ipsum Beta 4', 3, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'https://placehold.co/600x400/18181b/e4e4e7?text=Client+Lorem', 'Client Lorem', 0, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'https://placehold.co/600x400/18181b/e4e4e7?text=Client+Ipsum', 'Client Ipsum', 1, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'https://placehold.co/600x400/18181b/e4e4e7?text=Client+Dolor', 'Client Dolor', 2, NOW(), NOW());
INSERT INTO `project_images` (`project_id`, `src`, `alt`, `sort_order`, `created_at`, `updated_at`) VALUES (3, 'https://placehold.co/600x400/18181b/e4e4e7?text=Client+Amet', 'Client Amet', 3, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
