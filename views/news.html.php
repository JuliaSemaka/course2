<?if($news === false):?>
    Нет статей
<?else:?>
    <a href="/users/sign_in">Вход</a><hr>
    <a href="/users/sign_up">Регистрация</a><hr>
    <h2>Список статей</h2>
    <table  border="1" style="text-align: center">
        <tr style="border: dimgray 1px solid;">
            <th>Дата</th>
            <th>Название статьи</th>
            <th>Содержание</th>
            <th></th>
        </tr>
        <?foreach ($news as $value):?>
            <tr>
                <td><?=$value['dt']?></td>
                <td><?=$value['news_title']?></td>
                <td><a href="/news/one/<?=$value['id']?>"> <?=$value['news_content']?></a></td>
                <td><a href="/news/edit/<?=$value['id']?>">Редактировать</a> </td>
            </tr>
        <?endforeach;?>
    </table>
<?endif;?>
<a href="/news/new">Добавить новую статью</a><br>
<a href="/auth">Выход</a><br>