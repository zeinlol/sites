DROP TABLE `#__cf_filtertypes`; 
ALTER TABLE `#__cf_customfields` CHANGE `type_id` `type_id` VARCHAR( 24 ) NOT NULL DEFAULT '3' COMMENT 'The display type';