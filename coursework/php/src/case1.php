<?php
    require("index.php");
    //Query
    $query = "SELECT * FROM ml_movies";

    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    echo '<script>
                document.getElementById("case_container").classList.add("d-none");
                document.getElementById("case1_hide1").classList.add("d-none");
                document.getElementById("case1_hide2").classList.add("d-none");
                document.getElementById("case1_hide3").classList.add("d-none");
          </script>
          <div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>
          <div class="container">
          <table class="table table-center table-bordered" border="1">
          <thead> <tr> <th scope="col">Title</th> <th scope="col">Year</th> </tr> </thead> <tbody>';
    while ($row = mysqli_fetch_array($result))
    {
        echo '<tr> <td>' . $row['title'] . '</td><td>' . $row['year']. '</td> </tr>';
    }
    echo '</tbody> </table>
          </div>';
?>