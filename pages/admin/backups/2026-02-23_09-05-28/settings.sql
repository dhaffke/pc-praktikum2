-- Backup of table `settings`
-- Generated: 2026-02-23 09:05:28

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `free_start` date DEFAULT NULL,
  `free_end` date DEFAULT NULL,
  `free_active` tinyint(1) DEFAULT NULL,
  `days` varchar(20) DEFAULT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `settings` (`id`,`password`,`start`,`end`,`free_start`,`free_end`,`free_active`,`days`,`erstellt_am`) VALUES ('1','iwegolfp','2026-04-07','2026-07-17','2026-04-14','2026-04-15','1','1,2,4','2026-02-11 09:51:14');
