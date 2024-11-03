<?php

namespace Request;

class CartRequest
{

    public function validate(): array
    {
        $errors = [];

        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];

            $product = $this->product->getProductById($productId);

            if (empty($productId)) {
                $errors['product-id'] = 'поле продукта не должен быть пустым';
            } elseif (!is_numeric($productId)) {
                $errors['product-id'] = 'такого товара не существует';
            } elseif ($productId < 0) {
                $errors['product-id'] = 'поле продукта id не должен быть отрицательным';
            } elseif ($product->getId() === null) {
                $errors['product-id'] = 'продукта с таки ID не существует';
            }
        } else {
            $errors['product-id'] = 'id продукта должен быть указан';
        }
        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
            if (empty('amount')) {
                $errors['amount'] = 'поле количества не должен быть пустым';
            } elseif (!is_numeric($amount)) {
                $errors['amount'] = 'Такой цифры не существует';
            } elseif ($amount < 0) {
                $errors['amount'] = 'поле количества не должен быть отрицательным';
            }
        } else {
            $errors['amount'] = 'укажите количетсво  товара';
        }
        return $errors;
    }
}