-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 05:26 AM
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
-- Database: `university`
--
CREATE DATABASE IF NOT EXISTS `university` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `university`;

-- --------------------------------------------------------

--
-- Table structure for table `additions`
--

CREATE TABLE `additions` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `fk__from_table` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@ForeignKeys__table]',
  `fk__to_table` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@ForeignKeys__table]',
  `relationship` varchar(255) DEFAULT NULL,
  `f__from_reference` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@ForeignKeys__table__reference]',
  `f__to_reference` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@ForeignKeys__table__reference]',
  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__additions]',
  `s__status__k` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@System][@Keys__additions]',
  `s__more` text DEFAULT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `f__users` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `f__topics` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__topics]',
  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__attendances]',
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `k__table` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__table]',
  `queries` text NOT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `hours` tinyint(3) UNSIGNED NOT NULL,
  `cost` tinyint(3) UNSIGNED NOT NULL,
  `requirements` text DEFAULT NULL,
  `f__classes` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__classes]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_at` date NOT NULL COMMENT 'Day',
  `time_at` time NOT NULL COMMENT 'Start',
  `__` text DEFAULT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `__` text DEFAULT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financials`
--

CREATE TABLE `financials` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `f__users` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__financials]',
  `f__courses` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__financials]',
  `cost` tinyint(3) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__financials]',
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `f__users_from` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `f__users_to` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `f__topics` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__topics]',
  `degree` tinyint(3) UNSIGNED NOT NULL,
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__grades]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_s`
--

CREATE TABLE `information_s` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `fk__table` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@ForeignKeys__table]',
  `f__reference` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@ForeignKeys__table__reference]',
  `information_s` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`information_s`)),
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `table_name` varchar(32) NOT NULL,
  `key_tag` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `s__deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `k__keys` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__languages]',
  `k__section` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__languages]',
  `k__languages` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__languages]',
  `values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`values`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `f__users_from` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `f__users_to` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__messages]',
  `s__status__k` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@System][@Keys__messages]',
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `f__users` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `s__status__k` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@System][@Keys__notifications]',
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `k__table` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__table]',
  `k__operation` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__records]',
  `f__users` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__users]',
  `f__reference` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__k__table]',
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `f__topics` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__topics]',
  `date_at` date NOT NULL COMMENT 'Day',
  `time_at` time NOT NULL COMMENT 'Start'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `f__users` bigint(20) UNSIGNED NOT NULL COMMENT '[@Foreign__users]',
  `cookie` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `f__courses` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Foreign__courses]',
  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__topics]',
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `s__id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `code` varchar(16) NOT NULL,
  `phone` char(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,

  `k__type` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@Keys__users]',
  `s__status__k` bigint(20) UNSIGNED DEFAULT NULL COMMENT '[@System][@Keys__users]',
  `s__created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `s__updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `s__information_s` bigint(20) UNSIGNED DEFAULT NULL,
  `s__deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additions`
