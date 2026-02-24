-- Backup of table `experiments`
-- Generated: 2026-02-23 08:11:47

DROP TABLE IF EXISTS `experiments`;
CREATE TABLE `experiments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `repetition` int(2) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('17','Partielle Molvolumina','T1-2','2','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('19','Verbrennungsenthalpie','T2','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('20','Joule Thomson','T3','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('21','Kritischer Punkt','T4','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('22','Ausdehnungskoeffizient','T5','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('24','Esterverseifung','EK1-2','2','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('25','Fluoreszenzspektroskopie','KS1','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('26','Stopped Flow','KS2-2','2','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('27','Siedepunktserhöhung','TV1','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('28','Dampfdruckosmometrie','TV2','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('29','Konduktometrie','EV1','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('30','Potentiometrie','EV2','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('31','Voltammetrie','EV3','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('32','Reflexionsspektroskopie','SV1','1','1');
INSERT INTO `experiments` (`id`,`name`,`short_name`,`repetition`,`active`) VALUES ('39','cacfffff','qqq-2','2','1');
