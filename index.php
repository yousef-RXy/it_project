<?php require_once('config.php') ?>
<?php $id =1 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>home</title>
  <style>
    a{
      text-decoration: none;
      color: black;
    }
  </style>
</head>
<body>
  <?php
    if (isset($_POST['submit'])){
      $id = $_POST['number'];
      setcookie("id", $id, time() + 86400 * 30);}
  ?>

  <form action="" method="POST">
    <label for="number">add id:</label>
    <input type="number" name="number" min="1" steb="1" value='<?php echo $id; ?>'>
    <input type="submit" name="submit" value="Save your data">
  </form>

  <a href="./+move_series.php">+move_series</a>
  <br>
  <a href="./cast.php?id=<?php echo $id; ?>">cast</a>
  <br>
  <a href="./data.php">data</a>
  <br>
  <a href="./episodes.php?id=<?php echo $id; ?>">episodes</a>
  <br>
  <a href="./password.php">password</a>
  <br>
  <a href="./photos.php?id=<?php echo $id; ?>">photos</a>
  <br>
  <a href="./set_episodes.php?id=<?php echo $id; ?>">set_episodes</a>
  <br>
  <a href="./view.php?id=<?php echo $id; ?>">view</a>
  <br>
  <?php set_comment()?>
  <br>
</body>
</html>