--
ALTER TABLE `additions`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `additions__fk__from_table` (`fk__from_table`),
  ADD KEY `additions__fk__to_table` (`fk__to_table`),
  ADD KEY `additions__k__type` (`k__type`),
  ADD KEY `additions__s__status__k` (`s__status__k`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `f__users__f__topics` (`f__users`,`f__topics`),
  ADD KEY `attendances__f__topics` (`f__topics`),
  ADD KEY `attendances__k__type` (`k__type`),
  ADD KEY `attendances__s__information_s` (`s__information_s`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `title__description` (`title`,`description`),
  ADD KEY `backups__k__table` (`k__table`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `title__description` (`title`,`description`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `title__description` (`title`,`description`),
  ADD KEY `courses__f__classes` (`f__classes`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `title__description` (`title`,`description`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `title__description` (`title`,`description`),
  ADD KEY `events__s__information_s` (`s__information_s`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `title__description` (`title`,`description`),
  ADD KEY `files__s__information_s` (`s__information_s`);

--
-- Indexes for table `financials`
--
ALTER TABLE `financials`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `financials__f__users` (`f__users`),
  ADD KEY `financials__f__courses` (`f__courses`),
  ADD KEY `financials__k__type` (`k__type`),
  ADD KEY `financials__s__information_s` (`s__information_s`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `grades__f__users_from` (`f__users_from`),
  ADD KEY `grades__f__users_to` (`f__users_to`),
  ADD KEY `grades__f__topics` (`f__topics`),
  ADD KEY `grades__k__type` (`k__type`),
  ADD KEY `grades__s__information_s` (`s__information_s`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `title__description` (`title`,`description`);

--
-- Indexes for table `information_s`
--
ALTER TABLE `information_s`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `information_s__fk__table` (`fk__table`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `table_name__key_tag` (`table_name`,`key_tag`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `languages__k__keys` (`k__keys`),
  ADD KEY `languages__k__section` (`k__section`),
  ADD KEY `languages__k__languages` (`k__languages`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `messages__f__users_from` (`f__users_from`),
  ADD KEY `messages__f__users_to` (`f__users_to`),
  ADD KEY `messages__k__type` (`k__type`),
  ADD KEY `messages__s__status__k` (`s__status__k`),
  ADD KEY `messages__s__information_s` (`s__information_s`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `notifications__f__users` (`f__users`),
  ADD KEY `notifications__s__status__k` (`s__status__k`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `title__description` (`title`,`description`),
  ADD KEY `permissions__s__information_s` (`s__information_s`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`s__id`),
  ADD KEY `records__k__table` (`k__table`),
  ADD KEY `records__k__operation` (`k__operation`),
  ADD KEY `records__f__users` (`f__users`),
  ADD KEY `records__s__information_s` (`s__information_s`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `title__description` (`title`,`description`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `f__topics` (`f__topics`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `f__users__cookie` (`f__users`,`cookie`),
  ADD KEY `sessions__s__information_s` (`s__information_s`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `f__courses__title__description` (`f__courses`,`title`,`description`),
  ADD KEY `topics__k__type` (`k__type`),
  ADD KEY `topics__s__information_s` (`s__information_s`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`s__id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `users__k__type` (`k__type`),
  ADD KEY `users__s__status__k` (`s__status__k`),
  ADD KEY `users__s__information_s` (`s__information_s`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additions`
--
ALTER TABLE `additions`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financials`
--
ALTER TABLE `financials`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_s`
--
ALTER TABLE `information_s`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `s__id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additions`
--
ALTER TABLE `additions`
  ADD CONSTRAINT `additions__fk__from_table` FOREIGN KEY (`fk__from_table`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `additions__fk__to_table` FOREIGN KEY (`fk__to_table`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `additions__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `additions__s__status__k` FOREIGN KEY (`s__status__k`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances__f__topics` FOREIGN KEY (`f__topics`) REFERENCES `topics` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `attendances__f__users` FOREIGN KEY (`f__users`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `attendances__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `attendances__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `backups`
--
ALTER TABLE `backups`
  ADD CONSTRAINT `backups__k__table` FOREIGN KEY (`k__table`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses__f__classes` FOREIGN KEY (`f__classes`) REFERENCES `classes` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `financials`
--
ALTER TABLE `financials`
  ADD CONSTRAINT `financials__f__courses` FOREIGN KEY (`f__courses`) REFERENCES `courses` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `financials__f__users` FOREIGN KEY (`f__users`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `financials__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `financials__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades__f__topics` FOREIGN KEY (`f__topics`) REFERENCES `topics` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `grades__f__users_from` FOREIGN KEY (`f__users_from`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `grades__f__users_to` FOREIGN KEY (`f__users_to`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `grades__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `grades__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `information_s`
--
ALTER TABLE `information_s`
  ADD CONSTRAINT `information_s__fk__table` FOREIGN KEY (`fk__table`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages__k__keys` FOREIGN KEY (`k__keys`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `languages__k__languages` FOREIGN KEY (`k__languages`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `languages__k__section` FOREIGN KEY (`k__section`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages__f__users_from` FOREIGN KEY (`f__users_from`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `messages__f__users_to` FOREIGN KEY (`f__users_to`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `messages__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `messages__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `messages__s__status__k` FOREIGN KEY (`s__status__k`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications__f__users` FOREIGN KEY (`f__users`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `notifications__s__status__k` FOREIGN KEY (`s__status__k`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records__f__users` FOREIGN KEY (`f__users`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `records__k__operation` FOREIGN KEY (`k__operation`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `records__k__table` FOREIGN KEY (`k__table`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `records__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules__f__topics` FOREIGN KEY (`f__topics`) REFERENCES `topics` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions__f__users` FOREIGN KEY (`f__users`) REFERENCES `users` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sessions__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics__f__courses` FOREIGN KEY (`f__courses`) REFERENCES `courses` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `topics__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `topics__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users__k__type` FOREIGN KEY (`k__type`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users__s__information_s` FOREIGN KEY (`s__information_s`) REFERENCES `information_s` (`s__id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users__s__status__k` FOREIGN KEY (`s__status__k`) REFERENCES `keys` (`s__id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
