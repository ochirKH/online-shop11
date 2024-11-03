<?php

namespace Request;

class RegistrateRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }
    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }
    public function getPassword(): ?string
    {
        return $this->data['password'] ?? null;
    }
    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            // Валидация на имя
            if (empty($name)) {
                $errors['name'] = 'поле пустое';
            } elseif (strtoupper($name[0]) !== $name[0]) {
                $errors['name'] = 'имя начинается с большой буквы';
            } elseif (strlen($name) <= 2) {
                $errors['name'] = 'в имени должно быть больше букв';
            }
        } else {
            $errors['name'] = 'Пропишите Имя';
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            // Валидация на почту
            if (empty($email)) {
                $errors['email'] = 'поле пустое';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'не правильно указана почта';
            }
        } else {
            $errors['email'] = 'Пропишите почту';
        }

        if (isset($this->data['psw-repeat'])) {
            $repeatPsw = $this->data['psw-repeat'];
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            // Валидация на пароль
            if (empty($password)) {
                $errors['psw'] = 'поле пустое';
            } elseif ($password != $repeatPsw) {
                $errors['psw'] = 'пароль не совпадает';
            } elseif (strlen($password) <= 4) {
                $errors['psw'] = 'пароль короткий';
            }
        } else {
            $errors['psw'] = 'Пропишите пароль';
        }

        // Вытаскиваем результат
        return $errors;
    }
}