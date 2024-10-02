<?php

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

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

    // В БД ищем пользователя по почте т.к почта уникальная

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();

    // fetch выдает результат или ЛОЖЬ

    if ($result === false) {
        $errors['email'] = 'Пароль или логин указан не верно!';
    } else {

        // если истина, то берем пароль пользователя и сравниваем с хэшом, затем создаем сессию

        $passwordFromDb = $result['password'];
        if (password_verify($password, $passwordFromDb)) {
            session_start();
            $_SESSION['userId'] = $result['id'];
            $_SESSION['userName'] = $result['name'];
            header('Location: /main');
        } else {
            $errors['email'] = 'Пароль или логин указан не верно!';
        }
    }
    require_once './get_login.php';
}
