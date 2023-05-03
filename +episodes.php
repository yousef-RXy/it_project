<?php require_once('config.php')?>
<?php
  function episod(){
    global $photo_ext,$conn;
    if (empty($_FILES["file"]['name'])) {
      echo "the photo is empty";
    } else {
      if (empty($_POST["title"])) {
        echo "the name is empty";
      } else {
        $id = $_GET["id"];
        $file_name=$_FILES['file']['name'];
        $ep_name = $_POST["title"];
        $file_ex = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (in_array($file_ex, $photo_ext)) {
          $file_name = uniqid("ep-", true).'.'.$file_ex;
          if (!file_exists("./uploads/episodes/$id")) {
            mkdir("./uploads/episodes/$id", 0777, true);
          }
          $dest = "./uploads/episodes/$id/".$file_name;
          move_uploaded_file($_FILES['file']['tmp_name'], $dest);
          $conn->query("INSERT INTO episodes (id, name, path) VALUES ('$id','$ep_name','$dest')");
        }
      }
    }
  }
  if (isset($_POST['submit'])) {
    episod();
  }
?>
<html>
  <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styleye.css">
  <link rel="stylesheet" href="css/header.css">
  </head>
  
  <?php include "./inc/header.php" ?>

  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" class="file" value="" >
    <input type="text" name="title" class="title" >
    <input type="submit" name="submit" class="submit" value="Upload" >
  </form>
  <?php include "./inc/footer.php" ?>


</html>