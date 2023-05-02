
<?php
  require_once './config.php';
  $Username = $Password ="";
  $errors = array ("username"=>"","password"=>"");
  if(isset($_POST["log_in"])){
    if(empty($_POST["username"])){
      $errors["username"] = " A username is required."; 
    } else {
      $Username = ($_POST['username']);
      if(!preg_match('/^[a-zA-Z1-9]+$/',$Username)){
        $errors["username"] = "Username must be in letters and numbers only.";
      }
    }
    if(empty($_POST["password"])){
      $errors["password"] = " A password is required. "; 
    } else {
      $Password = htmlspecialchars($_POST['password']);
    }
    if (array_filter($errors)){
    } else{
      $Username = mysqli_real_escape_string($conn,$_POST['username']);
      $Password = mysqli_real_escape_string($conn,$_POST['password']);
      $sql =  "SELECT * FROM `users` WHERE `username` = '$Username' and `password` = '$Password' ";
      $result = mysqli_query($conn,$sql);
      if($result){
        $num = mysqli_num_rows($result);
        $result = $result->fetch_assoc();
        if($num>0){
          echo "Log in successfully";
          session_start();
          $_SESSION["id"] =  $result["id"];
          header('location:home.php');
        } else{
          echo "Incorrect Data!";
      }
    }}}
  if(isset($_POST["signup/register"])){
    header("location: register.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in page</title>
  <link rel="stylesheet" href="css/style1.css">
</head>
<body>
  <div class="first">
  <div class= "title">Welcome to Netfilm.</div>
    <form action="index.php" method="post" >
      <div class = "form-group">
        <div class = "form-input" id="login">
          <label><b><u>Username:</u></b></label><br> 
          <input  type="text" placeholder="Enter the Username" 
              name="username" class="input-field" 
              autocomplete="off" value="<?php echo $Username?>"><br> 
          <div class="red-text"><?php echo htmlspecialchars($errors['username']); ?></div> <br><br>
          <label> <u><b>Password:</b></u></label><br> 
          <input  type="password" placeholder="Enter the password" 
              name="password" class="input-field" 
              autocomplete="off" id="login" ><br>
          <div class="red-text"><?php echo htmlspecialchars($errors['password']); ?></div>
      </div>
        <div class="button-box">
          <div id="btn"></div>
            <div class = "form-input-btn">
              <input type="submit"  value= "log in" name = "log_in" class="toggle-btn"  style="text-decoration: underline;" >
            </div>
            </form>
          <form action="register.php" method="post">
            <div class = "form-input-btn">
              <input type="submit" name = "signup/register" value="signup/register" class="toggle-btn"  >
            </div>
            </div>
    </form>
  </div>
  </div>
  <br>
</body>
</html>
