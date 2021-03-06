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

        $genre_counts = array();
        $genre_variances = array();

        function variance($arr) {
            if (count($arr) == 0) {
                return 0;
            }
            $length = count($arr);
            if ($length == 0) {
              return array(0,0);
            }
            $sum = 0;
            foreach ($arr as $v) {
                $sum = $sum + $v["rating"];
            }
            $average = $sum/$length;
            $count = 0;
            foreach ($arr as $v) {
                $count += pow($average-$v["rating"], 2);
            }
            $variance = $count/$length;
            return $variance;
        }

        $genres = ["action", "adventure", "animation","children","comedy", "crime", "documentary", "drama"
        , "fantasy", "film_noir", "horror", "musical", "mystery", "romance", "sci-fi", "thriller", "war", "western"];


        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (action=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (adventure=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (animation=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (children=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (comedy=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (crime=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (documentary=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (drama=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (fantasy=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }


        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (film_noir=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }


        
        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (horror=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (musical=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (mystery=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (romance=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }
        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (sci_fi=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (thriller=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (war=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        $query = "SELECT rating FROM `ml_ratings` WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE (western=1))";
        $movie_ratings = $connection->query($query);
        if ($movie_ratings == FALSE) {
            $genre_counts[] = 0;
            $genre_variances[] = 0;
        } else {
            $movie_ratings = $movie_ratings->fetch_all(MYSQLI_ASSOC);
            $genre_counts[] = count($movie_ratings);
            $genre_variances[] = variance($movie_ratings);

        }

        echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>';

        reset($genre_counts);
        reset($genre_variances);
        arsort($genre_counts);
        arsort($genre_variances);
        //print_r($genre_variances);
        //print(array_sum($genre_counts));
        echo "<h3>The most popular kind of movies: ".$genres[key($genre_counts)]."</h3><br />";
        echo "<h3>The most polarising kind of movies: ".$genres[key($genre_variances)] . "</h3>";

        $rank = 1;
        echo '<div class="container">';
        echo "<p>Popularity Ranking ";
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Rank</th> <th scope="col">Kind</th> <th scope="col">Number of ratings</th> </tr> </thead> <tbody>';
        foreach ($genre_counts as $v) {
            echo '<tr> <td>' . $rank.'</td><td>' . $genres[array_keys($genre_counts,$v)[0]]. '</td><td>' . $v. '</td><td>';
            $rank = $rank + 1;
        }
        echo '</tbody> </table>';
        echo '</div>';

        $rank = 1;
        echo '<div class="container">';
        echo "<p>Polarity Ranking ";
        echo '<table class="table table-center table-bordered" border="1">';
        echo '<thead> <tr> <th scope="col">Rank</th> <th scope="col">Kind</th> <th scope="col">Variance</th> </tr> </thead> <tbody>';
        foreach ($genre_variances as $v) {
            echo '<tr> <td>' . $rank.'</td><td>' . $genres[array_keys($genre_variances,$v)[0]]. '</td><td>' . $v. '</td><td>';
            $rank = $rank + 1;
        }

    ?>