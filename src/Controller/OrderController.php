<?php

namespace Controller;

use \Model\OrderProduct;
use \Model\User;
use \Model\Product;
use \Model\Order;
use \Model\UserProduct;

class OrderController
{
    private User $user;
    private Product $product;
    private UserProduct $userProduct;
    private Order $userOrder;
    private CartController $cartController;
    private OrderProduct $orderProduct;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userOrder = new Order();
        $this->cartController = new CartController();
        $this->orderProduct = new OrderProduct();
    }

    public function getOrder()
    {
        require_once "./../View/order.php";
    }

    public function order()
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        }

        $errors = $this->validateOrder();

        if (empty($errors)){

            $userId = $_SESSION['userId'];
            $contactName = $_POST['contact-name'];
            $contactPhone = $_POST['contact-phone'];
            $address = $_POST['address'];

            $cartProductsByUserId = $this->userProduct->getByUserId($userId); // получаю продукты в корзине пользователя

            $productIds = [];
            foreach ($cartProductsByUserId as $product) {
                $productIds[] = $product['product_id']; //  вытаскиваю id продуктов пользователся
            }

            $products = [];
            foreach ($productIds as $productId) {
                $products[] = $this->product->getProductById($productId);
                // получаю продукты по id с продуктов
                // id name price images category ....
            }

            $result = [];

            foreach ($products as &$product) {
                foreach ($cartProductsByUserId as $cartProductByUserId) {
                    if ($cartProductByUserId['product_id'] === $product->getId()) {
                        $product['amount'] = $cartProductByUserId['amount'];
                        $result[] = $product;
                    }
                }
            }

            foreach ($result as $elem) {
                $sumOneProduct[] = $elem['amount'] * $elem->getPrice();
            }

            $sumAll = 0;
            foreach ($sumOneProduct as $sum) {
                $sumAll += $sum;
            }

            $orderId = $this->userOrder->add($contactName, $contactPhone, $address, $sumAll, $userId); // id


            foreach ($result as $product) {
                $this->orderProduct->add($orderId, $product);
            }

            $this->userProduct->deleteProduct($userId);

            echo 'Товар успешно заказан';
        }
    }

    private function validateOrder(): array
    {
        $errors = [];

        if (isset($_POST['contact-name'])) {
            $contactName = $_POST['contact-name'];
            if (empty($contactName)) {
                $errors['contact-name'] = 'поле имени пустое';
            } elseif (strtoupper($contactName[0]) !== $contactName[0]) {
                $errors['contact-name'] = 'Имя должно начинаться с большой буквы';
            } elseif (strlen(($contactName) >= 2)) {
                $errors['contact-name'] = 'в имени должно быть больше букв';
            }
        } else {
            $errors['contact-name'] = 'Отсутствует имя';
        }

        if (isset($_POST['contact-phone'])) {
            $contactPhone = $_POST['contact-phone'];
            if (is_numeric($contactPhone)) {
                $errors['contact-phone'] = 'напишите цифры в поле для телефона';
            }
        } else {
            $errors['contact-phone'] = 'Отсутствует телефон';
        }

        if (isset($_POST['address'])) {
            $address = $_POST['address'];
            if (empty($address)) {
                $errors['address'] = 'поле для ввода адреса пустое';
            }
        } else {
            $errors['address'] = 'Отсутствует адрес';
        }
        return $errors;
    }
}

