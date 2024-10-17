<?php

namespace Controller;

use \Model\User;


class UserController
{
    private User $user;

    public function __construct()
    {
        $this->user= new User();
    }

    public function getLogin(): void
    {
        require_once '../View/get_login.php';
    }

    public function getRegistration(): void
    {
        require_once '../View/get_registration.php';
    }

    public function registration(): void
    {

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }

        if (isset($_POST['psw-repeat'])) {
            $repeatPsw = $_POST['psw-repeat'];
        }

        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }

        $errors = $this->validate();

        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->user->addUserBd($name, $email, $hash);
            header('Location: /login');
        } else {
            require_once '../View/get_registration.php';
        }
    }



    public function login(): void
    {
        $errors = [];

        // проверка на наличие почты
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $errors['email'] = 'поле почты пустая';
        }

        // проверка на наличие пароля
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        } else {
            $errors['password'] = 'поле пароля пустая';
        }

        $user = $this->user->checkUserEmail($email);


        if ($user === false) {
            $errors['email'] = 'Пароль или логин указан не верно!';
        } else {
            $passwordFromDb = $user['password'];
            if (password_verify($password, $passwordFromDb)) {
                session_start();
                $_SESSION['userId'] = $user['id'];
                $_SESSION['userName'] = $user['name'];
                header('Location: /main');
            } else {
                $errors['email'] = 'Пароль или логин указан не верно!';
            }

        }
        require_once '../View/get_login.php';
    }

    private function validate(): array
    {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }

        if (isset($_POST['psw-repeat'])) {
            $repeatPsw = $_POST['psw-repeat'];
        }

        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }
        $errors = [];

        // Валидация на имя
        if (empty($name)) {
            $errors['name'] = 'поле пустое';
        } elseif (strtoupper($name[0]) !== $name[0]) {
            $errors['name'] = 'имя начинается с большой буквы';
        } elseif (strlen($name) <= 2) {
            $errors['name'] = 'в имени должно быть больше букв';
        }

        // Валидация на почту
        if (empty($email)) {
            $errors['email'] = 'поле пустое';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'не правильно указана почта';
        }

        // Валидация на пароль
        if (empty($password)) {
            $errors['psw'] = 'поле пустое';
        } elseif ($password != $repeatPsw) {
            $errors['psw'] = 'пароль не совпадает';
        } elseif (strlen($password) <= 4) {
            $errors['psw'] = 'пароль короткий';
        }

        // Вытаскиваем результат
        return $errors;
    }


    public function myProfile()
    {
        session_start();
        if (!isset($_SESSION['userId'])){
            header('Location: /login');
        } else {
            $userId = $_SESSION['userId'];
            $user = $this->user->checkUserId($userId);
        }
        require_once './../View/profile.php';
    }
    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /login');
    }
}