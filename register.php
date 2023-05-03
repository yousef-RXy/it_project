<?php
require_once './config.php';
  function insertToDatabase($Username,$Password,$Email,$Type){
    global $conn;
    $sql =  "insert into `users`(username,password,email,admin)
        VALUES ('$Username','$Password','$Email','$Type')";
      return mysqli_query($conn,$sql);
  }
  $Username = $Password = $Email = $Pass_conf = "";
  $errors = array ("username"=>"","password"=>"","email"=>"","password_Confirmation"=>"");
  if(isset($_POST["Register"])){
    if(empty($_POST["username"])){
      $errors["username"] = " A username is required. "; 
    } else {
      $Username = ($_POST['username']);
      if(!preg_match('/^[a-zA-Z0-9]+$/',$Username)){
        $errors["username"] = "Username must be in letters and numbers only.";
      }
    }
    if(empty($_POST["password"])){
      $errors["password"] = " A password is required. "; 
    } else {
      $Password = ($_POST['password']);
      if(strlen($Password) < 8){
      $errors["password"] = "The password must be at least 8 characters length";
    }}

    if(empty($_POST["email"])){
      $errors["email"] = " An email is required. <br />"; 
    } else {
      $Email = $_POST['email'];
      if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
        $errors["email"] = " This must be a valid email adress. <br />";
      }
    }
    
    if(empty($_POST["password_Confirmation"])){
      $errors["password_Confirmation"] = " A Password Confirmation is required. <br />"; 
    } else {
      $Pass_conf = $_POST["password_Confirmation"];
      if($Pass_conf !== $Password){
        $errors["password_Confirmation"] = " The password confirmation does not match.";
      }
    }
    
    if (array_filter($errors)){

    } else{
      $Username = mysqli_real_escape_string($conn,$_POST['username']);
      $Password = mysqli_real_escape_string($conn,$_POST['password']);
      $Email = mysqli_real_escape_string($conn,$_POST['email']);
      $Pass_conf = mysqli_real_escape_string($conn,$_POST['password_Confirmation']);
      $Type = mysqli_real_escape_string($conn,$_POST['type']);
      $sql =  "SELECT * FROM `users` WHERE username = '$Username'";
      $result = mysqli_query($conn,$sql);
      if($result){
        $num = mysqli_num_rows($result);
        if($num>0){
          echo "This Username is already exist";
        } else{
      $result = insertToDatabase($Username,$Password,$Email,$Type);
      if($result){
      echo "the register is completed successfully";
      header("location: index.php");
      }
      else{
      die(mysqli_error($conn));
      echo "not connected";}
      }
      }
    }}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>sign up page</title>
  <link rel="stylesheet" href="css/style2.css">
</head>
<body>
  <div class="first">
    <div class= "title">Welcome to Netfilm sign up page.</div>
      <form action="register.php" method="post">
        <div class = "form-group">
          <div class="form-input" id="sign-up">
            <div class = "form-input-1">
              <label><b>Username:</b></label><br> 
              <input  type="text" placeholder="Enter the Username" 
                  name="username" class="input-field"
                  autocomplete="off" value="<?php echo $Username?>"><br> 
              <div class="red-text"><?php echo htmlspecialchars($errors['username']); ?></div>
            </div>
            <div class = "form-input-1" >
              <label><b>Password:</b></label><br> 
              <input  type="password" placeholder="Enter the password" 
                  name="password" class="input-field" 
                  autocomplete="off" value="<?php echo $Password?>"><br>
              <div class="red-text"><?php echo htmlspecialchars($errors['password']); ?></div>
              <label><b>Password Confirmation:</b></label><br> 
              <input  type="password" placeholder="Enter the same password" 
                  name="password_Confirmation" class="input-field"
                  autocomplete="off" value="<?php echo htmlspecialchars($Pass_conf) ?>"><br>
              <div class="red-text"><?php echo $errors['password_Confirmation']; ?></div>
            </div>
            <div class = "form-input-1">
              <label><b>Email:</b></label><br> 
              <input  type="text" placeholder="Enter the email" 
                  name="email" class="input-field"
                  autocomplete = "off" value="<?php echo htmlspecialchars($Email) ?>"> <br> 
              <div class="input-field" class="red-text"><?php echo $errors['email']; ?></div>
            </div>
            <div class = "form-input-1">  
              <label for="Admin"><B>Admin</B></label><br>  
              <input type="radio" id="Admin" name="type" value= 1 class="input-field1">  
            </div>
            <div class = "form-input-1">  
              <label for="user"><B>User</B></label><br>  
              <input type="radio" id="user" name="type" value= 0 class="input-field1">   
            </div>
            </div>
          <div class="button-box">
          <div id="btn"></div>
            <div class = "form-input-btn">
            <input type="submit" name = "Register" class="toggle-btn" value="Register" style="text-decoration: underline;" ><br> 
          </div>
        </div>
      </form>
  </div>
</body>
</html>
