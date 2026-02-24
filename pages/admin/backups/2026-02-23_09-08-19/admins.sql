-- Backup of table `admins`
-- Generated: 2026-02-23 09:08:19

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_time` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`id`,`name`,`email`,`password`,`reset_token`,`reset_time`,`active`,`admin`) VALUES ('60','dirk','dirk.haffke@uni-konstanz.de','$2y$10$XS3ufls34NGzbTA.e7qw/.1qRcM9nentTmmQVYNkt4v1Oa7yVLjba','c418b1de26287f6140f63c6b393123db430f6878b5634dae8edad1d873efca42','1771405825','1','0');
