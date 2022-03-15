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
        function movie_variance($arr) {
            $length = count($arr);
            if ($length == 0) {
              return array(0,0);
            }
            $average = array_sum($arr)/$length;
            $count = 0;
            foreach ($arr as $v) {
                $count += pow($average-$v["rating"], 2);
            }
            $variance = $count/$length;
            return $variance;
        }

        function genre_variance($arr) {
            $length = count($arr);
            if ($length == 0) {
              return array(0,0);
            }
            $average = array_sum($arr)/$length;
            $count = 0;
            foreach ($arr as $v) {
                $count += pow($average-$v, 2);
            }
            $variance = $count/$length;
            return $variance;
        }

        $genres = array();
        $genres[] = "action";
        $genres[] = "adventure";
        $genres[] = "animation";
        $genres[] = "children";
        $genres[] = "comedy";
        $genres[] = "crime";
        $genres[] = "documentary";
        $genres[] = "drama";
        $genres[] = "fantasy";
        $genres[] = "film-noir";
        $genres[] = "horror";
        $genres[] = "musical";
        $genres[] = "mystery";
        $genres[] = "romance";
        $genres[] = "sci-fi";
        $genres[] = "thriller";
        $genres[] = "war";
        $genres[] = "western";
          
        $genre_counts = array();
        $genre_variances = array();

        $query = 'SELECT ml_movie_id FROM ml_movies WHERE (action=1)';
        $movie_id = $connection->query($query);
        $movie_id = $movie_id->fetch_all(MYSQLI_ASSOC);
        $movie_counts = 0;
        $movie_variances = array();
        foreach ($movie_id as $v) {
            $query = "SELECT rating FROM ml_ratings WHERE (ml_movie_id='{$v["ml_movie_id"]}')";
            $temp = $connection->query($query);
            $temp = $temp->fetch_all(MYSQLI_ASSOC);          
            $movie_counts = $movie_counts + count($temp);
            $movie_variances[] = movie_variance($temp);
        }
        //print_r($movie_variances);
        $genre_counts[] = $movie_counts;
        $genre_variances[] = genre_variance($movie_variances);
        print_r($genre_variances);

        $query = 'SELECT ml_movie_id FROM ml_movies WHERE (adventure=1)';
        $adventure_id = $connection->query($query);
        $adventure_id = $adventure_id->fetch_all(MYSQLI_ASSOC);
        $adventure_counts = 0;
        $adventure_variances = array();
        foreach ($adventure_id as $v) {
            $query = "SELECT rating FROM ml_ratings WHERE (ml_movie_id='{$v["ml_movie_id"]}')";
            $temp = $connection->query($query);
            $temp = $temp->fetch_all(MYSQLI_ASSOC);          
            $adventure_counts = $adventure_counts + count($temp);
            $adventure_variances[] = movie_variance($temp);
        }
        //print_r($movie_variances);
        $genre_counts[] = $adventure_counts;
        $genre_variances[] = genre_variance($adventure_variances);
        print_r($genre_variances);


        foreach ($genres as $genre) {
            $query = "SELECT ml_movie_id FROM ml_movies WHERE ('$genre'=1)";
            $movie_id = $connection->query($query);
            $movie_id = $movie_id->fetch_all(MYSQLI_ASSOC);
            $movie_counts = 0;
            $movie_variances = array();
            foreach ($movie_id as $v) {
                $query = "SELECT rating FROM ml_ratings WHERE (ml_movie_id='{$v["ml_movie_id"]}')";
                $temp = $connection->query($query);
                $temp = $temp->fetch_all(MYSQLI_ASSOC);          
                $movie_counts = $movie_counts + count($temp);
                $movie_variances[] = movie_variance($temp);
            }
            print_r($movie_variances);
            $genre_counts[] = $movie_counts;
            $genre_variances[] = genre_variance($movie_variances);
            //print_r($genre_variances);
        }
        


        
        //print(array_sum($genre_counts));
        //print max($counts);
        //print_r(variance($variances));




        
    ?>