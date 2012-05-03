CREATE TABLE `blog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(90) DEFAULT NULL,
  `text` text,
  `date_created` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--//@UNDO 
DROP TABLE IF EXISTS `blog`;
--//
