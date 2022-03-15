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

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        // $data = htmlspecialchars($data);
        return $data;
    }

    $keyword = test_input($_POST['case2_title']);
    
    $general_n_tags = "SELECT *
    FROM ml_movies m LEFT JOIN (SELECT movie_id, GROUP_CONCAT(DISTINCT tag) as movie_tags FROM ml_tags GROUP BY movie_id) AS t ON m.movie_id=t.movie_id
    WHERE m.title='$keyword'";

    $ratings_detail = "SELECT m.title, 
    SUM(CASE WHEN r.rating=5 THEN 1 ELSE 0 END) AS rating_5,
    SUM(CASE WHEN r.rating=4 THEN 1 ELSE 0 END) AS rating_4,
    SUM(CASE WHEN r.rating=3 THEN 1 ELSE 0 END) AS rating_3,
    SUM(CASE WHEN r.rating=2 THEN 1 ELSE 0 END) AS rating_2,
    SUM(CASE WHEN r.rating=5 THEN 1 ELSE 0 END) AS rating_1,
    COUNT(r.rating) AS rating_quantity,
    ROUND(AVG(r.rating),2) AS avg_rating
    FROM ml_movies m LEFT JOIN ml_ratings r ON m.movie_id=r.movie_id
    GROUP BY m.movie_id
    HAVING m.title='$keyword'";

    // $predictions = "SELECT m.movie_id, m.title, p.avg_pred, p.total_no_pred FROM ml_movies m LEFT JOIN 
    // (SELECT movie_id, ROUND(AVG(predictions),2) AS avg_pred, COUNT(predictions) AS total_no_pred FROM personality_predictions GROUP BY movie_id ORDER BY movie_id) as p
    // ON m.movie_id=p.movie_id
    // HAVING m.title='$keyword'";

    $ratings_breakdown = mysqli_query($connection, $ratings_detail);
    $ratings_breakdown_count = mysqli_num_rows($ratings_breakdown);

    $general_tag_info = mysqli_query($connection, $general_n_tags);
    $general_tag_info_count = mysqli_num_rows($general_tag_info);

    // $prediction_info = mysqli_query($connection, $predictions);
    // $prediction_info_count = mysqli_num_rows($prediction_info);

    echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>';

    // general info and tags table
    if ($general_tag_info_count>0) {
        // echo $general_tag_info_count;
        echo '<div class="container">Movie Details<br><table class="table table-center table-bordered" border="1" style=" table-layout: fixed ; width: 100%">';
        echo '<thead> <tr> <th scope="col">Title</th> <th scope="col">Year</th> <th scope="col">Tmdb_id</th> <th scope="col">Imdb_id</th> <th scope="col">Genre</th> <th scope="col">Movie Tags</th> </tr> </thead> <tbody>';
        while ($general_row = mysqli_fetch_array($general_tag_info)){
            if ($general_row['movie_tags'] == NULL) {
                $general_row['movie_tags'] = 'N/A';
            }

            $result_genre = array();
            if($general_row['action'] == 1) {
                array_push($result_genre, 'Action');
            }
            if($general_row['adventure'] == 1) {
                array_push($result_genre, 'Adventure');
            }
            if($general_row['animation'] == 1) {
                array_push($result_genre, 'Animation');
            }
            if($general_row['children'] == 1) {
                array_push($result_genre, 'Children');
            }
            if($general_row['comedy'] == 1) {
                array_push($result_genre, 'Comedy');
            }
            if($general_row['crime'] == 1) {
                array_push($result_genre, 'Crime');
            }
            if($general_row['documentary'] == 1) {
                array_push($result_genre, 'Documentary');
            }
            if($general_row['drama'] == 1) {
                array_push($result_genre, 'Drama');
            }
            if($general_row['fantasy'] == 1) {
                array_push($result_genre, 'Fantasy');
            }
            if($general_row['film-noir'] == 1) {
                array_push($result_genre, 'Film-Noir');
            }
            if($general_row['horror'] == 1) {
                array_push($result_genre, 'Horror');
            }
            if($general_row['musical'] == 1) {
                array_push($result_genre, 'Musical');
            }
            if($general_row['mystery'] == 1) {
                array_push($result_genre, 'Mystery');
            }
            if($general_row['romance'] == 1) {
                array_push($result_genre, 'Romance');
            }
            if($general_row['sci-fi'] == 1) {
                array_push($result_genre, 'Sci-Fi');
            }
            if($general_row['thriller'] == 1) {
                array_push($result_genre, 'Thriller');
            }
            if($general_row['war'] == 1) {
                array_push($result_genre, 'War');
            }
            if($general_row['western'] == 1) {
                array_push($result_genre, 'Western');
            }

            $genre_type_print = implode(', ', $result_genre);

            echo '<tr> <td>' . $general_row['title'] . '</td> <td>' . $general_row['year'] . '</td> <td>' . $general_row['tmdb_id'] . '</td> <td>' . $general_row['imdb_id'] . '</td> <td>' . $genre_type_print . '</td> <td>' . $general_row['movie_tags'] . '</td> </tr>';   
        }
        echo '</tbody> </table></div>';         
    } else {
        echo "<div class='container'><h3>No results found, please try again. </h3></div>";
    }

    // ratings table
    if ($ratings_breakdown_count>0) {
        // echo $ratings_breakdown_count;
        echo '<div class="container">Ratings Details<br><table class="table table-center table-bordered" border="1" style=" table-layout: fixed ; width: 100%; text-align: center;">';
        echo '<thead> <tr> <th scope="col">5</th> <th scope="col">4</th> <th scope="col">3</th> <th scope="col">2</th> <th scope="col">1</th> <th scope="col">Average Rating</th> <th scope="col">Total number of users who rated</th> </tr> </thead> <tbody>';
        while ($ratings_row = mysqli_fetch_array($ratings_breakdown)){
            if ($ratings_row['rating_quantity'] == 0) {
                $ratings_row['rating_5'] = 'N/A';
                $ratings_row['rating_4'] = 'N/A';
                $ratings_row['rating_3'] = 'N/A';
                $ratings_row['rating_2'] = 'N/A';
                $ratings_row['rating_1'] = 'N/A';
                $ratings_row['avg_rating'] = 'N/A';
            }
            echo '<tr> <td>' . $ratings_row['rating_5'] . '</td> <td>' . $ratings_row['rating_4'] . '</td> <td>' . $ratings_row['rating_3'] . '</td> <td>' . $ratings_row['rating_2'] . '</td> <td>' . $ratings_row['rating_1'] . '</td> <td>' . $ratings_row['avg_rating'] . '</td> <td>' . $ratings_row['rating_quantity'] . '</td> </tr>';   
        }
        echo '</tbody> </table></div>';         
    }

    //         $info = mysqli_fetch_array($result);
    //         echo '<div class="container">Ratings Details<br><table class="table table-center table-bordered" border="1" style="table-layout: fixed ; width: 100%; text-align: center;">';
    //         echo '<thead> <tr> <th scope="col">Total Number of Ratings</th> <th scope="col">Average Ratings</th> </tr> </thead> <tbody>';
    //         echo '<tr> <td>' . $info['no_of_ratings'] . '</td><td>' . $info['avg_rating']. '</td></tr>';
    //         echo '</tbody> </table></div>';


    //         echo '<div class="container">Ratings Breakdown<br><table class="table table-center table-bordered" border="1" style="table-layout: fixed ; width: 100%; text-align: center;">';
    //         echo '<thead> <tr><th scope="col">Rating</th> <th scope="col">5</th> <th scope="col">4</th> <th scope="col">3</th> <th scope="col">2</th> <th scope="col">1</th></tr> </thead> <tbody>';
    //         echo '<tr> <td>Quantity</td><td>' . $row5['movie_rating_5'] . '</td><td>' . $row4['movie_rating_4']. '</td><td>' . $row3['movie_rating_3']. '</td><td>' . $row2['movie_rating_2']. '</td> <td>' .$row1['movie_rating_1']. '</td></tr>';
    //         echo '</tbody> </table></div>';

    //     } else {
    //         echo "<div class='container'><h3>No results found, please try again. </h3></div>";
    //     }
   

    // } else {
    //     echo "<div class='container'><h3>No results found, please try again. </h3></div>";
    // }
?>
