<?php 
require_once './config.php';
// $(".myform")[0].reset();
$id=$_GET['id'];
$sql = "SELECT * FROM movie WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$rate = $row["rating"];
$num = $row ["rating_times"] ;
$title = $row["name"];
$descraption = $row ["description"] ;
$date= $row ["Director"];
$poster = $row["photo_path"];
$Trailer = $row ["trailer_path"] ;
} else {
echo "0 results";
}
if(isset($_POST['rate'])) {
  $Result = number_format(($_POST['num'] + ($rate*$num))/($num+1),1);
  $new_num = $num + 1;
  $conn->query("UPDATE movie SET rating=$Result , rating_times=$new_num  WHERE id=$id");
  header("Location: ./view.php?id=$id");
  exit();
}
else {
  $Result=$rate;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Movie Title</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }

    header {
      background-color: #fff;
      border-bottom: 1px solid #ddd;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #logo {
      font-size: 28px;
      font-weight: bold;
      color: #000;
    }

    main {
      width: 90%;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-top: 40px;
    }

    #movie-details {
      width: 60%;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    #movie-details img {
      width: 100%;
      height: auto;
    }

    #movie-details h1 {
      font-size: 36px;
      color: #000;
      margin-top: 0;
    }

    #movie-details p {
      font-size: 18px;
      color: #555;
      margin: 10px 0;
    }

    #movie-details p span {
      font-weight: bold;
    }
    main img {
      width: 400px;
      height: 470px;
    }

    .trailer h2 {
      font-size: 28px;
      font-weight: bold;
      color: #000;
    }

    .trailer iframe {
      width: 950px;
      height: 470px;
    }
  </style>
</head>
<body>
  <header>
    <div id="logo"><?php echo $title ?></div>
  </header>
  <main>
    <img src='<?php echo $poster ?>' alt="Movie Poster" class="img"> 
    <div class="trailer">
      <video controls src="<?php echo $Trailer ?>"></video>
    </div>
    <div id="movie-details">
      <h1>descraption</h1>
      <p> <?php echo $descraption ?></p>
      <form method="POST">
        rating
        <input type="number" min="0" max="10" step=".5" name="num" required> <br> <br>
        <input type="submit" value="submit" name="rate">
      </form> <br>

      <p>date: <span><?php echo $date ?></span> </p> 
      <p>rating: <span>
      <?php
        echo $Result;
      ?></span> </p>
    </div>
  </main>
</body>
</html>

