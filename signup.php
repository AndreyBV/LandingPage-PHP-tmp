<?php

$dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
mysqli_set_charset($dbc, "utf8");
if(isset($_POST['submit'])){

	$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
	$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

	$pattern_login = "/^[a-z0-9_]{3,16}$/u";
	$pattern_pwd = "/^[a-zA-Zа-яА-Я0-9_]{6,}$/u";
	if (preg_match($pattern_login,$username) && preg_match($pattern_pwd,$password1))
	{
		if(!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {

			if ($query = mysqli_prepare($dbc, "call test_login_user(?)"))
			{
				mysqli_stmt_bind_param($query, "s", $username);
				mysqli_stmt_execute($query);
				$data = mysqli_stmt_get_result($query);
				mysqli_stmt_close($query);
			}

			if(mysqli_num_rows($data) == 0) {
				if ($query = mysqli_prepare($dbc, "call registration_new_user(?, ?)"))
				{
					mysqli_stmt_bind_param($query, "ss", $username, SHA1($password2));
					mysqli_stmt_execute($query);
					mysqli_stmt_close($query);
				}
				$query = "call getid()";
				$data = mysqli_query($dbc,$query);
				mysqli_close($dbc);

				$dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
				mysqli_set_charset($dbc, "utf8");
				if (mysqli_num_rows($data) == 1)
				{
					$row = mysqli_fetch_assoc($data);
					$getid = $row['user_id'];
					$query = mysqli_prepare($dbc, "call	add_userdata(?)");

					mysqli_stmt_bind_param($query, "i", $getid);
					mysqli_stmt_execute($query);
					mysqli_stmt_close($query);

				}
				mysqli_close($dbc);
				header("Location:http://myproject.local/index.php");

				exit();
			}
			else {
					echo "<script>alert(\"Логин уже существует!\");</script>";
				// echo 'Логин уже существует!';
			}
		}
	}
	else
	{
			echo "<script>alert(\"Проверьте правильность ввода в полях\");</script>";
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
