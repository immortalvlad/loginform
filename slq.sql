SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `loginform`.`user_entity`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `loginform`.`user_entity` (
  `user_entity_id` INT(11) NOT NULL ,
  `email` VARCHAR(96) NULL ,
  `date_added` DATETIME NULL ,
  `status` TINYINT(1) NULL ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`user_entity_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `loginform`.`user_address`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `loginform`.`user_address` (
  `user_address_id` INT NOT NULL ,
  `user_entity_id` INT(11) NOT NULL ,
  `country_id` INT(11) NULL ,
  `city_id` INT(11) NULL ,
  PRIMARY KEY (`user_address_id`) ,
  CONSTRAINT `fk_User_address_User_entity`
    FOREIGN KEY (`user_entity_id` )
    REFERENCES `loginform`.`user_entity` (`user_entity_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_User_entity_idx` ON `loginform`.`user_address` (`user_entity_id` ASC) ;


-- -----------------------------------------------------
-- Table `loginform`.`user_picture`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `loginform`.`user_picture` (
  `user_picture_id` INT(11) NOT NULL ,
  `user_entity_id` INT(11) NOT NULL ,
  `path` VARCHAR(255) NULL ,
  `type` VARCHAR(10) NULL ,
  PRIMARY KEY (`user_picture_id`) ,
  CONSTRAINT `fk_User_picture_User_entity1`
    FOREIGN KEY (`user_entity_id` )
    REFERENCES `loginform`.`user_entity` (`user_entity_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_User_entity_idx` ON `loginform`.`user_picture` (`user_entity_id` ASC) ;


-- -----------------------------------------------------
-- Table `loginform`.`user_phone`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `loginform`.`user_phone` (
  `phone_id` INT(11) NOT NULL ,
  `value` VARCHAR(45) NULL ,
  `user_entity_id` INT(11) NOT NULL ,
  PRIMARY KEY (`phone_id`) ,
  CONSTRAINT `fk_Phone_User_entity1`
    FOREIGN KEY (`user_entity_id` )
    REFERENCES `loginform`.`user_entity` (`user_entity_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_Phone_User_entity_idx` ON `loginform`.`user_phone` (`user_entity_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
