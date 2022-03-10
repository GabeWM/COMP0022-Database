<?php
    require("index.php");
    //Query
    $query = "SELECT * FROM ml_movies";

    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    echo '<script>
                document.getElementById("hide1").classList.add("d-none");
                document.getElementById("hide2").classList.add("d-none");
                document.getElementById("hide3").classList.add("d-none");
          </script>';
    echo '<div class="container">';
    echo '<table class="table table-center table-bordered" border="1">';
    echo '<thead> <tr> <th scope="col">Title</th> <th scope="col">Year</th> </tr> </thead> <tbody>';
    while ($row = mysqli_fetch_array($result))
    {
        echo '<tr> <td>' . $row['title'] . '</td><td>' . $row['year']. '</td> </tr>';
    }
    echo '</tbody> </table>';
    echo '</div>';
?>