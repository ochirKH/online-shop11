<?php


$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$repeatPsw = $_POST['psw-repeat'];

$errors = [];

if (empty($name)) {
    $errors = 'поле пустое';
} elseif (strtoupper($name[0]) !== $name[0]) {
    $errors = 'имя начинается с большой буквы';
} elseif (strlen($name) < 2){
    $errors = 'имя должно быть';
}

if (empty($email)){
    $errors['email'] = 'поле пустое';
} elseif (){
    $errors['email'] = 'не правильно указана почта';
}

if (empty($password)){
    $errors['password'] = 'поле пустое';
} elseif ($password != $repeatPsw){
    $errors['password'] = 'пароль не совпадает';
}


    if (empty($errors))
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        print_r($result);
    }
print_r ($errors);