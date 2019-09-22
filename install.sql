CREATE TABLE `user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`email` VARCHAR(50) NOT NULL,
	`birthdate` DATE NOT NULL,
	`gender` ENUM('m','f','o') NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
;