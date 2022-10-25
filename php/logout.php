<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
<?php
session_start();
if(isset($_SESSION["email"])){
    logout();
}else{
    //echo "<h3><center>No Session Found or Destroyed... <br> Redirecting in 4</center></h3>";
    echo "<body class='bg-success'><div class='alert alert-danger' role='alert' style='margin:8% auto;'>
            <h3><center>No Session Found or Destroyed... <br> Redirecting in 4</center></h3>
          </div></body>";
    echo '<meta http-equiv="refresh" content="4; url=../forms/login.html">';
}

function logout(){
    // destroy the session
    session_destroy();
    //echo "<h3><center>Session Destroyed... <br> Redirecting in 3</center></h3>";
    echo "<body class='bg-success'><div class='alert alert-danger' role='alert' style='margin:8% auto;'>
            <h3><center>Session Destroyed... <br> Redirecting in 3</center></h3>
          </div></body>";
    echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
}

//echo "HANDLE THIS PAGE";
