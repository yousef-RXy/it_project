<?php 
require_once './config.php';
$id=$_GET['id'];
?>
<html lang="en">
  <head>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style_com.css">
</head>
<body>
  <?php include "./inc/header.php" ?>

  <div class="comments">
    <?php
      $sql = "SELECT * FROM comments_table WHERE id=$id";
      $result = $conn -> query($sql);
      while($row = $result-> fetch_assoc()) {
      echo "<h2>". $row['name']."</h2>";
      echo "<h5>".$row['comment'] . "</h5>" ."<br>" . "<hr>"."<br><br>" ;
      } 
      set_comment("comment",$id)
    ?>
    <br>
  </div>
  
</body>
</html>