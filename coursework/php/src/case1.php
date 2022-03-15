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
/*
        function console_log($output, $with_script_tags = true) {
            $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
            if ($with_script_tags) {
                $js_code = '<script>' . $js_code . '</script>';
            }
            echo $js_code;
        }
    */

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            // $data = htmlspecialchars($data);
            echo $data;
            return $data;
        }
       
        $title = test_input($_POST['title']);
        $genre = array();
        if (isset($_POST['genre'])) {
            $genre = $_POST['genre'];
        }
        $tmdb_id = $_POST['tmdb_id'];
        $imdb_id = $_POST['imdb_id'];
        $start_year = $_POST['start_year'];
        $end_year = $_POST['end_year'];
        $and_or = $_POST['case1_and_or'];
        
        global $query;

        // year_check
        // 0 = years not set
        // 1 = start or end year set

        if ($start_year AND $end_year) {
            if ($start_year> $end_year) {
                $new_start_year = $end_year;
                $end_year = $start_year;
                $start_year = $new_start_year;
            } else {
                $start_year = $start_year;
                $end_year = $end_year;
            }
            $year_check = 1;
        }
        if (!$start_year AND $end_year) {
            $start_year = 1900;
            $year_check = 1;
        }
        if ($start_year AND !$end_year) {
            $end_year = date("Y");
            $year_check = 1;
        }
        if (!$start_year AND !$end_year) {
            // no start or end year, can include NULL
            $year_check = 0;
        }

        // id_check
        // 0 = no tmdb, no imdb
        // 1 = no tmdb, imdb present
        // 2 = no imdb, tmdb present
        // 3 = both imdb, tmdb present
        if (!$tmdb_id AND !$imdb_id) {
            $id_check = 0;
        }
        if (!$tmdb_id AND $imdb_id) {
            $id_check = 1;
        }
        if ($tmdb_id AND !$imdb_id) {
            $id_check = 2;
        }
        if ($tmdb_id AND $imdb_id) {
            $id_check = 3;
        }
        
        // title_genre_check
        // 0 = no title, no genre
        // 1 = no title, genre
        // 2 = title, no genre
        // 3 = title, genre

        if (!$title AND !$genre) {
            $title_genre_check = 0;
        }
        if (!$title AND $genre) {
            $genre_type = implode(',', $_POST['genre']);
            $title_genre_check = 1;
        }
        if ($title AND !$genre) {
            $title_genre_check = 2;
        }
        if ($title AND $genre) {
            $genre_type = implode(',', $_POST['genre']);
            $title_genre_check = 3;
        }

        $temp = "";
        foreach ($genre as $genre_elem) {
            $temp = $temp . $genre_elem . " = 1 AND ";
        }
        $temp = substr($temp, 0, -4);

        if ($title_genre_check == 0 AND $id_check == 0 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies";
        } else if ($title_genre_check == 0 AND $id_check == 0 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 0 AND $id_check == 1 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 0 AND $id_check == 1 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 0 AND $id_check == 2 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id)";
        } else if ($title_genre_check == 0 AND $id_check == 2 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 0 AND $id_check == 3 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 0 AND $id_check == 3 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 1 AND $id_check == 0 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . $temp;
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type))";
            }
        } else if ($title_genre_check == 1 AND $id_check == 0 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 1 AND $id_check == 1 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE (imdb_id=$imdb_id)";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND (imdb_id=$imdb_id)";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (imdb_id=$imdb_id)";
            }
        } else if ($title_genre_check == 1 AND $id_check == 1 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 1 AND $id_check == 2 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id)";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND (tmdb_id=$tmdb_id)";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id)";
            }
        } else if ($title_genre_check == 1 AND $id_check == 2 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 1 AND $id_check == 3 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
            }
        } else if ($title_genre_check == 1 AND $id_check == 3 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 2 AND $id_check == 0 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%'";
        } else if ($title_genre_check == 2 AND $id_check == 0 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 2 AND $id_check == 1 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 2 AND $id_check == 1 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 2 AND $id_check == 2 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id)";
        } else if ($title_genre_check == 2 AND $id_check == 2 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 2 AND $id_check == 3 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 2 AND $id_check == 3 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 3 AND $id_check == 0 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%'";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%'";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%'";
            }
        } else if ($title_genre_check == 3 AND $id_check == 0 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 3 AND $id_check == 1 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (imdb_id=$imdb_id)";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND (imdb_id=$imdb_id)";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (imdb_id=$imdb_id)";
            }
        } else if ($title_genre_check == 3 AND $id_check == 1 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 3 AND $id_check == 2 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id)";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id)";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id)";
            }
        } else if ($title_genre_check == 3 AND $id_check == 2 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
            }
        } else if ($title_genre_check == 3 AND $id_check == 3 AND $year_check == 0) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
            }
        } else if ($title_genre_check == 3 AND $id_check == 3 AND $year_check == 1) {
            if ($and_or === "and") {
                if ($temp === "") {
                    $query = "SELECT * FROM ml_movies WHERE title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
                else {
                    $query = "SELECT * FROM ml_movies WHERE " . temp . " AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
                }
            }
            else {
                $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
            }
        } 

        if(isset($_POST['sort'])) {
            $sort = $_POST['sort'];
            if ($sort==1){
                $query .= " ORDER BY title";
            } else if ($sort==2) {
                $query .= " ORDER BY title DESC";
            } else if ($sort==3) {
                $query .= " ORDER BY year";
            } else if ($sort==4) {
                $query .= " ORDER BY year DESC";
            } else if ($sort==5) {
                $query .= " ORDER BY tmdb_id";
            } else if ($sort==6) {
                $query .= " ORDER BY tmdb_id DESC";
            } else if ($sort==7) {
                $query .= " ORDER BY imdb_id";
            } else if ($sort==8) {
                $query .= " ORDER BY imdb_id DESC";
            }
        }

        // echo $query;
        $result = mysqli_query($connection, $query);
        // $row = mysqli_fetch_array($result);
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
            echo '<thead> <tr> <th scope="col">Title</th> <th scope="col">Year</th> <th scope="col">Imdb_id</th> <th scope="col">Tmdb_id</th> <th scope="col">Genre</th></tr> </thead> <tbody>';
            while ($row = mysqli_fetch_array($result))
            {
                // get genre result

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
                if($row['film_noir'] == 1) {
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
                if($row['sci_fi'] == 1) {
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

                $genre_type_print = implode(', ', $result_genre);

                if ($row['title'] == NULL) {
                    $row['title'] = "N/A";
                }
                if ($row['year'] == NULL) {
                    $row['year'] = "N/A";
                }
                if ($row['tmdb_id'] == NULL) {
                    $row['tmdb_id'] = "N/A";
                }
                if ($row['imdb_id'] == NULL) {
                    $row['imdb_id'] = "N/A";
                }

                if ($genre_type_print == "") {
                    $genre_type_print = "N/A";
                }

                echo '<tr> <td>' . $row['title'] . '</td><td>' . $row['year']. '</td><td>' . $row['imdb_id']. '</td><td>' . $row['tmdb_id']. '</td> <td>' . $genre_type_print. '</td></tr>';
            }
            echo '</tbody> </table>';
            echo '</div>';
            
        } else {
            echo '<div class="container"><p>No results found, please try again. </p></div>';
        }
    ?>
</html>
