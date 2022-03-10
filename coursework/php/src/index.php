<?php
    //The MySQL service named in the docker-compose.yml.
    $host = "db";
    $user = "root";
    $pass = "password";
    $mydatabase = "comp0022_database";

    //Establish connection
    $connection = new mysqli($host, $user, $pass, $mydatabase);
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
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
                                <input type="text" class="form-control" id="title" placeholder="Enter a title"> 
                            </div>   
                            <div class="mb-4">                   
                                <label for="imdb_id" class="form-label">IMDB Id:</label>
                                <input type="text" class="form-control" id="imdb_id" placeholder="Enter an IMDB Id">                
                            </div>
                            <div class="mb-4">   
                                <label for="tmdb_id" class="form-label">TMDB Id:</label>
                                <input type="text" class="form-control" id="tmdb_id" placeholder="Enter a TMDB Id">
                            </div>
                            <div class="mb-4">   
                                <label for="year_min" class="form-label">Minimum Year:</label>
                                <input type="text" class="form-control" id="year_min" placeholder="Enter a Minimum Year (Inclusive)">
                            </div>
                            <div class="mb-4">   
                                <label for="year_max" class="form-label">Maximum Year:</label>
                                <input type="text" class="form-control" id="year_max" placeholder="Enter a Maximum Year (Inclusive)">
                            </div>
                        </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre1" name="genre1" value="Action">
                                    <label class="form-check-label" for="genre1">Action</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre2" name="genre2" value="Adventure">
                                    <label class="form-check-label" for="genre2">Adventure</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre3" name="genre3" value="Animation">
                                    <label class="form-check-label" for="genre3">Animation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre4" name="genre4" value="Children">
                                    <label class="form-check-label" for="genre4">Children</label>
                                </div>
                                <div class="form-check">    
                                    <input class="form-check-input" type="checkbox" id="genre5" name="genre5" value="Comedy">
                                    <label class="form-check-label" for="genre5">Comedy</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre6" name="genre6" value="Crime">
                                    <label class="form-check-label" for="genre6">Crime</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre7" name="genre7" value="Documentary">
                                    <label class="form-check-label" for="genre7">Documentary</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre8" name="genre8" value="Drama">
                                    <label class="form-check-label" for="genre8">Drama</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre9" name="genre9" value="Fantasy">
                                    <label class="form-check-label" for="genre9">Fantasy</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre10" name="genre10" value="Film-Noir">
                                    <label class="form-check-label" for="genre10">Film-Noir</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre11" name="genre11" value="Horror">
                                    <label class="form-check-label" for="genre11">Horror</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre12" name="genre12" value="Musical">
                                    <label class="form-check-label" for="genre12">Musical</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre13" name="genre13" value="Mystery">
                                    <label class="form-check-label" for="genre13">Mystery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre14" name="genre14" value="Romance">
                                    <label class="form-check-label" for="genre14">Romance</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre15" name="genre15" value="Sci-fi">
                                    <label class="form-check-label" for="genre15">Sci-fi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre16" name="genre16" value="Thriller">
                                    <label class="form-check-label" for="genre16">Thriller</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre17" name="genre17" value="War">
                                    <label class="form-check-label" for="genre17">War</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="genre18" name="genre18" value="Western">
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