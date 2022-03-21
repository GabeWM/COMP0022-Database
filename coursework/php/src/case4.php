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
Predicting how a film will be rated after its release from the reactions of a small preview audience, i.e., taking a sub-set of
the viewers for a particular movie in the data set and treating them as though they were people at a preview, is it possible
to predict the aggregate ratings of that film by all viewers from just that sub-set?
*/
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    // $data = htmlspecialchars($data);
    return $data;
}
$keyword = mysqli_real_escape_string($connection, test_input($_POST['case4_title']));
$number = mysqli_real_escape_string($connection, test_input($_POST['case4_number']));
$pred_rating_query = 
		"SELECT AVG(t.rating) AS average
		FROM (SELECT * FROM ml_ratings WHERE movie_id IN (SELECT movie_id FROM ml_movies WHERE title = \"$keyword\") ORDER BY RAND() LIMIT ".$number.") AS t ";

	$res_avg = $connection -> query($pred_rating_query);

	if ($res_avg->num_rows > 0) {
		echo "<h4>Predicted average rating: </h4>";
		$row = $res_avg->fetch_assoc();
		if ($row['average'] != NULL) {
			 echo "<p>{$row['average']} / 5</p>";
		} else {
			echo "<p class=\"text-danger\">Not available due to limited information</p>";
		}
	} 
?>

<?php
    require("connect.php");

    echo '<div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>
          <h3 class="text-center">Case 4 Output</h3>';
?>