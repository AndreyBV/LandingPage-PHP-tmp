
      function getClickButton() {
          var oSource = window.event.srcElement ;
          return oSource;
      }

      // tmp = '';
      function getNowImg(path)
      {
            tmp = path;
            var message = encodeURIComponent(path);
            window.location.href = 'http://myproject.local/personal_page.php?path_src='+path;
            // xmlHttp = new XMLHttpRequest();
            // xmlHttp.open("GET", "http://personal_page.php?path_src="+path, false);
            // xmlHttp.send(null);
            // imgbin = xmlHttp.responseText;

            var img=document.getElementById("base_img_perspage");
            img.src = path;
            // request.open("GET", 'http://myproject.local/personal_page.php?path_src='+path);
            // request.onreadystatechange = reqReadyStateChange;
            // request.send();
      }
      function getFileName () {
          var file = document.getElementById ('uploaded-file').value;
          file = file.replace (/\\/g, "/").split ('/').pop ();
          document.getElementById ('file-name').innerHTML = 'Имя файла:<br> ' + file;
      }
      function GetSrcSelectPicture()
      {
          var mainimg = document.getElementById("base_img_perspage");
          var src = mainimg.getAttribute("src");
          // alert(tmp);
          // var message = tmp;
          // $.get('http://myproject.local/personal_page.php', {message:message}, function(data)	{
          // 	alert('Сервер ответил: '+data);
          // });
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
          var pattern_pwd = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([azA-Z0-9]{8,10})$/;
          var pattern_surname_name = /^[a-zA-Zа-яА-ЯёЁ]{2,30}$/;
          var pattern_nickname = /^[a-z0-9_-]+/;
          var pattern_age = /^\d{1,3}$/;

          if (!pattern_surname_name.test(surname) || !pattern_surname_name.test(name) || !pattern_nickname.test(nickname) || !pattern_age.test(age))
          {
                alert('Проверьте правильность ввода в полях!');
          }
          else
          {
                alert('GOOD!');
          }
          if (pwd == "")
          {
              if (!pattern_login.test(login))
              {
                    alert('Проверьте правильность ввода в полях!');
              }
          }
          else
          {
              if (!pattern_login.test(login) || !pattern_pwd.test(pwd) )
              {
                    alert('Проверьте правильность ввода в полях!');
              }
          }
      }
      function ClearCookie( cookie_name )
      {
         var cookie_date = new Date ( );  // Текущая дата и время
         cookie_date.setTime ( cookie_date.getTime() - 1 );
         document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
         // alert('Доброй день');
      }



      //
      //
      // $(document).ready(function () {
      //   $("#buttonLoginSignup").submit(function () {
      //      // // Получение ID формы
      //      var formID = $(this).attr('id');
      //      // Добавление решётки к имени ID
      //      var formNm = $('#' + formID);
      //     // var oSource = getClickButton();
      //     //   alert(oSource.name);
      //      $.ajax({
      //        type: "POST",
      //        url: 'signup.php',
      //        data: formNm.serialize(),
      //        success: function (data) {
      //        // Вывод текста результата отправки
      //          $('body').html(data);
      //          // document.querySelector('.box').style.display = 'block'
      //        },
      //        error: function (jqXHR, text, error) {
      //        // Вывод текста ошибки отправки
      //          $('body').html(error);
      //        }
      //      });
      //      return false;
      //    });
      // });
