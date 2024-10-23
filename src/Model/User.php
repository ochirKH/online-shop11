<?php

namespace Model;
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function add(int $name, string $email, string $password): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getByEmail (string $email): User|null
    {
        // В БД ищем пользователя по почте т.к почта уникальная

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data= $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return $this->hydrate($data);
    }


    public function getById (int $userId): User|null
    {

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :userId');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetch();

        if (empty($data)){
            return null;
        }

        return $this->hydrate($data);
    }

    private function hydrate($data): User
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];

        return $obj;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}