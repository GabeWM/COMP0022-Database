USE `comp0022_database`;


LOAD DATA INFILE 'ml_movies_table.csv' 
INTO TABLE ml_movies 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DESCRIBE `ml_movies`;

LOAD DATA INFILE 'ml_ratings_table.csv' 
INTO TABLE ml_ratings
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DESCRIBE `ml_ratings`;

LOAD DATA INFILE 'ml_tags_table.csv' 
INTO TABLE ml_tags
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DESCRIBE `ml_tags`;

LOAD DATA INFILE 'personality_table.csv' 
INTO TABLE personality
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DESCRIBE `personality`;

LOAD DATA INFILE 'personality_ratings_table.csv' 
INTO TABLE personality_ratings
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DESCRIBE `personality_ratings`;

LOAD DATA INFILE 'personality_predictions_table.csv' 
INTO TABLE personality_predictions
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

DESCRIBE `personality_predictions`;