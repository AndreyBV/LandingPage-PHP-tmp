<?php
header("Content-type: text/html;charset=utf-8");
require_once 'simple_html_dom.php';
function getNewsWithPageDOM($url)
{
  $html = file_get_html($url);

  $i = 0;

  if($html->find('"div.publications list" div.item div.left div.image a img')){
      foreach($html->find('"div.publications list" div.item div.left div.image a img') as $img){
        echo '<tr>';
        echo '<td rowspan="2"><img src="https://btest.ru'.$img->src.'"></td>';


        if($html->find('"div.publications list" div.item div.mid h3 a')){
            $val = $html->find('"div.publications list" div.item div.mid h3 a');
            echo '<td ><a href="https://btest.ru'.$val[$i]->href.'">'.$val[$i]->innertext.'</a></br></td>';
            // foreach($html->find('"div.publications list" div.item div.mid h3 a') as $a){
            //   echo '<td ><a href="https://btest.ru'.$a->href.'">'.$a->innertext.'</a></br></td>';
            // }
        }

        echo '<tr>';
        if($html->find('"div.publications list" div.item div.mid p')){
            $val = $html->find('"div.publications list" div.item div.mid p');
            echo '<td><p>'.$val[$i]->innertext.'</p></br></td>';
            // foreach($html->find('"div.publications list" div.item div.mid p') as $p){
            //   echo '<td><p>'.$p->innertext.'</p></br></td>';
            // }
        }
        echo '</tr>';
        echo '</tr>';
            $i++;
        // file_put_contents('imgparser/'.basename($img->src), file_get_contents("https://btest.ru".$img->src));
      }
  }
  $html->clear(); // подчищаем за собой
  unset($html);
}
if(isset($_POST['parser_dom']))
{
  echo '<table border="1">';

  $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
  mysqli_set_charset($dbc, "utf8");

  for ($i = 1; $i <= 5; $i++) {
        $url = 'https://btest.ru/novosti/?p='.$i.'&category_id=22846';
        getNewsWithPageDOM($url);
   }

  mysqli_close($dbc);
  echo '</table>';

}






function getNewsWithPageRegEx($url)
{
  $html = file_get_contents($url);

  $regex_body_news = '#<div class="ts-row posts-grid listing-grid grid-2 "[^>]*?>(.+?)</div> <div class="main-pagination ">#isu';
  $regex_img = '#<im[^>]*?>#isu';
  $regex_title = '#<a[^>]*? class="post-link">(.+?)</a>#isu';
  $regex_article = '#<p[^>]*?>(.+?)</p>#isu';

  preg_match_all($regex_body_news, $html, $res_body_news);

  preg_match_all($regex_img, $res_body_news[0][0], $res_img);
  preg_match_all($regex_title, $res_body_news[0][0], $res_title);
  preg_match_all($regex_article, $res_body_news[0][0], $res_article);

  $j = 0;


  for ($i = 0; $i <= count($res_img[0])-1; $i++) {
      echo '<tr>';
      echo '<td rowspan="2">'.$res_img[0][$i].'<br></td>';

      // for ($i = 0; $i <= count($res_title[0]); $i++) {
          echo '<td>'.str_replace("href=\"","href=\"http://art-news.com.ua/",$res_title[0][$j]).'<br></td>';
      // }
      echo '<tr>';
      // for ($i = 0; $i <= count($res_article[0]); $i++) {
          echo '<td>'.$res_article[0][$j].'<br></td>';
      // }

      echo '</tr>';
      echo '</tr>';
      $j++;
   }

  // $html->clear(); // подчищаем за собой
  // unset($html);
}
if(isset($_POST['parser_regex']))
{
  echo '<table border="1">';

  $dbc = mysqli_connect('localhost', 'root', '', 'PhotoSphere') OR DIE('Ошибка подключения к базе данных');
  mysqli_set_charset($dbc, "utf8");

  // getNewsWithPageRegEx("");
  for ($i = 1; $i <= 10; $i++) {
        $url = 'http://art-news.com.ua/page/'.$i.'/';
        getNewsWithPageRegEx($url);
   }
  // var_dump($res_title);
  mysqli_close($dbc);
    echo '</table>';
}
?>
