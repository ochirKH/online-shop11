<?php

class UserModel
{
    public function addUserBd($name, $email, $password): void
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    }

    public function checkUserEmail($email): array|false
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        // В БД ищем пользователя по почте т.к почта уникальная

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        if ($result === false){
            return false;
        } else {
            return $result;
        }
    }

    public function checkUserId($userId): array|false
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :userId');
        $stmt->execute(['userId'=>$userId]);
        $result = $stmt->fetch();

        if ($result === false){
            return false;
        } else {
            return $result;
        }

    }
}