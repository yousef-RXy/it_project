<?php require_once('config.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<?php
  $id=$_GET['id'];
  $sql="SELECT * FROM `episodes` WHERE id=$id";
  $statement=$connection->prepare($sql);
  $statement->execute();
  $data=$statement->fetchAll();
?>
<body>
  <table>
    <tr>
      <th>
        images
      </th>
      <th>
        name
      </th>
    </tr>
      <?php foreach($data as $value):?>
    <tr>
      <th>
        <img width="150px" src='<?php echo $data[$id-1]["path"]; ?>'alt='<?php echo $data[$id-1]["path"]; ?>'>
      </th>
      <th>
      <?php echo $value['name']?>
      </th>
    </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
