<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once 'app/services/Router.php';
require_once 'app/services/DbUsers.php';
require_once 'app/User.php';

Router::page('/registration', 'registr', 'Регистрация');
Router::page('/registration/new', 'registr', 'Регистрация', 'User', 'addNewUser', $_POST);
Router::page('/authorization', 'auth', 'Авторизация');
Router::page('/authorization/login', 'auth', 'Авторизация', 'User', 'login', $_POST);
Router::page('/authorization/logout', 'main', 'Главная', 'User', 'logout');
Router::page('/', 'main', 'Главная');

Router::enable();
