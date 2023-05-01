<?php require_once('config.php') ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="./css/stylejn.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
  <title>add movie/series</title>
</head>

<body>
  <?php include "./inc/header.php" ?>

  <?php
    if (isset($_POST['submit'])) {
      $poster_ext=strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
      $trailer_ext=strtolower(pathinfo($_FILES['trailer']['name'], PATHINFO_EXTENSION));
      if (in_array($poster_ext, $photo_ext) && in_array($trailer_ext, $video_ext)) {
        $new = array('name' => $_POST['title'], 'description' => $_POST['description'], 'date' => $_POST['date']);
        $keys_string = implode(', ', array_keys($new));
        $keys_placeholder = ':' . implode(', :', array_keys($new));
        $sql = (sprintf("INSERT INTO movie (%s) VALUES (%s)", $keys_string, $keys_placeholder));
        $connection->prepare($sql)->execute($new);
        $name=$_POST['title'];
        $date=$_POST['date'];
        $sql = "SELECT id FROM movie WHERE name='$name' AND date='$date'";
        $statement =  $connection->prepare($sql);
        $statement-> execute();
        $id =$statement-> fetch()["id"];
        set_image('movie',0,'poster',$id);
        set_video($id, 'trailer');
        set_image('photos', 1, 'photos',$id);
        if (!$_POST['type']) {
          $sql = "UPDATE movie SET movie=0 WHERE id=$id";
          $connection->prepare($sql)->execute();
        }
        header("Location: ./view.php?id=$id");
        exit();
      }
      else {
        message("the extention of the poster/trailer is not valid", "red");
      }
    }
  ?>

  <form class="form" action="" method="POST" enctype="multipart/form-data">
    <div class="title">Add Movie/series</div>

    <div style="margin-top: 40px" class="input-container" >
      <input name="title" class="input" type="text" placeholder=" " required/>
      <div style="width: 43px" class="cut"></div>
      <label for="title" class="placeholder">title</label>
    </div>

    <div class="input-container">
      <input name="description" class="input" type="text" placeholder=" " required/>
      <div style="width: 90px" class="cut"></div>
      <label for="description" class="placeholder">description</label>
    </div>
    
    <div class="input-container">
      <input name="date" class="input" type="date" placeholder=" " required/>
      <div style="width: 49px" class="cut_f"></div>
      <label for="date" class="placeholder_f">date</label>
    </div>
    
    <div class="file">
      <span class="material-symbols-outlined"> upload </span>
      <label class="file__lable" for="trailer">Add poster</label>
      <input class="file__input" type="file" name="poster" value="" required/>
    </div>
    
    <div class="file">
      <span class="material-symbols-outlined"> upload </span>
      <label class="file__lable" for="trailer">Add trailer</label>
      <input class="file__input" type="file" name="trailer" value="" required/>
    </div>
    
    <div class="file">
      <span class="material-symbols-outlined"> upload </span>
      <label class="file__lable" for="photos">Add photos</label>
      <input class="file__input" type="file" name="photos[]" value="" multiple/>
    </div>
    
    <div class="radio">
      <input class="radio__input" type="radio" id="movie" name="type" value="1" required />
      <label class="radio__lable" for="movie" >movie</label>
      <input class="radio__input" type="radio" id="series" name="type" value="0" required />
      <label class="radio__lable" for="series" >series</label >
    </div>

    <input class="submit" type="submit" name="submit" value="Upload">
  </form>

  <?php include "./inc/footer.php" ?>
</body>
</html>
