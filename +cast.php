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
  <link rel="stylesheet" href="style.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
  <title><?php echo 'Add cast to ' . $title ?></title>
</head>

<body class="body_form">
  <form class="form" action="" method="POST" enctype="multipart/form-data">
    <div class="title">Add cast to<span class="film-name"><?php echo $title ?></span></div>

    <div style="margin-top: 40px" class="input-container" >
      <input name="name" class="input" type="text" placeholder=" " required/>
      <div style="width: 43px" class="cut"></div>
      <label for="name" class="placeholder">name</label>
    </div>

    <div class="input-container">
      <input name="role" class="input" type="text" placeholder=" " required/>
      <div style="width: 90px" class="cut"></div>
      <label for="role" class="placeholder">role</label>
    </div>

    <input class="submit" type="submit" name="submit" value="Upload">
  </form>
</body>
</html>

<?php
  if (isset($_POST['submit'])) {
    $new = array('id'=>$id, 'name' => $_POST['name'], 'role' => $_POST['role']);
    $keys_string = implode(', ', array_keys($new));
    $keys_placeholder = ':' . implode(', :', array_keys($new));
    $sql = (sprintf("INSERT INTO cast (%s) VALUES (%s)", $keys_string, $keys_placeholder));
    $connection->prepare($sql)->execute($new);
    header("Location: ./cast.php?id=$id");
    exit();
  }
?>