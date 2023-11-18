-- ALTER TABLE `sopc_items` ADD `is_cancelled` TINYINT(1) NOT NULL DEFAULT '0' AFTER `remark`;

ALTER TABLE `sopc_reports` ADD `partial` DECIMAL(10,2) NULL DEFAULT NULL AFTER `s1p`;