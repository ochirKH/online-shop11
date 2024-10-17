
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
        <?php foreach ($result as $elem): ?>
        <form action="/main" method="POST"></form>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    <?php echo $elem['name'] ?? ''; ?>
                </div>
                <div class="card-footer">
                    <?php echo $elem['price'] ?? ''; ?> рублей
                </div>
                <img class="card-img-top" src=<?php echo $elem['images'] ?? ''; ?> width="500" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"> <?php echo $elem['category'] ?? ''; ?></p>
                    <a href="#"><h5 class="card-title"><?php echo $elem['description'] ?? ''; ?></h5></a>
                </div>
            </a>
        </form>

    </div>

    <?php endforeach; ?>
        <p><b><?php echo 'Обшая сумма в корзине ' . $sumAll . ' рублей';  ?></b></p>
    </div>    <a href='/buy'>Купить все содержимое в корзине</a>

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
        b