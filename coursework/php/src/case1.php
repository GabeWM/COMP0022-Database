<?php
    include ("connect.php");

?>
<!DOCTYPE html>
<html lang="en">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <head>
        <h1 class="text-center">Movie Industry Database</h1>
        <p class="text-center">for marketing professionals</p>
    </head>

    <?php

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            // $data = htmlspecialchars($data);
            echo $data;
            return $data;
        }

        $title = test_input($_POST['title']);
        $genre = $_POST['genre'];
        $tmdb_id = $_POST['tmdb_id'];
        $imdb_id = $_POST['imdb_id'];
        $start_year = $_POST['start_year'];
        $end_year = $_POST['end_year'];
        
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


        if ($title_genre_check == 0 AND $id_check == 0 AND $year_check == 0) {
            echo "Displaying all results";
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
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type))";
        } else if ($title_genre_check == 1 AND $id_check == 0 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 1 AND $id_check == 1 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 1 AND $id_check == 1 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 1 AND $id_check == 2 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id)";
        } else if ($title_genre_check == 1 AND $id_check == 2 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 1 AND $id_check == 3 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 1 AND $id_check == 3 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
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
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%'";
        } else if ($title_genre_check == 3 AND $id_check == 0 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 3 AND $id_check == 1 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 3 AND $id_check == 1 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 3 AND $id_check == 2 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id)";
        } else if ($title_genre_check == 3 AND $id_check == 2 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND year BETWEEN $start_year AND $end_year";
        } else if ($title_genre_check == 3 AND $id_check == 3 AND $year_check == 0) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id)";
        } else if ($title_genre_check == 3 AND $id_check == 3 AND $year_check == 1) {
            $query = "SELECT * FROM ml_movies WHERE (1 IN ($genre_type)) AND title LIKE '%$title%' AND (tmdb_id=$tmdb_id) AND (imdb_id=$imdb_id) AND year BETWEEN $start_year AND $end_year";
        } 

        echo $query;
        $result = mysqli_query($connection, $query);
        // $row = mysqli_fetch_array($result);
        $result_count = mysqli_num_rows($result);
            
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

                $genre_type_print = implode(', ', $result_genre);
                echo '<tr> <td>' . $row['title'] . '</td><td>' . $row['year']. '</td><td>' . $row['imdb_id']. '</td><td>' . $row['tmdb_id']. '</td> <td>' . $genre_type_print. '</td></tr>';
            }
            echo '</tbody> </table>';
            echo '</div>';
            
        } else {
            echo '<div class="container"><p>No results found, please try again. </p></div>';
        }
    ?>
</html>