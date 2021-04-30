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
        <li><a href="/">Главная</a></li>

        <? if(!$_SESSION['auth']):?>
            <li><a href="/authorization">Войти</a></li>
            <li><a href="/registration">Зарегистрироваться</a></li>
        <?endif;?>

        <? if($_SESSION['auth']):?>
            <li><a href="/authorization/logout">Выйти</a></li>
        <?endif;?>
    </ul>
</div>
