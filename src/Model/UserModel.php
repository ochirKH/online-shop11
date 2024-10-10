<?php

class UserModel
{
    public function addUserBd(int $name, string $email, string $password): void
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function checkUserEmail(string $email): array|false
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        // В БД ищем пользователя по почте т.к почта уникальная

        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $result = $stmt->fetch();

    }

    public function checkUserId(int $userId): array|false
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :userId');
        $stmt->execute(['userId'=>$userId]);
        return $result = $stmt->fetch();

    }
}