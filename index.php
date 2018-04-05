<?php
  if(!empty($_COOKIE['user_id']))
  {
    session_start();
    $_SESSION["login"] = $_COOKIE['user_id'];
  }
if(isset($_POST['Exit']))
{
  session_destroy();
  header("Location:http://myproject.local/index.php");
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PhotoSphere</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href= "https://fonts.googleapis.com/css?family=Roboto:400,700" rel="sidebar">
  <link rel="stylesheet" type="text/css" media="screen" href="sans-serif.css">
  <!-- <link rel="stylesheet" href="/css/master.css"> -->
  <link rel="SHORTCUT ICON" href="media/ico/logo_mini.png" type="image/gif">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="js/script.js"></script>

  <!-- <script type="text/javascript">
      $(function(){
        $('#buttonLoginSignup').submit(function(e){
          e.preventDefault();
          var data = $(this).serialize();
          $.ajax({
            type: "POST",
            url: "signup.php",
            data: data,
            success: function(result){
              $('body').html(result);
            }
          });
        });
      });
    </script> -->


<!-- <script type="text/javascript">
    $(document).ready(function () {
      $("#buttonLoginSignup").submit(function () {
         // Получение ID формы
         var formID = $(this).attr('id');
         // Добавление решётки к имени ID
         var formNm = $('#' + formID);

         var oSource = window.event.srcElement ;
          alert(oSource.name);

         $.ajax({
           type: "POST",
           url: 'signup.php',
           data: formNm.serialize(),
           success: function (data) {
           // Вывод текста результата отправки
             $('body').html(data);
           },
           error: function (jqXHR, text, error) {
           // Вывод текста ошибки отправки
             $('body').html(error);
           }
         });
         return false;
       });
    });
  </script> -->

</head>
<body>

  <section class="top_section">
    <header class="header">
           <div class="logo">
               <a href="#"><img src="media/ico/logo.png" alt=""> </a>
           </div>
           <div class="search">
             <img class="logo_search" src="media/ico/search.png" alt="ico_search">
             <input class="entry_field" type="text" name="search" placeholder="Let's start...">
           </div>
           <div class="button_LISU">
             <?php
               // echo "Кука:".$_COOKIE['username'].$_COOKIE['user_id'];
                  if(!empty($_COOKIE['username'])){
             ?>
                     <form class="button_LISU" >
                       <div class="LI">
                           <!-- <input type="submit" name="Account" value="Account" onclick="getClickButton()" class="LI"> -->
                          <a href="personal_page.php" class="LI">Account</a>
                       </div>
                       <div class="SU">
                          <input type="submit" name="Exit" value="Exit" onclick="ClearCookie('username');ClearCookie('user_id')" class="SI">
                         <!-- <a href="signup.php" class="SI">Sign up</a> -->
                       </div>
                     </form>
             <?php
                 }
                 else {
            ?>
                      <form class="button_LISU" id="buttonLoginSignup">
                        <div class="LI">
                            <!-- <input type="submit" name="Login" value="Log in" onclick="getClickButton()" class="LI"> -->
                           <a href="login.php" class="LI">Log in</a>
                        </div>
                        <div class="SU">
                           <!-- <input type="submit" name="Signup" value="Sign up" onclick="getClickButton()" class="SI"> -->
                          <a href="signup.php" class="SI">Sign up</a>
                        </div>
                      </form>
            <?php
                 }
             ?>
           </div>


    </header>
    <!-- <div class="base_phrase">
      <h1>FIND YOUR</h1>
      <h1>INSPIRATION</h1>
    </div> -->
    <div class="menu">
      <div class="elements_menu">

        <a class="bt_menu" href="#">Photos</a>
        <a class="bt_menu" href="#">Popular</a>
        <a class="bt_menu" href="#">Latest</a>
      </div>
    </div>

    <div class="base_picture">
         <img src="media/img/bg_base.png" alt="">
    </div>


  </section>


    <div class="content_menu">
              <div class="data_miniaturs">
                <span>Landscape</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

            <div class="data_miniaturs">
                <span>Portrait</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Architecture</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                  <span>Animals</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Auto</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                  <span>Hi-Tech</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Games</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Films</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Abstraction</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Macro</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Textures</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>

              <div class="data_miniaturs">
                <span>Black and White</span>
          <a href="#"><img src="http://www.anypics.ru/pic/201302/1024x768/anypics.ru-60617.jpg" alt="FILE NOT FOUND!"></a>

        </div>
    </div>


    <footer >
      <div class="logo logo_footer">
          <a href="#"><img src="media/ico/logo.png" alt=""> </a>
      </div>
      <address class="data_address">
        <table>
          <tr>
            <td><img src="media/ico/tel.png" alt=""></td> <td>Phone: +7 (952) 645-22-11</td>
          </tr>
          <tr>
            <td><img src="media/ico/email.png" alt=""></td> <td>E-Mail: PSphere@gmail.com</td>
          </tr>
          <tr>
            <td><img src="media/ico/geo.png" alt=""></td> <td>Location: PSphere, 42 Pufffin street, France</td>
          </tr>
        </table>
        <div class="copyright">&#169;2018 - Social network developed PhotoSphere&trade;</div>
      </address>
      <div class="social_network">
        <a href="https://vk.com/andreasford" target="_blank"><img src="media/ico/vk.png" alt=""></a>
        <a href="https://ru-ru.facebook.com/" target="_blank"><img src="media/ico/fb.png" alt=""></a>
        <a href="https://twitter.com/" target="_blank"><img src="media/ico/tt.png" alt=""></a>
      </div>
    </footer>
    <form class="parsers" action="parsers.php" method="post">
        <input type="submit" name="parser_dom" value="Новости фототехники" class="SI">
        <input type="submit" name="parser_regex" value="Арт новости" class="SI">
    </form>


   <!-- </div> -->

</body>
</html>
