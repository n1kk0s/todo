<html>
<head></head>
<body>

  <?php
  include('connect.php')

  // if(is_null($_SESSION['user'])) { // If session variable isn't set, automatically go to index
  //   header("Location: https://todo.nickweld.com");
  // }

  if(isset($_GET['newTask'])) {
    $task = $_GET['task'];
    $user = $_SESSION['user'];
    $sql = "INSERT INTO task (userID, title) VALUES ('{$user}', '{$task}')";
    $result = mysqli_query($conn, $sql);
    header("Location: https://todo.nickweld.com/list.php");
  }
  ?>

  <h1>Here's what to do</h1>
  <!-- Add "form" for new item here -->
  <form action='list.php' method='get'>
    <input type='text' name='task' placeholder='New task'>
    <input typte='submit' name='newTask' value='CREATE'>
  </form>

  <table>
    <?php
      $user = $_SESSION['user'];
      $sql = "SELECT title FROM task WHERE userID='{$user}'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['title']."</td></tr>";
        }
      } else {
        echo "You don't have any tasks yet!";
      }
    ?>
  </table>
</body>
</html>
