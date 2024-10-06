<?php
session_start();

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
}
if (isset($_POST['product-id'])) {
    $productId = $_POST['product-id'];
}
if (isset($_POST['amount'])) {
    $amount = $_POST['amount'];
}

$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
$stmt = $pdo->prepare('SELECT id FROM products WHERE id = :product'); // Проверяем есть ли такой товар в магазине
$stmt->execute(['product' => $productId]);
$result = $stmt->fetch();

if ($result === false){
    exit('Такого товара не существует');
}


function addProduct($user, $product, $amount) // Добавляю в корзину товар и количество
{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
    $stmt = $pdo->prepare('INSERT INTO user_products (user_id, product_id, amount) VALUES (:user, :product, :amount)');
    $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
}



//function checkUser($user, $product) // Проверка наличия товара у пользователя
//{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
    $stmt=$pdo->prepare('SELECT * FROM user_products WHERE user_id = :user AND product_id = :product');
    $stmt->execute(['user'=>$userId, 'product'=>$productId]);
    $result = $stmt->fetch();

    if($result === false){
        $result = null;
    } else {
        $result;
    }

//}

function amountPlus($user, $product, $amount) // Обновляем количество
{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
    $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user AND product_id = :product");
    $stmt->execute(['user'=>$user, 'product'=>$product, 'amount' => $amount]);
    return $stmt->fetchAll();
}


if ($result === null){ // Если товара нет в корзине, то создаем новый
    addProduct($userId, $productId, $amount);
} else {
    amountPlus($userId, $productId, $result['amount']+$amount); //если товар уже есть такой, то меняе количество
}

header("Location: /main");

