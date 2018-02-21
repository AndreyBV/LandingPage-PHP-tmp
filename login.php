<?php
$dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
if(!isset($_COOKIE['user_id'])) {
if(isset($_POST['submit'])) {
$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
if(!empty($user_username) && !empty($user_password)) {
  $query = "SELECT `user_id` , `username` FROM `signup` WHERE username = '$user_username' AND password = SHA('$user_password')";
  $data = mysqli_query($dbc,$query);
  if(mysqli_num_rows($data) == 1) {
      $row = mysqli_fetch_assoc($data);
      setcookie('user_id', $row['user_id'], time() + (60*60*24*30));
      setcookie('username', $row['username'], time() + (60*60*24*30));
      $home_url = 'http://' . $_SERVER['HTTP_HOST'];
      header('Location: '. $home_url);
      echo 'Извините вы должны заполнить поля правильно';
  }
  else {
    echo 'Извините, вы должны ввести правильные имя пользователя и пароль';
  }
}
else {
  echo 'Извините вы должны заполнить поля правильно';
}
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>123</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href= "https://fonts.googleapis.com/css?family=Roboto:400,700" rel="sidebar">
  <title>Document</title>
</head>
<body>

  <div class="overlay_popup"></div>
    <div class="popup" id="popup1">
      <div class="object">


            <span class="lable_LISI">Enter the data</span>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="entry">
               <input class="entry_field" type="text" name="username" placeholder="LOGIN">
            </div>
            <div class="entry">
               <input class="entry_field" type="password" name="password" placeholder="PASSWORD">
            </div>
            <div class="bt_entry">
                <button class="bt_entry_text" type="submit" name="submit">Sign up</button>
              <!-- <a href="#" class="bt_entry_text" >Log in</a> -->
            </div>

</form>
      </div>
    </div>

</body>
</html>
