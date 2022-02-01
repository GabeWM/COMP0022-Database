/*
Testing how to create tables
To run script: docker exec -i mysql mysql -u root -ppassword -t < ./scripts/gabe_test_script.sql
 */
CREATE DATABASE IF NOT EXISTS `comp0022_database`;
SHOW DATABASES;
USE `comp0022_database`;
CREATE TABLE IF NOT EXISTS `movies` (`movie_id` SMALLINT UNIQUE NOT NULL, `title` VARCHAR(200) NOT NULL, `year` YEAR NOT NULL, `tmdb_id` INT UNIQUE NOT NULL, `imdb_id` INT UNIQUE NOT NULL, `action` TINYINT(1) NOT NULL, `adventure` TINYINT(1) NOT NULL, `animation` TINYINT(1) NOT NULL, `children` TINYINT(1) NOT NULL, `comedy` TINYINT(1) NOT NULL, `crime` TINYINT(1) NOT NULL, `documentary` TINYINT(1) NOT NULL, `drama` TINYINT(1) NOT NULL, `fantasy` TINYINT(1) NOT NULL, `film-noir` TINYINT(1) NOT NULL, `horror` TINYINT(1) NOT NULL, `musical` TINYINT(1) NOT NULL, `mystery` TINYINT(1) NOT NULL, `romance` TINYINT(1) NOT NULL, `sci-fi` TINYINT(1) NOT NULL, `thriller` TINYINT(1) NOT NULL, `war` TINYINT(1) NOT NULL, `western` TINYINT(1) NOT NULL, PRIMARY KEY(`movie_id`));
DESCRIBE `movies`;
SHOW TABLES;