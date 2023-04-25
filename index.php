
<?php
  include './config.php';
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
        if($num>0){
          echo "Log in successfully";
          $row = $result->fetch_assoc();
          $_SESSION["id"] = $row["id"];
          header('location: ./home.php');
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
  <title>Document</title>
</head>
<body>
  <div class="container my-5">
    <form action="index.php" method="post">
      <div class = "form-group">
        <label><b>Username:</b></label><br> 
        <input  type="text" placeholder="Enter the Username" 
          name="username" class="form-control" 
          autocomplete="off" value="<?php echo $Username?>"><br> 
        <div class="red-text"><?php echo htmlspecialchars($errors['username']); ?></div>
      </div>
      <div class = "form-group">
        <label><b>Password:</b></label><br> 
        <input  type="password" placeholder="Enter the password" 
          name="password" class="form-control" 
          autocomplete="off" ><br>
        <div class="red-text"><?php echo htmlspecialchars($errors['password']); ?></div>
    </div>  
    <div class = "form-group">
      <input type="submit"  value="log in" name = "log_in">
    </div>
    </form>
  <form action="register.php" method="post">
    <div class = "form-group">
      <input type="submit" name = "signup/register" value="signup/register" >
    </div>
  </form>
  <br>
</body>
</html>
