<!DOCTYPE html>
<html>
<head>
  <title>To Do</title>
  <link rel='stylesheet' type='text/css' href="styles.css">
  <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico'/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <?php
  session_start();
  include('connect.php');

  if(is_null($_SESSION['user'])) { // If session variable isn't set, automatically go to index
    header("Location: https://todo.nickweld.com");
  }

  if(isset($_GET['newTask'])) { // Creates new task, sets notification, and reloads page
    $task = $_GET['task'];
    $user = $_SESSION['user'];
    $sql = "INSERT INTO task (userID, title) VALUES ('{$user}', '{$task}')";
    $result = mysqli_query($conn, $sql);
    unset($_SESSION['notification']);
    header("Location: https://todo.nickweld.com/list.php");
  }

  if(isset($_GET['delete'])) { // Deletes task, sets notification, and reloads page
    $task = $_GET['taskID'];
    $sql = "DELETE FROM task WHERE taskID='{$task}'";
    $result = mysqli_query($conn, $sql);
    if($result) {
      $_SESSION['notification'] = "<p class='notification'>Task deleted</p>";
      header("Location: https://todo.nickweld.com/list.php");
    } else {
      $_SESSION['notification'] = "<p class='notification'>Your task couldn't be deleted</p>";
      header("Location: https://todo.nickweld.com/list.php");
    }
  }

  if(isset($_GET['exit'])) { // Allows for logging out and ending the session
    session_destroy();
    header("Location: https://todo.nickweld.com");
  }
  ?>

  <h1 class='title'>To-Do's</h1>

  <?php if(!empty($_SESSION['notification'])) {echo $_SESSION['notification']; }?>

  <form action='https://todo.nickweld.com/list.php' method='get'>
    <input class='field' type=text name='task' placeholder='New task' required>
    <input class='submit' type=submit name='newTask' value='CREATE'>
  </form>

  <table>
    <?php // Section builds table with data from the database
      $user = $_SESSION['user'];
      $sql = "SELECT taskID, title FROM task WHERE userID='{$user}'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['title']."</td><td><form acion='https://todo.nickweld.com/list.php' method='get'><input type='hidden' name='taskID' value='".$row['taskID']."'><input class='check' type='submit' name='delete' value='DELETE'></form></td></tr>";
        }
      } else {
        echo "<p class='notification'>You don't have any tasks yet!</p>";
      }
    ?>
  </table>
  <footer>
    <form action='list.php' method='get'>
      <input class='submit' type=submit name='exit' value='LOG OUT'>
    </form>
    <p>todo.nickweld.com</p>
  </footer>
</body>
</html>
