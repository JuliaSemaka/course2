<a href="<?=$_SERVER['HTTP_REFERER']?>">Вернуться назад</a><hr>
<?//
//echo '<pre>';
//    print_r($err);
//echo '</pre>';
//die();
//?>
<h2><?=$err['message']?></h2>
<?
if ($err['trace']) {
    echo '<pre>';
    print_r($err['trace']);
    echo '</pre>';
}
if ($err['errors']){
    echo "<h2>Ошибки: </h2>";
    echo '<pre>';
    print_r($err['errors']);
    echo '</pre>';
}
?>