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

    $movie_id = $_POST['case5_movie_id'];
    $rating = $_POST['case5_rating'];

    $query = "SELECT personality_ratings.rating, AVG(personality.openness), AVG(personality.agreeableness), AVG(personality.emotional_stability), AVG(personality.conscientiousness), AVG(personality.extraversion) FROM personality_ratings LEFT JOIN personality ON personality_ratings.personality_user_id = personality.personality_user_id WHERE personality_movie_id = $movie_id AND personality_ratings.rating = $rating GROUP BY personality_ratings.rating ORDER BY personality_ratings.rating;";
    $result = mysqli_query($connection, $query);
    $result_count = mysqli_num_rows($result);

    echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>';
    if ($result_count > 0) {
        echo '<div class="container">';
        echo "<p>Total number of records: $result_count<p>";
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Rating</th> <th scope="col">Avg(Openness)</th> <th scope="col">Avg(Agreeableness)</th> <th scope="col">Avg(Emotional_Stability)</th> <th scope="col">Avg(Conscientiousness)</th> <th scope="col">Avg(Extraversion)</th> </tr> </thead> <tbody>';
        while ($row = mysqli_fetch_array($result))
        {
            echo '<tr> <td>' . $row['rating'] . '</td><td>' . $row['AVG(personality.openness)']. '</td><td>' . $row['AVG(personality.agreeableness)']. '</td><td>' . $row['AVG(personality.emotional_stability)']. '</td> <td>' . $row['AVG(personality.conscientiousness)']. '</td> <td>' . $row['AVG(personality.extraversion)']. '</td></tr>';
        }
        echo '</tbody> </table>';
        echo '</div>';
    }
    else {
        echo '<div class="container"><p>No results found, please try again. </p></div>';
    }
?>