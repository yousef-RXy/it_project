<?php 
  require_once('config.php');
  $id_user=$_SESSION["id"];
  $sql = "SELECT admin FROM users WHERE id=$id_user";
  $result_user = $conn->query($sql)->fetch_assoc();
  $isAdmin = $result_user["admin"];
?>

<header>
    <div class="containeer">
      <div class="logo">
      <a href="./home.php">
          Movies<br><span>&</span><span>Series</span>
      </a>
      </div>
      <nav>
      <ul>
        <li>
          <a href="./home.php">Home</a>
        </li>
        <li>
          <a href="./FAQuser.php">FAQuser</a>
        </li>
        <?php if ($isAdmin) : ?>
          <li>
            <a href="./+move_series.php">+move_series</a>
          </li>
          <li>
            <a href="./FAQadmin.php">FAQadmin</a>
          </li>
        <?php endif; ?>
        <li>
          <a href="./data.php">profile</a>
        </li>
        <li>
          <a href="./password.php">password</a>
        </li>
        <li class="logout">
          <a href="./logout.php">
            Logout
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
            </svg>
          </a>
        </li>
    </ul>
  </nav>
</div>
</header>