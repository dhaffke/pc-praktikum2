-- Backup of table `users`
-- Generated: 2026-02-23 09:06:13

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `study_program_id` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `study_program_id` (`study_program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('1','Mellone Patrizia','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('2','Strobel Marcel','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('3','Schneider Amelie','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('4','Mazloum Linda','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('5','Baumhof Lukas','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('6','Hartmann Kai','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('7','Barreto de Pinho Mark','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('8','Seutemann Niklas','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('9','Roth Carlotta','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('10','Dorn Annemarie','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('11','Ferch Anika','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('12','Reffert Sarina','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('13','Diehl Yannik','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('14','Kroth Zeshan','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('15','Renner Raphael','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('16','Weiße Elias','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('17','Wilhelm Emily','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('18','Kießling Niklas','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('19','Böttcher Mariella','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('20','Stäudle Noelle','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('21','Braun Elias','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('22','Kretschmer Sarah','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('23','Langlouis Alexander','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('24','Braun Janik','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('25','Jurgenson Markus','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('26','Deriu Riccardo','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('27','Kranke Pauline','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('28','Graf Benedikt','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('29','Ebbecke Lucas','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('30','Huang Kaixuan','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('31','Traeger Hendrik','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('32','Dellemann Tobias','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('33','Ussat Niklas','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('34','Altwicker David','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('35','Ritz Felix','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('36','Gerull Maximilian','13','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('37','Klimsa Vinzent','1','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('38','Batteux Finn','1','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('42','Desens Maurice','1','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('47','Pißler Selma','2','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('48','Reinalter Liv','2','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('49','Burkhart Eva','2','1');
INSERT INTO `users` (`id`,`name`,`study_program_id`,`active`) VALUES ('50','Fackler Veit','2','1');
