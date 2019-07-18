<div>
    <a href="<?=$_SERVER['HTTP_REFERER']?>">Назад</a>
</div><hr>
<h2>Новая статья</h2>
<form method="post">
    Введите название статьи<br>
    <input type="text" name="title" value="<?=$title?>"><br>
    Введите текст статьи<br>
    <textarea name="content"><?=$content?></textarea><br>
    <button>Сохранить</button>
    <?if($err):?>
        <?=var_dump($err);?>
    <?endif;?>
</form>
<div>