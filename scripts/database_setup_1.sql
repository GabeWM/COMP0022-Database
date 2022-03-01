/*
How to setup database (assuming your in git directory)
To start container: docker run --name mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=password -v "${PWD}/data/clean_data:/home/misc" mysql --secure-file-priv=""
To run script 1: docker exec -i mysql mysql -u root -ppassword -t < ./scripts/database_setup_1.sql
To get interactive shell for container: docker exec -it mysql /bin/bash
To copy files: cp -a /home/misc/. /var/lib/mysql/comp0022_database/
To run script 2: docker exec -i mysql mysql -u root -ppassword -t < ./scripts/database_setup_2.sql

*/

/*
Helpful commands
To get interactive shell for container: docker exec -it mysql /bin/bash
To get interactive shell for mysql : docker exec -it mysql mysql -ppassword
-p to use password

To create docker volume: docker volume create docker_volume
To check docker volume info use: docker volume inspect docker_volume
 */

CREATE DATABASE IF NOT EXISTS `comp0022_database`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

SHOW DATABASES;

USE `comp0022_database`;

/*
IF you need to delete database uncomment below
DROP TABLE `predictions`;
DROP TABLE `tags`;
DROP TABLE `ratings`;
DROP TABLE `personality`;
DROP TABLE `movies`;
*/

CREATE TABLE IF NOT EXISTS `movies` (
    `movie_id` INT UNIQUE NOT NULL, 
    `title` VARCHAR(200) NOT NULL, 
    `year` YEAR, 
    `tmdb_id` INT, 
    `imdb_id` INT, 
    `action` TINYINT(1) NOT NULL, 
    `adventure` TINYINT(1) NOT NULL, 
    `animation` TINYINT(1) NOT NULL, 
    `children` TINYINT(1) NOT NULL, 
    `comedy` TINYINT(1) NOT NULL, 
    `crime` TINYINT(1) NOT NULL, 
    `documentary` TINYINT(1) NOT NULL, 
    `drama` TINYINT(1) NOT NULL, 
    `fantasy` TINYINT(1) NOT NULL, 
    `film-noir` TINYINT(1) NOT NULL, 
    `horror` TINYINT(1) NOT NULL, 
    `musical` TINYINT(1) NOT NULL, 
    `mystery` TINYINT(1) NOT NULL, 
    `romance` TINYINT(1) NOT NULL, 
    `sci-fi` TINYINT(1) NOT NULL, 
    `thriller` TINYINT(1) NOT NULL, 
    `war` TINYINT(1) NOT NULL, 
    `western` TINYINT(1) NOT NULL, 
    PRIMARY KEY(`movie_id`)
);

CREATE TABLE IF NOT EXISTS `personality` (
    `personality_id` VARCHAR(32),
    `assigned_metric` VARCHAR(32) NOT NULL,
    `assigned_condition` VARCHAR(32) NOT NULL,
    `openness` DECIMAL(2,1) NOT NULL,
    `agreeableness` DECIMAL(2,1) NOT NULL,
    `emotional_stability` DECIMAL(2,1) NOT NULL,
    `conscientiousness` DECIMAL(2,1) NOT NULL,
    `extraversion` DECIMAL(2,1) NOT NULL,
    `is_personalized` TINYINT NOT NULL,
    `enjoyed_watching` TINYINT NOT NULL,
    PRIMARY KEY (`personality_id`)
);

CREATE TABLE IF NOT EXISTS `ratings` (
    `user_id` SMALLINT NOT NULL,
    `movie_id` INT NOT NULL,
    `rating` TINYINT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL,
    `personality_id` VARCHAR(32),
    PRIMARY KEY (`user_id`, `movie_id`),
    FOREIGN KEY (`movie_id`) REFERENCES `movies`(`movie_id`),
    FOREIGN KEY (`personality_id`) REFERENCES `personality`(`personality_id`)
);

CREATE TABLE IF NOT EXISTS `tags` (
    `index` INT UNIQUE NOT NULL,
    `user_id` SMALLINT NOT NULL,
    `movie_id` INT NOT NULL,
    `tag` VARCHAR(200) NOT NULL,
    `timestamp` TIMESTAMP NOT NULL,
    PRIMARY KEY (`index`),
    FOREIGN KEY (`movie_id`) REFERENCES `movies`(`movie_id`),
    FOREIGN KEY (`user_id`) REFERENCES `ratings`(`user_id`)
);

CREATE TABLE IF NOT EXISTS `predictions` (
    `personality_id` VARCHAR(32),
    `movie_id` INT NOT NULL,
    `predictions` DECIMAL(12,11) NOT NULL,
    PRIMARY KEY (`personality_id`, `movie_id`),
    FOREIGN KEY (`movie_id`) REFERENCES `movies`(`movie_id`),
    FOREIGN KEY (`personality_id`) REFERENCES `personality`(`personality_id`)
);

SHOW TABLES;