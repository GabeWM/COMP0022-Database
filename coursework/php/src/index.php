<?php
    //The MySQL service named in the docker-compose.yml.
    // $host = "db";
    // $user = "root";
    // $pass = "password";
    // $mydatabase = "comp0022_database";

    // //Establish connection
    // $connection = new mysqli($host, $user, $pass, $mydatabase);
    // if (mysqli_connect_errno())
    // {
    //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
    // }
    include("connect.php");
?>

<!DOCTYPE html>
    <html>
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <head>
            <h1 class="text-center">Movie Industry Database</h1>
            <p class="text-center">for marketing professionals</p>
        </head>
        <body>
            <div class="container">
                <form id="hide1" action="case1.php" method="post">
                    <div class="row">
                        <div class="col">
                            <div class="mb-4">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="Enter a title" name='title'> 
                            </div>   
                            <div class="mb-4">                   
                                <label for="imdb_id" class="form-label">IMDB Id:</label>
                                <input type="number" class="form-control" id="imdb_id" placeholder="Enter an IMDB Id" name='imdb_id'>                
                            </div>
                            <div class="mb-4">   
                                <label for="tmdb_id" class="form-label">TMDB Id:</label>
                                <input type="number" class="form-control" id="tmdb_id" placeholder="Enter a TMDB Id" name='tmdb_id'>
                            </div>
                            <div class="mb-4">   
                                <label for="year_min" class="form-label">Year Released (From):</label>
                                <input type="number" class="form-control" id="year_min" placeholder="Enter a year (Inclusive)" name='start_year' min=1900 max=2050>
                            </div>
                            <div class="mb-4">   
                                <label for="year_max" class="form-label">Year Released (To):</label>
                                <input type="number" class="form-control" id="year_max" placeholder="Enter a year (Inclusive)" name='end_year' min=1950 max=2050>
                            </div>
                        </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre1" name="genre[]" value="action">
                                    <label class="form-check-label" for="genre1">Action</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre2" name="genre[]" value="adventure">
                                    <label class="form-check-label" for="genre2">Adventure</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre3" name="genre[]" value="animation">
                                    <label class="form-check-label" for="genre3">Animation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre4" name="genre[]" value="children">
                                    <label class="form-check-label" for="genre4">Children</label>
                                </div>
                                <div class="form-check">    
                                    <input class="form-check-input" type="checkbox" id="genre5" name="genre[]" value="comedy">
                                    <label class="form-check-label" for="genre5">Comedy</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre6" name="genre[]" value="crime">
                                    <label class="form-check-label" for="genre6">Crime</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre7" name="genre[]" value="documentary">
                                    <label class="form-check-label" for="genre7">Documentary</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre8" name="genre[]" value="drama">
                                    <label class="form-check-label" for="genre8">Drama</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre9" name="genre[]" value="fantasy">
                                    <label class="form-check-label" for="genre9">Fantasy</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre10" name="genre[]" value="film-noir">
                                    <label class="form-check-label" for="genre10">Film-Noir</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre11" name="genre[]" value="horror">
                                    <label class="form-check-label" for="genre11">Horror</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre12" name="genre[]" value="musical">
                                    <label class="form-check-label" for="genre12">Musical</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre13" name="genre[]" value="mystery">
                                    <label class="form-check-label" for="genre13">Mystery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre14" name="genre[]" value="romance">
                                    <label class="form-check-label" for="genre14">Romance</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre15" name="genre[]" value="sci-fi">
                                    <label class="form-check-label" for="genre15">Sci-fi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre16" name="genre[]" value="thriller">
                                    <label class="form-check-label" for="genre16">Thriller</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre17" name="genre[]" value="war">
                                    <label class="form-check-label" for="genre17">War</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre18" name="genre[]" value="western">
                                    <label class="form-check-label" for="genre18">Western</label>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="hide2" class="btn btn-primary btn-lg" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="hide3" class="btn btn-secondary btn-lg" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>       
        </body>
    </html>