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
    // echo $_POST['case2_title'];
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        // echo $data;
        return $data;
    }

    $keyword = test_input($_POST['case2_title']);
    
    $query = "SELECT title, COUNT(rating) AS no_of_ratings, ROUND(AVG(rating),2) AS avg_rating FROM ml_movies INNER JOIN ml_ratings ON ml_movies.movie_id=ml_ratings.movie_id WHERE title='$keyword' GROUP BY ml_movies.movie_id ORDER BY ml_movies.movie_id";
    $rating_5_count = "SELECT title, COUNT(rating) AS movie_rating_5 FROM ml_movies INNER JOIN ml_ratings ON ml_movies.movie_id=ml_ratings.movie_id WHERE ml_ratings.rating = 5 AND title='$keyword' GROUP BY ml_movies.movie_id ORDER BY ml_movies.movie_id";
    $rating_4_count = "SELECT title, COUNT(rating) AS movie_rating_4 FROM ml_movies INNER JOIN ml_ratings ON ml_movies.movie_id=ml_ratings.movie_id WHERE ml_ratings.rating = 4 AND title='$keyword' GROUP BY ml_movies.movie_id ORDER BY ml_movies.movie_id";
    $rating_3_count = "SELECT title, COUNT(rating) AS movie_rating_3 FROM ml_movies INNER JOIN ml_ratings ON ml_movies.movie_id=ml_ratings.movie_id WHERE ml_ratings.rating = 3 AND title='$keyword' GROUP BY ml_movies.movie_id ORDER BY ml_movies.movie_id";
    $rating_2_count = "SELECT title, COUNT(rating) AS movie_rating_2 FROM ml_movies INNER JOIN ml_ratings ON ml_movies.movie_id=ml_ratings.movie_id WHERE ml_ratings.rating = 2 AND title='$keyword' GROUP BY ml_movies.movie_id ORDER BY ml_movies.movie_id";
    $rating_1_count = "SELECT title, COUNT(rating) AS movie_rating_1 FROM ml_movies INNER JOIN ml_ratings ON ml_movies.movie_id=ml_ratings.movie_id WHERE ml_ratings.rating = 1 AND title='$keyword' GROUP BY ml_movies.movie_id ORDER BY ml_movies.movie_id";
    $details = "SELECT *, T.tags FROM ml_movies AS M INNER JOIN (SELECT movie_id, GROUP_CONCAT(DISTINCT tag ORDER BY tag SEPARATOR ', ') AS tags FROM ml_tags GROUP BY movie_id) AS T WHERE M.movie_id=T.movie_id AND title='$keyword'";
    $general_query = "SELECT * FROM ml_movies WHERE title=$keyword";

    // mysqli_multi_query($connection, $query);
    $result = mysqli_query($connection, $query);
    $result_count = mysqli_num_rows($result);


    echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>';
    

    if ($result_count > 0) {
        
        
        $result5 = mysqli_query($connection, $rating_5_count);
        $result4 = mysqli_query($connection, $rating_4_count);
        $result3 = mysqli_query($connection, $rating_3_count);
        $result2 = mysqli_query($connection, $rating_2_count);
        $result1 = mysqli_query($connection, $rating_1_count);
        $movie_details = mysqli_query($connection, $details);

        $ratings_count = mysqli_num_rows($result5);
        if ($ratings_count > 0) {
            $row5 = mysqli_fetch_array($result5);
            $row4 = mysqli_fetch_array($result4);
            $row3 = mysqli_fetch_array($result3);
            $row2 = mysqli_fetch_array($result2);
            $row1 = mysqli_fetch_array($result1);
            $row = mysqli_fetch_array($movie_details);

            $result_genre = array();
            if($row['action'] == 1) {
                array_push($result_genre, 'Action');
            }
            if($row['adventure'] == 1) {
                array_push($result_genre, 'Adventure');
            }
            if($row['animation'] == 1) {
                array_push($result_genre, 'Animation');
            }
            if($row['children'] == 1) {
                array_push($result_genre, 'Children');
            }
            if($row['comedy'] == 1) {
                array_push($result_genre, 'Comedy');
            }
            if($row['crime'] == 1) {
                array_push($result_genre, 'Crime');
            }
            if($row['documentary'] == 1) {
                array_push($result_genre, 'Documentary');
            }
            if($row['drama'] == 1) {
                array_push($result_genre, 'Drama');
            }
            if($row['fantasy'] == 1) {
                array_push($result_genre, 'Fantasy');
            }
            if($row['film-noir'] == 1) {
                array_push($result_genre, 'Film-Noir');
            }
            if($row['horror'] == 1) {
                array_push($result_genre, 'Horror');
            }
            if($row['musical'] == 1) {
                array_push($result_genre, 'Musical');
            }
            if($row['mystery'] == 1) {
                array_push($result_genre, 'Mystery');
            }
            if($row['romance'] == 1) {
                array_push($result_genre, 'Romance');
            }
            if($row['sci-fi'] == 1) {
                array_push($result_genre, 'Sci-Fi');
            }
            if($row['thriller'] == 1) {
                array_push($result_genre, 'Thriller');
            }
            if($row['war'] == 1) {
                array_push($result_genre, 'War');
            }
            if($row['western'] == 1) {
                array_push($result_genre, 'Western');
            }

        

            echo "<div class='container'><h3 class='text-center'>".$row['title']."</h3><br>";

            $genre_type_print = implode(', ', $result_genre);
            echo '<div class="container">Movie Details<table class="table table-center table-bordered" border="1">';
            echo '<thead> <tr> <th scope="col">Title</th> <th scope="col">Year</th> <th scope="col">Imdb_id</th> <th scope="col">Tmdb_id</th> <th scope="col">Genre</th><th scope="col">Movie tags</th></tr> </thead> <tbody>';
            echo '<tr> <td>' . $row['title'] . '</td><td>' . $row['year']. '</td><td>' . $row['imdb_id']. '</td><td>' . $row['tmdb_id']. '</td> <td>' . $genre_type_print. '</td> <td>' . $row['tags']. '</td> </tr> </tbody> </table></div>';

            $info = mysqli_fetch_array($result);
            echo '<div class="container">Ratings Details<br><table class="table table-center table-bordered" border="1" style="table-layout: fixed ; width: 100%; text-align: center;">';
            echo '<thead> <tr> <th scope="col">Total Number of Ratings</th> <th scope="col">Average Ratings</th> </tr> </thead> <tbody>';
            echo '<tr> <td>' . $info['no_of_ratings'] . '</td><td>' . $info['avg_rating']. '</td></tr>';
            echo '</tbody> </table></div>';


            echo '<div class="container">Ratings Breakdown<br><table class="table table-center table-bordered" border="1" style="table-layout: fixed ; width: 100%; text-align: center;">';
            echo '<thead> <tr><th scope="col">Rating</th> <th scope="col">5</th> <th scope="col">4</th> <th scope="col">3</th> <th scope="col">2</th> <th scope="col">1</th></tr> </thead> <tbody>';
            echo '<tr> <td>Quantity</td><td>' . $row5['movie_rating_5'] . '</td><td>' . $row4['movie_rating_4']. '</td><td>' . $row3['movie_rating_3']. '</td><td>' . $row2['movie_rating_2']. '</td> <td>' .$row1['movie_rating_1']. '</td></tr>';
            echo '</tbody> </table></div>';

        } else {
            echo "<div class='container'><h3>No results found, please try again. </h3></div>";
        }
   

    } else {
        echo "<div class='container'><h3>No results found, please try again. </h3></div>";
    }
?>
