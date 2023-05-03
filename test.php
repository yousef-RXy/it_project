<?php 
require_once './config.php';

function getRate(){
  global $conn;
  $id=$_GET['id'];
  $sql = "SELECT * FROM movie WHERE id=$id";
  return  $conn->query($sql);
}
function updateRate($Result,$new_num,$id){
  global $conn;
  $conn->query("UPDATE movie SET rating=$Result , rating_times=$new_num  WHERE id=$id");
    header("Location: ./view.php?id=$id");
}
$result = getRate();
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $rate = $row["rating"];
  $num = $row ["rating_times"] ;
  $title = $row["name"];
  $descraption = $row ["description"] ;
  $date= $row ["date"];
  $poster = $row["photo_path"];
  $Trailer = $row ["trailer_path"] ;
  $movie = $row["movie"];
} else {
  echo "0 results";
}
if(isset($_POST['rate'])) {
  if (empty($_POST['num'])) {
    echo "the rating is empty";
    $Result=$rate;
  } else {
    $Result = ($_POST['num'] + ($rate*$num))/($num+1);
    $new_num = $num + 1;
    updateRate($Result,$new_num,$id);
    exit();
  }
}
else {
  $Result=$rate;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Movie Title</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/Styleym.css">
</head>
<body>
<?php include "./inc/header.php" ?>

<h2>
  <?php echo $title ?>
  </h2>
  <div class="rate">
  <p>rating: <span>  
  <?php
  echo number_format($Result,1) ;
  ?></span> </p>
  </div>
  <main>
  <div class="Movie-Poster">
    <img src='<?php echo $poster ?>' alt="Movie Poster" class="img">
    <div id="movie-details">
    <h1>description</h1>
    <p> <?php echo $descraption ?></p>
    <form method="POST">
    rating
    <input type="number" min="0" max="10" step=".5" name="num" > <br> <br>
    <input type="submit" value="rate" name ="rate" > 
    </form> <br>
    <p>date: <span><?php echo $date ?></span> </p> 
      <div>
        <p><span><a href="./cast.php?id=<?php echo $id; ?>">cast</a></span></p>
        <p><span><a href="./photos.php?id=<?php echo $id; ?>">photos</a></span></p>
        <p><span><a href="./comment.php?id=<?php echo $id; ?>">comment</a></span></p>
      </div>
      <p><span><?php 
        if (!$movie) {
          echo " 
                <a href='./episodes.php?id=$id'>episodes</a>
                <br>";
        }
  ?></span></p>
  </div>
  </div>  
  <div class="trailer">
    <video controls src="<?php echo $Trailer?>"></video>
  </div> 

</main>



  <?php include "./inc/footer.php" ?>
</body>
</html>

