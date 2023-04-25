<?php require_once('config.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <title>Document</title>
</head>
<?php
  $id=$_GET['id'];
  $sql="SELECT * FROM `cast` WHERE id=$id";
  $statement=$connection->prepare($sql);
  $statement->execute();
  $data=$statement->fetchAll();
?>
<head>
<link rel="stylesheet" href="css/header.css">
</head>
<body>
  <?php include "./inc/header.php" ?>

  <div class="header">
  <?php 
    $id_user=$_SESSION["id"];
    $sql = "SELECT admin FROM users WHERE id=$id_user";
    $result_user = $conn->query($sql)->fetch_assoc();
    if($result_user["admin"]):
  ?>
  <form method="POST">
    <button name="add">
      <span class="material-symbols-outlined">add</span>
    </button>
  </form>
  <?php
    endif;
    if(isset($_POST["add"])){
      header("Location: ./+cast.php?id=$id");
      exit();
    }
  ?>
  </div>
  <table>
    <tr>
      <th>
        name
      </th>
      <th>
        role
      </th>
    </tr>
    <?php foreach($data as $value):?>
    <tr>
      <th>
        <?php echo $value['name']?>
      </th>
      <th>
        <?php echo $value['role']?>
      </th>
    </tr>
    <?php endforeach?>
  </table>
  
  <?php include "./inc/footer.php" ?>
</body>
</html>
