<?php
require_once 'views/templates/header.php';

?>
    <h1>Регистрация</h1>
    <form action="/registration/new" method="post" class="registration" id="registration">
        <fieldset>
            <legend>Регистрация</legend>
            <label>Введите логин<input type="text" id="login" name="login" placeholder="Логин" value="User01"></label>
            <label>Введите пароль<input type="password" id="password" name="password" placeholder="Пароль" value="!Q2w3e"></label>
            <label>Подтвердите пароль<input type="password" id="confirm_password" name="confirm_password" placeholder="Пароль" value="!Q2w3e"></label>
            <label>Введите email<input id="email" type="email" name="email" placeholder="email" value="mail@mail.mail"></label>
            <label>Введите имя<input type="text" id="name" name="name" placeholder="Имя" value="Пользователь"></label>
            <input type="button" id="btn_registration" name="registration" value="Зарегистрироваться">
        </fieldset>
    </form>

<?php
require_once 'views/templates/footer.php';
