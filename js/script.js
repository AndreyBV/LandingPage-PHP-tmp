
      function getClickButton() {
          var oSource = window.event.srcElement ;
          return oSource;
      }

      function getNowImg(path)
      {
            var message = encodeURIComponent(path);
            window.location.href = 'http://myproject.local/personal_page.php?path_src='+path; // Получает-устанавливает URL окна и его компоненты (весь URL)

            var img = document.getElementById("base_img_perspage"); //возвращает ссылку на элемент, который имеет атрибут id с указанным значением.
            img.src = path;
      }
      function getFileName () {
          var file = document.getElementById ('uploaded-file').value;
          file = file.replace (/\\/g, "/").split ('/').pop (); //замена, разбиение на массив, удаление последнего элемента и его возврат
          document.getElementById ('file-name').innerHTML = 'Имя файла:<br> ' + file;
      }
      function CheckEnterDataRegex()
      {
          var surname = document.getElementById("surname").value;
          var name = document.getElementById("name").value;
          var nickname = document.getElementById("nickname").value;
          var age = document.getElementById("age").value;
          var login = document.getElementById("login").value;
          var pwd = document.getElementById("pwd").value;

          var pattern_login = /^[a-z0-9_]{3,16}$/;
          var pattern_pwd = /^[a-zA-Zа-яА-Я0-9_]{6,}$/;
          var pattern_surname_name = /^[a-zA-Zа-яА-ЯёЁ]{2,30}$/;
          var pattern_nickname = /^[a-z0-9_-]+/;
          var pattern_age = /^\d{1,3}$/;


          //test - Используется, чтобы выяснить, есть ли совпадения регулярного выражения со строкой
          if (!pattern_surname_name.test(surname) || !pattern_surname_name.test(name) || !pattern_nickname.test(nickname) || !pattern_age.test(age))
          {
                alert('Проверьте правильность ввода в полях: фамилия, имя, никнемй, возраст!');
          }
          else
          {
                // alert('GOOD!');
          }
          if (pwd == "")
          {
              if (!pattern_login.test(login))
              {
                    alert('Проверьте правильность ввода в поляе логин!');
              }
          }
          else
          {
              if (!pattern_login.test(login) || !pattern_pwd.test(pwd) )
              {
                    alert('Проверьте правильность ввода в полях: логин, пароль!');
              }
          }
      }
      function ClearCookie( cookie_name )
      {
         var cookie_date = new Date ( );  // Текущая дата и время
         cookie_date.setTime ( cookie_date.getTime() - 1 );
         document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
      }
