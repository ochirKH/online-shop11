<?php

namespace Request;

use Model\Product;

class FavoriteRequest extends Request
{
    public function getProductId()
    {
        return $this->data['product-id'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['product-id'])) {
            $productId = $this->data['product-id'];

            $product = (new \Model\Product)->getProductById($productId);

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
        return $errors;
    }
}