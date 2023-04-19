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
  $sql="SELECT * FROM `cast` WHERE id=$id";
  $statement=$connection->prepare($sql);
  $statement->execute();
  $data=$statement->fetchAll();
?>
<body>
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
</body>
</html>
