<?php

$dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
if(isset($_POST['submit'])){
	$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
	$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
	if(!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
		$query = "SELECT * FROM `signup` WHERE username = '$username'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data) == 0) {
			$query ="INSERT INTO `signup` (username, password) VALUES ('$username', SHA('$password2'))";
			mysqli_query($dbc,$query);
			echo 'Всё готово, можете авторизоваться';
			mysqli_close($dbc);
			exit();
		}
		else {
			echo 'Логин уже существует';
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

                 <form method="POST" action="<?php echo $_SERVER['{PHP_SELF}']; ?>" method="post">
                       <span class="lable_LISI">Enter the data</span>
                 <div class="entry">
                    <input class="entry_field" type="text" name="username" placeholder="LOGIN">
                 </div>
                 <div class="entry">
                    <input class="entry_field" type="password" name="password1" placeholder="PASSWORD">
                 </div>
                 <div class="entry">
                    <input class="entry_field" type="password" name="password2" placeholder="REENTER PASSWORD">
                 </div>
                 <div class="bt_entry">
                       <button class="bt_entry_text" type="submit" name="submit">Sign up</button>
                 </div>
                 </form>
           </div>
         </div>



</body>
</html>
