<?php

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['psw'])) {
    $password = $_POST['psw'];
}
if (isset($_POST['psw-repeat'])) {
    $repeatPsw = $_POST['psw-repeat'];
}

$errors = [];

function validateRegistration(): array
{
    $errors = [];

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

    if (empty($name)) {
        $errors['name'] = 'поле пустое';
    } elseif (strtoupper($name[0]) !== $name[0]) {
        $errors['name'] = 'имя начинается с большой буквы';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'имя должно быть';
    }


    if (empty($email)) {
        $errors['email'] = 'поле пустое';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'не правильно указана почта';
    }


    if (empty($password)) {
        $errors['psw'] = 'поле пустое';
    } elseif ($password != $repeatPsw) {
        $errors['psw'] = 'пароль не совпадает';
    }

    return $errors;
}

$errors = validateRegistration();

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    require_once "./get_login.php";
} else {
    require_once "./get_registration.php";
}
