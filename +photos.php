<?php
  require_once('config.php');
  $id = $_GET["id"];
  $sql = "SELECT * FROM movie WHERE id=$id";
  $result = $conn->query($sql)->fetch_assoc();
  $title = $result["name"];
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="./css/stylejn.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
  <title><?php echo 'Add photo to ' . $title ?></title>
</head>

<body class="body_form">
  <?php include "./inc/header.php" ?>

  <form class="form" action="" method="POST" enctype="multipart/form-data">
    <div class="title">Add photo to<span class="film-name"><?php echo $title ?></span></div>
    
    <div class="file">
      <span class="material-symbols-outlined"> upload </span>
      <label class="file__lable" for="photos">Add photos</label>
      <input class="file__input" type="file" name="photos[]" value="" multiple required/>
    </div>

    <input class="submit" type="submit" name="submit" value="Upload">
  </form>

  <?php include "./inc/footer.php" ?>
</body>
</html>

<?php
  if (isset($_POST['submit'])) {
    set_image('photos', 1, 'photos',$id);
    header("Location: ./photos.php?id=$id");
    exit();
  }
?>