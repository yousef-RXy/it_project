<?php require_once('config.php');
      include "./inc/header.php";
?>
<?php
  if (isset($_POST['add_question'])) {
    if(empty($_POST['question'])){
      echo '<div style = "color: red;
      text-align: center;
      width: fit-content;
      margin: auto;
      margin-top: 50px;
      font-size: xx-large;">please add the question</div>';
    }
    else {
      $question = $_POST["question"];
      $sql = "INSERT INTO faq (q) VALUE ('$question')";
      mysqli_query($conn , $sql);
      header("Location: ./FAQuser.php");
      exit();
    }
  }
  $sql = "SELECT * FROM faq ORDER BY id DESC";
  $result = mysqli_query($conn , $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FAQs</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/styleya.css">
</head>
<body>

  <div class="container">
    <h2>FAQs</h2>
    <form action="FAQuser.php" method="post">
      <p class="ask">Do you have any questions ?</p>
      <input type="text" name="question" placeholder="entre your question here" class="question">
      <br>
      <input type="submit" name="add_question" value="add question" class="submit">
    </form>
  </div>
  <hr class="hr">
  <table class="userfaq">
    <caption class="user-caption">FAQs</caption>
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

  <?php include "./inc/footer.php" ?>
</body>
</html>

