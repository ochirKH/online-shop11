<?php

namespace Request;

class OrderRequest extends Request
{
    public function getContactName(): ?string
    {
        return $this->data['contact-name'] ?? null;
    }

    public function getContactPhone(): ?int
    {
        return $this->data['contact-phone'] ?? null;
    }

    public function getAddress(): ?string
    {
        return $this->data['address'] ?? null;
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['contact-name'])) {
            $contactName = $this->data['contact-name'];
            if (empty($contactName)) {
                $errors['contact-name'] = 'поле имени пустое';
            } elseif (strtoupper($contactName[0]) !== $contactName[0]) {
                $errors['contact-name'] = 'Имя должно начинаться с большой буквы';
            } elseif (strlen(($contactName) <= 2)) {
                $errors['contact-name'] = 'в имени должно быть больше букв';
            }
        } else {
            $errors['contact-name'] = 'Отсутствует имя';
        }

        if (isset($this->data['contact-phone'])) {
            $contactPhone = $this->data['contact-phone'];
            if (!is_numeric($contactPhone)) {
                $errors['contact-phone'] = 'напишите цифры в поле для телефона';
            }
        } else {
            $errors['contact-phone'] = 'Отсутствует телефон';
        }

        if (isset($this->data['address'])) {
            $address = $this->data['address'];
            if (empty($address)) {
                $errors['address'] = 'поле для ввода адреса пустое';
            }
        } else {
            $errors['address'] = 'Отсутствует адрес';
        }
        return $errors;
    }
}