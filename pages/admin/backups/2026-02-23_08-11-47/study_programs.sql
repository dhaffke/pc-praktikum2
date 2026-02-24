-- Backup of table `study_programs`
-- Generated: 2026-02-23 08:11:47

DROP TABLE IF EXISTS `study_programs`;
CREATE TABLE `study_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `study_programs` (`id`,`name`,`active`) VALUES ('1','Life-Sience','1');
INSERT INTO `study_programs` (`id`,`name`,`active`) VALUES ('2','Nano-Science','1');
INSERT INTO `study_programs` (`id`,`name`,`active`) VALUES ('13','Chemie','1');
