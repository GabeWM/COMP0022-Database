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

    $title = $_POST['case5_title'];

    $query1 = "SELECT AVG(personality.openness), AVG(personality.agreeableness), AVG(personality.emotional_stability), AVG(personality.conscientiousness), AVG(personality.extraversion)
              FROM personality_ratings 
              LEFT JOIN personality ON personality_ratings.personality_user_id = personality.personality_user_id 
              WHERE rand() <= .3 AND (personality_ratings.rating = 4 OR personality_ratings.rating = 5) AND personality_ratings.movie_id = 
                    (SELECT ml_movies.movie_id 
                    FROM ml_movies 
                    WHERE ml_movies.title = \"$title\")";

    $result1 = mysqli_query($connection, $query1);
    $result_count1 = mysqli_num_rows($result1);

    $query2 = "SELECT AVG(personality.openness), AVG(personality.agreeableness), AVG(personality.emotional_stability), AVG(personality.conscientiousness), AVG(personality.extraversion)
    FROM personality_ratings 
    LEFT JOIN personality ON personality_ratings.personality_user_id = personality.personality_user_id 
    WHERE (personality_ratings.rating = 4 OR personality_ratings.rating = 5) AND personality_ratings.movie_id = 
        (SELECT ml_movies.movie_id 
        FROM ml_movies 
        WHERE ml_movies.title = \"$title\")";

    $result2 = mysqli_query($connection, $query2);
    $result_count2 = mysqli_num_rows($result2);

    echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>';
    echo $result_count1;
    if ($result_count1 > 0) {
        echo '<div class="container">';
        echo "<p>Training Data Set (30%) for " . $title .":";
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Rating</th> <th scope="col">Avg(Openness)</th> <th scope="col">Avg(Agreeableness)</th> <th scope="col">Avg(Emotional_Stability)</th> <th scope="col">Avg(Conscientiousness)</th> <th scope="col">Avg(Extraversion)</th> </tr> </thead> <tbody>';
        while ($row = mysqli_fetch_array($result1))
        {
            echo '<tr> <td>4 and 5</td><td>' . $row['AVG(personality.openness)']. '</td><td>' . $row['AVG(personality.agreeableness)']. '</td><td>' . $row['AVG(personality.emotional_stability)']. '</td> <td>' . $row['AVG(personality.conscientiousness)']. '</td> <td>' . $row['AVG(personality.extraversion)']. '</td></tr>';
        }
        echo '</tbody> </table>';
        echo '</div>';
    }
    else {
        echo '<div class="container"><h3>No results found, please try again. </h3></div>';
    }
    if ($result_count2 > 0) {
        echo '<div class="container">';
        echo "<p>Full Data Set (100%) for " . $title .":";
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Rating</th> <th scope="col">Avg(Openness)</th> <th scope="col">Avg(Agreeableness)</th> <th scope="col">Avg(Emotional_Stability)</th> <th scope="col">Avg(Conscientiousness)</th> <th scope="col">Avg(Extraversion)</th> </tr> </thead> <tbody>';
        while ($row = mysqli_fetch_array($result2))
        {
            echo '<tr> <td>4 and 5</td><td>' . $row['AVG(personality.openness)']. '</td><td>' . $row['AVG(personality.agreeableness)']. '</td><td>' . $row['AVG(personality.emotional_stability)']. '</td> <td>' . $row['AVG(personality.conscientiousness)']. '</td> <td>' . $row['AVG(personality.extraversion)']. '</td></tr>';
        }
        echo '</tbody> </table>';
        echo '</div>';
    }
?>