<a href="<?=$_SERVER['HTTP_REFERER']?>">Вернуться назад</a><hr>
<h2><?='Редактирование статьи' . $id?></h2>
<?//
//echo '<pre>';
//    print_r($news);
//echo '</pre>';
//die();
//?>
<form method="post">
    Заголовок статьи<br>
    <input type="text" name="title" value="<?=$news['news_title']?>"><br>
    Текст статьи<br>
    <input type="text" name="content" value="<?=$news['news_content']?>"><br>
    <button>Сохранить</button><br>
</form>
<!--<div>--><?// foreach ($msg as $value) {
//        echo $value."<br>";
//    }?><!--</div>-->