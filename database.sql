CREATE DATABASE IF NOT EXISTS `url_shortener`;

CREATE TABLE IF NOT EXISTS `url_shortener`.`urls` (
    `hash` VARCHAR(8) NOT NULL,
    `url` VARCHAR(2048) NOT NULL,
    `hits` INT NOT NULL DEFAULT '0',
    `created_at` DATETIME NOT NULL,
    UNIQUE (`hash`),
    UNIQUE (`url`)
) ENGINE = InnoDB;
