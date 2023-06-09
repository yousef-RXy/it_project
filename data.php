<?php require_once('config.php') ?>

<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Update profile</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="./css/stylejn.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>

<body>
<?php include "./inc/header.php" ?>

  <?php
    $id=$_SESSION["id"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $statement =  $connection->prepare($sql);
    $statement-> execute();
    $user =  $statement-> fetch();
    $userset = array('id'=> $id, 'username' => $user['username'], 'email' => $user['email']);
    if (isset($_POST['submit'])) {      
      updateuserdata();
    }
  ?>

  <form action="" method="POST" class="form">
    <div class="title">Update profile</div>
    <div class="input-container">
      <input type="text" class="input" name="username" value="<?php echo $userset["username"] ?>">
      <div style="width: 86px" class="cut_f"></div>
      <label for="username" class="placeholder_f">Username</label>
    </div>
    <div class="input-container">
      <input type="text" class="input" name="email" value="<?php echo $userset["email"]; ?>">
      <div style="width: 57px" class="cut_f"></div>
      <label for="email" class="placeholder_f">  Email</label>
    </div>
    <input class="submit" type="submit" name="submit" value="Save your data">
  </form>

  <?php include "./inc/footer.php" ?>
</body>

</html>