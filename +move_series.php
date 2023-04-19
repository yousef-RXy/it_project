<?php require_once('config.php') ?>
<?php $page_title = 'add movie/series'; ?>
<?php $page_heading = 'add movie/series'; ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>
</head>
<body>
  <h1> <?php echo $page_heading; ?> </h1>
  <p> <a href="index.php">Go back to the homepage</a> </p>
  <form action="" method="POST" enctype="multipart/form-data">
    <br><label for="title">title</label>
    <input type="text" name="title" required>
    <br><label for="description">description</label>
    <input type="text" name="description" required>
    <br><label for="director">director</label>
    <input type="text" name="director" required>
    <br><label for="poster">poster</label>
    <input type="file" name="poster" value="" required>
    <br><label for="trailer">trailer</label>
    <input type="file" name="trailer" value="" required>
    <br><label for="trailer">photos</label>
    <input type="file" name="photos[]" value="" multiple required>
    <br>Type:  
    <label for="movie">movie</label>
    <input type="radio" id="movie" name="type" value=1 required>
    <label for="series">series</label>
    <input type="radio" id="series" name="type" value=0 required>
    <br><br><input type="submit" name="submit" value="Upload">
  </form>
</body>
</html>

<?php
  if (isset($_POST['submit'])) {
    $poster_ext=strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
    $trailer_ext=strtolower(pathinfo($_FILES['trailer']['name'], PATHINFO_EXTENSION));
    if (in_array($poster_ext, $photo_ext) && in_array($trailer_ext, $video_ext)) {
      $new   = array('name' => $_POST['title'], 'description' => $_POST['description'], 'Director' => $_POST['director']);
      $keys_string = implode(', ', array_keys($new));
      $keys_placeholder = ':' . implode(', :', array_keys($new));
      $sql = (sprintf("INSERT INTO movie (%s) VALUES (%s)", $keys_string, $keys_placeholder));
      $connection->prepare($sql)->execute($new);
      $name=$_POST['title'];
      $description=$_POST['description'];
      set_image('movie',0,'poster',$name,$description);
      set_video($name, $description, 'trailer');
      $sql = "SELECT id FROM movie WHERE name='$name' AND description='$description'";
      $statement =  $connection->prepare($sql);
      $statement-> execute();
      $id =$statement-> fetch()['id'];
      set_image('photos', 1, 'photos');
      if (!$_POST['type']) {
        $sql = "UPDATE movie SET movie=0 WHERE name='$name' AND description='$description'";
        $connection->prepare($sql)->execute();
      }
    }
  }
?>