CREATE  TABLE IF NOT EXISTS `category`
(
  `id_category` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  PRIMARY KEY (`id_category`)
) ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `job`
(
  `id_job` INT NOT NULL AUTO_INCREMENT ,
  `id_category` INT NOT NULL ,
  `type` VARCHAR(255) NULL ,
  `company` VARCHAR(255) NOT NULL ,
  `logo` VARCHAR(255) NULL ,
  `url` VARCHAR(255) NULL ,
  `position` VARCHAR(255) NOT NULL ,
  `location` VARCHAR(255) NOT NULL ,
  `description` TEXT NOT NULL ,
  `how_to_play` TEXT NOT NULL ,
  `is_public` TINYINT(1) NOT NULL ,
  `is_activated` TINYINT(1) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `created_at` TIMESTAMP NOT NULL ,
  `updated_at` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id_job`) ,
  CONSTRAINT `fk_job_category` FOREIGN KEY (`id_category`)
    REFERENCES `category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE INDEX `fk_job_category2` ON `job` (`id_category` ASC);
