-- Backup of table `calendar_holidays`
-- Generated: 2026-02-20 12:50:02

DROP TABLE IF EXISTS `calendar_holidays`;
CREATE TABLE `calendar_holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `holiday` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_entry` (`user_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

