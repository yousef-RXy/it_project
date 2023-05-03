<?php require_once('config.php') ?>

<?php
function selectQuestions(){
  global $conn;
  $sql = "SELECT * FROM faq ORDER BY id DESC";
  return mysqli_query($conn , $sql);
}
$result = selectQuestions()
?>

<html lang="en">
<head>
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/styleya.css">

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQs</title>
</head>
<body>
  <?php include "./inc/header.php" ?>
  
  <table class="adminfaq">
    <caption class="admin-caption"><h3>user's questions</h3></caption>
    <thead>
      <tr>
        <th>Question</th>
        <th>Answer</th>
      </tr>
    </thead>
    <tbody>
      <?php
        function checkAnswerQuestions(){
          global $conn, $result;
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              if($row["ans"] == null){
                $id = $row['id'];
                $q = $row['q'];
                echo("
                  <tr>
                    <td>$q</td>
                    <td><form action='FAQadmin.php' method='post'>
                      <textarea name='ans' id='ans' cols='30' rows='5' placeholder='entre your answer here...'></textarea><br>
                      <button name='add_answer' value='$q'>submit</button>
                    </form></td>
                  <tr>
                ");
          }}}
          if (isset($_POST['add_answer'])) {
            if(empty($_POST['ans'])){
              echo '<div style = "color: red;
                                  text-align: center;
                                  width: fit-content;
                                  margin: auto;
                                  margin-top: 50px;
                                  font-size: xx-large;">please add an answer</div>';
            }
            else{
              $ans = $_POST["ans"];
              $q = $_POST["add_answer"];
              $sql = "UPDATE faq SET ans='$ans' WHERE q='$q'";
              mysqli_query($conn , $sql);
              header("Location: ./FAQadmin.php");
              exit();
            }
          }
        }
        checkAnswerQuestions();
      ?>
    </tbody>
  </table>

  <?php include "./inc/footer.php" ?>
</body>
</html>

