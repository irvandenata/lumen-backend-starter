-- Adminer 4.8.0 MySQL 5.7.33 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `banners` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(5,	'wefewf wadawdawdaw',	'wefwefdwdwda awdawd',	'2021-12-28 07:18:58',	'2021-12-28 08:09:01');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1,	'test',	'test',	'2021-12-27 18:18:43',	'2021-12-27 18:18:43'),
(2,	'About',	'about',	'2021-12-28 05:05:36',	'2021-12-28 05:05:36'),
(3,	'Skill',	'skill',	'2021-12-28 05:05:47',	'2021-12-28 05:05:47'),
(4,	'Portofolio',	'portofolio',	'2021-12-28 05:05:58',	'2021-12-28 05:05:58');

DROP TABLE IF EXISTS `contents`;
CREATE TABLE `contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nothing',
  `view_count` bigint(20) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contents_category_id_foreign` (`category_id`),
  CONSTRAINT `contents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contents` (`id`, `title`, `body`, `slug`, `view_count`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(1,	'skill 1',	'<p>loremipsum amete</p>',	'skill-1-2',	0,	1,	3,	'2021-12-28 05:06:02',	'2021-12-28 05:06:52'),
(2,	'skill 2',	'<p>awdawdawd</p>',	'skill-2',	0,	1,	3,	'2021-12-28 05:06:55',	'2021-12-28 05:08:22'),
(3,	'skill 3',	'<p>waefawef</p>',	'skill-3',	0,	1,	3,	'2021-12-28 05:08:24',	'2021-12-28 05:09:49'),
(4,	'Skill 4',	'<p>awdawd</p>',	'skill-4',	0,	1,	3,	'2021-12-28 05:09:53',	'2021-12-28 05:10:46'),
(5,	'Porto 1',	'<p>awdawdwad</p>',	'porto-1',	0,	1,	4,	'2021-12-28 05:09:55',	'2021-12-28 05:11:02'),
(6,	'Porto 2',	'<p>awefawefwfe</p>',	'porto-2',	0,	1,	4,	'2021-12-28 05:11:04',	'2021-12-28 05:11:33'),
(7,	'porto 3',	'<p>waefawef</p>',	'porto-3',	0,	1,	4,	'2021-12-28 05:11:37',	'2021-12-28 05:11:53'),
(8,	'Porto 4',	'<p>waefawefwaef</p>',	'porto-4',	0,	1,	4,	'2021-12-28 05:11:55',	'2021-12-28 05:12:10'),
(9,	'About',	'<p>awefwaefwaef ewfwefaw waefawefwaef</p>',	'about',	0,	1,	2,	'2021-12-28 05:12:15',	'2021-12-28 05:12:43'),
(10,	'About 2',	'<p>wafewaefwaef</p>',	'about-2',	0,	1,	2,	'2021-12-28 05:12:46',	'2021-12-28 05:16:51'),
(11,	'about 3',	'<p>awefawef</p>',	'about-3',	0,	1,	2,	'2021-12-28 05:16:53',	'2021-12-28 05:17:06');

DROP TABLE IF EXISTS `content_tag`;
CREATE TABLE `content_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_tag_content_id_foreign` (`content_id`),
  KEY `content_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `content_tag_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fileable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fileable_id` bigint(20) unsigned DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `files` (`id`, `fileable_type`, `fileable_id`, `link`, `type`, `created_at`, `updated_at`) VALUES
(7,	'App\\Models\\Content',	1,	'Contents/3VcH42.png',	'image',	'2021-12-28 05:06:46',	'2021-12-28 05:06:46'),
(8,	'App\\Models\\Content',	2,	'Contents/8WIw86.png',	'image',	'2021-12-28 05:07:49',	'2021-12-28 05:07:49'),
(9,	'App\\Models\\Content',	3,	'Contents/i0glEM.png',	'image',	'2021-12-28 05:09:33',	'2021-12-28 05:09:33'),
(10,	'App\\Models\\Content',	4,	'Contents/PdZcbO.png',	'image',	'2021-12-28 05:10:45',	'2021-12-28 05:10:45'),
(11,	'App\\Models\\Content',	5,	'Contents/Jp5a7p.png',	'image',	'2021-12-28 05:11:00',	'2021-12-28 05:11:00'),
(12,	'App\\Models\\Content',	6,	'Contents/Ild9TW.png',	'image',	'2021-12-28 05:11:29',	'2021-12-28 05:11:29'),
(13,	'App\\Models\\Content',	7,	'Contents/RB3DFO.png',	'image',	'2021-12-28 05:11:50',	'2021-12-28 05:11:50'),
(14,	'App\\Models\\Content',	8,	'Contents/bSaPkd.png',	'image',	'2021-12-28 05:12:09',	'2021-12-28 05:12:09'),
(15,	'App\\Models\\Content',	9,	'Contents/nVgvpY.png',	'image',	'2021-12-28 05:12:40',	'2021-12-28 05:12:40'),
(16,	'App\\Models\\Content',	10,	'Contents/g742wh.png',	'image',	'2021-12-28 05:13:02',	'2021-12-28 05:13:02'),
(17,	'App\\Models\\Content',	11,	'Contents/hcpBxi.png',	'image',	'2021-12-28 05:17:04',	'2021-12-28 05:17:04'),
(22,	'App\\Models\\Banner',	5,	'Banner/1qyvAt.png',	'image',	'2021-12-28 08:10:16',	'2021-12-28 08:10:16'),
(24,	'App\\Models\\User',	1,	'Profile/D8MIro.png',	'image',	'2021-12-28 08:18:45',	'2021-12-28 08:18:45');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2021_09_08_154129_create_users_table',	1),
(2,	'2021_09_08_155832_create_categories_table',	1),
(3,	'2021_09_09_115952_create_tags_table',	1),
(4,	'2021_09_09_132215_create_files_table',	1),
(5,	'2021_09_09_132508_create_contents_table',	1),
(6,	'2021_09_09_133300_create_content_tags_table',	1),
(7,	'2021_12_26_125401_create_social_media_table',	1),
(8,	'2021_12_28_065951_create_banners_table',	2);

DROP TABLE IF EXISTS `social_media`;
CREATE TABLE `social_media` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_media_user_id_foreign` (`user_id`),
  CONSTRAINT `social_media_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `social_media` (`id`, `user_id`, `name`, `link`, `created_at`, `updated_at`) VALUES
('1-0',	1,	'089687813',	'irvanfew',	'2021-12-28 08:18:45',	'2021-12-28 08:18:45'),
('1-1',	1,	'irvan denata',	'https://www.facebook.com/irvan.denata/',	'2021-12-28 08:18:45',	'2021-12-28 08:18:45'),
('1-2',	1,	'irvan denata',	'https://www.instagram.com/irvandenata/',	'2021-12-28 08:18:45',	'2021-12-28 08:18:45'),
('1-3',	1,	'irvandenata',	'irvan',	'2021-12-28 08:18:45',	'2021-12-28 08:18:45');

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `address`, `description`, `password`, `created_at`, `updated_at`) VALUES
(1,	'irvan denata',	'irvan@gmail.com',	'jalan amanah tebas',	'Hidup adalah keyakinan',	'$2y$10$Iy3GWGKKWVc/N75dWMHtWeirVCTLSgMxi12/nBPwiR2ZN1Gpn2oYq',	'2021-12-27 18:18:43',	'2021-12-27 18:22:56');

-- 2021-12-28 15:16:55
