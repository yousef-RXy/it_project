<?php require_once('config.php') ?>
<?php $page_title = 'Update an user password'; ?>
<?php $page_heading = 'User password Updating'; ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title><?php echo $page_title; ?></title>

</head>

<body>
  <h1> <?php echo $page_heading; ?> </h1>
  <p> <a href="index.php">Go back to the homepage</a> </p>

  <?php
  $id=$_COOKIE['id'];

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
        message("Your password had updated succesfully", "green");
      }else {
        message("Your new password didn't match the confirm password", "red");
      }
    }else{
      message("Your your old password is not correct", "red");
    }
  }
?>

  <form action="" method="POST">
    <label for="oldpassword">Old Password</label>
    <input type="password" name="oldpassword" required>
    <br><br>
    <label for="password">New Password</label>
    <input type="password" name="password" required>
    <br><br>
    <label for="confirm">Confirm Password</label>
    <input type="password" name="confirm" required>
    <br><br>
    <input type="submit" name="submit" value="Save your password">
  </form>

</body>

</html>