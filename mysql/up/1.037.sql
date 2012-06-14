ALTER TABLE `settings` ADD `css` varchar(128) DEFAULT '';

UPDATE `settings` SET `css` = 'blue' WHERE id = 1;