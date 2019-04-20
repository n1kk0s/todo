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
      $sql = "SELECT title FROM task WHERE userID='{$_SESSION[user]}'";
      $result = mysqli_query($conn, $sql);

      if ($result->mysqli_num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['title']."</td></tr>";
        }
      } else {
        echo "You don't have any tasks yet!";
      }
    ?>
</body>
</html>
