<div>
    <a href="<?=$_SERVER['HTTP_REFERER']?>">Назад</a>
</div><hr>
<?if($news === false):?>
    Нет такой статьи<br>
<?else:?>
    <h2>Статья №<?=$news['id']?></h2>
            <p><b>Дата:</b> <?=$news['dt']?></p>
            <h3><b>Название статьи:</b> <?=$news['news_title']?></h3>
            <p><b>Содержание:</b> <?=$news['news_content']?></p>

                <p><a href="/edit/<?=$news['id_news']?>">Редактировать</a> </p>

<?endif;?>
<a href="/new">Добавить новую статью</a><br>
<a href="/auth">Выход</a><br>