<?php

// Starts session aLnd forms connection
session_start();

include('connect.php');

function authenticate() {
  $sql = "SELECT * FROM user WHERE userID='{$_GET['userID']}' AND password='{$_GET['password']}'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) > 0) { // If login is successful
    $_SESSION['user'] = $_GET['userID'];
    header("Location: https://todo.nickweld.com/list.php");
  } else { // If login isn't successful
    header("Location: https://todo.nickweld.com");
    $_SESSION['notification'] = "User ID or password was incorrect";
  }
}

function create() {
  $sql = "SELECT * FROM user WHERE userID='{$_GET['newUser']}'"; // Check for existing user ID
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) > 0) { // If one already exists, don't create account
    $_SESSION['notification'] = "That user ID already exists";
    header("Location: https://todo.nickweld.com");
  } else { // If one doesn't exist, create it, set session variable, and redirect to list
    $sql = "INSERT INTO user (userID, password) VALUES ('{$_GET['newUser']}', '{$_GET['newPassword']}')";
    $result = mysqli_query($conn, $sql);
    if($result) { // If successful, go to list
      $_SESSION['user'] = $_GET['newUser'];
      header("Location: https://todo.nickweld.com/list.php");
    } else { // If not, set notification and reload
      $_SESSION['notification'] = "Something went wrong creating your account";
      header("Location: https://todo.nickweld.com");
    }
  }
}

?>

<html>
<head></head>
<body>
  <h1>To Do List</h1>

  <?php
  echo $_SESSION['notification'];
  ?>

  <form action='authenticate()' method='get'>
    <label for=userID>User ID:</label>
    <input type=text name=userID><br>
    <label for=password>Password:</label>
    <input type=password name=password></br>
    <input type=submit name='login' value='LOGIN'>
  </form>
  <h1>No account?</h1>
  <form action='create()' method='get'>
    <label for='newUser'>User ID:</label>
    <input type='text' name='newUser'><br>
    <label for='newPassword'>Password:</label>
    <input type='text' name='newPassword'></br>
    <input type='submit' name='create' value='CREATE'>
  </form>
</body>
</html>
