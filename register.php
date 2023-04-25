<?php
  include './config.php';
  $Username = $Password = $Email = $Pass_conf = "";
  $errors = array ("username"=>"","password"=>"","email"=>"","password_Confirmation"=>"");
  if(isset($_POST["Register"])){
    if(empty($_POST["username"])){
      $errors["username"] = " A username is required. <br />"; 
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
          $sql =  "insert into `users`(username,password,email,admin)
        VALUES ('$Username','$Password','$Email','$Type')";
      $result = mysqli_query($conn,$sql);
      if($result){
      echo "the register is completed successfully";
      header("location: index.php");
      }
      else{
      die(mysqli_error($conn));
        // echo "not connected";
      }
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
  <title>Document</title>
</head>
<body>
  <div class="container my-5">
    <form action="register.php" method="post">
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
          autocomplete="off" value="<?php echo $Password?>"><br>
        <div class="red-text"><?php echo htmlspecialchars($errors['password']); ?></div>

        <label><b>Password Confirmation:</b></label><br> 
        <input  type="password" placeholder="Enter the same password" 
          name="password_Confirmation" 
          autocomplete="off" value="<?php echo htmlspecialchars($Pass_conf) ?>"><br>
        <div class="red-text"><?php echo $errors['password_Confirmation']; ?></div>
      </div>
      <div class = "form-group">
        <label><b>Email:</b></label><br> 
        <input  type="text" placeholder="Enter the email" 
          name="email" class="form-control"
          autocomplete = "off" value="<?php echo htmlspecialchars($Email) ?>"> <br> 
        <div class="red-text"><?php echo $errors['email']; ?></div>
      </div>
      <div class = "form-group">  
        <label for="Admin"><B>Admin</B></label><br>  
        <input type="radio" id="Admin" name="type" value= 1 >  
      </div>
      <div class = "form-group">  
        <label for="user"><B>User</B></label><br>  
        <input type="radio" id="user" name="type" value= 0 >   
      </div>
      <div class = "form-group">
        <input type="submit" name = "Register"  value="Register"><br> 
      </div>
    </form>
  </div>
</body>
</html>
<?php
  echo "<B><h1>This is the register page.</h1></B>";
?>