<?php
    session_start();

    function DoSql($query)
    {
      $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
      mysqli_set_charset($dbc, "utf8");

      $data = mysqli_query($dbc, $query);
      mysqli_close($dbc);
      return $data;
    }
    if(!empty($_COOKIE['user_id']))
    {
      $_SESSION["user_id"] = $_COOKIE['user_id'];
    }
    if(isset($_SESSION["user_id"]))
    {
      //
      // $getid = $_SESSION["user_id"];

      $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
      mysqli_set_charset($dbc, "utf8");
      $getid = mysqli_real_escape_string($dbc, trim($_SESSION["user_id"]));
      if ($query = mysqli_prepare($dbc, "call get_all_picture_user(?)"))
      {
        mysqli_stmt_bind_param($query, "i", $getid);
        mysqli_stmt_execute($query);
      	$all_picture = mysqli_stmt_get_result($query);
        mysqli_stmt_close($query);
      }
      if ($query = mysqli_prepare($dbc, "call get_info_user(?)"))
      {
        mysqli_stmt_bind_param($query, "i", $getid);
        mysqli_stmt_execute($query);
        $data = mysqli_stmt_get_result($query);
        mysqli_stmt_close($query);
      }
      mysqli_close($dbc);
      // $query = "call get_all_picture_user($getid)";
      // $all_picture = DoSql($query);

      // $query = "call get_info_user($getid)";
      // $data = DoSql($query);

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
            $pattern_pwd = "/^[a-zA-Zа-яА-Я0-9_]{6,}$/u";
            $pattern_surname_name = "/^[a-zA-Zа-яА-ЯёЁ]{2,30}$/u";
            $pattern_nickname = "/^[a-z0-9_-]+/u";
            $pattern_age = "/^\d{1,3}$/u";

            //preg_match — Выполняет проверку на соответствие регулярному выражению
            if(preg_match($pattern_surname_name,$surname_post) && preg_match($pattern_surname_name,$name_post) && preg_match($pattern_nickname,$nickname_post) && preg_match($pattern_age,$age_post))
            {
                $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
                mysqli_set_charset($dbc, "utf8");
                if ($query = mysqli_prepare($dbc, "call update_user_data(?,?,?,?,?)"))
                {
                  $surname_post = mysqli_real_escape_string($dbc, trim($surname_post));
                  $name_post = mysqli_real_escape_string($dbc, trim($name_post));
                  $nickname_post = mysqli_real_escape_string($dbc, trim($nickname_post));
                  $age_post = mysqli_real_escape_string($dbc, trim($age_post));
                  $getid = mysqli_real_escape_string($dbc, trim($getid));
                  mysqli_stmt_bind_param($query, "sssii", $surname_post, $name_post, $nickname_post, $age_post, $getid);
                  mysqli_stmt_execute($query);
                  mysqli_stmt_close($query);
                }
                mysqli_close($dbc);
                //
                // $query = "call update_user_data('$surname_post', '$name_post', '$nickname_post', $age_post, $getid)";
                // $data = DoSql($query);
                header('Location: personal_page.php');
            }

            $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
            mysqli_set_charset($dbc, "utf8");
            if ($query = mysqli_prepare($dbc, "call test_login_user(?)"))
            {
              $login_post = mysqli_real_escape_string($dbc, trim($login_post));
              mysqli_stmt_bind_param($query, "s", $login_post);
              mysqli_stmt_execute($query);
              $data = mysqli_stmt_get_result($query);
              mysqli_stmt_close($query);
            }
            mysqli_close($dbc);
            // $query = "call test_login_user('$login_post')";
            // $data = DoSql($query);
            $count_person = mysqli_num_rows($data);
            if ($_POST['pwd'] == '')
            {

              if($count_person == 0 || $login_post == $login) {
                if (preg_match($pattern_login,$login_post))
                {
                  $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
                  mysqli_set_charset($dbc, "utf8");
                  if ($query = mysqli_prepare($dbc, "call update_only_login(?,?)"))
                  {
                    $file_name = mysqli_real_escape_string($dbc, trim($file_name));
                    mysqli_stmt_bind_param($query, "si", $login_post, $getid);
                    mysqli_stmt_execute($query);
                    mysqli_stmt_close($query);
                  }
                  mysqli_close($dbc);
                    $query = "call update_only_login('$login_post', $getid)";
                    $data = DoSql($query);
                      header('Location: personal_page.php');
                }
              }
              else
              {
                  echo "<script>alert(\"Логин уже существует!\");</script>";
              }
            }
            else
            {
              if($count_person == 0 || $login_post == $login) {
                  if (preg_match($pattern_login,$login_post) && preg_match($pattern_pwd,$pwd_post))
                  {
                    $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
                    mysqli_set_charset($dbc, "utf8");
                    if ($query = mysqli_prepare($dbc, "call update_login_and_pwd(?,?,?)"))
                    {
                      $file_name = mysqli_real_escape_string($dbc, trim($file_name));
                      mysqli_stmt_bind_param($query, "ssi", $login_post, SHA1($pwd_post), $getid);
                      mysqli_stmt_execute($query);
                      mysqli_stmt_close($query);
                    }
                    mysqli_close($dbc);
                    header('Location: personal_page.php');
                  }
              }
              else
              {
                  echo "<script>alert(\"Логин уже существует!\");</script>";
              }
            }
          }

          // $_FILES - Ассоциативный массив (array) элементов, загруженных в текущий скрипт через метод HTTP POST.
          if($_FILES["selectimg"]["name"])
          {
            if ($_POST['addPicture'])
            {
              $file_name = "user_img/original/".$getid."-".$_FILES["selectimg"]["name"];

              $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
              mysqli_set_charset($dbc, "utf8");
              if ($query = mysqli_prepare($dbc, "call test_name_img(?)"))
              {
                $file_name = mysqli_real_escape_string($dbc, trim($file_name));
                mysqli_stmt_bind_param($query, "s", $file_name);
                mysqli_stmt_execute($query);
                $data = mysqli_stmt_get_result($query);
                mysqli_stmt_close($query);
              }
              mysqli_close($dbc);
              // $query = "call test_name_img('$file_name')";
              // $data = DoSql($query);
              if(mysqli_num_rows($data) == 0) {
                    $nameimg = basename($_FILES["selectimg"]["name"]);
                    $tmp_name = $_FILES["selectimg"]["tmp_name"];
                    $pathimg = 'user_img/original/'.$getid.'-'.$nameimg;
                    move_uploaded_file($tmp_name, $pathimg);

                    $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
                    mysqli_set_charset($dbc, "utf8");
                    if ($query = mysqli_prepare($dbc, "call add_img_user(?,?)"))
                    {
                      $pathimg = mysqli_real_escape_string($dbc, trim($pathimg));
                      mysqli_stmt_bind_param($query, "is", $getid, $pathimg);
                      mysqli_stmt_execute($query);
                      mysqli_stmt_close($query);
                    }
                    mysqli_close($dbc);

                    header('Location: personal_page.php');
              }
              else
              {
                echo "<script>alert(\"Придумайте другое название изображения!\");</script>";
                // echo "Придумайте другое название изображения!";
              }
              $_FILES["selectimg"]["name"] = "";
            }
          }


          if($_POST['delPicture'])
          {
            if($_GET['path_src'])
            {
              $tmp_path = $_GET['path_src'];

              $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
              mysqli_set_charset($dbc, "utf8");
              if ($query = mysqli_prepare($dbc, "call del_img_user(?)"))
              {
                $tmp_path = mysqli_real_escape_string($dbc, trim($tmp_path));
                mysqli_stmt_bind_param($query, "s", $tmp_path);
                mysqli_stmt_execute($query);
                mysqli_stmt_close($query);
              }
              mysqli_close($dbc);
              unlink ($tmp_path);
              $_GET['path_src'] = "";
              $_POST['delPicture'] = "";
              $tmp_path = "";
              header('Location: personal_page.php');
            }

          }
      }
      else{
          echo "<script>alert(\"Страницы пользователя не существует!\");</script>";
      }
    }
    else {
        header('Location: index.php');
    }
    if ($_POST['goBasePage'])
      header('Location: index.php');
// ====================================================================================================================================================================================
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
          <?php
                 while( $row = mysqli_fetch_assoc($all_picture))
                      $data_pic[] = $row[path_img];

                if (count($data_pic) != 0)
                {
                  if ($_GET['path_src'])
                      $one_picture = $_GET['path_src'];
                   else
                      $one_picture = $data_pic[0];
                  }
                  else
                  {
                    $one_picture = 'media/img/no_img.png';
                  }
                        echo "<div class=\"img\">";
                          echo "<img id=\"base_img_perspage\"  src='$one_picture' alt=\"FILE NOT FOUND!\">";
                        echo "</div>";

                        echo "<nav class=\"list_img\">";

                        for ($i = 0; $i < count($data_pic); $i++)
                        {
                          $tmp = $data_pic[$i];
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

            <div class="buttonAction">
              <div class="bt_config">
                  <!-- <form  method="post"> -->
                    <input  type="submit" name="saveChange" value="Сохранить изменения" onclick="CheckEnterDataRegex();">
                  </form>
              </div>
              <div class="bt_config">
                <!-- multipart/form-data Данные не кодируются. Это значение применяется при отправке файлов. -->
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
