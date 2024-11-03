<?php

namespace Request;

class LoginRequest extends Request
{
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

        if (isset($this->data['email'])){
            $email = $this->data['email'];
        } else {
            $errors['email'] = 'поле для почты пустая';
        }

        if (isset($this->data['password'])) {
            $password = $this->data['password'];
        } else {
            $errors['password'] = 'поле для пароля пустая';
        }

        return $errors;
    }
}