<?php
    require("index.php");

    echo '<script>
                document.getElementById("case_container").classList.add("d-none");
                document.getElementById("case5_hide1").classList.add("d-none");
                document.getElementById("case5_hide2").classList.add("d-none");
                document.getElementById("case5_hide3").classList.add("d-none");
          </script>
          <div class="container">
            <div class="row">
                <button class="btn btn-warning btn-lg" onClick="GoBackWithRefresh();return false;">Go To Front Page</button>
            </div>
          </div>
          <br>
          <h3 class="text-center">Case 5 Output</h3>';
