<?php require_once('config.php') ?>
<?php $page_title = 'photos'; ?>
<?php $page_heading = 'photos'; ?>

<!DOCTYPE html>
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
  <?php
    $id = $_GET["id"];
    $sql = "SELECT * FROM photos WHERE id=$id";
    $statement =  $connection->prepare($sql);
    $statement-> execute();
    $photo =  $statement-> fetchAll();
    for ($x = 0; $x <= sizeof($photo)-3; $x+=3):
  ?>
    <table style="width:100%;background:#eee;text-align:center">
        <tr>
          <th><img width="150px" src='<?php echo $photo[$x]["path"]; ?>'alt='<?php echo $photo[$x]["path"]; ?>'></th>
          <th><img width="150px" src='<?php echo $photo[$x+1]["path"]; ?>'alt='<?php echo $photo[$x+1]["path"]; ?>'></th>
          <th><img width="150px" src='<?php echo $photo[$x+2]["path"]; ?>'alt='<?php echo $photo[$x+1]["path"]; ?>'></th>
        </tr>
        <?php endfor; ?>
    </table>
</body>
</html>