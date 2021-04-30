<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

// подключаем классы
require_once ROOT . '/app/services/Router.php';
require_once ROOT . '/app/services/DbUsers.php';
require_once ROOT . '/app/User.php';

// перечисляем страницы сайта и при необходимости обработчики
Router::page('/', 'main', 'Главная');
Router::page('/authorization', 'auth', 'Авторизация');
Router::page('/authorization/login', 'auth', 'Авторизация', 'User', 'login', $_POST);
Router::page('/authorization/logout', 'main', 'Главная', 'User', 'logout');
Router::page('/registration', 'registr', 'Регистрация');
Router::page('/registration/new', 'registr', 'Регистрация', 'User', 'addNewUser', $_POST);

// выполняем маршрутизацию
Router::enable();
