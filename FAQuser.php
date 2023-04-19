<?php require_once('config.php') ?>
<?php
  if (isset($_POST['add-question'])) {
    $question = $_POST["question"];
    $sql = "INSERT INTO faq (q) VALUE ('$question')";
    mysqli_query($conn , $sql);
    header("Location: ./FAQuser.php");
    exit();
  }
  $sql = "SELECT * FROM faq ORDER BY id DESC";
  $result = mysqli_query($conn , $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FAQs</title>
</head>
<body>
  <h3>FAQs</h3>
  <form action="FAQuser.php" method="post">
    Do you have any questions ?<br>
    <input type="text" name="question" placeholder="entre your question here" >
    <br>
    <input type="submit" name="add-question" value="add question">
  </form>
  <hr>
  <table>
    <caption>FAQs</caption>
    <thead>
      <tr>
      <th>Question</th>
      <th>Answer</th>
      </tr>
    </thead>
    <tbody>
      <?php
        if(mysqli_num_rows($result) > 0):
          while($row = mysqli_fetch_assoc($result)):
            if($row["ans"]):
      ?>
      <tr>
      <td><?php echo $row["q"];?></td>
      <td><?php echo $row["ans"];?></td>
      </tr>
      <?php 
            endif;
          endwhile;
        endif;
      ?>
    </tbody>
  </table>
</body>
</html>

