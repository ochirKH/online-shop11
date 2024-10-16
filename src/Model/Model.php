<?php

namespace Model;
class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
    }
}