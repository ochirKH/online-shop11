<?php

// проверка на наличие заполненных полей в браузере

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

// создаем пустой массив ошибок

$errors = [];

function validateRegistration(): array // вытаскиваем массив
{
    // создаем еще раз, так как у функции свое поле видимости

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
    } elseif (strlen($password) <= 4){
        $errors['psw'] = 'пароль короткий';
    }

    // Вытаскиваем результат
    return $errors;

}

// все что получили с функции validateRegistration сохраняем в пустой массив ошибок, так как область видимости другой

$errors = validateRegistration();

// Если нет ошибок выполняем процесс регистрации

if (empty($errors)) {

    // Если нет ошибок, то выполняем процесс регистрации

    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

//    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
//    $stmt->execute(['email' => $email]);
//    $result = $stmt->fetch();
    require_once "./get_login.php";
} else {
    require_once "./get_registration.php";
}