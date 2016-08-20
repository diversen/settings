ALTER TABLE `settings` ADD `css` varchar(128) DEFAULT '';

UPDATE `settings` SET `css` = 'default' WHERE id = 1;