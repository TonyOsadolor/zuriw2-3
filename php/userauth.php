<?php
session_start();
require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();

    //check if user with this email already exist in the database
    $checkdb = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $checkdb);
    if(mysqli_num_rows($result) > 0){
        echo "This User Already Exists";
        /* echo "<body class='bg-success'><div class='alert alert-danger' role='alert' style='margin:8% auto;'>
                <h3><center>This User Already Exists... <br> Redirecting in 3</center></h3>
              </div></body>"; */
        echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
        return false;
    } else{
        $sql = "INSERT INTO  students (`full_names`, `country`, `email`, `gender`, `password`) 
                VALUES ('$fullnames', '$country', '$email', '$gender', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "User Successfully Registered";
            /* echo "<body class='bg-success'><div class='alert alert-success' role='alert' style='margin:8% auto;'>
                    <h3><center>User Successfully Registered... <br> Redirecting in 3</center></h3>
                  </div></body>"; */
            echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    $conn->close();
}

//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard

    //check if email is registerd in the Database
    $checkdb = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $checkdb);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
            if($row["password"] === $password){
                $_SESSION["email"] = $row["email"];
                $_SESSION["username"] = $row["full_names"];
                header("Location: ../dashboard.php");
            }else{
                echo "Password is Wrong";
                /* echo "<body class='bg-success'><div class='alert alert-danger' role='alert' style='margin:8% auto;'>
                        <h3><center>Password is Wrong... <br> Redirecting in 3</center></h3>
                     </div></body>"; */
                echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
            }
        }
    }else{
        echo "Sorry, No Such User Found";
        /* echo "<body class='bg-success'><div class='alert alert-danger' role='alert' style='margin:8% auto;'>
                <h3><center>Sorry, No Such User Found... <br> Redirecting in 3</center></h3>
              </div></body>"; */
        echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
    }
    $conn->close();
}

function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given

    //check if user with this email already exist in the database
    $checkdb = "SELECT * FROM students WHERE email = '$email'";
    $result = mysqli_query($conn, $checkdb);
    if(mysqli_num_rows($result) > 0){
        $update = "UPDATE students SET password = '$password' WHERE email = '$email'";
        if (mysqli_query($conn, $update)) {
            echo "Password Updated Successfully";
            /* echo "<body class='bg-success'><div class='alert alert-success' role='alert' style='margin:8% auto;'>
                    <h3><center>Password Updated Successfully... <br> Redirecting in 3</center></h3>
                  </div></body>"; */
            echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
        }else{
            echo "Error updating record: " . mysqli_error($conn);
        }
    }else{
        echo "No Such User";
        /* echo "<body class='bg-success'><div class='alert alert-danger' role='alert' style='margin:8% auto;'>
                <h3><center>No Such User... <br> Redirecting in 3</center></h3>
              </div></body>"; */
        echo '<meta http-equiv="refresh" content="3; url=../forms/login.html">';
    }
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] . "</td>
                <td style='width: 150px'>" . $data['email'] . "</td>
                <td style='width: 150px'>" . $data['gender'] . "</td>
                <td style='width: 150px'>" . $data['country'] . "</td>
                <form action='action.php' method='post'> 
                    <input type='hidden' name='id' value='" . $data['id'] . "'>
                    <td style='width: 150px'>
                    <button type='submit' name='delete'> DELETE </button>
                    </td>
                </form>
             </tr>";
        }
        echo "</table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database

     $delete = "DELETE FROM students WHERE id = '$id'";
     if (mysqli_query($conn, $delete)) {
        echo "<script>alert('Record Deleted Successfully')</script>";
        echo '<meta http-equiv="refresh" content="0.5; url=action.php?all=">';
     }else{
        echo "Error deleting record: " . mysqli_error($conn);
    }
 }
