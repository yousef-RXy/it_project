<?php require_once('config.php') ?>
<!-- Search PHP code -->

<!-- Search bar -->
<?php
function getId($title)
{
  global $conn;
  $title = strtolower($title);
  $sql = "SELECT id FROM movie WHERE name='$title'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  return $row['id'] ?? 0;
}
$id = 0;
$idError = '';
function filterTitleAndHandleId(){
  global $id ,$idError;
  $title = filter_input(
    INPUT_GET,
    'search',
    FILTER_SANITIZE_FULL_SPECIAL_CHARS
  );
  $id = getId($title);
  $idError;
  if($id) {
    header("location: view.php?id=$id");
  }else{
    
    $idError = "<p style='font-size: 18px;font-weight:bold;margin:15px 0;color:red;'>There is no movie or series with title $title</p>";
  }
}

if (isset($_GET["submit"])) {
  filterTitleAndHandleId();
}
?>





<!-- Get Movies For Slider -->
<?php
function getSliderMoviesAndSeries($limit = "", $where = '')
{
  global $conn;
  $sql = "SELECT * FROM movie $where ORDER BY id DESC $limit";
  $result = mysqli_query($conn, $sql);
  return  mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$mostRecent = getSliderMoviesAndSeries("LIMIT 10");
$movies = getSliderMoviesAndSeries("", "WHERE movie=1");
$series = getSliderMoviesAndSeries(" ", "WHERE movie=0");
// print_r($sliderMovies);
?>








<!-- Render Most Recent Slider -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>home</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/styleys.css">
</head>

<body>
  <?php include "./inc/header.php" ?>

  <main class="home">
    <div class="search">
      <div class="container">
        <?= $idError ?? NULL ?>
        <form class="search-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
          <input name="search" type="text" name="title" id="title" placeholder="Enter movie title">
          <button type="submit" name="submit">
            Search
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="20" stroke-width="52" d="M338.29 338.29L448 448" />
            </svg>
          </button>
        </form>
      </div>
    </div>
    <div class="slider">
      <div class="container">
        <h2>Most Recent</h2>
        <div class="slider-container">
          <?php foreach ($mostRecent as $item) : ?>
            <a href="./view.php?id=<?= $item['id'] ?>" class="slider-item">
              <div class="img">
                <img src="<?= $item['photo_path'] ?>" alt="<?= $item['name'] ?>">
              </div>
              <h4><?= $item['name'] ?></h4>
              <div class="rating">
                <?= $item['rating'] ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
        <div class="controls">
          <div class="left">
            <ion-icon class="disabled" data-dir="left" name="arrow-dropleft-circle"></ion-icon>
          </div>
          <div class="right">
            <ion-icon data-dir="right" name="arrow-dropright-circle"></ion-icon>
          </div>
        </div>
      </div>
    </div>

  </main>
  <section class="moviesAndSeries">
    <div class="slider">
      <div class="container">
        <h2>Movies</h2>
        <div class="slider-container">
          <?php foreach ($movies as $item) : ?>
            <a href="./view.php?id=<?= $item['id'] ?>" class="slider-item">
              <div class="img">
                <img src="<?= $item['photo_path'] ?>" alt="<?= $item['name'] ?>">
              </div>
              <h4><?= $item['name'] ?></h4>
              <div class="rating">
                <?= $item['rating'] ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
        <div class="controls">
          <div class="left">
            <ion-icon class="disabled" data-dir="left" name="arrow-dropleft-circle"></ion-icon>
          </div>
          <div class="right">
            <ion-icon data-dir="right" name="arrow-dropright-circle"></ion-icon>
          </div>
        </div>
      </div>
    </div>
    <br><br>
    <div class="slider">
      <div class="container">
        <h2>Series</h2>
        <div class="slider-container">
          <?php foreach ($series as $item) : ?>
            <a href="./view.php?id=<?= $item['id'] ?>" class="slider-item">
              <div class="img">
                <img src="<?= $item['photo_path'] ?>" alt="<?= $item['name'] ?>">
              </div>
              <h4><?= $item['name'] ?></h4>
              <div class="rating">
                <?= $item['rating'] ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
        <div class="controls">
          <div class="left">
            <ion-icon class="disabled" data-dir="left" name="arrow-dropleft-circle"></ion-icon>
          </div>
          <div class="right">
            <ion-icon data-dir="right" name="arrow-dropright-circle"></ion-icon>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include "./inc/footer.php" ?>
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <script src="./scripts/main.js"></script>
</body>
</html>