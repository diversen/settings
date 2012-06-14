CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `logo` varchar(128) DEFAULT '',
  `footer_message` varchar(512) DEFAULT '',
  `template` varchar(128) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

INSERT INTO `settings` (`template`) values ('clean');