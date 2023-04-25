<?php require_once('config.php') ?>

<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>User password Updating</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="./css/stylejn.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>

<body>
  <?php include "./inc/header.php" ?>

  <?php
  $id=$_SESSION['id'];
  $sql = "SELECT * FROM users WHERE id=:id";
  $statement =  $connection->prepare($sql);
  $statement->bindValue(":id", $id);
  $statement-> execute();
  $user =  $statement-> fetch(PDO::FETCH_ASSOC);
  if (isset($_POST['submit'])){
    if ($user['password'] == $_POST['oldpassword']) {
      if ($_POST['password'] == $_POST['confirm']) {
        $password = $_POST['password'];
        $sql = "UPDATE users SET password=$password WHERE id=$id";
        $statement = $connection->prepare($sql);
        $statement->execute();
        header("Location: ./password.php");
        exit();
      }else {
        message("Your new password didn't match the confirm password", "red");
      }
    }else{
      message("Your your old password is not correct", "red");
    }
  }
  ?>

  <form action="" method="POST" class="form">
    <div class="title">Update user password</div>
    
    <div class="input-container">
      <input type="password" placeholder=" " class="input" name="oldpassword" required>
      <div style="width: 110px" class="cut_f"></div>
      <label for="oldpassword" class="placeholder">Old Password</label>
    </div>
    
    <div class="input-container">
      <input type="password" placeholder=" " class="input" name="password" required>
      <div style="width: 117px" class="cut"></div>
      <label class="placeholder" for="password">New Password</label>
    </div>

    <div class="input-container">
      <input type="password" placeholder=" " class="input" name="confirm" required>
      <div style="width: 137px" class="cut"></div>
      <label for="confirm" class="placeholder">Confirm Password</label>
    </div>
    
    <input type="submit" name="submit" value="Save your password" class="submit">
  </form>

  <?php include "./inc/footer.php" ?>
</body>

</html>