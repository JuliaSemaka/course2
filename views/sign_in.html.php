<a href="/">Вернуться назад</a><hr>
<a href="/users/sign_up">Регистрация</a><hr>
<form <?=$form->method()?> <?=$form->buildClass()?>>
    <?=$form->inputSign()?>
    <? foreach ($form->fields() as $field):?>
        <div class="form-item">
            <?=$field?>
        </div>
    <? endforeach;?>
</form>


<!--<a href="/">Вернуться назад</a><hr>-->
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
<!--    --><?//if(isset($err['no_such_user'])):?>
<!--        <p style="font: small-caption; color: red; margin: 0">--><?//=$err['no_such_user']?><!--</p>-->
<!--    --><?//endif;?>
<!--    <input type="checkbox" name="remember">Запомнить<br>-->
<!--    <button>Отправить</button><br>-->
<!--</form>-->