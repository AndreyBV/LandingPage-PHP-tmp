<?php
    session_start();
    if(!empty($_COOKIE['user_id']))
    {
      $_SESSION["user_id"] = $_COOKIE['user_id'];
    }

    if(isset($_SESSION["user_id"]))
    {
      $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
      mysqli_set_charset($dbc, "utf8");
      $getid = $_SESSION["user_id"];

      $query = "SELECT path_img FROM `path_img_server` WHERE user_id = '$getid'";
      $all_picture = mysqli_query($dbc, $query);

      $query = "SELECT signup.username, signup.password, users.surname, users.name, users.nickname, users.age
                FROM `signup`
                INNER JOIN `users` ON users.signupid = signup.user_id
                WHERE user_id = $getid";
      $data = mysqli_query($dbc,$query);

      if(mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_assoc($data);

          $login = $row['username'];
          $surname = $row['surname'];
          $name = $row['name'];
          $nickname = $row['nickname'];
          $age = $row['age'];

          if(isset($_POST['saveChange']))
          {
            $login_post = $_POST['login'];
            $pwd_post = $_POST['pwd'];
            $surname_post = $_POST['surname'];
            $name_post = $_POST['name'];
            $nickname_post = $_POST['nickname'];
            $age_post = $_POST['age'];

            $pattern_login = "/^[a-z0-9_]{3,16}$/u";
            $pattern_pwd = "/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([azA-Z0-9]{8,10})$/u";
            $pattern_surname_name = "/^[a-zA-Zа-яА-ЯёЁ]{2,30}$/u";
            $pattern_nickname = "/^[a-z0-9_-]+/u";
            $pattern_age = "/^\d{1,3}$/u";

            if(preg_match($pattern_surname_name,$surname_post) && preg_match($pattern_surname_name,$name_post) && preg_match($pattern_nickname,$nickname_post) && preg_match($pattern_age,$age_post))
            {
                $query = "UPDATE `users`
                          SET surname = '$surname_post',
                              name = '$name_post',
                              nickname = '$nickname_post',
                              age = $age_post
                          WHERE signupid = $getid";

                $data = mysqli_query($dbc,$query);
            }

            $query = "SELECT * FROM `signup` WHERE username = '$login_post'";
            $data = mysqli_query($dbc, $query);
            $count_person = mysqli_num_rows($data);

            if ($_POST['pwd'] == '')
            {
              if($count_person == 0 || $login_post == $login) {
                if (preg_match($pattern_login,$login_post))
                {
                    $query = "UPDATE `signup`
                          SET username = '$login_post'
                          WHERE user_id = $getid";
                    $data = mysqli_query($dbc,$query);
                }
                // else
                // echo "Проверьте правильность ввода в полях!";
              }
              else
              {
                  echo 'Логин уже существует!';
              }
            }
            else
            {
              // $query = "SELECT * FROM `signup` WHERE username = '$login_post'";
              // $data = mysqli_query($dbc, $query);
              // mysqli_num_rows($data) == 0 ||
              if($count_person == 0 || $login_post == $login) {
                  if (preg_match($pattern_login,$login_post) && preg_match($pattern_pwd,$pwd_post))
                  {
                    $query = "UPDATE `signup`
                              SET username = '$login_post',
                                  password = SHA('$pwd_post')
                              WHERE user_id = $getid";
                    $data = mysqli_query($dbc,$query);
                  }
                  // else
                  // echo "Проверьте правильность ввода в полях!";
              }
              else
              {
                  echo 'Логин уже существует!';
              }
              // header('Refresh: 1; url=personal_page.php');
            }
                header('Location: personal_page.php');
          }

          if($_FILES["selectimg"]["name"])
          {
            if ($_POST['addPicture'])
            {
              $file_name = "user_img/original/".$getid."-".$_FILES["selectimg"]["name"];
              $query = "SELECT path_img_server.path_img
                        FROM `path_img_server`
                        WHERE path_img = '$file_name'";
                // echo "".$query;
              $data = mysqli_query($dbc,$query);

              if(mysqli_num_rows($data) == 0) {
                    $nameimg = basename($_FILES["selectimg"]["name"]);
                    $tmp_name = $_FILES["selectimg"]["tmp_name"];
                    $pathimg = 'user_img/original/'.$getid.'-'.$nameimg;
                    move_uploaded_file($tmp_name, $pathimg);
                    $query = "INSERT INTO path_img_server (user_id, path_img) VALUES ($getid, '$pathimg')";
                    $data = mysqli_query($dbc, $query);
                    // unset($_FILES['selectimg']);
                    header('Location: personal_page.php');
              }
              else
              {
                echo "Придумайте другое название изображения!";
              }
              $_FILES["selectimg"]["name"] = "";
            }
          }


          if($_POST['delPicture'])
          {
            if($_GET['path_src'])
            {
               echo "string";
                // unlink ('$tmp_path');
              // $tmp_path = $_GET['path_src'];
              // $query = "DELETE FROM path_img_server WHERE path_img = '$tmp_path'";
              // $data = mysqli_query($dbc, $query);

            }

          }

      }
      else{

      }
    }
    else {

    }
    if ($dbs)
      mysqli_close($dbc);
    if ($_POST['goBasePage'])
      header('Location: index.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PersonalPage</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href= "https://fonts.googleapis.com/css?family=Roboto:400,700" rel="sidebar">
  <link rel="SHORTCUT ICON" href="media/ico/logo_mini.png" type="image/gif">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/script.js"></script>

</head>
<body>
    <div class="personal_form">

      <div class="img_and_dataimg">
        <div class="img">
          <img id="base_img_perspage"  alt="FILE NOT FOUND!">
        </div>

        <nav class="list_img">

          <?php
              while ( $row = mysqli_fetch_assoc($all_picture) ) {
                $tmp = $row[path_img];
                echo "<img src='$tmp' alt=\"FILE NOT FOUND!\" onclick=\"getNowImg('$tmp')\" >";
              }
          ?>
        </nav>

  <form  method="post"  action="personal_page.php">

        <div class="dataimg">
          <table class="tableElementInput">
            <tbody>
              <tr>
                <td><span>Фамилия</span></td><td>
                  <div class="background_input_text">
                      <input id="surname" type="text" name="surname" placeholder="Фамилия" value='<? echo $surname; ?>'>
                  </div>
                </td>
              </tr>
              <tr>
                <td><span>Имя</span></td><td>
                  <div class="background_input_text">
                      <input  id="name" type="text" name="name" placeholder="Имя" value='<? echo $name; ?>'>
                  </div>
                </td>
              </tr>
              <tr>
                <td><span>Никнейм</span></td><td>
                  <div class="background_input_text">
                      <input  id="nickname" type="text" name="nickname" placeholder="Никнейм" value='<? echo $nickname; ?>'>
                  </div>
                </td>
              </tr>
              <tr>
                <td><span>Возраст</span></td><td>
                  <div class="background_input_text">
                      <input id="age" type="text" name="age" placeholder="Возраст" value='<? echo $age; ?>'>
                  </div>
                </td>
              </tr>
              <tr>
                <td><span>Логин</span></td><td>
                  <div class="background_input_text">
                      <input id="login" type="text" name="login" placeholder="Логин" value='<? echo $login; ?>'>
                  </div>
                </td>
              </tr>
              <tr>
                <td><span>Пароль</span></td><td>
                  <div class="background_input_text">
                      <input  id="pwd" type="text" name="pwd" placeholder="Пароль">
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

    <!-- </form> -->
          <!-- <label for="set_pwd">Смнить логин/пароль </label>
          <input type="checkbox" name="set_pwd" placeholder="Пароль"> -->




            <div class="buttonAction">
              <div class="bt_config">
                  <!-- <form  method="post"> -->
                    <input  type="submit" name="saveChange" value="Сохранить изменения" onclick="CheckEnterDataRegex();">
                  </form>
              </div>
              <div class="bt_config">
                <form  method="post" enctype="multipart/form-data">
                  <!-- <input  type="file" name="selectimg"> -->
                  <div class="file-upload">
                    <label>
                      <input type="file" name="selectimg" onchange="getFileName();" id="uploaded-file">
                      <span>Выберите файл</span>
                    </lable>
                  </div>
                  <div id="file-name"></div>
                  <input  type="submit" name="addPicture" value="Добавить изображение">
                </form>
              </div>
                <form  method="post">
              <div class="bt_config">
                  <input  type="submit" name="delPicture" onclick="GetSrcSelectPicture();" value="Удалить изображение">
              </div>
              <div class="bt_config">
                  <input  type="submit" name="goBasePage" value="На главную страницу">
              </div>
              </form>
            </div>

        </div>
      </div>
    </div>
</body>
</html>
