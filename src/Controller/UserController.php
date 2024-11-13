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
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->user->add($name, $email, $hash);
            header('Location: /login');
        } else {
            require_once '../View/get_registration.php';
        }
    }


    public function login(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $password = $request->getPassword();
            $email = $request->getEmail();

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