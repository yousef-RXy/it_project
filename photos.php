<?php require_once('config.php') ?>
<?php
  $id = $_GET["id"];
  $sql = "SELECT * FROM photos WHERE id=$id";
  $statement =  $connection->prepare($sql);
  $statement-> execute();
  $photo =  $statement-> fetchAll();
  $sql = "SELECT * FROM movie WHERE id=$id";
  $result = $conn->query($sql)->fetch_assoc();
  $title = $result["name"];
  $page_title = $title.' photos';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="./css/stylejn.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <title><?php echo $page_title; ?></title>
</head>
<body>
  <?php include "./inc/header.php" ?>
  <div class="background"></div>
  <div class="container">
    <div class="box">
      <div class="header">
        <h1> <a href="./view.php?id=<?php echo $id?>"> <?php echo $page_title?> </a> </h1>
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
            header("Location: ./+photos.php?id=$id");
            exit();
          }
        ?>
      </div>
      <div class="photos">
        <?php
          for ($x = 0; $x <= sizeof($photo)-1; $x++){
            $photo_cu = $photo[$x]["path"];
            echo "<img src=$photo_cu style='width: 100%'/>";
          }
        ?>
      </div>
    </div>
  </div>

  <?php include "./inc/footer.php" ?>
</body>
</html>