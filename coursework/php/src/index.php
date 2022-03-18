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

<script>
    function case1() {
        hideCases();
        document.getElementById("case1_container").classList.remove("d-none");
        document.getElementById("case1_hide2").classList.remove("d-none");
        document.getElementById("case1_hide3").classList.remove("d-none");
    }

    function case2() {
        hideCases();
        document.getElementById("case2_container").classList.remove("d-none");
        document.getElementById("case2_hide2").classList.remove("d-none");
        document.getElementById("case2_hide3").classList.remove("d-none");
    }

    function case3() {
        hideCases();
        document.getElementById("case3_container").classList.remove("d-none");
        document.getElementById("case3_hide2").classList.remove("d-none");
        document.getElementById("case3_hide3").classList.remove("d-none");
    }

    function case4() {
        hideCases();
        document.getElementById("case4_container").classList.remove("d-none");
        document.getElementById("case4_hide2").classList.remove("d-none");
        document.getElementById("case4_hide3").classList.remove("d-none");
    }

    function case5() {
        hideCases();
        document.getElementById("case5_container").classList.remove("d-none");
        document.getElementById("case5_hide2").classList.remove("d-none");
        document.getElementById("case5_hide3").classList.remove("d-none");
    }

    function case6() {
        hideCases();
        document.getElementById("case6_container").classList.remove("d-none");
        document.getElementById("case6_hide2").classList.remove("d-none");
        document.getElementById("case6_hide3").classList.remove("d-none");
    }

    function hideCases() {
        document.getElementById("case_container").classList.add("d-none");
    }

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
            <div id="case_container" class="container">
                    <div class="row ">
                        <button id="case1_button" class="btn btn-success btn-lg" type="button" onclick="case1()">Case 1: Browsing visual lists of films</button>
                    </div>
                    <br>
                    <div class="row">
                        <button id="case2_button" class="btn btn-success btn-lg" type="button" onclick="case2()">Case 2: Searching for a film to obtain a report on the viewer reaction to it</button>
                    </div>
                    <br>
                    <div class="row">
                        <button id="case3_button" class="btn btn-success btn-lg" type="button" onclick="case3()">Case 3: Reporting which are the most popular and polarising kinds of movies</button>
                    </div>
                    <br>
                    <div class="row">
                        <button id="case4_button" class="btn btn-success btn-lg" type="button" onclick="case4()">Case 4: Predicting how a film will be rated after its release from the reactions of a small preview audience</button>
                    </div>
                    <br>
                    <div class="row">
                        <button id="case5_button" class="btn btn-success btn-lg" type="button" onclick="case5()">Case 5: Predicting the personality traits of viewers of a film given a rating</button>
                    </div>
                    <br>
                    <div class="row">
                        <button id="case6_button" class="btn btn-success btn-lg" type="button" onclick="case6()">Case 6: Predicting the personality traits of viewers of a film who will give it a high rating</button>
                    </div>
                    <br>
            </div>
            <div id="case1_container" class="container d-none">
                <form id="case1_hide1" action="case1.php" method="post">
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
                            <div class="mb-4">
                                <label for="case1_sort" class="form-label">Sort By</label>
                                <select class="form-select" id="case1_sort" name="sort">
                                    <option value="1"selected>Movie Title (A -> Z)</option>
                                    <option value="2">Movie Title (Z -> A)</option>
                                    <option value="3">Year (Oldest to Most Recent)</option>
                                    <option value="4">Year (Most Recent to Oldest)</option>
                                    <option value="5">Tmdb_id (Lowest to Highest)</option> 
                                    <option value="6">Tmdb_id (Highest to Lowest)</option> 
                                    <option value="7">Imdb_id (Lowest to Highest)</option> 
                                    <option value="8">Imdb_id (Highest to Lowest)</option>  
                                </select>
                            </div>
                        </div>
                            <div class="col">
                                    <label for="case1_and_or" class="form-label">Select "And" or "Or" for Genres</label>
                                    <select class="form-select" id="case1_and_or" name="case1_and_or" required>
                                        <option value="">Nothing Selected</option>
                                        <option value="or">Or</option>
                                        <option value="and">And</option>
                                    </select>
                                <br>
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
                                    <input class="form-check-input" type="checkbox" id="genre10" name="genre[]" value="film_noir">
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
                                    <input class="form-check-input" type="checkbox" id="genre15" name="genre[]" value="sci_fi">
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
                            <input id="case1_hide2" class="btn btn-primary btn-lg d-none" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case1_hide3" class="btn btn-secondary btn-lg d-none" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
            <!--CASE 2 UI HERE-->
            <div id="case2_container" class="container d-none">
                <form id="case2_hide1" action="case2.php" method="post">
                    <div class="mb-5">
                        <label for="case5_movie_id" class="form-label">Movie Title:</label>
                        <input type="text" class="form-control" id="case2" placeholder="Enter a Movie title" name='case2_title' required> 
                    </div>
                    <div class="row">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case2_hide2" class="btn btn-primary btn-lg d-none" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case2_hide3" class="btn btn-secondary btn-lg d-none" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
            <!--CASE 3 UI HERE-->
            <div id="case3_container" class="container d-none">
                <form id="case3_hide1" action="case3.php" method="post">
                    <div class="row">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case3_hide2" class="btn btn-primary btn-lg d-none" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case3_hide3" class="btn btn-secondary btn-lg d-none" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
            <!--CASE 4 UI HERE-->
            <div id="case4_container" class="container d-none">
                <form id="case4_hide1" action="case4.php" method="post">
                <div class="mb-5">
                        <label for="case5_movie_id" class="form-label">Movie Title:</label>
                        <input type="text" class="form-control" id="case4" placeholder="Enter a Movie title" name='case4_title' required> 
                    </div>
                    <div class="mb-5">
                        <label for="case5_movie_id" class="form-label">Number of people at a preview:</label>
                        <input type="text" class="form-control" id="case4" placeholder="Enter a positive whole number" name='case4_number' required> 
                    </div>
                    <div class="row">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case4_hide2" class="btn btn-primary btn-lg d-none" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case4_hide3" class="btn btn-secondary btn-lg d-none" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
            <!--CASE 5 UI HERE-->
            <div id="case5_container" class="container d-none">
                <form id="case5_hide1" action="case5.php" method="post">
                    <div class="mb-3">
                            <label for="case5_title" class="form-label">Movie Title:</label>
                            <input type="text" class="form-control" id="case5_title" placeholder="Enter a movie title" name='case5_title' required> 
                    </div>  
                    <div class="row">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case5_hide2" class="btn btn-primary btn-lg d-none" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case5_hide3" class="btn btn-secondary btn-lg d-none" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
            <!--CASE 6 UI HERE-->
            <div id="case6_container" class="container d-none">
                <form id="case6_hide1" action="case6.php" method="post">
                    <div class="row">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case6_hide2" class="btn btn-primary btn-lg d-none" type="submit" value="Submit">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <input id="case6_hide3" class="btn btn-secondary btn-lg d-none" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>       
        </body>
    </html>