CREATE TABLE `language` (
  `lang_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `original` text COLLATE utf8_unicode_ci NOT NULL,
  `destination` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*
-- Query: SELECT * FROM xms2_au_20161121.language
-- Date: 2017-01-06 16:10
*/
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('en','Code Generator','Code Generator');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('en','Database name','Database name');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('en','Table name','Table name');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('en','Destination folder','Destination folder');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('en','Generate','Generate');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('fr','Code Generator','Générateur de code');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('fr','Database name','Nom de la base de données');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('fr','Table name','Nom de la table');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('fr','Destination folder','Dossier de destination');
INSERT INTO `language` (`lang_code`,`original`,`destination`) VALUES ('fr','Generate','Générer');
