<?php

namespace Controller;

use Controller\Data\Data;
use \Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;



class UserController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function getLogin(): void
    {
        require_once '../View/get_login.php';
    }

    public function getRegistration(): void
    {
        require_once '../View/get_registration.php';
    }
    
    public function registration(RegistrateRequest $request): void
    {
        $errors = [];

        if (isset($request['name'])) {
            $name = $request['name'];
            // Валидация на имя
            if (empty($name)) {
                $errors['name'] = 'поле пустое';
            } elseif (strtoupper($name[0]) !== $name[0]) {
                $errors['name'] = 'имя начинается с большой буквы';
            } elseif (strlen($name) <= 2) {
                $errors['name'] = 'в имени должно быть больше букв';
            }
        } else {
            $errors['name'] = 'Пропишите Имя';
        }

        if (isset($request['email'])) {
            $email = $request['email'];
            // Валидация на почту
            if (empty($email)) {
                $errors['email'] = 'поле пустое';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'не правильно указана почта';
            }
        } else {
            $errors['email'] = 'Пропишите почту';
        }


        if (isset($request['psw'])) {
            $password = $request['psw'];
            // Валидация на пароль
            if (empty($password)) {
                $errors['psw'] = 'поле пустое';
            } elseif (strlen($password) <= 4) {
                $errors['psw'] = 'пароль короткий';
            }
        } else {
            $errors['psw'] = 'Пропишите пароль';
        }

        if (isset($request['psw-repeat'])) {
            $repeatPsw = $request['psw-repeat'];
            if ($password != $repeatPsw) {
                $errors['psw'] = 'пароль не совпадает';
            }
            if (empty($errors)) {
                $name = $request['name'];
                $email = $request['email'];
                $password = $request['psw'];
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $this->user->add($name, $email, $hash);
                header('Location: /login');
            } else {
                require_once '../View/get_registration.php';
            }
        }
    }


    public function login($request): void
    {
        $errors = [];

        if (isset($request['email'])){
            $email = $request['email'];
        } else {
            $errors['email'] = 'поле для почты пустая';
        }

        if (isset($request['password'])) {
            $password = $request['password'];
        } else {
            $errors['password'] = 'поле для пароля пустая';
        }

        if (empty($errors)) {
            $password = $request['psw'];
            $email = $request['email'];

            $user = $this->user->getByEmail($email);

            if ($user === null) {
                $errors['email'] = 'Пароль или логин указан не верно!';
            } else {
                $passwordFromDb = $user->getPassword();
                if (password_verify($password, $passwordFromDb)) {
                    session_start();
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userName'] = $user->getName();
                    header('Location: /main');
                } else {
                    $errors['email'] = 'Пароль или логин указан не верно!';
                }

            }
        }
        require_once '../View/get_login.php';
    }


    public function myProfile()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['userId'];
            $user = $this->user->getById($userId);
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