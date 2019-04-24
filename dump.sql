-- -----------------------------------------------------
-- Table .`pages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `body` LONGTEXT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table .`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_login` VARCHAR(45) NOT NULL,
  `password_hash` VARCHAR(250) NOT NULL,
  `user_full_name` VARCHAR(100) NOT NULL,
  `user_email` VARCHAR(250) NOT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table .`curses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` INT NOT NULL AUTO_INCREMENT,
  `course_name` VARCHAR(100) NOT NULL,
  `course_img` VARCHAR(100) NULL,
  `course_duration` DECIMAL(3,1) NOT NULL,
  `course_description` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table .`team`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS  `team` (
  `member_id` INT NOT NULL AUTO_INCREMENT,
  `member_name` VARCHAR(100) NOT NULL,
  `member_photo` VARCHAR(100) NULL,
  `member_description` TEXT NULL,
  PRIMARY KEY (`member_id`))
ENGINE = InnoDB;
