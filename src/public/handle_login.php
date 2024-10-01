<?php

$errors = [];

if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    $errors['email'] = 'поле почты пустая';
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $errors['password'] = 'поле пароля пустая';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();

    if ($result === false) {
        $errors['email'] = 'пароль или логин указан не верно';
    } else {
        $passwordFromDb = $result['password'];
        if (password_verify($password, $passwordFromDb)) {
            session_start();
            $_SESSION['userId'] = $result['id'];
            $_SESSION['userName'] = $result['name'];
            header('Location: /main.php');
        } else {
            $errors['email'] = 'пароль или логин указан не верно';
        }
    }
    require_once './get_login.php';
}
