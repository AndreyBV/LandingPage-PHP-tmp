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
			$getid = mysqli_insert_id($dbc);
			$query ="INSERT INTO `users` (signupid) VALUES ('$getid')";
			mysqli_query($dbc,$query);
			echo 'OK, you must go!';


			mysqli_close($dbc);
			exit();
		}
		else {
			echo 'Логин уже существует!';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign in</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href= "https://fonts.googleapis.com/css?family=Roboto:400,700" rel="sidebar">
	  <link rel="SHORTCUT ICON" href="media/ico/logo_mini.png" type="image/gif">
</head>
<body>

        <div class="LISU_form">

                 <form class="content_LISU" method="post" action="<?php echo $_SERVER['{PHP_SELF}']; ?>">
                       <span class="LISU_form_marg">Enter the data</span>
			                 <div class="entry LISU_form_marg">
			                    <input class="entry_field" type="text" name="username" placeholder="LOGIN">
			                 </div>
			                 <div class="entry LISU_form_marg">
			                    <input class="entry_field" type="password" name="password1" placeholder="PASSWORD">
			                 </div>
			                 <div class="entry LISU_form_marg">
			                    <input class="entry_field" type="password" name="password2" placeholder="REENTER PASSWORD">
			                 </div>
			                 <div class="bt_entry LISU_form_marg">
			                       <button class="bt_entry_text" type="submit" name="submit">Sign up</button>
			                 </div>
                 </form>
        </div>



</body>
</html>
