CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(128),
  `description` text,
  `logo` varchar(128),
  `footer_message` varchar(512),
  `template` varchar(128),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

INSERT INTO `settings` (`template`) values ('uikit');