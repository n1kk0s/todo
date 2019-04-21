<html>
<head></head>
<body>

  <?php
  session_start();
  include('connect.php');

  if(is_null($_SESSION['user'])) { // If session variable isn't set, automatically go to index
    header("Location: https://todo.nickweld.com");
  }

  if(isset($_GET['newTask'])) {
    $task = $_GET['task'];
    $user = $_SESSION['user'];
    $sql = "INSERT INTO task (userID, title) VALUES ('{$user}', '{$task}')";
    $result = mysqli_query($conn, $sql);
    header("Location: https://todo.nickweld.com/list.php");
  }

  if(isset($_GET['exit'])) {
    session_destroy();
    header("Location: https://todo.nickweld.com");
  }
  ?>

  <h1>Here's what to do</h1>
  <!-- Add "form" for new item here -->
  <form action='list.php' method='get'>
    <input type=text name='task' placeholder='New task'>
    <input type=submit name='newTask' value='CREATE'>
  </form>

  <table>
    <?php
      $user = $_SESSION['user'];
      $sql = "SELECT title FROM task WHERE userID='{$user}'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['title']."</td><td><input type=submit name='done' value='Done'></td></tr>";
        }
      } else {
        echo "You don't have any tasks yet!";
      }
    ?>
  </table>
  <form action='list.php' method='get'>
    <input type=submit name='exit' value='LOG OUT'>
  </form>
</body>
</html>
