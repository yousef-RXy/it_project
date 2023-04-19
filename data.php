<?php require_once('config.php') ?>
<?php $page_title = 'Update an user data'; ?>
<?php $page_heading = 'User data Updating'; ?>

<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title><?php echo $page_title; ?></title>

</head>

<body>
  <h1> <?php echo $page_heading; ?> </h1>
  <p> <a href="index.php">Go back to the homepage</a> </p>

  <?php
    $id=$_COOKIE["id"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $statement =  $connection->prepare($sql);
    $statement-> execute();
    $user =  $statement-> fetch();
    $userset = array('id'=> $id, 'username' => $user['username'], 'email' => $user['email']);
    if (isset($_POST['submit'])) {
      updateuserdata();
    }
  ?>

  <form action="" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php echo $userset["username"] ?>" required>
    <br><br>
    <label for="email">  Email</label>
    <input type="email" name="email" value="<?php echo $userset["email"]; ?>" required>
    <br><br>
    <input type="submit" name="submit" value="Save your data">
  </form>

</body>

</html>