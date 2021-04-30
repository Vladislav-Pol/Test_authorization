<?php
require_once 'views/templates/header.php';

?>
    <h1>Авторизация</h1>
    <form action="#" method="post" class="authorization" id="authorization">
        <fieldset>
            <legend>Авторизация</legend>
            <label id="login">Введите логин<input type="text" name="login" placeholder="Логин" value="User01"></label>
            <label id="password">Введите пароль<input type="password" name="password" placeholder="Пароль" value="!Q2w3e"></label>
            <label id="remember">Запомнить меня<input type="checkbox" name="remember"></label>
<!--            <input type="submit" name="authorization" value="Войти">-->
            <button type="button" id="btn_login">Войти</button>
        </fieldset>
    </form>

<?php
require_once 'views/templates/footer.php';
