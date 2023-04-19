<?php require_once('config.php')?>
<?php
  if (isset($_POST['submit'])) {
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
      $mysqli = new mysqli($hostname, $dbuser, $dbuserpassword, $dbname);
      $mysqli->query("INSERT INTO episodes (id, name, path) VALUES ($id,'$ep_name','$dest')");
    }
  }
?>
<html>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" value="" required>
    <input type="text" name="title" required>
    <input type="submit" name="submit" value="Upload" required>
  </form>

</html>