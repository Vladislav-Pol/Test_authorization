<?php


class User
{
    public $login;
    protected $password;
    protected $confirm_password;
    public $email;
    public $name;
    public $dateErrors;

    protected $pregLogin = '/^[a-z0-9]{6,}$/i';
    protected $pregPassword = '/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=])(.{6,})/';
    protected $pregEmail = '/^[a-z]([a-z0-9]*[-_.]?[a-z0-9]+)+@[a-z0-9]([a-z0-9]*[-_.]?[a-z0-9]+)+\.[a-z]{2,11}$/i';
    protected $pregName = '/[a-z0-9а-я]{2,}/i';
    protected $authLifeTime = 60 * 60 * 24 * 30;

    public function addNewUser($data)
    {
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->confirm_password = $data['confirm_password'];
        $this->email = $data['email'];
        $this->name = $data['name'];

        if ($this->validateRegData() && $this->isUniqueUser()) {
            $this->salt = md5(mt_rand());

            $arUsers = DbUsers::getUsers();

            $newUser = $arUsers->addChild('user');
            $newUser->addChild('login', $this->login);
            $newUser->addChild('password', $this->getPasswordHash($this->password, $this->salt));
            $newUser->addChild('salt', $this->salt);
            $newUser->addChild('email', $this->email);
            $newUser->addChild('name', $this->name);

            if (DbUsers::updateUsers($arUsers)) {
                echo json_encode(['registr' => true]);
                die;
            };
        }
        echo json_encode($this->dateErrors);
        die;
    }

    public function login($data)
    {
        $result = ['login_error' => "Неверный логин или пароль"];
        if (!$this->checkAuth()) {

            $arUsers = DbUsers::getUsers();

            foreach ($arUsers as $user) {
                if ($user->login == $data['login'] &&
                    $user->password == $this->getPasswordHash($data['password'], $user->salt)) {

                    $sessionId = session_id();
                    if($data['remember'] === on) {
                        setcookie("key", $sessionId, time() + $this->authLifeTime, "/");
                        $user->cookie = $sessionId;
                    }
                    $_SESSION['auth'] = true;
                    $_SESSION['user_login'] = $data['login'];
                    $_SESSION['user_name'] = (string)$user->name;
                    $user->sessionId = $sessionId;
                    if (DbUsers::updateUsers($arUsers)) {
                        $result = ['auth' => true];
                        break;
                    }
                }
            }
        }
        header('Content-type: application/json');
        echo json_encode($result);
        die;
    }

    public function logout()
    {
        $arUsers = DbUsers::getUsers();

        foreach ($arUsers as $user) {
            if ($user->sessionId == session_id() || $user->cookie == $_COOKIE['key']) {
                setcookie("key", '', time() - 3600, "/");
                unset($_SESSION['auth'], $_SESSION['user_login'], $_SESSION['user_name'], $user->sessionId, $user->cookie);
                DbUsers::updateUsers($arUsers);
            }
        }

        header('Location: /');
    }

    protected function getPasswordHash($password, $salt)
    {
        return md5($salt . md5($password));
    }

    //возвращает true если все поля соответстуют условиям валидации, иначе false и довавляет поле с ошибкой в массив
    protected function validateRegData()
    {
        $result = true;

        if (!preg_match($this->pregLogin, $this->login)) {
            $this->dateErrors['login'] = 'Логин ' . $this->login . ' не подходит. Логин должен состоять только из букв латинского алфавита и цифр. Минимальная длина логина - 6 символов';
            $result = false;
        }
        if (!preg_match($this->pregPassword, $this->password)) {
            $this->dateErrors['password'] = 'Пароль слишком легкий';
            $result = false;
        }
        if ($this->password != $this->confirm_password) {
            $this->dateErrors['confirm_password'] = 'Пароли не совпадают';
            $result = false;
        }
        if (!preg_match($this->pregEmail, $this->email)) {
            $this->dateErrors['email'] = 'Неправильный email';
            $result = false;
        }
        if (!preg_match($this->pregName, $this->name)) {
            $this->dateErrors['name'] = 'Неправильное имя';
            $result = false;
        }

        return $result;
    }

    protected function isUniqueUser()
    {
        $result = true;
        $arUsers = DbUsers::getUsers();
        foreach ($arUsers as $user) {
            if ($user->login == $this->login) {
                $this->dateErrors['login'] = 'Пользователь с логином ' . $this->login . ' уже существует.';
                $result = false;
            }
            if ($user->email == $this->email) {
                $this->dateErrors['email'] = 'Адрес ' . $this->email . ' занят другим пользователем.';
                $result = false;
            }
        }

        return $result;
    }

    public static function checkAuth()
    {
        $result = false;

        if ($_SESSION['auth']) {
            $result = true;
        } elseif ($_COOKIE['key']) {

            $arUsers = DbUsers::getUsers();

            foreach ($arUsers as $user) {
                if ($user->cookie == $_COOKIE['key']) {
                    $_SESSION['auth'] = true;
                    $user->sessionId = session_id();
                    DbUsers::updateUsers($arUsers);
                }
            }
        }

        return $result;
    }

}