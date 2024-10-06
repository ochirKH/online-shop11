<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: /get_login.php");
}
$userId = $_SESSION['userId'];


$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

$exec = $pdo->prepare('SELECT product_id FROM user_products WHERE user_id = :user'); // вытаскиваю Id продуктов у пользователя
$exec->execute(['user' => $userId]);
$products = $exec->fetchAll();

$result = [];

foreach ($products as $product) {
    $productId = $product['product_id'];
    $exec = $pdo->prepare('SELECT * FROM products WHERE id = :product'); // далее смотрим те продукты которые были у пользователя
    $exec->execute(['product' => $productId]);
    $result[] = $exec->fetch();

}

?>
<div class="container">
    <a href='/logout'>Выход</a>
    <div>
        <a href='/profile'>Личный кабинет</a>
    </div>
    <div>
        <a href='/main'>Главная страница</a>
    </div>
    <h3>КОРЗИНА</h3>
    <div class="card-deck">
        <?php foreach ($result as $product): ?>
        <form action="/main" method="POST"></form>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    <?php echo $product['name'] ?? ''; ?>
                </div>
                <div class="card-footer">
                    <?php echo $product['price'] ?? ''; ?> рублей
                </div>
                <img class="card-img-top" src=<?php echo $product['images'] ?? ''; ?> width="500" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"> <?php echo $product['category'] ?? ''; ?></p>
                    <a href="#"><h5 class="card-title"><?php echo $product['description'] ?? ''; ?></h5></a>
                </div>
            </a>
        </div>
        <!--            <input type="text" hidden placeholder="Enter product-id" name="product-id" id="product-id" value="-->
        <?php //echo $product['id']?><!--" required>-->
        <!--            <button type="submit" >Add</button>-->
        </form>
    </div>
    <?php endforeach; ?>
</div>

<style>
    /*img {*/
    /*    display: block;*/
    /*    margin: 0 auto;*/
    /*}*/
    .container {
        background-color: #f1f1f1;
        width: 1000px;
        margin: 0 auto;

    }

    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 500em;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 24px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 18px;
    }

    .card-footer {
        font-weight: bold;
        font-size: 20px;
        background-color: white;
    }
</style>
