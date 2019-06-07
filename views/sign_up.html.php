<a href="<?=$_SERVER['HTTP_REFERER']?>">Вернуться назад</a><hr>
<form method="post">
    Введите имя<br>
    <input type="text" name="user_name" value="<?=$err['user_name']?>"><br>
    <?if(isset($err['errors']['user_name'])):?>
        <?foreach ($err['errors']['user_name'] as $value):?>
            <p style="font: 12px small-caption; color: red; margin: 0"><?=$value?></p>
        <?endforeach;?>
    <?endif;?>
    Введите текст статьи<br>
    <input type="password" name="user_password" value="<?=$err['user_password']?>"><br>
    <?if(isset($err['errors']['user_password'])):?>
        <?foreach ($err['errors']['user_password'] as $value):?>
            <p style="font: 12px small-caption; color: red; margin: 0"><?=$value?></p>
        <?endforeach;?>
    <?endif;?>
    <input type="checkbox" name="remember">Запомнить<br>
    <button>Отправить</button><br>
</form>