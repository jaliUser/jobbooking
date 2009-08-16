ALTER TABLE `webcal_user` 
ADD `role_id` TINYINT NULL,
ADD `site_id` TINYINT NULL,
ADD `count` INT NULL,
ADD `age_range` VARCHAR(10) NULL,
ADD `qualifications` VARCHAR(255) NULL,
ADD `notes` VARCHAR(255) NULL;

ALTER TABLE `webcal_entry` 
ADD `job_id` TINYINT NULL, 
ADD `person_need` TINYINT NULL DEFAULT '0' ;

ALTER TABLE `webcal_entry_user`
ADD `count` INT NULL,
ADD `notes` VARCHAR(255) NULL;