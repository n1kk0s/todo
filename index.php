<?php

// Starts session aLnd forms connection
session_start();

include('connect.php');

if(isset($_GET['login'])) {
  $user = $_GET['userID'];
  $password = $_GET['password'];
  $sql = "SELECT * FROM user WHERE userID='{$user}' AND password='{$password}'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result)>0) { // If login is successful
    $_SESSION['user'] = $_GET['userID'];
    header("Location: https://todo.nickweld.com/list.php");
  } else { // If login isn't successful
    header("Location: https://todo.nickweld.com");
    $_SESSION['notification'] = "<p class='notification'>User ID or password was incorrect</p>";
  }
}

if(isset($_GET['create'])) {
  $sql = "SELECT * FROM user WHERE userID='{$_GET['newUser']}'"; // Check for existing user ID
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) > 0) { // If one already exists, don't create account
    $_SESSION['notification'] = "<p class='notification'>That user ID already exists</p>";
    header("Location: https://todo.nickweld.com");
  } else { // If one doesn't exist, create it, set session variable, and redirect to list
    $newUser = $_GET['newUser'];
    $newPassword = $_GET['newPassword'];
    $sql = "INSERT INTO user (userID, password) VALUES ('{$newUser}', '{$newPassword}')";
    $result = mysqli_query($conn, $sql);
    echo $result;
    if($result) { // If successful, go to list
      $_SESSION['user'] = $_GET['newUser'];
      header("Location: https://todo.nickweld.com/list.php");
    } else { // If not, set notification and reload
      $_SESSION['notification'] = "<p class='notification'>Something went wrong creating your account</p>";
      header("Location: https://todo.nickweld.com");
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>To Do</title>
  <link rel='stylesheet' type='text/css' href="styles.css">
  <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico'/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <h1 class='title'>To Do List</h1>

  <?php
  if(isset($_SESSION['notification'])) {echo $_SESSION['notification'];}
  ?>

  <form action='index.php' method='get'>
    <label class='label' for=userID>User ID:</label>
    <input class='field' type=text name=userID placeholder="Username" required><br>
    <label class='label' for=password>Password:</label>
    <input class='field' type=password name=password placeholder="Password" required></br>
    <input class='submit' type=submit name='login' value='LOGIN'>
  </form>
  <h1 class='subtitle'>No account?</h1>
  <form action='index.php' method='get'>
    <label class='label' for='newUser'>User ID:</label>
    <input class='field' type='text' name='newUser' placeholder="Username" required><br>
    <label class='label' for='newPassword'>Password:</label>
    <input class='field' type='password' name='newPassword' placeholder="Password" required></br>
    <input class='submit' type='submit' name='create' value='CREATE'>
  </form>
  <footer>
    <p>todo.nickweld.com</p>
  </footer>
</body>
</html>
