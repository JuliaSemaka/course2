<a href="/">Вернуться назад</a><hr>
<form <?=$form->method()?> <?=$form->buildClass()?>>
    <?=$form->inputSign()?>
    <? foreach ($form->fields() as $field):?>
        <div class="form-item">
            <?=$field?>
        </div>
    <? endforeach;?>
</form>

<!--<form method="post">-->
<!--    Введите имя<br>-->
<!--    <input type="text" name="user_name" value="--><?//=$user['user_name']?><!--"><br>-->
<!--    --><?//if(isset($err['user_name'])):?>
<!--        --><?//foreach ($err['user_name'] as $value):?>
<!--            <p style="font: 12px small-caption; color: red; margin: 0">--><?//=$value?><!--</p>-->
<!--        --><?//endforeach;?>
<!--    --><?//endif;?>
<!--    Введите пароль<br>-->
<!--    <input type="password" name="user_password" value="--><?//=$user['user_password']?><!--"><br>-->
<!--    --><?//if(isset($err['user_password'])):?>
<!--        --><?//foreach ($err['user_password'] as $value):?>
<!--            <p style="font: 12px small-caption; color: red; margin: 0">--><?//=$value?><!--</p>-->
<!--        --><?//endforeach;?>
<!--    --><?//endif;?>
<!--    Повторите пароль<br>-->
<!--    <input type="password" name="user_password_repeat" value="--><?//=$user['user_password_repeat']?><!--"><br>-->
<!--    --><?//if(isset($err['user_password_repeat'])):?>
<!--        <p style="font: 12px small-caption; color: red; margin: 0">--><?//=$err['user_password_repeat']?><!--</p>-->
<!--    --><?//endif;?>
<!--    <button>Отправить</button><br>-->
<!--</form>-->