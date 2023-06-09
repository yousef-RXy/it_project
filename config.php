<?php
  $hostname= "localhost";
  $dbname= "project";
  $dbuser= "root";
  $dbuserpassword= "";
  $dsn = "mysql:host=$hostname;dbname=$dbname";
  $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  $connection = new PDO($dsn, $dbuser, $dbuserpassword, $options);
  $conn = new mysqli($hostname, $dbuser, $dbuserpassword, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $photo_ext = ['png', 'jpg', 'jpeg', 'gif'];
  $video_ext = ['mp4', 'webm', 'avi', 'flv'];
  session_start();
  
?>

<?php 
function message($s,$color){
  echo (" 
          <div style='margin:25px auto 0;border-radius:12px;background:$color;color:white;padding:10px;'>
            <p>$s</p>
          </div>
          <br>
      "); 
}
function updateuserdata(){
  global $connection,$id,$userset;
  $username =$_POST['username'];
  $email = $_POST['email'];
  $sql = "SELECT * FROM users WHERE (username='$username' OR email='$email') AND NOT id=$id ";
  $statement =  $connection->prepare($sql);
  $statement-> execute();
  $user_all =$statement-> fetchAll();
  if (empty($user_all)&&($userset['username']!=$username||$userset['email']!=$email)) {
    if (empty($username)) {
      message("the user name is empty","red");
    } else {
      if (empty($email)) {
        message("the user email is empty", "red");
      } else {
        $userset['username'] = $_POST['username'];
        $userset['email'] = $_POST['email'];
        if(filter_var($userset['email'], FILTER_VALIDATE_EMAIL)){
          if(preg_match('/^[a-zA-Z0-9]+$/',$userset['username'])){
            $sql = "UPDATE users SET username=:username ,email=:email WHERE id=:id";
            $statement = $connection->prepare($sql);
            $statement->execute($userset);
            header("Location: ./data.php");
            exit();
          }
          else{
            message("this user name must contain just letters and numpers", "red");
          }
        }
        else{
          message("the email is not valid", "red");
        }
      }
    }
  }
  else{
    message("this user name/email exist", "red");
  }
}
function set_image($table, $check,$dir, $id,$file_name=null) {
  global $connection,$photo_ext;
  if (!file_exists("./uploads/$dir")) {
    mkdir("./uploads/$dir", 0777, true);
  }
  if ($check) {
    for ($x = 0; $x < sizeof($_FILES['photos']['name']); $x++) {
      $file_name=$_FILES['photos']['name'][$x];
      if (file_ex($photo_ext,$file_name,$dir)) {
        $dest = "./uploads/$dir/".$file_name;
        move_uploaded_file($_FILES['photos']['tmp_name'][$x], $dest);
        $new_photo = array('id' => $id, 'path' => $dest);
        $keys_string = implode(', ', array_keys($new_photo));
        $keys_placeholder = ':' . implode(', :', array_keys($new_photo));
        $sql = (sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $keys_string, $keys_placeholder));
        $connection->prepare($sql)->execute($new_photo);
      }
    }
  }
  else{
    $file_name=$_FILES[$dir]['name'];
    if (file_ex($photo_ext,$file_name,$dir)) {
      $dest = "./uploads/$dir/".$file_name;
      move_uploaded_file($_FILES[$dir]['tmp_name'], $dest);
      $sql = "UPDATE $table SET photo_path='$dest' WHERE id=$id";
      $connection->prepare($sql)->execute();
    }
  }
};
function set_video($id,$dir){
  global $connection,$video_ext;
  $file_name=$_FILES[$dir]['name'];
  if (file_ex($video_ext,$file_name,'trailer')) {
    if (!file_exists("./uploads/$dir")) {
      mkdir("./uploads/$dir", 0777, true);
    }
    $dest = "./uploads/$dir/".$file_name;
    move_uploaded_file($_FILES[$dir]['tmp_name'], $dest);
    $sql = "UPDATE movie SET trailer_path='$dest' WHERE id=$id";
    $connection->prepare($sql)->execute();
  }
}
function file_ex($allowed_exs,&$file_name,$start_name){
  $file_ex = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  if (in_array($file_ex, $allowed_exs)) {
      $file_name = uniqid("$start_name-", true).'.'.$file_ex;
    return 1;
  }
  else{
    return 0;
  }
}
function set_comment($page,$id_page){
  global $connection, $conn,$id;
  $iduser=$_SESSION["id"];
  $sql = "SELECT username FROM users WHERE id=$iduser";
  $statement =  $connection->prepare($sql);
  $statement-> execute();
  $username = $statement-> fetch()['username'];
  if(isset($_POST['post_comment'])){
    $comment=$_POST['comment'];
    $sql = "INSERT INTO comments_table (id,name,comment) VALUES ($id,'$username','$comment')"; 
    if ($conn->query($sql) === TRUE) {
      message('New record created successfully!', 'green');
      header("Location: ./$page.php?id=$id_page");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;//why?
    }
  }
  echo ('
    <div class ="com">
    <form action="" method="POST">
      <textarea  name="comment" cols="30" rows="10" class="comment" placeholder="type your comment..." ></textarea>
      <br>
      <button type="submit" class="button" name="post_comment" >POST</button>
    </form>
    </div>
  ');
}
?>
