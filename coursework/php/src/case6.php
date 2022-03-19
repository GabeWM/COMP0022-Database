<?php
    require("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
            function GoBackWithRefresh(event) {
            if ('referrer' in document) {
                window.location = document.referrer;
                /* OR */
                //location.replace(document.referrer);
            } else {
                window.history.back();
            }
        }
    </script>

    <head>
        <h1 class="text-center">Movie Industry Database</h1>
        <p class="text-center">for marketing professionals</p>
    </head>

<?php
    require("connect.php");

    $movie = $_POST['case6_title'];    

    $query1 = "SELECT AVG(tag_values.op2), AVG(tag_values.ag2), AVG(tag_values.es2), AVG(tag_values.co2), AVG(tag_values.ex2) FROM
        (SELECT * FROM (SELECT DISTINCT ml_tags.tag as tag
        FROM ml_movies
        LEFT JOIN ml_tags ON ml_tags.movie_id = ml_movies.movie_id
        WHERE LOWER(ml_movies.title) = LOWER(\"$movie\") AND tag IS NOT NULL) AS movie_tags1) as movie_tags
        INNER JOIN (SELECT * FROM(SELECT tag, AVG(op1) as op2, AVG(ag1) as ag2, AVG(es1) as es2, AVG(co1) as co2, AVG(ex1) as ex2
        FROM (SELECT ml_movies.title as title, LOWER(ml_tags.tag) as tag, AVG(personality.openness) as op1, AVG(personality.agreeableness) as ag1, AVG(personality.emotional_stability) as es1, AVG(personality.conscientiousness) as co1, AVG(personality.extraversion) as ex1
        FROM ml_movies
        LEFT JOIN ml_tags ON ml_tags.movie_id = ml_movies.movie_id
        LEFT JOIN personality_ratings ON ml_movies.movie_id = personality_ratings.movie_id
        LEFT JOIN personality ON personality_ratings.personality_user_id = personality.personality_user_id
        WHERE (personality_ratings.rating = 4 OR personality_ratings.rating = 5) 
            AND ml_tags.movie_id IS NOT NULL
            AND personality_ratings.movie_id IN 
                (SELECT ml_movies.movie_id 
                FROM ml_movies)
        GROUP BY tag,  ml_movies.movie_id) as movie_tag_pers
        GROUP BY movie_tag_pers.tag) as tag_values1) as tag_values
        WHERE movie_tags.tag = tag_values.tag";

    $result1 = mysqli_query($connection, $query1);
    
    
    $query2 = "SELECT * FROM (SELECT DISTINCT ml_tags.tag as tag
    FROM ml_movies
    LEFT JOIN ml_tags ON ml_tags.movie_id = ml_movies.movie_id
    WHERE LOWER(ml_movies.title) = LOWER(\"$movie\") AND tag IS NOT NULL) AS movie_tags
    INNER JOIN (SELECT * FROM(SELECT tag, AVG(op1) as op2, AVG(ag1) as ag2, AVG(es1) as es2, AVG(co1) as co2, AVG(ex1) as ex2
    FROM (SELECT ml_movies.title as title, LOWER(ml_tags.tag) as tag, AVG(personality.openness) as op1, AVG(personality.agreeableness) as ag1, AVG(personality.emotional_stability) as es1, AVG(personality.conscientiousness) as co1, AVG(personality.extraversion) as ex1
    FROM ml_movies
    LEFT JOIN ml_tags ON ml_tags.movie_id = ml_movies.movie_id
    LEFT JOIN personality_ratings ON ml_movies.movie_id = personality_ratings.movie_id
    LEFT JOIN personality ON personality_ratings.personality_user_id = personality.personality_user_id
    WHERE (personality_ratings.rating = 4 OR personality_ratings.rating = 5) 
        AND ml_tags.movie_id IS NOT NULL
        AND personality_ratings.movie_id IN 
            (SELECT ml_movies.movie_id 
            FROM ml_movies)
    GROUP BY tag,  ml_movies.movie_id) as movie_tag_pers
    GROUP BY movie_tag_pers.tag) as tag_values1) as tag_values
    WHERE movie_tags.tag = tag_values.tag";

    $result2 = mysqli_query($connection, $query2);
    $result_count = mysqli_num_rows($result2);
    
    echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>';

    if ($result_count > 0) {
        //List of Tags
        echo '<div class="container">';
        echo "<p>The movie, " . $movie .", contains the following tags with their correlating average personality values:"; 
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Tags</th> <th scope="col">Avg(Openness)</th> <th scope="col">Avg(Agreeableness)</th> <th scope="col">Avg(Emotional_Stability)</th> <th scope="col">Avg(Conscientiousness)</th> <th scope="col">Avg(Extraversion)</th>';
        while ($row2 = mysqli_fetch_array($result2))
        {
            echo '<tr> <td>' . $row2['tag']. '</td><td>' . $row2['op2']. '</td><td>' . $row2['ag2']. '</td><td>' . $row2['es2']. '</td> <td>' . $row2['co2']. '</td> <td>' . $row2['ex2']. '</td></tr>';
        }
        echo '</tbody> </table>';
        echo '</div>';   
        //Personality which best suits the movie
        echo '<div class="container">';
        echo "<p>People with the personality type shown below are likely to enjoy " . $movie ."."; 
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Avg(Openness)</th> <th scope="col">Avg(Agreeableness)</th> <th scope="col">Avg(Emotional_Stability)</th> <th scope="col">Avg(Conscientiousness)</th> <th scope="col">Avg(Extraversion)</th> </tr> </thead> <tbody>';
        while ($row1 = mysqli_fetch_array($result1))
        {
            echo '<tr> <td>' . $row1['AVG(tag_values.op2)']. '</td><td>' . $row1['AVG(tag_values.ag2)']. '</td><td>' . $row1['AVG(tag_values.es2)']. '</td> <td>' . $row1['AVG(tag_values.co2)']. '</td> <td>' . $row1['AVG(tag_values.ex2)']. '</td></tr>';
        }
        echo '</tbody> </table>';
        echo '</div>';
    }
    else {
        echo '<div class="container"><p>No results found or no tag data available, please try again. </p></div>';
    }    
?>
