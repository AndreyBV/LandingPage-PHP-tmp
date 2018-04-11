<?php
header("Content-type: text/html;charset=utf-8");
//Выражение require_once аналогично require за исключением того, что PHP проверит, включался ли уже данный файл, и если да, не будет включать его еще раз.
require_once 'simple_html_dom.php';
function getNewsWithPageDOM($url)
{
  $html = file_get_html($url); // умеет загружать данные с удаленного URL или из локального файла
  $i = 0;
  // $html->find  - выполняет поиск в документе по заданным параметрам
  if($html->find('"div.publications list" div.item div.left div.image a img')){

      foreach($html->find('"div.publications list" div.item div.left div.image a img') as $img){
        $_title = "";
        $_title_href = "";
        $_article = "";
        $_path_img = "";

        echo '<tr>';
        echo '<td rowspan="2"><img src="https://btest.ru'.$img->src.'"></td>';


        if($html->find('"div.publications list" div.item div.mid h3 a')){
            $val = $html->find('"div.publications list" div.item div.mid h3 a');
            echo '<td ><a target="_blank" href="https://btest.ru'.$val[$i]->href.'">'.$val[$i]->innertext.'</a></br></td>';
            $_title = $val[$i]->innertext;
            $_title_href = $val[$i]->href;
        }

        echo '<tr>';
        if($html->find('"div.publications list" div.item div.mid p')){
            $val = $html->find('"div.publications list" div.item div.mid p');
            echo '<td><p>'.$val[$i]->innertext.'</p></br></td>';
            $_article = $val[$i]->innertext;
        }
        echo '</tr>';
        echo '</tr>';
        $i++;


        $path_img = 'imgparser/'.basename($img->src);
        // file_put_contents('imgparser/'.basename($img->src), file_get_contents("https://btest.ru".$img->src));

        $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
        mysqli_set_charset($dbc, "utf8");

        $query = "SELECT title_href
                  FROM `data_DOM`
                  WHERE title_href = '$_title_href'";
        $data = mysqli_query($dbc,$query);
        if(mysqli_num_rows($data) == 0) {
          $query = "INSERT INTO data_DOM (title_href, title, article, path_img) VALUES ('$_title_href', '$_title', '$_article', '$path_img')";
          $data = mysqli_query($dbc, $query);
        }
        mysqli_close($dbc);
      }
  }
  $html->clear(); // подчищаем за собой
  unset($html);
}
if(isset($_POST['parser_dom']))
{
  echo '<table border="1">';
  $number_page = 2;
  for ($i = 1; $i <= $number_page; $i++) {
        $url = 'https://btest.ru/novosti/?p='.$i.'&category_id=22846';
        getNewsWithPageDOM($url);
   }
  echo '</table>';

}

// ================================= ^^^^^^ DOM ^^^^^^ ================================== vvvvvv REGEX vvvvvv ==========================================================================================

function getNewsWithPageRegEx($url)
{
  $html = file_get_contents($url);

  //i -    , s - включение однострочного режима   , u - для работы с кирилицей
  $regex_body_news = '#<div class="ts-row posts-grid listing-grid grid-2 "[^>]*?>(.+?)</div> <div class="main-pagination ">#isu';
  $regex_img = '#<im[^>]*?>#isu';
  $regex_title = '#<a[^>]*? class="post-link">(.+?)</a>#isu';
  $regex_article = '#<p[^>]*?>(.+?)</p>#isu';

  // preg_match_all — Выполняет глобальный поиск шаблона в строке
  preg_match_all($regex_body_news, $html, $res_body_news);

  preg_match_all($regex_img, $res_body_news[0][0], $res_img);
  preg_match_all($regex_title, $res_body_news[0][0], $res_title);
  preg_match_all($regex_article, $res_body_news[0][0], $res_article);

  $j = 0;


  for ($i = 0; $i <= count($res_img[0])-1; $i++) {
      $_title = "";
      $_title_href = "";
      $_article = "";
      $_path_img = "";


      echo '<tr>';

      echo '<td rowspan="2">'.$res_img[0][$i].'<br></td>';
      echo '<td>'.str_replace("href=\"","target=\"_blank\" href=\"http://art-news.com.ua/",$res_title[0][$j]).'<br></td>';

      echo '<tr>';

      echo '<td>'.$res_article[0][$j].'<br></td>';

      echo '</tr>';
      echo '</tr>';
      $j++;

   }

}
if(isset($_POST['parser_regex']))
{
    echo '<table border="1">';
    $number_page = 2;

    for ($i = 1; $i <= $number_page; $i++) {
          $url = 'http://art-news.com.ua/page/'.$i.'/';
          getNewsWithPageRegEx($url);
     }
  // var_dump($res_title);
    echo '</table>';
}
?>
