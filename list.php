<html>
<head></head>
<body>

  <?php
  include('connect.php')
  ?>

  <h1>Here's what to do</h1>
  <!-- Add "form" for new item here -->
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
</body>
</html>
