<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title><?=$title?>></title>

</head>
<body>
<div class="header">
    <? if($_SESSION['auth']):?>
    <p>Здравствуйте, <?=$_SESSION['user_name']?>!</p>
    <?endif;?>
    <ul>
        <a href="/"><li>Главная</li></a>

        <? if(!$_SESSION['auth']):?>
            <a href="/authorization"><li>Войти</li></a>
            <a href="/registration"><li>Зарегистрироваться</li></a>
        <?endif;?>

        <? if($_SESSION['auth']):?>
        <a href="/authorization/logout"><li>Выйти</li></a>
        <?endif;?>
    </ul>
</div>
